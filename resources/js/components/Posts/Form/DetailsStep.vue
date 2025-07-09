<script setup>
import {ref, computed, onMounted} from 'vue';
import {usePostStore} from "@/stores/PostStore";
import TextInput from '@/components/Shared/TextInput';
import VueTrix from '@/components/Shared/VueTrix';
import CustomCheckbox from '@/components/Shared/CustomCheckbox';
import WhereComponent from "../../Posts/Form/Partials/WhereComponent.vue";
import WhenComponent from "../../Posts/Form/Partials/WhenComponent.vue";
import CostComponent from "../../Posts/Form/Partials/CostComponent.vue";
import {STATES} from "../../../core/categories_data";
import {debounce} from "lodash";
import { useOrganisationStore } from "../../../stores/OrganisationStore";

const store = usePostStore();
const orgStore = useOrganisationStore();
const {
          form,
          categoryExcludeFields     : excludeFields,
          categoryExcludeFieldValues: excludeFieldValues,
          categoryCustomLabels      : customLabels
      } = store;

const totalAddr = ref(1);

const categorySlug = computed(() => store.form.category.replace(' ', '-').toLowerCase());
const subCategorySlug = computed(() => store.form.sub_category?.replace(' ', '-').toLowerCase());
const subChildcategorySlug = computed(() => store.form.sub_child_category?.replace(' ', '-').toLowerCase());


onMounted(async () => {
    await orgStore.getStates()

    if(store.form.state) {
        await orgStore.getCities(store.form.state)
    }

    if (store.form.city) {
        await orgStore.getPostCode(store.form.city)
    }
});

const getCities = () => {
    orgStore.getCities(store.form.state);
}

const getPostCode = async () => {
    await orgStore.getPostCode(store.form.city)
    store.form.postcode = orgStore.form.postcode;
    store.form.adress = orgStore.form.address;
}

const callMethods = debounce(async (e) => {
    if (e.target.value.length > 3) {
        await orgStore.getCityAndState(e.target.value)
        store.form.postcode = orgStore.form.postcode
        store.form.city = orgStore.form.city
    }
}, 500)
</script>

<template>
    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <h5 class="mb-1">Post Information</h5>
            <!-- <small></small> -->
            <span class="text-muted">{{ form.category_name }} <i v-show="form.sub_category"
                                                                 class="bx bx-chevron-right"></i></span>
            <span v-if="form.sub_child_category">
                <span class="text-muted">{{ form.sub_category }} <i class="bx bx-chevron-right"></i></span>
                {{ form.sub_child_category }}
            </span>
            <span v-else>{{ form.sub_category }}</span>
        </div>


        <div class="row g-3 pb-4">
            <!-- title -->
            <div class="col-md-12">
                <TextInput
                    class="col-md-12"
                    name="title"
                    type="text"
                    label="Title"
                    placeholder="Your Post Title"
                />
                <p class="mb-0 fs-tiny">Give your ad a descriptive title to improve its visibility.</p>
            </div>

            <!-- description -->
            <div class="col-md-12">
                <label class="form-label" for="description">SUMMARY / BRIEF DESCRIPTION</label>
                <VField name="description" v-slot="{ field, errorMessage }">
                    <VueTrix
                        v-bind="field"
                        v-model="form.description"
                        placeholder="A short summary of the post"
                        :class="{'form-control': true, 'is-invalid': !!errorMessage}">
                    </VueTrix>

                    <p class="invalid-feedback mb-0" v-show="errorMessage">{{ errorMessage }}</p>
                </VField>
            </div>

            <TextInput
                class="col-md-5"
                name="address"
                type="text"
                label="Address"
                placeholder="Address of the Organisation"
            />


            <div class="col-sm-2">
                <label class="form-label" for="state">State</label>

                <v-field name="state" rules="required" v-model="store.form.state" v-slot="{ field, errors }">
                    <select v-bind="field"
                            :class="{ 'form-control': true, 'is-invalid': !!errors[0] }"
                            @change="getCities">
                        <option value="">Select State</option>
                        <option v-for="state in orgStore?.states" :key="state.state" :value="state.state">
                            {{ state.state }}
                        </option>
                    </select>
                    <error-message :class="{'invalid-feedback': errors[0]}" name="org_type"></error-message>
                </v-field>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="city">City</label>
                <v-field name="city" rules="required" v-slot="{ field, errors }" v-model="store.form.city">
                    <select v-bind="field"
                            :class="{ 'form-control': true, 'is-invalid': !!errors[0] }"
                            @change="getPostCode">
                        <option value="">Select City</option>
                        <option v-for="(city,index) in orgStore?.cities" :key="index" :value="city.locality">
                            {{ city.locality }}
                        </option>
                    </select>
                    <error-message :class="{'invalid-feedback': errors[0]}" name="city"></error-message>
                </v-field>
            </div>

            <div class="col-md-2">
                <label class="form-label" for="postcode">Postcode</label>
                <v-field name="postcode" rules="required" v-model="store.form.postcode" v-slot="{ field, errors }">
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

            <!-- where -->
            <where-component v-if="!excludeFields.includes('where')" class="col-6 mt-3"
                             :values="form.preferences"
                             :exclude-field-values="excludeFieldValues"
                             :custom-labels="customLabels">
            </where-component>

            <!-- when -->
            <when-component v-if="!excludeFields.includes('when')" class="col-6 mt-3"
                            :values="form.preferences"
                            :exclude-field-values="excludeFieldValues"
                            :custom-labels="customLabels">
            </when-component>

            <!-- cost -->
            <cost-component v-if="!excludeFields.includes('cost')" class="col-md-12 mt-3"
                            :values="form.preferences"
                            :exclude-field-values="excludeFieldValues"
                            :custom-labels="customLabels">
            </cost-component>
        </div>

        <div class="row g-3">
            <CustomCheckbox
                class="col-md-6"
                as="checkbox"
                type="radio"
                name="is_anonymous"
                label="Make Anonymous Post"
                :classes="`${form.is_anonymous ? 'checked' : ''}`"
                @click="form.is_anonymous = !form.is_anonymous"
                :value="form.is_anonymous"/>
        </div>
    </div>
</template>
