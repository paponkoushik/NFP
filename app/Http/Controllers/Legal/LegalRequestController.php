<?php

namespace App\Http\Controllers\Legal;

use App\Actions\Filters\LegalRequestFilter;
use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Http\Resources\Legal\LegalRequestResource;
use App\Http\Resources\Legal\LegalUserResource;
use App\Mail\AssignedLawyerMailable;
use App\Models\LegalRequest;
use App\Models\Workflow;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use App\Services\LegalAdminService;

class LegalRequestController extends Controller
{
    protected $legalAdminService;

    public function __construct(LegalAdminService $legalAdminService)
    {
        $this->legalAdminService = $legalAdminService;
    }

    public function render(): View
    {
        return view('legal.liaison-request.index', [
            'statuses' => Workflow::select('id', 'status_name')->get(),
            'can' => [
                'edit' => !request()->user()->isOrgAdmin(),
            ]
        ]);
    }

    public function index(LegalRequestFilter $filters): AnonymousResourceCollection
    {
        $user = request()->user();

        return LegalRequestResource::collection(
            LegalRequest::with(LegalRequest::loadRelationships())
                ->when($user->isOrgAdmin(), fn (Builder $query) => $query->where('requested_user_id', $user->id))
                ->when($user->isLawyer(), fn (Builder $query) => $query->where('assigned_to', $user->id))
                ->latest()
                ->filters($filters)
                ->paginate(request('limit', 10))
        )->additional([
            'can' => [
                'assign' => $user->can(UserRoles::LegalAdmin->value),
            ]
        ]);
    }

    public function newLegalRequest(LegalRequestFilter $filters, Request $request): AnonymousResourceCollection
    {
        $user = request()->user();

        return LegalRequestResource::collection(
            LegalRequest::with(LegalRequest::loadRelationships())
                ->when($user->isOrgAdmin(), fn (Builder $query) => $query->where('requested_user_id', $user->id))
                ->when($user->isLawyer(), fn (Builder $query) => $query->where('assigned_to', $user->id))
                ->where('workflow_status', 'New')
                ->latest()
                ->filters($filters)
                ->paginate(request('limit', 10))
        )->additional([
            'can' => [
                'assign' => $user->can(UserRoles::LegalAdmin->value),
                'cardData' => $this->legalAdminService->dashboard($request->category, $request->fromDate, $request->toDate),
            ]
        ]);
    }

    public function lawyerRequest(string | null $startDate= null, string | null $endDate = null): array
    {
        return $this->legalAdminService->getLawyerRatingsData($startDate= null, $endDate = null);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $legal = LegalRequest::findOrFail($id);
            $legal->completed_date = $request->completed_date ?? $legal->completed_date;

            $legal->billed_amount = $request->billed_amount;
            if ($request->user()->isLawyer()) {
                $legal->additional_lawyer_note = $request->additional_lawyer_note;
            }

            $legal->save();

            return respond(UPDATE_SUCCESS);
        } catch(\Exception $e) {
            return respondError(UPDATE_FAIL, 400);
        }
    }

    public function assignLegal(Request $request): LegalUserResource
    {
        $legal = LegalRequest::find($request->legal_req_id);
        $legal->update([
            'assigned_to' => $request->user_id
        ]);

        $legal->load('assignedTo');

        Mail::to($legal->assignedTo->email)->send(new AssignedLawyerMailable($legal));

        return new LegalUserResource($legal->assignedTo);
    }

    public function RemoveAssignLegal(Request $request): JsonResponse
    {
        LegalRequest::find($request->legal_req_id)->update([
            'assigned_to' => null
        ]);

        return respond('Assign legal successfully removed.');
    }

    public function archived(LegalRequest $legalReq): JsonResponse
    {
        $legalReq->is_archived = true;
        $legalReq->archived_at = now();
        $legalReq->save();

        return respond('Legal request archived successfully.');
    }
}
