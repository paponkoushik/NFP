<script setup>
    import { ref, reactive } from "vue";
    import ModalFooter from '@/components/Shared/ModalFooter'

    let showModal = ref(false);

    let message = ref('Test message');

    let form = reactive({
        name: 'John Doe',
        age: '',
        status: ''
    });

    function onSubmit(values) {
        console.log('values: ', values)
        flash('submitted')
        //alert(JSON.stringify(values, null ,2));
    }
</script>

<template>
    <button
        class="btn btn-primary px-4 py-2 rounded"
        @click="showModal = true"
    >Add Modal</button>

        <Modal 
            :show="showModal" 
            @close="showModal = false"
            position="centered"
            title="Modal Title"
        >
            <template #body>
                <p>Need to add a new member to your team?</p>

                <v-form @submit="onSubmit">
                    <div class="flex gap-2">
                        <div class="col mb-2">
                            <v-field v-model="form.name" 
                                name="name" 
                                rules="required" 
                                type="text" 
                                class="form-control" />

                            <error-message name="name"></error-message>
                        </div>
                        <div class="col mb-2">
                            <v-field v-model="form.age" 
                                name="age" 
                                rules="required" 
                                type="text" 
                                class="form-control" />

                            <error-message name="age"></error-message>
                        </div>
                        <div class="col mb-2">
                            <v-field v-model="form.status" 
                                name="status" 
                                rules="required" 
                                type="text" 
                                class="form-control" />

                            <error-message name="status"></error-message>
                        </div>

                        <ModalFooter class="justify-content-start px-0 py-2">
                            <button type="submit" class="btn btn-info rounded-0">Save Changes</button>
                        </ModalFooter>
                    </div>
                </v-form>
            </template>

            <!-- <template #footer class="justify-content-start">
                <button type="submit" class="btn-info rounded-0">Save changes</button>
                <button class="btn-sm" @click="$closeModal">Close</button>
            </template> -->
        </Modal>
</template>