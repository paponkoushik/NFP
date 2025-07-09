<?php

namespace App\Services;

use App\Models\Comms;
use App\Models\Message;

class ChatServices
{
    protected $request;
    protected $model;

    public function __construct(Comms $comms)
    {
        $this->model = $comms;
    }

    public function validateRequest($request): static
    {
        $this->request = $request;

        validator($this->request->all(), $this->rules())->validate();

        return $this;
    }

    public function rules(): array
    {
        return [
            'comms_id' => 'required',
            'message' => 'required|string',
        ];
    }

    public function storeMessage()
    {
        Message::create([
            'user_id' => auth()->user()->id,
            'comms_id' => $this->request->comms_id,
            'comment' => $this->request->message,
            'type' => $this->request->type,
        ]);

        return $this;
    }

    public function updateCommunication(): static
    {
        $comms = Comms::query()->findOrFail($this->request->comms_id);

        $comms->fill($this->commUpdateAbleData($comms))->save();

        return $this;
    }

    public function commUpdateAbleData($comms): array
    {
        $array = [
            'updated_at' => now(),
        ];

        $array1 = $this->getLastSeenByAuth($comms, $array);

        return $array;
    }

    public function updateCommSeenTime($comms): static
    {
        $this->model = $comms;

        $this->model->fill($this->getLastSeenByAuth($this->model, []))->save();

        return $this;
    }

    public function getLastSeenByAuth($comms, $array): array
    {
        if ($comms->from_org_id === authUserOrgId()) {
            $array['from_org_last_seen_at'] = now();
        } elseif ($comms->to_org_id === authUserOrgId()) {
            $array['to_org_last_seen_at'] = now();
        }

        return $array;
    }
}
