<?php

namespace App\Services;

use App\Events\OrganisationCreated;
use App\Mail\OrgMail;
use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OrganizationService
{
    protected $request;
    protected $model;

    public function __construct(Organisation $organisation)
    {
        $this->model = $organisation;
    }

    public function validateRequest($request): static
    {
        $this->request = $request;

        validator($this->request->all(), $this->createdRules())->validate();

        return $this;
    }

    public function createdRules(): array
    {
        return [
            'org_name' => 'required|unique:organisations|string|max:100',
            'org_type' => [
                'required',
                Rule::in(['client', 'legal_partner'])
            ],
            // 'client_type' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postcode' => 'required',
            'contact_email' => 'required|email|unique:users,email|unique:organisations',
            'status' => 'required',
        ];
    }

    public function store(): static
    {
        $input = $this->request->only('org_name', 'org_type', 'client_type', 'contact_email', 'contact_phone', 'abn', 'acn', 'is_accept_terms', 'status', 'alias');
        $input['created_by'] = Auth::user()->id;

        if ($this->request->path) {
            $files = explode('/', $this->request['path']);
            $input['logo'] = $files[5];
        }

        $this->model = $this->model->query()->create($input);

        return $this;
    }

    public function createLocation(): static
    {
        $input = $this->request->only('city', 'state', 'postcode', 'address');
        $input['organisation_id'] = $this->model->id;
        $input['is_primary'] = 1;

        $this->model->primaryAddress()->create($input);

        return $this;

    }

    public function createSubscription(): static
    {
        $this->model->subscription()->create($this->subscriptionData());

        return $this;
    }

    public function sendMail(): static
    {
        event(new OrganisationCreated($this->request->all(), $this->model->id));
//        Mail::to($this->model->contact_email)->send(new OrgMail());

        return $this;
    }

    public function subscriptionData(): array
    {
        return [
            'user_id' => auth()->user()->id,
            'organisation_id' => $this->model->id,
            'name' => 'organisation-subscription',
            'stripe_id' => uniqid(),
            'stripe_status' => 'success',
            'subs_start_date' => $this->request->activation_date ?? date('Y-m-d'),
            'subscription_period' => $this->request->subscription_period,
            'is_trial' => $this->request->is_trial,
            'form' => $this->request->activation_date,
            'to' => $this->request->expiry_date,
            'trial_ends_at' => $this->request->is_trial ? $this->request->expiry_date : null,
        ];
    }

    public function validateUpdateRequest($request, $org): static
    {
        $this->request = $request;

        validator($this->request->all(), $this->updatedRules($org))->validate();

        return $this;
    }

    public function updatedRules($org): array
    {
        return [
            'org_name' => 'required|string|max:100|unique:organisations,org_name,' . $org->id . '',
            'contact_email' => 'required|string|max:100|unique:organisations,contact_email,' . $org->id . '',
            'city' => 'required|string',
            'state' => 'required|string',
            'postcode' => 'required',
        ];
    }

    public function setModel($organisation): static
    {
        $this->model = $organisation;

        return $this;
    }

    public function update(): static
    {
        $input = $this->request->only('org_name', 'org_type', 'client_type', 'contact_email', 'contact_phone', 'abn', 'acn', 'is_accept_terms', 'status', 'alias');

        if ($this->request->path) {
            $files = explode('/', $this->request['path']);
            $input['logo'] = $files[5];
        }

        $this->model->fill($input)->save();

        return $this;
    }

    public function updateLocation(): static
    {
        $input = $this->request->only('city', 'state', 'postcode', 'address');

        $this->model->primaryAddress()->update($input);

        return $this;
    }

    public function updateSubscription(): static
    {
        $this->model->subscription()->update($this->subscriptionData());

        return $this;
    }
}
