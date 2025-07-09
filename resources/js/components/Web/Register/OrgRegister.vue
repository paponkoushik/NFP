<script setup>
import {useOrganisationStore} from "@/stores/OrganisationStore";
import {ref, computed, onMounted} from "vue";
import {Field, ErrorMessage} from 'vee-validate';
import FormWizard from "@/components/Shared/FormWizard";
import FormStep from "@/components/Shared/FormStep";
import TextInput from '@/components/Shared/TextInput';

const props = defineProps({
    type: {default: 'nfp'}
});

const clientType = ref("")

// use store
const store = useOrganisationStore();

onMounted(async () => {
    await store.getStates();
});


function getCities() {
    store.getCities();
}

function getPostCode() {
    store.getPostCode();
}


// const schemas = [
//     {
//         first_name: 'required',
//         last_name: 'required',
//         email: 'required|email|unique:users,email',
//         password: 'required|min:8',
//         password_confirmation: 'confirmed:@password',
//         phone: '',
//         terms: (value) => {
//             if (value && value.length) {
//                 return true;
//             }

//             return 'You must agree to privacy policy & terms';
//         },
//     },
//     {
//         //org_name: 'required',
//         //abn: 'required',
//         address: 'required',
//         details: '',
//     },
//     // {
//     //     select_plan: '',
//     //     card_number: 'required',
//     //     card_name: '',
//     //     expiry_date: '',
//     //     cvv_code: ''
//     // }
// ];


const schemas = computed(() => {
    let profileSchema = {
        address : 'required',
        state   : 'required',
        city    : 'required',
        postcode: 'required',
        details : '',
    };

    if (clientType.value === 'individual') {
        // Set ABN validation to an empty string for individual clients
        profileSchema.abn = '';
    } else {
        // Set Org name validation to 'required' for other client types
        profileSchema.abn = 'required';
    }

    if (clientType.value === 'individual') {
        // Set Org name validation to an empty string for individual clients
        profileSchema.org_name = '';
    } else {
        // Set ABN validation to 'required' for other client types
        profileSchema.org_name = 'required';
    }

    return [
        {
            first_name           : 'required',
            last_name            : 'required',
            email                : 'required|email|unique:users,email',
            password             : 'required|min:8',
            password_confirmation: 'confirmed:@password',
            phone                : '',
            terms                : (value) => {
                if (value && value.length) {
                    return true;
                }

                return 'You must agree to privacy policy & terms';
            },
        },
        profileSchema, // Include the profile schema here
    ];
});

const loading = ref(false);
const currentStepIdx = ref(0);
const visiblePass = ref(false);

const formValues = ref({client_type: props.type});

const tabs = ref([
    {
        tabId   : 0,
        title   : 'Account',
        subTitle: 'Account Details',
        icon    : 'bxs-user-detail fs-3'
    },
    {
        tabId   : 1,
        title   : 'Profile',
        subTitle: 'Enter Information',
        icon    : 'bxs-user-circle fs-3'
    },
    // {
    //     tabId: 2,
    //     title: 'Billing',
    //     subTitle: 'Payment Details',
    //     icon: 'bx-detail'
    // }
]);

const totalTabs = computed(() => tabs.value.length);


/**
 * Handle change steps
 */
function handleSteps(stepId) {
    currentStepIdx.value = stepId;
}


/**
 * Handle submit
 */
async function handleSubmit(formData) {
    loading.value = true;

    try {
        const {data} = await axios.post('/register', formData);

        flashSwal(data.message);

        setTimeout(() => location.replace('/dashboard'), 1000);
    } catch (err) {
        flashSwal(err.response.data.message, 'danger');
    }

    loading.value = false;

    //flashSwal('Your Profile registered successfully. Please varify your account and logged in!');
}


</script>

<template>
    <div class="border-0 bs-stepper shadow-none">
        <div class="border-bottom-0 bs-stepper-header pt-0 px-0">
            <div v-for="tab in tabs" :key="tab.tabId" :class="{
                'step d-flex align-items-center': true,
                'active': tab.tabId === currentStepIdx,
                'crossed': tab.tabId < currentStepIdx
            }">
                <button type="button" class="step-trigger" :disabled="tab.tabId < currentStepIdx">
                    <span :class="{
                        'bs-stepper-circle': true,
                    }">
                        <i :class="`bx ${tab.tabId < currentStepIdx ? 'bx-check fw-bold fs-3' : tab.icon}`"></i>
                    </span>
                    <span :class="{
                        'bs-stepper-label mt-1': true,
                    }">
                        <span class="bs-stepper-title">{{ tab.title }}</span>
                        <span :class="`bs-stepper-subtitle`">{{ tab.subTitle }}</span>
                    </span>
                </button>

                <div class="line" v-show="tab.tabId < totalTabs - 1">
                    <i :class="`bx bx-chevron-right ${tab.tabId < currentStepIdx ? 'text-primary' : ''}`"></i>
                </div>
            </div>
        </div>

        <div class="bs-stepper-content pt-1 px-2">
            <FormWizard :step-label="loading ? 'Processing...' : 'Register'" :validation-schema="schemas"
                        :form-values="formValues" @stepChange="handleSteps" @submit="handleSubmit" :loading="loading">
                <!-- <transition name="fade" mode="out-in">
                    <KeepAlive>
                        <component :is="components[currentStepIdx]" />
                    </KeepAlive>
                </transition> -->

                <!-- Account Details -->
                <FormStep>
                    <div class="content-header mb-3 fs-tiny">
                        <h5 class="mb-1">Account Information</h5>
                        <span>Enter Your Account Details</span>
                    </div>

                    <div class="row g-3">
                        <TextInput class="col-md-6" vlabel="first name" name="first_name" type="text" label="First Name"
                                   placeholder="Enter First Name"/>

                        <TextInput class="col-md-6" vlabel="last name" name="last_name" type="text" label="Last Name"
                                   placeholder="Enter Last Name"/>

                        <TextInput class="col-md-6" name="email" type="email" label="Email" placeholder="Enter Email"/>

                        <TextInput class="col-md-6" vlabel="mobile" name="phone" type="text" label="Mobile"
                                   placeholder="Enter Mobile"/>

                        <div class="row g-3 mb-2">
                            <div class="col-md">
                                <div class="form-check form-check-inline">
                                    <VField type="radio" class="form-check-input" v-model="clientType" id="nfp"
                                            name="client_type" value="nfp"/>
                                    <label class="form-check-label" for="nfp">NOT FOR PROFIT</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <VField type="radio" class="form-check-input" v-model="clientType" id="fp"
                                            name="client_type" value="fp"/>
                                    <label class="form-check-label" for="fp">FOR PROFIT</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <VField type="radio" class="form-check-input" v-model="clientType" id="charity"
                                            name="client_type"
                                            value="charity"/>
                                    <label class="form-check-label" for="charity">FOR CHARITY</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <VField type="radio" class="form-check-input" v-model="clientType" id="fi"
                                            name="client_type"
                                            value="individual"/>
                                    <label class="form-check-label" for="charity">FOR INDIVIDUAL</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <Field name="password" v-slot="{ field, errorMessage }">
                                    <input v-bind="field" :type="`${visiblePass ? 'text' : 'password'}`"
                                           :class="{ 'form-control': true, 'is-invalid': !!errorMessage }" id="password"
                                           name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                </Field>
                                <span @click="visiblePass = !visiblePass" class="input-group-text cursor-pointer">
                                    <i :class="`bx bx-${visiblePass ? 'show' : 'hide'}`"></i>
                                </span>
                            </div>
                            <ErrorMessage class="invalid-feedback d-block" name="password"/>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="confirm-password">Confirm Password</label>

                            <div class="input-group input-group-merge">
                                <Field name="password_confirmation" label="confirm password"
                                       v-slot="{ field, errorMessage }">
                                    <input v-bind="field" :type="`${visiblePass ? 'text' : 'password'}`"
                                           :class="{ 'form-control': true, 'is-invalid': !!errorMessage }"
                                           id="confirm-password" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                </Field>
                                <span @click="visiblePass = !visiblePass" class="input-group-text cursor-pointer">
                                    <i :class="`bx bx-${visiblePass ? 'show' : 'hide'}`"></i>
                                </span>
                            </div>
                            <ErrorMessage class="invalid-feedback d-block" name="password_confirmation"/>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <VField name="terms" type="checkbox" class="form-check-input" id="terms-conditions"
                                        value="agree"/>
                                <label class="form-check-label" for="terms-conditions">
                                    I agree to
                                    <a href="javascript:void(0);">privacy policy &amp; terms</a>
                                </label>
                            </div>
                            <ErrorMessage class="invalid-feedback d-block" name="terms"/>
                        </div>
                    </div>
                </FormStep>

                <!-- Profile Details -->
                <FormStep>
                    <div class="content-header mb-3 fs-tiny">
                        <h5 class="mb-1">Profile Information</h5>
                        <span>Enter Your Profile Information</span>
                    </div>

                    <div class="row g-3">

                        <TextInput v-if="clientType != 'individual'" class="col-md-6" vlabel="org.name" name="org_name"
                                   type="text"
                                   label="Name of the Profile" placeholder="Your Profile. Name"/>

                        <TextInput v-if="clientType != 'individual'" class="col-md-6" name="abn" type="text" label="ABN"
                                   placeholder="ABN"/>

                        <div class="col-md-4">
                            <label class="form-label" for="state">State</label>
                            <Field v-model="store.form.state" name="state" v-slot="{ field, errorMessage }">

                                <select v-bind="field"
                                        :class="{ 'form-control': true, 'is-invalid': !!errorMessage }" name="state"
                                        @change="getCities">
                                    <option value="">Select State</option>
                                    <option v-for="state in store?.states" :key="state.state" :value="state.state">{{
                                            state.state
                                        }}
                                    </option>
                                </select>

                                <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                            </Field>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="city">City</label>
                            <Field v-model="store.form.city" name="city" v-slot="{ field, errorMessage }">

                                <select v-bind="field"
                                        :class="{ 'form-control': true, 'is-invalid': !!errorMessage }" name="city"
                                        @change="getPostCode">
                                    <option value="">Select City</option>
                                    <option v-for="city in store?.cities" :key="city.locality" :value="city.locality">
                                        {{
                                            city.locality
                                        }}
                                    </option>
                                </select>

                                <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                            </Field>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="postcode">Post code</label>
                            <Field v-model="store.form.postcode" name="postcode" v-slot="{ field, errorMessage }">
                                <input type="text" v-bind="field"
                                       :class="{ 'form-control': true, 'is-invalid': !!errorMessage }" name="postcode"
                                       placeholder="Postcode">
                                <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                            </Field>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <Field v-model="store.form.address" name="address" v-slot="{ field, errorMessage }">
                                <textarea v-bind="field" :class="{ 'form-control': true, 'is-invalid': !!errorMessage }"
                                          cols="2" rows="2" placeholder="Address of the Profile" v-autosize></textarea>

                                <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                            </Field>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="details">Details</label>
                            <Field name="details" v-slot="{ field, errorMessage }">
                                <textarea v-bind="field" :class="{ 'form-control': true, 'is-invalid': !!errorMessage }"
                                          cols="3" rows="4" placeholder="Detailed description of the Profile"
                                          v-autosize></textarea>

                                <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                            </Field>
                        </div>
                    </div>
                </FormStep>
            </FormWizard>
        </div>
    </div>
</template>
