<?php

namespace App\Actions\Repository;

use App\Models\Document;
use App\Models\DocumentTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DocumentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DocumentRepository
{
    protected $document;

    public function create(array $request): bool
    {
        DB::transaction(function () use ($request) {
            $this->createDocument($request)
                ->createDocumentTags($request)
                ->createDocumentCollections($request);
        });

        if (!$this->document) {
            throw new \Exception('Failed to create document!');
        }

        return $this->document ?? false;
    }

    public function update(array $request, string $documentId): bool
    {
        DB::transaction(function () use ($request, $documentId) {
            $this->getDocument($documentId)
                ->updateDocument($request)
                ->updateDocumentTags($request)
                ->updateDocumentCollections($request);
        });

        if (!$this->document) {
            throw new \Exception('Failed to update document!');
        }

        return $this->document ?? false;
    }

    protected function getDocument(string $documentId): DocumentRepository
    {
        $document = Document::findOrFail($documentId);

        if (!$document) {
            throw new \Exception('Failed to find document!');
        }
        $this->document = $document;

        return $this;
    }

    protected function createDocument(array $request): DocumentRepository
    {
        $document = Document::create($this->setDocumentData($request));

        if (!$document) {
            throw new \Exception('Failed to create document!');
        }
        $this->document = $document;

        return $this;
    }

    protected function createDocumentCollections(array $request): DocumentRepository
    {
        $documentCollections = DocumentCollection::insert($this->setDocumentCollectionData($request));

        if (!$documentCollections) {
            throw new \Exception('Failed to create document collections!');
        }

        return $this;
    }

    protected function createDocumentTags(array $request): DocumentRepository
    {
        $documentTags = DocumentTag::insert($this->setDocumentTagData($request));

        if (!$documentTags) {
            throw new \Exception('Failed to create document tags!');
        }

        return $this;
    }

    protected function updateDocument(array $request): DocumentRepository
    {
        $isUpdated = $this->document->update($this->setDocumentData($request));

        if (!$isUpdated) {
            throw new \Exception('Failed to update document!');
        }

        return $this;
    }

    protected function updateDocumentCollections(array $request): DocumentRepository
    {
        $this->clearDocumentCollections();
        $documentCollections = $this->createDocumentCollections($request);
        // $documentCollections = DocumentCollection::insert($this->setDocumentCollectionData($request));

        if (!$documentCollections) {
            throw new \Exception('Failed to update document collections!');
        }

        return $this;
    }

    protected function updateDocumentTags(array $request): DocumentRepository
    {
        $this->clearDocumentTags();
        $documentTags = $this->createDocumentTags($request);
        // $documentTags = DocumentTag::insert($this->setDocumentTagData($request));

        if (!$documentTags) {
            throw new \Exception('Failed to update document tags!');
        }

        return $this;
    }

    protected function clearDocumentCollections(): mixed
    {
        return DocumentCollection::where('document_id', $this->document->id)->delete();
    }

    protected function clearDocumentTags(): mixed
    {
        return DocumentTag::where('document_id', $this->document->id)->delete();
    }

    protected function setDocumentData(array $request): array
    {
        $fileInfo = $this->uploadFile($request);

        return [
            'title' => $request['title'],
            'summary' => $request['summary'],
            'path' => $fileInfo['path'],
            'file_type' => $fileInfo['type'],
            'is_free' => ($request['is_free'] == "true") ? 1 : 0,
            'price' => ($request['is_free'] == "true") ? null : $request['price'],
            'organisation_id' => authUserOrgId(),
            'status' => 'published'
        ];
    }

    protected function uploadFile(array $request): array
    {

        if ($request['is_external_link'] == "true") {
            if ($this->document && optional($this->document)->path && optional($this->document)->file_type != 'link') {
                \UploadBuilder::deleteFile($this->document->path);
            }

            return [
                'type' => 'link',
                'path' => $request['external_link']
            ];
        }

        if ($this->document && optional($this->document)->path == $request['path']) {
            return [
                'type' => $this->document->file_type,
                'path' => $this->document->path
            ];
        }

        $path = "private/documents/";

        $filename = pathinfo($request['path'], PATHINFO_FILENAME);
        $extension = pathinfo($request['path'], PATHINFO_EXTENSION);

        // Sanitize the filename to remove any potentially unsafe characters
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);

        $filepath = $path . $filename . '.' . $extension;
        // Storage::move($request['path'], $filepath);

        return [
            'type' => $extension,
            'path' => $filepath,
        ];
    }

    protected function setDocumentCollectionData(array $request): array
    {
        $collections = $request['collections'] ? explode(',', $request['collections']) : [];

        if (count($collections) > 0) {
            foreach ($collections as $collection) {
                $documentCollections[] = [
                    'document_id' => $this->document->id,
                    'collection_id' => $collection,
                ];
            }
        }

        return $documentCollections ?? [];
    }

    protected function setDocumentTagData(array $request): array
    {
        $tags = $request['tags'] ? explode(',', $request['tags']) : [];

        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                $documentTags[] = [
                    'document_id' => $this->document->id,
                    'tag_id' => $tag,
                ];
            }
        }

        return $documentTags ?? [];
    }

    public function deleteFile(string $path): JsonResponse
    {
        try {
            if (File::exists($path)) {
                File::delete($path);
                return response()->json(['message' => "File successfully deleted."], 200);
            } else {
                return response()->json(['message' => 'File not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
