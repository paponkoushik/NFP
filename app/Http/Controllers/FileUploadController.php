<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(Request $request)
    {
        try {
            return \UploadBuilder::uploadFile($request->tmp_file, 'tmp-files')->save();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function documentFileUpload(Request $request): JsonResponse
    {
        try {
            $extension = $request->file('tmp_file')->getClientOriginalExtension();
            $filename = pathinfo($request->file('tmp_file')->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
            $path = "documents/";

            $uploadPath = $path . $filename;

            // Move the uploaded file to the "private/documents" directory with the same name
            $request->file('tmp_file')->storeAs($path, $filename, 'private');

            // You can save the $uploadPath to your database as needed

            return response()->json(['uploadPath' => $uploadPath]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            if ($data = json_decode($request->getContent())) {
                \UploadBuilder::deleteFile($data->path);
            }

            return response()->json(['message' => DELETE_SUCCESS]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function uploadFileBeforeCreateOrg(Request $request): JsonResponse
    {
        $uploadFile = $request->file('file');
        $path = $uploadFile->store('public/logos');

        if (!$path) {
            return respondError('The file could not be saved.');
        }

        $uploadFile->hashName();
        $fileUrl = config('app.url') . '/storage/logos/' . $uploadFile->hashName();

        return response()->json(['uploadPath' => $fileUrl]);
    }
}
