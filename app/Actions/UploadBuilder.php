<?php

namespace App\Actions;

use Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadBuilder
{
    /**
     * The file associated with the upload builder.
     *
     * @var object
     */
    protected $file;

    /**
     * The name for the upload file.
     *
     * @var string
     */
    protected $fileName;

    /**
     * The path associate with the upload file.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The resize path of the upload file.
     *
     * @var string
     */
    protected $fileResizePath;

    /**
     * The base path of the uplaod directory.
     *
     * @var string
     */
    protected $basePath;

    /**
     * The driver name used while uploading file.
     *
     * @var string
     */
    protected $driver;

    /**
     * Create a new upload builder instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->driver = app()->environment('local') ? 'public' : 's3';
        $this->driver = 'public';
    }

    /**
     * Set uploaded file and directory.
     *
     * @param  resource $file
     * @param  bool|string $dir
     * @return $this
     */
    public function uploadFile($file, $dir = false)
    {
        return $this->setFile($file)
                    ->setDir($dir);
    }

    /**
     * Set file & base path for the uploaded file.
     *
     * @param  resource $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        $this->basePath = base_path();
        $this->setFileName();

        return $this;
    }

    /**
     * Set file name for the uploaded file.
     *
     * @return void
     */
    public function setFileName()
    {
        $fileNameWithExtension = $this->file->getClientOriginalName();

        $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

        $extension = $this->file->getClientOriginalExtension();

        $this->fileName = md5(time()) . "." . $extension;
    }

    /**
     * Set custom directory for the uploaded file.
     *
     * @param  string $dir
     * @return $this
     */
    public function setDir($dir = null)
    {
        $dir = ($dir) ? "{$dir}/" : "";

        $folderPath = "/storage/{$dir}";
        $this->createPath($this->basePath . $folderPath);
        $this->filePath = $folderPath;

        return $this;
    }

    /**
     * Get full file path with file name.
     *
     * @return string
     */
    public function fullFilePath()
    {
        return $this->filePath . $this->fileName;
    }

    /**
     * Save uploaded file.
     *
     * @return string
     */
    public function save()
    {
        $this->file->move($this->basePath . $this->filePath, $this->fileName);

        return $this->fullFilePath();
    }

    /**
     * Save uploaded file after resizing.
     *
     * @param  int $width
     * @param  int $height
     * @return string
     */
    public function saveWithResize($width = 80, $height = 80)
    {
        Image::make($this->file->getPathName())->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save($this->basePath . $this->fullFilePath());

        return $this->fullFilePath();
    }

    /**
     * Save uploaded file after fit resizing.
     *
     * @param  int $width
     * @param  int $height
     * @return string
     */
    public function saveWithFit($width = 80, $height = null)
    {
        $img = Image::make($this->file->getPathName());

        if (empty($height)) {
            $img->fit($width);
        }

        // fit image based on width and height and retain maximum upsize
        if (!empty($width) && !empty($height)) {
            $img->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            });
        }

        $img->save($this->basePath . $this->fullFilePath());

        return $this->fullFilePath();
    }

    /**
     * Generate custom file name.
     *
     * @param  UploadedFile $uploadedFile
     * @return string
     */
    public function generateFileName(UploadedFile $uploadedFile)
    {
        return rand(1000, 9999) . md5(time()) . "." . strtolower($uploadedFile->getClientOriginalExtension());
    }

    /**
     * Save uploaded file in storage path.
     *
     * @param  UploadedFile $uploadedFile
     * @param  string $dir
     * @param  string $driver
     * @return string
     */
    public function storeFile(UploadedFile $uploadedFile, $dir = 'draft', $driver = null)
    {
        $directory = "/storage/{$dir}";

        $disk = Storage::build([
            'driver' => $driver ?? $this->driver,
            'root' => $directory,
        ]);

        return $disk->put($this->generateFileName($uploadedFile), $uploadedFile);
    }

    /**
     * Recursively create a long directory path.
     *
     * @param  string $path
     * @return string|bool
     */
    public function createPath($path)
    {
        if (is_dir($path)) {
            return true;
        }
        $prevPath = substr($path, 0, strrpos($path, '/', -2) + 1);
        $return = $this->createPath($prevPath);

        return ($return && is_writable($prevPath)) ? mkdir($path, 0777) : false;
    }

    /**
     * Delete files of a given driver and files.
     *
     * @param  array $files
     * @param  bool $fromLocal
     * @return void
     */
    public function deleteFiles($files, $fromLocal = false)
    {
        if (!empty($files)) {
            $method = $fromLocal ? 'deleteFileFromLocalDisk' : 'deleteFile';

            foreach ($files as $file) {
                $this->{$method}($file);
            }
        }
    }

    /**
     * Delete file from s3 directory.
     *
     * @param  string $path
     * @return bool
     */
    public function deleteFile($path)
    {
        if ($this->driver == 's3') {
            if ($this->checkS3FileExists($path)) {
                Storage::disk('s3')->delete($path);
                return true;
            }
            return false;
        }

        return $this->deleteFileFromLocalDisk($path);
    }

    /**
     * Delete file from local disk.
     *
     * @param  string $path
     * @return bool
     */
    public function deleteFileFromLocalDisk($path)
    {
        if ($this->checkFileExists($path, 'public')) {
            Storage::disk('public')->delete($path);
            // File::delete($path);
            return true;
        }

        return false;
    }

    /**
     * Delete file from media disk.
     *
     * @param  string $path
     * @return bool
     */
    public function deleteFileFromMediaDisk($path)
    {
        if ($this->checkFileExists($path, 'media')) {
            Storage::disk('media')->delete($path);
            return true;
        }

        return false;
    }

    /**
     * Check file exists in s3 directory of a given path.
     *
     * @param  string $path
     * @return bool
     */
    public function checkS3FileExists($path)
    {
        return Storage::disk('s3')->exists($path);
    }

    /**
     * Check file exists in a given driver.
     *
     * @param  string $path
     * @return bool
     */
    public function checkFileExists($path, $driver = null)
    {
        return Storage::disk($driver ?? $this->driver)->exists($path);
    }

    /**
     * Download file based on a given path.
     *
     * @param  string $path
     * @return bool
     */
    public function download($path)
    {
        if ($this->driver == 's3') {
            if ($this->checkS3FileExists($path)) {
                return Storage::download($path);
            }
            return false;
        }

        if ($this->checkFileExists($path)) {
            return Storage::download($path);
            // return response()->download($path);
        }

        return false;
    }

    /**
     * Move file from local disk to s3 disk.
     *
     * @param  string $existingPath
     * @param  string $newPath
     * @return string|bool
     */
    public function moveFileLocalDiskToS3($existingPath, $newPath)
    {
        if ($this->checkFileExists($existingPath, 'public')) {
            $moveTo = $newPath . "/" . basename($existingPath);
            $file = Storage::disk('public')->get($existingPath);
            Storage::disk($this->driver)->put($moveTo, $file);
            return $moveTo;
        }

        return false;
    }

}
