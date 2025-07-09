<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Legal\LegalNotesResource;
use App\Models\LegalRequestNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LegalRequestNoteController extends Controller
{
    public function store(Request $request): JsonResponse|LegalNotesResource
    {
        $request->validate([
            'legal_req_id' => 'required|exists:legal_requests,id',
            'stage' => 'required',
            'status' => 'required',
            'note' => 'required|min:10'
        ]);

        try {
            $note = LegalRequestNote::create([
                'legal_request_id' => $request->legal_req_id,
                'stage' => $request->stage,
                'step' => $request->status,
                'note' => $request->note
            ]);

            $legalReq = $note->legalRequest;

            $legalReq->update([
                'workflow_status' => $request->status,
                'workflow_stage' => $request->stage,
                'completed_date' => $request->completed_date ?? $legalReq->completed_date,
            ]);

            return new LegalNotesResource($note->load('createdBy'));
        } catch(\Exception $e) {
            return respondError('Failed to create notes!', 400);
        }
    }

    public function update(Request $request, int | string $id): Response|LegalNotesResource
    {
        $request->validate([
            //'status' => 'required',
            'note' => 'required|min:10'
        ]);

        try {
            $note = LegalRequestNote::findOrFail($id);

            $note->update([
                //'step' => $request->status,
                'note' => $request->note
            ]);

            return new LegalNotesResource($note->load('createdBy'));
        } catch(\Exception $e) {
            return respondError('Failed to update notes!', 400);
        }
    }

    public function destroy(int | string $id)
    {
        try {
            LegalRequestNote::findOrFail($id)->delete();

            return respond('Note successfully deleted!');
        } catch(\Exception $e) {
            return respondError('Failed to delete notes!', 400);
        }
    }
}
