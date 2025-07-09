<script setup>
import {useCategoryComposable} from "@/composables/category/category.composable";
import {nextTick} from "vue";
import {COST_OPTIONS, TYPES, WHEN_OPTIONS} from "../../core/categories_data";

const props = defineProps({
    excludeFields     : {
        type    : Array,
        default : () => [],
        required: true
    },
    excludeFieldValues: {
        type    : Object,
        default : () => ({}),
        required: true
    },
});

const excludeFormSubmitHandler = () => {
    store.showExcludeFieldModal = false;
    emitter.emit('closeModal');
    store.excludeFields = store.formattedExcludeFields;
};

const excludeFieldValueFormSubmitHandler = () => {
    store.showExcludeFieldValueModal = false;
    emitter.emit('closeModal');
    store.excludeFieldValues = store.formattedExcludeFieldValues;
};

const {
          categoryForm,
          store,
          onSubmit,
          typeChangeHandler,
          whereChangeHandler,
          whenChangeHandler,
          costChangeHandler,
          summaryChangeHandler,
      } = useCategoryComposable();
</script>

<template>
    <div class="col-12">
        <div class="card">
            <v-form ref="categoryForm" @submit="onSubmit">
                <div class="card-body">
                    <InputGroup label="Name" class="form-group">
                        <v-field name="name" label="name" rules="required" v-model="store.form.name"
                                 v-slot="{ field, errors }">
                            <input type="text"
                                   class="form-control"
                                   :class="{'is-invalid': errors[0]}"
                                   placeholder="Enter name"
                                   v-bind="field"
                            />
                            <error-message :class="{'invalid-feedback': errors[0]}" name="name"></error-message>
                        </v-field>
                    </InputGroup>

                    <InputGroup label="Code" class="form-group">
                        <v-field name="code" label="code" rules="required" v-model="store.form.code"
                                 v-slot="{ field, errors }" readonly>
                            <input type="text"
                                   class="form-control"
                                   :class="{'is-invalid': errors[0]}"
                                   placeholder="Enter code"
                                   v-bind="field"
                            />
                            <error-message :class="{'invalid-feedback': errors[0]}" name="code"></error-message>
                        </v-field>
                    </InputGroup>

                    <div class="form-group mb-3">
                        <label for="parent" class="form-label">Parent Category</label>
                        <Select2 :settings="{allowClear: true}" id="parent" name="parent_id" class="mt-2"
                                 placeholder="Select Parent Category" v-model="store.form.parent_id"
                                 :options="store.select2Options"/>
                    </div>

                    <div class="form-group mb-3">
                        <label for="exclude-for" class="form-label">Exclude For</label>
                        <select class="form-control" name="exclude_for" id="exclude-for"
                                v-model="store.form.exclude_for">
                            <option value="">Select Exclude For</option>
                            <option value="org">Organisation</option>
                            <option value="inv">Individual</option>
                        </select>
                    </div>

                    <InputGroup label="Exclude Fields" class="form-group">
                        <v-field name="exclude_fields" label="Exclude Fields"
                                 v-model="store.excludeFields"
                                 v-slot="{ field, errors }">
                            <input type="text"
                                   class="form-control"
                                   :class="{'is-invalid': errors[0]}"
                                   placeholder="Select Exclude Fields"
                                   v-bind="field" @click.prevent="store.showExcludeFieldModal = true"
                            />
                            <error-message :class="{'invalid-feedback': errors[0]}"
                                           name="exclude_fields"></error-message>
                        </v-field>
                    </InputGroup>

                    <InputGroup label="Exclude Field Values" class="form-group">
                        <v-field name="exclude_field_values" label="Exclude Field Values"
                                 v-model="store.excludeFieldValues"
                                 v-slot="{ field, errors }">
                            <input type="text"
                                   class="form-control"
                                   :class="{'is-invalid': errors[0]}"
                                   placeholder="Select Exclude Field Values"
                                   v-bind="field" @click.prevent="store.showExcludeFieldValueModal = true"
                            />
                            <error-message :class="{'invalid-feedback': errors[0]}"
                                           name="exclude_field_values"></error-message>
                        </v-field>
                    </InputGroup>

                    <InputGroup label="Status" class="form-group">
                        <v-field name="status" label="status" rules="required" v-model="store.form.status"
                                 v-slot="{ field, errors }">
                            <select class="form-control" :class="{'is-invalid': errors[0]}" v-bind="field">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <error-message :class="{'invalid-feedback': errors[0]}" name="status"></error-message>
                        </v-field>
                    </InputGroup>

                    <fieldset>
                        <legend>Custom Labels</legend>

                        <div class="col-md-12">
                            <div class="form-check form-check-success mb-2">
                                <label for="is-type-labels">
                                    <input class="form-check-input" type="checkbox" :value="true"
                                           name="is_type_labels"
                                           :checked="store.isTypeLabels"
                                           @change.prevent="typeChangeHandler($event)"
                                           id="is-type-labels"/>
                                    Is Type Labels
                                </label>
                            </div>
                            <div class="form-group row mb-2" v-for="(type, tIndex) in TYPES" :key="tIndex"
                                 v-if="store.isTypeLabels">
                                <div class="col-md-6">
                                    <input type="text" readonly
                                           :value="type.charAt(0).toUpperCase() + type.slice(1)"
                                           :id="`type-title-${tIndex}`" class="form-control"
                                           placeholder="Enter title">
                                </div>

                                <div class="col-md-6">
                                    <input type="text" :id="`type-label-${tIndex}`" class="form-control"
                                           :placeholder="`Enter ${type} label`"
                                           v-model="store.form.custom_label.type[type]">
                                </div>
                            </div>

                            <div class="form-check form-check-success mt-2 mb-2">
                                <label for="is-where-labels">
                                    <input class="form-check-input" type="checkbox" :value="true"
                                           name="is_where_labels"
                                           :checked="store.isWhereLabels"
                                           @change="whereChangeHandler"
                                           v-model="store.isWhereLabels"
                                           id="is-where-labels"/>
                                    Is Where Labels
                                </label>
                            </div>
                            <div class="form-group mb-2" v-if="store.isWhereLabels">
                                <input type="text" id="where-label" class="form-control"
                                       placeholder="Enter where label" v-model="store.form.custom_label.where">
                            </div>

                            <div class="form-check form-check-success mt-2 mb-2">
                                <label for="is-when-labels">
                                    <input class="form-check-input" type="checkbox" :value="true"
                                           name="is_when_labels"
                                           :checked="store.isWhenLabels"
                                           @change.prevent="whenChangeHandler($event)"
                                           id="is-when-labels"/>
                                    Is When Labels
                                </label>
                            </div>
                            <div v-if="store.isWhenLabels">
                                <div class="form-group mb-2">
                                    <input type="text" id="when-label" class="form-control"
                                           placeholder="Enter when label" v-model="store.form.custom_label.when.title">
                                </div>
                                <div class="form-group row mb-2" v-for="(when, wIndex) in WHEN_OPTIONS" :key="wIndex">
                                    <div class="col-md-6">
                                        <input type="text" readonly
                                               :value="when.charAt(0).toUpperCase() + when.slice(1)"
                                               :id="`when-field-value-${wIndex}`" class="form-control"
                                               placeholder="Enter field value">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" :id="`when-field-value-label-${wIndex}`" class="form-control"
                                               :placeholder="`Enter when-${when} field value label`"
                                               v-model="store.form.custom_label.when[when]">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check form-check-success mt-2 mb-2">
                                <label for="is-cost-labels">
                                    <input class="form-check-input" type="checkbox" :value="true"
                                           name="is_cost_labels"
                                           :checked="store.isCostLabels"
                                           @change.prevent="costChangeHandler($event)"
                                           id="is-cost-labels"/>
                                    Is Cost Labels
                                </label>
                            </div>
                            <div v-if="store.isCostLabels">
                                <div class="form-group mb-2">
                                    <input type="text" id="cost-label" class="form-control"
                                           placeholder="Enter cost label" v-model="store.form.custom_label.cost.title">
                                </div>
                                <div class="form-group row mb-2" v-for="(cost, cIndex) in COST_OPTIONS" :key="cIndex">
                                    <div class="col-md-6">
                                        <input type="text" readonly
                                               :value="cost.charAt(0).toUpperCase() + cost.slice(1)"
                                               :id="`cost-field-value-${cIndex}`" class="form-control"
                                               placeholder="Enter field value">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" :id="`cost-field-value-label-${cIndex}`" class="form-control"
                                               :placeholder="`Enter cost-${cost} field value label`"
                                               v-model="store.form.custom_label.cost[cost]">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check form-check-success mt-2 mb-2">
                                <label for="is-summary-labels">
                                    <input class="form-check-input" type="checkbox" :value="true"
                                           name="is_summary_labels"
                                           :checked="store.isSummaryLabels"
                                           @change.prevent="summaryChangeHandler($event)"
                                           id="is-summary-labels"/>
                                    Is Summary Labels
                                </label>
                            </div>
                            <div v-if="store.isSummaryLabels">
                                <div class="form-group row mb-2">
                                    <div class="col-md-6">
                                        <input type="text" v-model="store.form.custom_label.summary.label"
                                               id="Enter summary label" class="form-control"
                                               placeholder="Enter summary label">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" v-model="store.form.custom_label.summary.placeholder"
                                               id="Enter summary placeholder" class="form-control"
                                               placeholder="Enter summary placeholder">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-danger" @click.prevent="store.view='list'">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-2">Submit</button>
                </div>
            </v-form>
        </div>

        <Modal
            :show="store.showExcludeFieldModal"
            @close="store.showExcludeFieldModal = false"
            title="Exclude Fields"
        >

            <template #body>
                <v-form @submit="excludeFormSubmitHandler">

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <ul class="list-unstyled m-0 ps-4">
                                <li class="d-flex align-items-center mb-3"
                                    v-for="(excludeField, exIndex) in excludeFields"
                                    :key="exIndex">
                                    <div class="form-check form-check-success">
                                        <label :for="`ex_field_${excludeField}`">
                                            <input class="form-check-input" type="checkbox" :value="excludeField"
                                                   name="exclude_fields"
                                                   v-model="store.form.exclude_fields"
                                                   :id="`ex_field_${excludeField}`"/>
                                            {{ excludeField.charAt(0).toUpperCase() + excludeField.slice(1) }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <ModalFooter class="px-0 py-2">
                        <button type="submit" class="btn btn-info">Save Changes</button>
                    </ModalFooter>
                </v-form>
            </template>
        </Modal>

        <Modal
            :show="store.showExcludeFieldValueModal"
            @close="store.showExcludeFieldValueModal = false"
            title="Exclude Field Values"
        >

            <template #body>
                <v-form @submit="excludeFieldValueFormSubmitHandler">

                    <div class="row">
                        <div class="col-6 col-sm-6" v-for="(excludeFieldValueLabel, labIndex) in excludeFieldValues"
                             :key="labIndex">
                            <h4>
                                {{ labIndex.charAt(0).toUpperCase() + labIndex.slice(1) }}
                            </h4>
                            <ul class="list-unstyled m-0 ps-4">
                                <li class="d-flex align-items-center mb-3"
                                    v-for="(excludeFieldVal, exValIndex) in excludeFieldValueLabel"
                                    :key="exValIndex">
                                    <div class="form-check form-check-success">
                                        <label :for="`ex_field_${excludeFieldVal}`">
                                            <input class="form-check-input" type="checkbox" :value="excludeFieldVal"
                                                   name="exclude_fields"
                                                   v-model="store.form.exclude_field_values[labIndex]"
                                                   :id="`ex_field_${excludeFieldVal}`"/>
                                            {{ excludeFieldVal.charAt(0).toUpperCase() + excludeFieldVal.slice(1) }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <ModalFooter class="px-0 py-2">
                        <button type="submit" class="btn btn-info">Save Changes</button>
                    </ModalFooter>
                </v-form>
            </template>
        </Modal>
    </div>
</template>
