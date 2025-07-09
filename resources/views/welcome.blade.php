<x-app-layout>
    <div class="shadow-sm p-3">
        You're logged in!

        {{-- <example>
            <template #default>
                <p class="fw-bold" v-text="message"></p>
                <x-button class="btn-danger my-2" modal="v-form">Add New Form</x-button>

                <x-modal formAction="onSubmit" id="v-form" title="Example Form">
                    <x-slot:body>
                        <div class="row g-2">
                            <v-field name="form.name" type="text" placeholder="Who are you" rules="required"></v-field>
                            <error-message name="form.name"></error-message>
                        </div>
                        <div class="row g-2">
                            <x-input 
                                class="col mb-2"
                                label="Name"
                                placeholder="Enter name" />
            
                            <x-input 
                                class="col mb-2"
                                label="Short name"
                                placeholder="Enter short name" />
                        </div>
            
                        <div class="row g-2">                      
                            <x-input 
                                class="col mb-2"
                                label="Key"
                                placeholder="Enter key" />
            
                            <x-input.group class="col mb-2" for="status" label="status" :error="$errors->first('form.status')">
                                <x-input.select>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </x-input.select>
                            </x-input.group>
                        </div>
            
                    </x-slot>
            
                    <x-slot:footer class="justify-content-start">
                        <x-button type="submit" class="btn-info rounded-0">Save changes</x-button>
                        <x-button class="btn-sm" data-bs-dismiss="modal" onclick="closeModal('modal')">Close</x-button>
                    </x-slot>
                </x-modal>
            </template>
        </example> --}}

        <v-form @submit="onSubmit">
            <v-field name="name" type="text" placeholder="Who are you" rules="required"></v-field>
            <v-input>
                <v-field name="name" type="text" placeholder="Who are you" rules="required"></v-field>
                <error-message name="name"></error-message>
            </v-input>

            <input name="name" type="text" class="form-control my-1" placeholder="Enter name" rules="required" />

            <error-message name="name"></error-message>
            <flash></flash>

            <button>Submit</button>
        </v-form>

        <select2 v-model="id" :options="['one', 'two', 'three']" :settings="{multiple: true}"></select2>
        <flatpickr v-model="id"></flatpickr>
        <button type="button" class="btn btn-facebook" @click="swalConfirm('Are you sure?')">Swal Confirm Box</button>
        
        <div>
            <x-modal formAction="onSubmit" id="modal" title="Add New Brand">
                <x-slot:body>
                    <div class="row g-2">
                        <v-field name="name" type="text" placeholder="Who are you" rules="required"></v-field>
                        <error-message name="name"></error-message>
                    </div>
                    <div class="row g-2">
                        <x-input 
                            class="col mb-2"
                            label="Name"
                            placeholder="Enter name" />
        
                        <x-input 
                            class="col mb-2"
                            label="Short name"
                            placeholder="Enter short name" />
                    </div>
        
                    <div class="row g-2">                      
                        <x-input 
                            class="col mb-2"
                            label="Key"
                            placeholder="Enter key" />
        
                        <x-input.group class="col mb-2" for="status" label="status" :error="$errors->first('form.status')">
                            <x-input.select>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
        
                </x-slot>
        
                <x-slot:footer class="justify-content-start">
                    <x-button type="submit" class="btn-info rounded-0">Save changes</x-button>
                    <x-button class="btn-sm" data-bs-dismiss="modal" onclick="closeModal('modal')">Close</x-button>
                </x-slot>
            </x-modal>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <modal-example></modal-example>
            </div>
        </div>
    </div>
</x-app-layout>
