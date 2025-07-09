<script setup>
import { ref } from 'vue';
import useUtilsFunc from "@/composables/useUtilsFunc.js";
import axios from 'axios';

const props = defineProps({
    from: {
        type: String,
        default: 'post'
    },
    data: {
        type: Object,
        required: true
    },
    id: { required: true }
    
});

const { handleFormError } = useUtilsFunc();
const { id, from } = props;
const loading = ref(false);
const form = ref({
    message: '',
    contract_amount: ''
});

const handleSubmit = async () => {
    try {
        loading.value = true;
        const { data } = await axios.post(`/legal/${id}/support`, { ...form.value, from });
        form.value.message = form.value.contract_amount = '';
        flashSwal(data.message, 'Thank You');
        let openedCanvas = bootstrap.Offcanvas.getInstance(document.getElementById('legalSupportOffcanvas'));
        openedCanvas.hide();
    } catch(error) {
        handleFormError(error.response);
    }
    loading.value = false;
}
</script>

<template>
    <slot name="supportIcon">
        <div class="buy-now">
            <a href="#" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#legalSupportOffcanvas" 
                aria-controls="legalSupportOffcanvas" 
                class="btn-buy-now hover:shadow-sm p-1 shadow-lg rounded-circle"
            >
                <img src="/assets/img/legal-service.png" 
                    data-bs-toggle="tooltip" 
                    data-bs-offset="0,4" 
                    title="Legal Support" 
                    alt="Legal Support" />
            </a>
        </div>
    </slot>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="legalSupportOffcanvas" aria-labelledby="legalSupportOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="legalSupportOffcanvasLabel" class="offcanvas-title">Legal Support</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">     
            <VForm @submit="handleSubmit">
                <div class="row gap-md-0 gap-3 mb-4">
                    <div class="col-md-12">
                        <div class="text-body small fw-semibold">
                            Title: <span class="fw-normal">{{ data.title }}</span>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <div class="text-body small fw-semibold mb-1">Summary: </div>                    
                        <p class="text-body small mb-0" v-html="data.summary"></p>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="text-body small fw-semibold mb-2">Message: </div>                    
                        <VField as="textarea"
                            v-model.trim="form.message"
                            name="message"
                            rules="required|min:20" 
                            class="form-control" 
                            cols="30" 
                            rows="5" 
                            placeholder="Enter your message..."
                            v-autosize
                        />

                        <ErrorMessage class="invalid-feedback d-block" name="message" />
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="text-body small fw-semibold mb-2">Contract Amount: </div>                    
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                v-model.trim="form.contract_amount"
                                class="form-control" 
                                placeholder="1500" />
                        </div>
                    </div>
                </div>

                <p class="alert alert-warning" v-show="!data.canLegalSupport">
                    Your already requested for legal support. We shortly contact with you.
                    Thank You!
                </p>

                <button type="submit" 
                    :class="$setLoadingSpinner(loading)" 
                    :disabled="loading || !data.canLegalSupport" 
                    class="btn btn-primary mb-2 d-grid w-100 mt-5">Contract Mills Oakley</button>
                <button type="button" class="btn btn-label-secondary d-grid w-100" data-bs-dismiss="offcanvas">Cancel</button>
            </VForm>
        </div>
    </div>
</template>