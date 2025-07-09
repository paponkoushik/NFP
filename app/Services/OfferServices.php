<?php

namespace App\Services;

use App\Enums\OfferStatus;
use App\Models\Comms;
use App\Models\Offer;

class OfferServices
{
    protected $request;
    protected $model;
    protected $offerModel;

    public function __construct(Comms $comms, Offer $offer )
    {
        $this->model = $comms;
        $this->offerModel = $offer;
    }

    public function validateRequest($request): OfferServices
    {
        $this->request = $request;

        validator($this->request->all(), $this->rules())->validate();

        return $this;
    }

    public function rules(): array
    {
        return [
            'offer_status' => 'required|in:pending,reject,accept',
        ];
    }

    public function updateCommOffer($comms): OfferServices
    {
        $this->model = $comms;
        $this->model->fill($this->updateAbleData())->save();

        return $this;
    }

    public function updateAbleData(): array
    {
        $array = [
            'offer_status' => $this->request->offer_status,
            'is_offered' => $this->request->offer_status == OfferStatus::Accept->value ? 1 : 0,
            'to_org_last_seen_at' => now()
        ];

        if ($this->request->offer_status == OfferStatus::Reject->value) {
            $array = array_merge($array, [
                'offered_amount' => null
            ]);
        }

        return $array;
    }

    public function updateOffer(): static
    {
        $updateAbleData = ['status' => $this->request->offer_status];

        if ($this->request->offer_status === OfferStatus::Accept->value) {
            $updateAbleData['offered_accepted_at'] = now();
        }

        $this->model->latestOffer()->update($updateAbleData);

        return $this;
    }

    public function validateOfferRequest($request): static
    {
        $this->request = $request;

        validator($this->request->all(), $this->offerRules())->validate();

        return $this;
    }

    public function offerRules(): array
    {
        return [
            'offered_amount' => 'required',
        ];

    }
    public function updateOfferAmount($comms): static
    {
        $this->model = $comms;

        $this->model->fill($this->offerData())->save();

        return $this;
    }

    public function offerData(): array
    {
        return [
            'offered_amount' => $this->request->offered_amount,
            'is_offered' => 1,
            'offer_status' => OfferStatus::Pending,
        ];
    }

    public function createOffer(): static
    {
        if ($this->request->offered_amount !== 'null') {
            $this->offerModel->query()->create($this->createOfferData());
        }

        return $this;
    }

    public function createOfferData(): array
    {
        return [
            'listing_id' => $this->model->listing_id,
            'offered_org_id' => authUserOrgId(),
            'comms_id' => $this->model->id,
            'offered_at' => now(),
            'offer_amount' => $this->request->offered_amount,
            'status' => OfferStatus::Pending
        ];
    }

    public function setOfferModel(Offer $offer): static
    {
        $this->offerModel = $offer;
        return $this;
    }

    public function updateCommunication(): static
    {
        if ($this->offerModel->communication->latestOffer->id === $this->offerModel->id) {
            $this->offerModel->communication()->update([
                'offer_status' => OfferStatus::Cancel,
                'is_offered' => 0,
                'offered_amount' => null,
            ]);
        }
        return $this;
    }

    public function cancelOffer(): static
    {
        $this->offerModel->fill(['status' => 'cancel'])->save();

        return $this;
    }
}
