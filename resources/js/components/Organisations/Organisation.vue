<script setup>
import {debounce} from "lodash";
import {useOrganisationStore} from "@/stores/OrganisationStore";
import {onMounted, ref} from "vue";
import FilePond from "../Shared/FilePond";

const store = useOrganisationStore();
store.fill();

function pageChange({page, limit}) {
    store.fill({page, limit})
}

const handleSearch = debounce(function (e) {
    const currentStr = e.target.value;
    const prevStr = store.search;

    if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
        return;
    }
    store.search = currentStr;

    store.fill();
}, 500)

function clearSearch() {
    store.search = null;
    store.fill();
}

const orgForm = ref(null);

function handleAddClick() {
    orgForm.value.resetForm();
    store.handleAddClick();
}

const uploadedFile = ({uploadPath}) => {
    store.uploadPath = uploadPath;
    store.form.path = uploadPath;
};

onMounted(async () => {
    await store.getStates()
    await store.getCities()
    await store.getPostCode()
});

const getCities = () => {
    store.getCities();
}

const getPostCode = () => {
    store.getPostCode();
}

const callMethods = debounce(e => {
    if (e.target.value.length > 3) {
        store.getCityAndState(e.target.value)
    }
}, 500)
</script>

<template>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card" :class="$setLoadingSpinner(store.loading)" style="min-height: 75vh;">
                <CardHeader title="Organisations" class="d-flex justify-content-between align-items-cnter">
                    <div style="display: grid; grid-template-columns: auto auto;">
                        <button type="button"
                                class="btn btn-sm btn-info"
                                @click="handleAddClick()"
                        >
                            <span class="tf-icons bx bx-plus"></span>
                        </button>
                    </div>
                </CardHeader>
                <hr/>

                <div class="input-group input-group-merge px-3 pb-2">
                    <span class="input-group-text">
                        <i class="bx bx-search"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search..."
                        aria-label="Search..."
                        :value="store.search"
                        @keyup="handleSearch"
                    >
                    <span
                        class="input-group-text"
                        v-if="store.search"
                        @click="clearSearch()"
                    >
                        <i class="bx bx-x"></i>
                    </span>
                </div>

                <div class="organisation-list overlay custom-scroll mb-2 px-3">
                    <h6 v-if="store.totalOrganisation <= 0" class="text-center mt-3">
                        No organisations found...
                    </h6>

                    <li
                        v-for="organisation in store.organisations"
                        :key="organisation.id"
                        class="list-item"
                        :class="{'active': organisation.id === store.selectedOrgId}"
                        @click="store.handleOrganisationSelect(organisation)"
                    >
                        <a class="d-flex align-items-center">
                            <div class="flex-shrink-0 icon-container">
                                <i class="bx bx-building-house rounded-circle icon"
                                   :class="store.getIconClass(organisation)"></i>
                            </div>
                            <div class="list-info flex-grow-1 ms-2">
                                <h6 class="list-name text-truncate m-0">
                                    {{ organisation.org_name }}
                                </h6>
                                <small class="text-truncate mb-0" v-if="organisation.subscription">
                                    <i class="bx bx-purchase-tag-alt fs-6 me-1"
                                       :class="organisation.org_type ? 'text-danger' : 'text-primary'">
                                    </i>
                                    <span
                                        v-text="organisation.subscription.is_trial ? 'Trial' : organisation.subscription.subscription_period"></span>

                                    <i class="bx bx-calendar fs-6 ms-4 me-1"
                                       style="margin-top: -3px"
                                       :class="`${organisation.expired ? 'text-danger' : 'text-secondary'}`">
                                    </i>
                                    <span>{{ organisation.subscription.to }}</span>
                                </small>
                            </div>

                            <button
                                type="button"
                                class="btn btn-icon btn-sm btn-label-secondary"
                                @click="store.delete(organisation)"
                            >
                                <span class="tf-icons bx bx-trash"></span>
                            </button>
                        </a>
                    </li>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-8">
            <div class="card" style="min-height: 75vh;">
                <CardHeader :title="store.selectedOrgId ? 'Edit Organisation' : 'Create Organisation'"></CardHeader>
                <hr class="mb-0"/>

                <div class="card-body">
                    <v-form ref="orgForm" v-slot="{ handleSubmit }">
                        <div class="row">
                            <div class="col-sm-6">
                                <InputGroup label="Org Name">
                                    <v-field name="org_name" label="org name" rules="required"
                                             v-model="store.form.org_name" v-slot="{ field, errors }">
                                        <input type="text"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter org name"
                                               v-bind="field"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="org_name"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>

                            <div class="col-sm-3">
                                <InputGroup label="Org Type">
                                    <v-field name="org_type" label="type" rules="required" v-model="store.form.org_type"
                                             v-slot="{ field, errors }">
                                        <select
                                            class="form-select"
                                            :class="{'is-invalid': errors[0]}"
                                            v-bind="field"
                                        >
                                            <option value="" selected disabled>Choose type</option>
                                            <option value="client">Client</option>
                                            <option value="legal_partner">Legal Partner</option>
                                        </select>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="org_type"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>

                            <div class="col-sm-3">
                                <InputGroup label="Alias" :required="false">
                                    <v-field name="alias" rules="" v-model="store.form.alias"
                                             v-slot="{ field, errors }">
                                        <input type="text"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter alias"
                                               v-bind="field"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="alias"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <InputGroup label="Address" :required="false">
                                    <v-field name="address" rules="" v-model="store.form.address"
                                             v-slot="{ field, errors }">
                                        <textarea rows="3"
                                                  class="form-control"
                                                  :class="{'is-invalid': errors[0]}"
                                                  placeholder="Include your address"
                                                  v-bind="field">
                                        </textarea>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="address"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <InputGroup label="State">
                                    <v-field name="state" rules="required" v-model="store.form.state"
                                             v-slot="{ field, errors }">
                                        <select v-bind="field"
                                                :class="{ 'form-control': true, 'is-invalid': !!errors[0] }"
                                                name="state"
                                                @change="getCities">
                                            <option value="">Select State</option>
                                            <option v-for="state in store?.states" :key="state.state"
                                                    :value="state.state">{{
                                                state.state
                                                }}
                                            </option>
                                        </select>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="org_type"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>

                            <div class="col-sm-4">
                                <InputGroup label="City">
                                    <v-field name="city" rules="required" v-model="store.form.city"
                                             v-slot="{ field, errors }">
                                        <select v-bind="field"
                                                :class="{ 'form-control': true, 'is-invalid': !!errors[0] }" name="city"
                                                @change="getPostCode">
                                            <option value="">Select City</option>
                                            <option v-for="city in store?.cities" :key="city.locality"
                                                    :value="city.locality">
                                                {{ city.locality }}
                                            </option>
                                        </select>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="city"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>


                            <div class="col-sm-4">
                                <InputGroup label="Post Code">
                                    <v-field name="postcode" rules="required" v-model="store.form.postcode"
                                             v-slot="{ field, errors }">
                                        <input type="text"
                                               @input="callMethods"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter postcode"
                                               v-bind="field"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="postcode"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <InputGroup label="Contact Email">
                                    <v-field name="contact_email" label="contact email" rules="required"
                                             v-model="store.form.contact_email" v-slot="{ field, errors }">
                                        <input type="email"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter email"
                                               v-bind="field"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="contact_email"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>

                            <div class="col-sm-6">
                                <InputGroup label="Contact Phone" :required="false">
                                    <v-field name="contact_phone" label="contact phone" rules=""
                                             v-model="store.form.contact_phone" v-slot="{ field, errors }">
                                        <input type="text"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter phone"
                                               v-bind="field"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="contact_phone"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <InputGroup label="Is Suspend ?">
                                    <br/>
                                    <label class="switch switch-danger mt-2">
                                        <input type="checkbox" class="switch-input" v-model="store.form.status">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">{{ store.form.status ? 'Suspend' : 'No' }}</span>
                                    </label>
                                </InputGroup>
                            </div>

                            <div class="col-sm-3">
                                <InputGroup label="Is Trial ?">
                                    <br/>
                                    <label class="switch switch-success mt-2">
                                        <input type="checkbox" class="switch-input" v-model="store.form.is_trial"
                                               @change="store.calculateExpiryDate()">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">{{
                                                store.form.is_trial ? 'Trial' : 'Subscription'
                                            }}</span>
                                    </label>
                                </InputGroup>
                            </div>

                            <div class="col-sm-6">
                                <InputGroup label="Expiry Date">
                                    <v-field name="expiry_date" label="expiry date" rules=""
                                             v-model="store.form.expiry_date" v-slot="{ field, errors }">
                                        <input type="text"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="YYYY-MM-DD"
                                               v-bind="field"
                                               disabled
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="expiry_date"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row" v-if="!store.form.is_trial">
                            <div class="col-sm-6">
                                <InputGroup label="Subscription Peroid">
                                    <v-field name="subscription_period"
                                             label="subscription period"
                                             rules="required"
                                             v-model="store.form.subscription_period"
                                             v-slot="{ field, errors }">
                                        <select
                                            class="form-select"
                                            :class="{'is-invalid': errors[0]}"
                                            v-bind="field"
                                            @change="store.calculateExpiryDate()"
                                        >
                                            <option value="" selected disabled>Subscription period</option>
                                            <option value="1-month">1 Month</option>
                                            <option value="3-month">3 Month</option>
                                            <option value="6-month">6 Month</option>
                                            <option value="1-year">1 Year</option>
                                        </select>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="subscription_period"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>

                            <div class="col-sm-6">
                                <InputGroup label="Activation/Renewal Date">
                                    <v-field name="activation_date" label="activation date" rules="required"
                                             v-model="store.form.activation_date" v-slot="{ field, errors }">
                                        <flatpickr
                                            class="form-control"
                                            :class="{'is-invalid': errors[0]}"
                                            placeholder="YYYY-MM-DD"
                                            v-bind="field"
                                            @input="store.calculateExpiryDate()"
                                        >
                                        </flatpickr>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="activation_date"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="mb-1">Upload Logo</h6>
                                <p class="m-0 small mb-2">
                                    Photo should be JPG, PNG, JPEG & less then 2 MB
                                </p>

                                <FilePond
                                    class="filepond"
                                    v-if="store.selectedOrgId || store.isCreateOrg"
                                    file-size="2MB"
                                    accepted-types="image/*"
                                    url="/upload-org-file"
                                    :disabled="store.uploadPath ? true : false"
                                    @processed-file="uploadedFile"
                                />
                            </div>

                            <div class="col-md-4">
                                <label v-if="store.uploadPath" class="document-item small mt-5">
                                    <div class="document-content border-0 item px-2">
                                        <img :src="store.uploadPath" alt="org logo" height="70"/>
                                        <i class="bx bx-trash d-none icon hidden-icon" @click="store.deleteFile()"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="px-0 py-2 d-flex flex-row-reverse justify-content-between">
                            <button
                                type="button"
                                class="btn btn-info"
                                @click="handleSubmit($event, store.handleSubmit)">
                                Save Changes
                            </button>
                        </div>
                    </v-form>
                </div>
            </div>
        </div>
    </div>
</template>
