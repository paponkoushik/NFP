<script setup>
import CustomCheckbox from '@/components/Shared/CustomCheckbox';
import {useOurPreferencesComposable} from "../../../composables/organization/steps/our_preferences.composable";
import {TYPES, EMAIL_PREFERENCES} from "@/core/categories_data";
import WhereComponent from "./Partials/WhereComponent.vue";
import WhenComponent from "./Partials/WhenComponent.vue";
import CostComponent from "./Partials/CostComponent.vue";


const {
          store,
          preferenceFormData,
          getSlug,
          typeChangeHandler,
          emailPreferenceChangeHandler,
          checkExcludeField,
          renderTypeCustomLabel,
      } = useOurPreferencesComposable();

</script>

<template>

    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <h5 class="mb-1">Our Preferences</h5>
            <small>The preferences to get emails based on what you are looking for &amp; offering</small>
        </div>

        <div class="row my-4">
            <div class="col-12">
                <div class="accordion" id="collapsibleSection">
                    <div v-for="(item, idx) in store.our_preferences" :key="idx" class="card accordion-item">
                        <!-- header & breadcrumb -->
                        <h2 class="accordion-header" :id="`headingDeliveryAddress-${idx}`">
                            <button type="button"
                                    :class="{
                                    'accordion-button': true,
                                    'bg-label-linkedin': item.type || item.where.location || item.where_looking.looking || item.where_offer.offer
                            }"
                                    data-bs-toggle="collapse"
                                    :data-bs-target="`#collapseDeliveryAddress-${idx}`"
                                    aria-expanded="true"
                                    :aria-controls="`collapseDeliveryAddress-${idx}`"
                            >
                                <span class="text-muted">
                                    {{ item.category }}
                                    <i class="bx bx-chevron-right"></i>
                                </span>

                                <span class="text-muted" v-if="item.sub_category">
                                    {{ item.sub_category }}
                                    <i class="bx bx-chevron-right"></i>
                                </span>
                                {{ item.sub1_category }}{{
                                    !checkExcludeField(idx, 'type') && store.organisation.client_type !== 'individual' ? '' : ' - (Seeking)'
                                }}
                            </button>
                        </h2>
                        <!-- End of header & breadcrumb -->

                        <div :id="`collapseDeliveryAddress-${idx}`"
                             :class="`accordion-collapse collapse ${idx === 0 ? 'show' : ''}`"
                             data-bs-parent="#collapsibleSection">
                            <div class="accordion-body mt-2">
                                <!-- type -->
                                <div class="row g-3 mb-3"
                                     v-if="!checkExcludeField(idx, 'type') && store.organisation.client_type !== 'individual'">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <template v-for="(type, typeKey) in TYPES"
                                                      :key="typeKey">
                                                <CustomCheckbox
                                                    @click="typeChangeHandler(type, idx)"
                                                    class="col-md-4"
                                                    as="radio"
                                                    type="radio"
                                                    :name="`our_preferences.${idx}.type`"
                                                    :classes="`${type === item.type ? 'checked' : ''}`"
                                                    :label="renderTypeCustomLabel(idx, type)"
                                                    :value="type"/>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" :name="'our_preferences.' + idx + '.category'"
                                       :value="item.category">
                                <input type="hidden" :name="'our_preferences.' + idx + '.sub_category'"
                                       :value="item.sub_category">
                                <input type="hidden" :name="'our_preferences.' + idx + '.sub1_category'"
                                       :value="item.sub1_category">

                                <!-- individual -->
                                <div v-if="item.type !== 'both' || store.organisation.client_type === 'individual'"
                                     class="row g-3">

                                    <!-- where -->
                                    <where-component :item="item" :loop-key="idx" :key="idx"
                                                     :values="item.where"
                                                     class="col-6 mt-2"
                                                     @radiusChange="radiusSelectionHandler"
                                                     @where-change="whereChangeHandler"
                                                     v-if="!checkExcludeField(idx, 'where')">
                                    </where-component>

                                    <!-- when -->
                                    <when-component :item="item" :key="idx" :values="item.where" class="col-6 mt-2"
                                                    v-show="!checkExcludeField(idx, 'when')">
                                    </when-component>

                                    <!-- cost -->
                                    <cost-component class="col-md-12 mt-2" :item="item" :values="item.where"
                                                    v-show="!checkExcludeField(idx, 'cost')">
                                    </cost-component>

                                </div>

                                <!-- both -->
                                <div
                                    v-if="item.type === 'both'"
                                    class="row mt-3">
                                    <div class="col-6">
                                        <div class="p-2 rounded shadow-sm h-100">
                                            <p class="border-light fs-5 mb-0">We are searching</p>

                                            <!-- where -->
                                            <where-component :item="item" :loop-key="idx" :key="idx"
                                                             :values="item.where_looking"
                                                             type="looking"
                                                             class="mt-2"
                                                             v-if="!checkExcludeField(idx, 'where')">
                                            </where-component>

                                            <!-- when -->
                                            <when-component :item="item" :key="idx" :values="item.where_looking"
                                                            class="mt-2" v-if="!checkExcludeField(idx, 'when')">
                                            </when-component>

                                            <!-- cost -->
                                            <cost-component class="mt-2" :key="idx" :item="item"
                                                            :values="item.where_looking"
                                                            v-if="!checkExcludeField(idx, 'cost')">
                                            </cost-component>

                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="p-2 rounded shadow-sm h-100">
                                            <p class="border-light fs-5 mb-0">We are offering</p>

                                            <!-- where -->
                                            <where-component :item="item" :loop-key="idx" :key="idx"
                                                             :values="item.where_offer"
                                                             type="offer"
                                                             class="mt-2"
                                                             v-if="!checkExcludeField(idx, 'where')">
                                            </where-component>

                                            <!-- when -->
                                            <when-component :item="item" :key="idx" :values="item.where_offer"
                                                            class="mt-2" v-if="!checkExcludeField(idx, 'when')">
                                            </when-component>

                                            <!-- cost -->
                                            <cost-component class="mt-2" :key="idx" :item="item"
                                                            :values="item.where_offer"
                                                            v-if="!checkExcludeField(idx, 'cost')">
                                            </cost-component>

                                        </div>
                                    </div>
                                </div>

                                <!-- Summary -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="summary">
                                            {{
                                                Object.keys(item.custom_labels).length
                                                && item.custom_labels.hasOwnProperty('summary')
                                                && Object.keys(item.custom_labels.summary).length
                                                && item.custom_labels.summary.hasOwnProperty('label')
                                                    ? item.custom_labels.summary.label : 'Summary'
                                            }}
                                        </label>
                                        <v-field :name="`our_preferences.${idx}.summary`" rules="required"
                                                 v-model="item.summary"
                                                 v-slot="{ field, errors }">
                                            <textarea v-bind="field"
                                                      :class="{'form-control': true, 'is-invalid': errors[0]}"
                                                      cols="3"
                                                      rows="3"
                                                      :placeholder="Object.keys(item.custom_labels).length
                                                && item.custom_labels.hasOwnProperty('summary')
                                                && Object.keys(item.custom_labels.summary).length
                                                && item.custom_labels.summary.hasOwnProperty('placeholder')
                                                    ? item.custom_labels.summary.placeholder : 'Summary what you are looking for & offering'"
                                                      v-autosize></textarea>
                                            <error-message :class="{'invalid-feedback': errors[0]}"
                                                           :name="`our_preferences.${idx}.summary`"></error-message>
                                        </v-field>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- E-mail Preference-->
            <div class="col-12 mt-3 mx-1">
                <label class="form-check-label mb-2">E-mail Preference </label>
                <br/>
                <div class="row">
                    <template v-for="(preference, prefKey) in EMAIL_PREFERENCES"
                              :key="prefKey">
                        <CustomCheckbox
                            @click="emailPreferenceChangeHandler(preference)"
                            class="col-md-3"
                            as="radio"
                            type="radio"
                            name="our_preferences.email_preference"
                            :classes="`${preference === store.email_preference ? 'checked' : ''}`"
                            :label="preference.charAt(0).toUpperCase() + preference.slice(1)"
                            :value="preference"/>
                    </template>
                </div>
            </div>
        </div>
        <ErrorMessage class="invalid-feedback d-block" name="our_preferences"/>
    </div>
</template>
