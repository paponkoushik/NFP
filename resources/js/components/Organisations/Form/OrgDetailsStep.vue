<script setup>
import {onMounted, ref} from 'vue';
import TextInput from '@/components/Shared/TextInput';
import FilePond from '@/components/Shared/FilePond';
import {useOrgSettingsStore} from "@/stores/OrgSettingsStore";
import {useFieldArray} from 'vee-validate';
import {useOrganisationStore} from "../../../stores/OrganisationStore";
import {debounce} from "lodash";


const {organisation} = useOrgSettingsStore();
const store = useOrganisationStore();

const states = ref([
    'NSW', 'VIC', 'QLD', 'SA', 'WA', 'TAS', 'NT', 'ACT'
]);

const totalAddr = ref(1);

const uploadedFile = ({logo}) => {
    organisation.logo = logo;
};

onMounted(async () => {
    await store.getStates()
    if (organisation.state) {
        await store.getCities(organisation.state)
    }
    if (organisation.city) {
        await store.getPostCode(organisation.city)
    }
});

const getCities = () => {
    store.getCities(organisation.state);
}

const getPostCode = async () => {
    await store.getPostCode(organisation.city)
    organisation.postcode = store.form.postcode;
}

const callMethods = debounce(async (e) => {
    if (e.target.value.length > 3) {
        await store.getCityAndState(e.target.value)
        organisation.postcode = store.form.postcode
        organisation.city = store.form.city
    }
}, 500)

const {remove, push, fields} = useFieldArray('other_locations');

// === Below section how can i set or get value form vee-validate
/* import { useForm, useField } from 'vee-validate';
const inputValue = ref('');
const { setValue, value: postCodeValue } = useField('postcode');
const { value: stateFieldValue } = useField('state');

const updateFieldValue = () => {
    console.log(stateFieldValue.value)
    setValue(inputValue.value);
}; */
// === above section how can i set or get value form vee-validate

// const { setFieldValue } = useForm({
//     initialValues: organisation,
// });

// const setAddr = () => {
//     setFieldValue('address', 'Bd, Bang');
//     setFieldValue('city', 'test');
//     setFieldValue('state', 'SA');
//     setFieldValue('postcode', '5587');
// }

const orgAdminTypes = ['nfp', 'fp', 'charity'];
</script>

<template>
    <div class="content active dstepper-block">
        <!-- <input type="text" v-model="inputValue" />
        <button @click="updateFieldValue" type="button">Set Field Value</button> -->

        <div class="content-header mb-3">
            <h5 class="mb-1" v-if="organisation.client_type === 'nfp'">Organisation Information</h5>
            <h5 class="mb-1" v-else>Your Information</h5>
            <small v-if="organisation.client_type === 'nfp'">The organisation</small>
            <small v-else>Your</small>
            <small> information is important for other NFP or Charities to find and know about you and
                your activities.
                Please provide a short summary, your logo and a detailed description of what you do, where you are
                located etc that will be used on searching and represent you in your
                <small v-if="organisation.client_type === 'nfp'">organisation</small> profile.</small>
        </div>
        <div class="d-flex align-items-center mb-2">
            <div class="me-3">
                <img :src="'/storage/' + organisation.logo" alt="Your Logo" class="rounded img-fluid" height="100" width="110">
            </div>

            <div>
                <FilePond
                    class="filepond"
                    url="/organisation/upload"
                    @processed-file="uploadedFile"
                />
                <!-- <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                    <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" for="account-upload">Upload Organisation logo</label>
                    <input type="file" id="account-upload" hidden="">
                    <button class="btn btn-sm btn-secondary ms-2">Reset</button>
                </div> -->
                <p class="text-muted mt-n3 mb-0">
                    <small>Allowed JPG, GIF or PNG. Max size of 1MB</small>
                </p>
            </div>
            <!-- <button type="button" @click="setAddr">set addrs</button> -->
        </div>

        <div class="row g-3">
            <!-- <div class="col-sm-5">
                <label class="form-label" for="org_name">Name of the Organisation</label>
                <VField name="org_name"
                    label="org. name"
                    id="org_name"
                    class="form-control"
                    placeholder="Your Org. Name" />
                <ErrorMessage class="fs-tiny text-danger" name="org_name" />
            </div> -->

            <TextInput
                v-if="orgAdminTypes.includes(organisation.client_type)"
                class="col-md-5"
                vlabel="org. name"
                name="org_name"
                type="text"
                label="Name of the Organisation"
                placeholder="Your Org. Name"
            />

            <TextInput
                v-if="orgAdminTypes.includes(organisation.client_type)"
                class="col-md-2"
                name="abn"
                type="text"
                label="ABN"
                placeholder="ABN"
            />

            <TextInput
                v-if="orgAdminTypes.includes(organisation.client_type)"
                class="col-md-2"
                name="acn"
                type="text"
                label="ACN"
                placeholder="ACN"
            />

            <TextInput
                :class="[orgAdminTypes.includes(organisation.client_type) ? 'col-md-3' : 'col-md-6']"
                name="website"
                type="text"
                label="Website (if any)"
                placeholder="https://your-org-url.com.au"
            />

            <TextInput
                :class="[orgAdminTypes.includes(organisation.client_type) ? 'col-md-5' : 'col-md-6']"
                name="address"
                type="text"
                label="Address"
                placeholder="Address of the Organisation"
            />

            <div :class="[orgAdminTypes.includes(organisation.client_type) ? 'col-sm-2' : 'col-sm-4']">
                <label class="form-label" for="state">State</label>

                <v-field name="state" rules="required" v-model="organisation.state" v-slot="{ field, errors }">
                    <select v-bind="field"
                            :class="{ 'form-control': true, 'is-invalid': !!errors[0] }"
                            @change="getCities">
                        <option value="">Select State</option>
                        <option v-for="state in store?.states" :key="state.state" :value="state.state">
                            {{ state.state }}
                        </option>
                    </select>
                    <error-message :class="{'invalid-feedback': errors[0]}" name="org_type"></error-message>
                </v-field>

            </div>

            <div :class="[orgAdminTypes.includes(organisation.client_type) ? 'col-md-3' : 'col-md-4']">
                <label class="form-label" for="city">City</label>
                <v-field name="city" rules="required" v-slot="{ field, errors }" v-model="organisation.city">
                    <select v-bind="field"
                            :class="{ 'form-control': true, 'is-invalid': !!errors[0] }"
                            @change="getPostCode">
                        <option value="">Select City</option>
                        <option v-for="(city,index) in store?.cities" :key="index" :value="city.locality">
                            {{ city.locality }}
                        </option>
                    </select>
                    <error-message :class="{'invalid-feedback': errors[0]}" name="city"></error-message>
                </v-field>
            </div>

            <div :class="[orgAdminTypes.includes(organisation.client_type) ? 'col-md-2' : 'col-md-4']">
                <label class="form-label" for="postcode">Postcode</label>
                <v-field name="postcode" rules="required" v-model="organisation.postcode" v-slot="{ field, errors }">
                    <input type="text"
                           @input="callMethods"
                           class="form-control"
                           :class="{'is-invalid': errors[0]}"
                           placeholder="Enter postcode"
                           v-bind="field"
                    />
                    <error-message :class="{'invalid-feedback': errors[0]}" name="postcode"></error-message>
                </v-field>
            </div>

            <label class="form-label" for="other-locations">
                Other Location

                <button type="button" @click="push({address: '', city: '', state: '', postcode: ''})"
                        class="btn btn-label-secondary btn-xs ms-3 pe-2 ps-1 rounded-3">
                    <i class="bx bx-plus"></i> Add more
                </button>
            </label>

            <div class="row mb-1" v-for="(field, idx) in fields" :key="field.key">
                <div class="col-3">
                    <VField :name="`other_locations[${idx}].address`" class="form-control" :placeholder="`Address`"/>
                </div>

                <div class="col-3">
                    <VField :name="`other_locations[${idx}].city`" class="form-control" :placeholder="`City`"/>
                </div>

                <div class="col-3">
                    <VField
                        :name="`other_locations[${idx}].state`"
                        v-slot="{ field, errorMessage }"
                    >
                        <select v-bind="field"
                                :class="{
                                'form-control': true,
                                'is-invalid': !!errorMessage
                            }">
                            <option value="">Select a State</option>
                            <option
                                v-for="(state, idx) in states"
                                :key="`state-${idx}`"
                                :value="state">{{ state }}
                            </option>
                        </select>
                    </VField>
                </div>

                <div class="col-3 d-flex align-items-center">
                    <VField :name="`other_locations[${idx}].postcode`" class="form-control" :placeholder="`Postcode`"/>
                    <a href="#" @click.prevent="remove(idx)" class="ps-2"><i
                        class="bx bx-x fs-5 fw-bolder text-danger"></i></a>
                </div>
            </div>

            <!-- <div class="align-items-end col-md-2 d-flex mb-1 mt-0">
                <button type="button" class="btn-label-slack btn btn-sm pe-2 ps-1" @click="totalAddr += 1"><i class="bx bx-plus"></i> Add more</button>
            </div> -->

            <div class="col-md-12">
                <label class="form-label" for="summary">Summary</label>
                <VField name="summary" v-slot="{ field, errorMessage }">
                    <textarea
                        v-bind="field"
                        :class="{'form-control': true, 'is-invalid': !!errorMessage}"
                        cols="3"
                        rows="3"
                        placeholder="A short summary of the organisation"
                        v-autosize></textarea>

                    <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                </VField>

                <p class="mb-0 fs-tiny">The summary is restricted to 120 characters, please give a short description of
                    your organisation specially the service you provide </p>

                <!-- <VField name="summary"
                    id="summary"
                    class="form-control"
                    as="textarea"
                    cols="3"
                    rows="3"
                    placeholder="A short summary of the organisation"
                />
                <ErrorMessage class="fs-tiny text-danger" name="summary" /> -->
            </div>

            <div class="col-md-12">
                <label class="form-label" for="details">Details</label>
                <VField name="details" v-slot="{ field, errorMessage }">
                    <textarea
                        v-bind="field"
                        :class="{'form-control': true, 'is-invalid': !!errorMessage}"
                        cols="3"
                        rows="6"
                        placeholder="Detailed description of the organisation"
                        v-autosize></textarea>

                    <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                </VField>
                <p class="mb-0 fs-tiny">A detailed description of the organisation which will get displayed in your
                    organisation page.</p>
            </div>
        </div>
    </div>
</template>
