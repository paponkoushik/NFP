<?php

namespace App\Http\Controllers\Legal;

use App\Actions\Contracts\GenerateLegalRequestNo;
use App\Actions\Contracts\Mailable\SendLegalSupportMail;
use App\Enums\LegalReqTypes;
use App\Http\Controllers\Controller;
use App\Models\LegalRequest;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LegalSupportController extends Controller
{
    public function __construct(
        private readonly GenerateLegalRequestNo $genReqNo,
        private readonly SendLegalSupportMail $mail,
    ) {
    }

    public function __invoke(Request $request, string $listingIdOrOrgId): JsonResponse
    {
        if(!$request->user()->can($request->from . '-legal-support', $listingIdOrOrgId)) {
            return respondError('You already requested for legal supports. We will contact with you shortly.', 403);
        }

        $request->validate([
            'from' => 'required',
            'message' => 'required'
        ]);

        try {
            $legalReq = LegalRequest::create([
                'request_no' => $this->genReqNo->handle(),
                'request_from' => $request->from,
                'listing_id' => $request->from == LegalReqTypes::Post->value ? $listingIdOrOrgId : null,
                'primary_org_id' => optional($request->user()->organisations()->whereIsPrimary(true)->first())->id,
                'secondary_org_id' => $request->from == LegalReqTypes::Post->value ? Listing::select('organisation_id')->find($listingIdOrOrgId)->organisation_id : $listingIdOrOrgId,
                'requested_user_id' => $request->user()->id,
                'request_summary' => $request->message,
                'request_contract_amount' => $request->contract_amount,
                'workflow_status' => 'New',
                'workflow_stage' => 'new',
                'requested_date' => now(),
            ]);

            //$this->mail->send($request->user(), $legalReq);

            return respond('Your Legal Support request has been sent! we will contact with you shortly.');
        } catch(\Exception $e) {
            return respondError('Failed to legal support. Try again!');
        }
    }
}
