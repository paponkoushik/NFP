<div class="tab-pane fade" id="summary" role="tabpanel">
    <div class="row">
        <x-input.group class="col mb-3" for="summary" label="Initial Consultation:" :error="$errors->first('form.notes')">
            <x-input.textarea wire:model.defer="form.summary" rows="3" placeholder="Enter initial consultation" />
        </x-input.group>
    </div>

    <div class="row">
        <x-input.group class="col mb-3" for="goals" label="Summary:" :error="$errors->first('form.notes')">
            <x-input.textarea wire:model.defer="form.goals_objectives" rows="3" placeholder="Enter Goals & Objectives" />
        </x-input.group>
    </div>

    <div class="row g-2">                 
        <x-input.date
            wire:model.defer="form.receive_date" 
            class="col mb-3"
            label="Receive Date"
            :options="[
                'dateFormat' => 'Y-m-d',
                'enableTime' => false
            ]"
            placeholder="Enter Receive Date" />

        <x-input.date
            wire:model.defer="form.reviewed_date" 
            class="col mb-3"
            label="Reviewed Date"
            :options="[
                'dateFormat' => 'Y-m-d',
                'enableTime' => false
            ]"
            placeholder="Enter Reviewed Date" />
    </div>

    <div class="row">
        <x-input.group class="col mb-3" for="comments" label="Internal Comments:" :error="$errors->first('form.notes')" helpText="Based on our assessment of the documents provided, we have identified potential risks which are noted in the alerts below.">
            <x-input.textarea wire:model.defer="form.comments" rows="3" placeholder="Enter Comments" />
        </x-input.group>
    </div>
</div>