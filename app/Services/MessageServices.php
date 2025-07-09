<?php

namespace App\Services;

use App\Enums\OfferStatus;
use App\Models\Comms;
use App\Models\Message;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class MessageServices
{
    protected $communication;
    protected $comms;
    protected $request;

    /**
     * @throws ValidationException
     */
    public function validateRequest($request): MessageServices
    {
        $this->request = $request;
        validator($this->request->all(), $this->rules())->validate();

        return $this;
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string',
            'from_org_anonymous' => 'required|in:true,false',
        ];
    }

    public function checkCommunicationExists(): MessageServices
    {
        $listing_id = $this->request->listing_id ?? null;

        $this->communication = Comms::query()
//            ->when($listing_id, function (Builder $query, $listing_id ) {
//                $query->where('listing_id', '=' ,$listing_id);
//            })
            ->where('listing_id', '=' ,$listing_id)
            ->where('to_org_id', '=', $this->request->to_org_id)
            ->where('from_org_id', '=', authUserOrgId())
            ->first();

        return $this;
    }

    public function storeCommunication(): MessageServices
    {
        if ($this->communication) {

            $this->communication->update($this->updateAbleData());

            return $this;
        }

        $this->communication = Comms::create([
            'listing_id' => $this->request->listing_id ?? null,
            'to_org_id' => $this->request->to_org_id,
            'from_org_id' => authUserOrgId(),
            'is_offered' => $this->request->is_offered,
            'offered_amount' => $this->request->offered_amount,
            'from_org_last_seen_at' => now(),
            'from_org_anonymous' => $this->request->from_org_anonymous == 'true' ? 1 : 0
        ]);

        return $this;
    }

    public function updateAbleData(): array
    {
        $array = [
            'from_org_anonymous' => $this->request->from_org_anonymous == 'true' ? 1 : 0,
            'from_org_last_seen_at' => now(),
            'updated_at' => now()
        ];

        if ($this->request->offered_amount !== 'null') {
            $array = array_merge($array, ['offered_amount' => $this->request->offered_amount,
                'is_offered' => $this->request->is_offered,
                'offer_status' => OfferStatus::Pending
            ]);

        }

        return $array;
    }

    public function storeOffer(): static
    {
        if ($this->request->offered_amount !== 'null') {
            Offer::query()->create($this->createOfferData());
        }

        return $this;
    }

    public function createOfferData(): array
    {
        return [
            'listing_id' => $this->request->listing_id,
            'offered_org_id' => authUserOrgId(),
            'comms_id' => $this->communication->id,
            'offered_at' => now(),
            'offer_amount' => $this->request->offered_amount,
            'note' => $this->request->message,
            'status' => OfferStatus::Pending
        ];
    }

    public function storeMessage(): MessageServices
    {
        Message::query()->create([
            'comms_id' => $this->communication->id,
            'user_id' => auth()->user()->id,
            'comment' => $this->request->message,
            'type' => $this->request->type,
        ]);

        return $this;
    }

    public function getOwnAndReplied(array $param)
    {
        $listId = $param['listing_id'] ?? null;

        $this->comms = Comms::query()
            ->where('to_org_id', '=', $param['to_org_id'])
            ->where('from_org_id', '=', authUserOrgId())
            ->where('listing_id', '=', $listId)
            ->with('senderOrg.users')
            ->first();

        if ($this->comms) {
            $this->buildAnonyousData();

        }
        return $this->comms;
    }

    public function buildAnonyousData()
    {
        $this->comms->is_anonymous = authUserOrgId() === $this->comms->to_org_id ? $this->comms->from_org_anonymous : $this->comms->to_org_anonymous;
        $this->comms->senderOrg->anonymous_short_name = shortString($this->comms->senderOrg->alias);
        $this->comms->senderOrg->anonymous_name = $this->comms->senderOrg->alias;
        $this->comms->senderOrg->user = $this->comms->senderOrg->users[0];
        $this->comms->senderOrg->user->full_name = ucFirst($this->comms->senderOrg->user->first_name. " " .$this->comms->senderOrg->user->last_name);
        $this->comms->senderOrg->user->short_name = shortString($this->comms->senderOrg->user->full_name);
        $this->comms->senderOrg->user->avatar = $this->comms->senderOrg->user->avatar ? url($this->comms->senderOrg->user->avatar) : null;
    }
}
