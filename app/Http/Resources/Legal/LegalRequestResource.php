<?php

namespace App\Http\Resources\Legal;

use App\Enums\LegalReqTypes;
use App\Enums\UserRoles;
use App\Models\Workflow;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class LegalRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'request_no' => $this->request_no,
            'request_from' => $this->request_from,
            'request_note' => $this->request_note,
            'request_init_note' => $this->request_init_note,
            'request_summary' => $this->request_summary,
            'offered_amount' => $this->offered_amount,
            'offered_date' => $this->offered_date,
            'agreed_amount' => $this->agreed_amount,
            'agreed_date' => $this->agreed_date,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'request' => ($isPostReq = $this->request_from == LegalReqTypes::Post->value) ? (new LegalListingResource($this->whenLoaded('listing'))) : (new LegalOrganisationResource($this->whenLoaded('primaryOrg'))),
            'primaryOrg' => new LegalOrganisationResource($this->whenLoaded('primaryOrg')),
            'secondaryOrg' => new LegalOrganisationResource($this->whenLoaded('secondaryOrg')),

            $this->mergeWhen(($user->isLawyer() || $user->isAdmins()), [
                'isLawyerNoteVisible' => true,
                'additional_lawyer_note' => $this->additional_lawyer_note,
            ]),

            $this->mergeWhen($user->cannot(UserRoles::OrgAdmin->value), [
                'is_request_accepted' => $this->is_request_accepted,
                'is_offer_accepted' => $this->is_offer_accepted,
                'assigned_to' => $this->assigned_to,
                'advice_summary' => $this->advice_summary,
                'billed_amount' => $this->billed_amount,
                'legal_contract_amount' => $this->legal_contract_amount,
                'requested_date' => $this->requested_date,
                'completed_date' => $this->completed_date,
                'is_archived' => $this->is_archived,
                'archived_at' => $this->archived_at,
                'legalNotes' => LegalNotesResource::collection($this->whenLoaded('legalRequestNotes')),
                'requestedUser' => new LegalUserResource($this->whenLoaded('requestedUser')),
                'assignedTo' => new LegalUserResource($this->whenLoaded('assignedTo')),
                'workflowStages' => $this->whenLoaded('workflowStages', fn () => $this->workflowStages->pluck('status_name')),
                'workflow_status' => $this->workflow_status,
                'status_badge' => Workflow::getBadgeClass($this->workflow_status, $this->workflow_stage),
                'workflow_stage' => $this->workflow_stage,
                'stage_name' => workflowSteps()[$this->workflow_stage] ?? $this->workflow_stage,
                'isPostReq' => $isPostReq,
                'isOnHold' => $this->workflow_stage == 'in-progress' && strtolower($this->workflow_status) == 'on hold',
                'isCancelled' => $this->workflow_stage == 'done' && strtolower($this->workflow_status) == 'invalid',
                'isCompleted' => $this->workflow_stage == 'done' && strtolower($this->workflow_status) == 'completed',
            ]),

            $this->mergeWhen($user->can(UserRoles::OrgAdmin->value), [
                'requested_date' => dateFormat($this->requested_date, 'd M Y'),
            ])
        ];
    }
}
