<div class="tab-pane fade show active" id="client-details" role="tabpanel">
    <div class="row g-2">
        <x-input 
            wire:model.defer="form.name" 
            class="col mb-3"
            label="Name"
            placeholder="Enter Name" />

        <x-input 
            wire:model.defer="form.surname" 
            class="col mb-3"
            label="Surname"
            placeholder="Enter Surname" />
    </div>

    <div class="row g-2">                 
        <x-input.date
            wire:model.defer="form.dob" 
            class="col mb-3"
            label="DOB"
            :options="[
                'dateFormat' => 'Y-m-d',
                'enableTime' => false
            ]"
            placeholder="Enter DOB" />

        <x-input.group class="col mb-3" for="status" label="Status" :error="$errors->first('form.status')">
            <x-input.select wire:model.defer="form.status">
                <option value="inactive">Inactive</option>
                <option value="active">Active</option>
            </x-input.select>
        </x-input.group>
    </div>

    <div class="row">
        <x-input.group class="col mb-3" for="address" label="Address" :error="$errors->first('form.address')">
            <x-input.textarea wire:model.defer="form.address" rows="2" placeholder="Enter address" />
        </x-input.group>
    </div>
</div>