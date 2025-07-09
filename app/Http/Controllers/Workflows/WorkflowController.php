<?php

namespace App\Http\Controllers\Workflows;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkflowController extends Controller
{
    public function index(): View
    {
        return Workflow::all()->groupBy('stage_code')->all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'stage_code' => [
                'required',
                Rule::in(array_keys(workflowSteps()))
            ],
            'status_name' => 'required',
        ]);

        try {
            return Workflow::create([
                'stage_code' => $request->stage_code,
                'status_name' => $request->status_name
            ]);
        } catch(\Exception $e) {
            return respondError('Failed to create workflow!', 400);
        }
    }

    public function update(Request $request, int | string $id): JsonResponse
    {
        $request->validate([
            'stage_code' => [
                'required',
                Rule::in(array_keys(workflowSteps()))
            ],
            'status_name' => 'required',
        ]);

        try {
            $workflow = Workflow::findOrFail($id);

            $workflow->update([
                'stage_code' => $request->stage_code,
                'status_name' => $request->status_name
            ]);

            return respond('Workflow successfully updated.');
        } catch(\Exception $e) {
            return respondError('Failed to update workflow!', 400);
        }
    }

    public function destroy(int | string $id): JsonResponse
    {
        try {
            $workflow = Workflow::findOrFail($id);

            if (!$workflow->is_default && $workflow->delete()) {
                return respond('Workflow successfully deleted!');
            }

            return respondError('Default workflow can\'t be deleted!', 404);
        } catch(\Exception $e) {
            return respondError('Failed to delete workflow!', 400);
        }
    }
}
