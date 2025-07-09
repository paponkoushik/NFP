import useDatatableFunc from "@/composables/useDatatableFunc.js";
import {useUrlFunc} from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import {category} from "@/core/endpoints";
import {defineStore} from 'pinia';
import {nextTick} from "vue";

const {getItemAndMetaData} = useDatatableFunc();
const {destroy} = useUtilsFunc();
const {getUrlParams, buildURLQuery} = useUrlFunc();

export const useCategoryStore = defineStore('CategoryStore', {
    state: () => ({
        meta                      : {},
        categories                : [],
        categoryOptions           : [],
        select2Options            : [],
        subCategoryOptions        : [],
        loading                   : false,
        editMode                  : false,
        view                      : 'list',
        showExcludeFieldModal     : false,
        showExcludeFieldValueModal: false,
        excludeFields             : '',
        excludeFieldValues        : '',
        customLabels              : [],
        isTypeLabels              : false,
        isWhereLabels             : false,
        isWhenLabels              : false,
        isCostLabels              : false,
        isSummaryLabels           : false,
        filterSelectedCategoryIds : [],
        form                      : {
            id                  : null,
            parent_id           : '',
            name                : '',
            code                : '',
            status              : 'active',
            exclude_for         : '', // org or inv
            exclude_fields      : [], // array elements
            exclude_field_values: {
                where: [],
                when : [],
            }, // object
            custom_label        : {}, // json data
        }
    }),

    getters: {
        totalCategory() {
            return this.meta?.total ?? this.categories.length;
        },
        formattedExcludeFields(state) {
            return state.form.exclude_fields.length ? state.form.exclude_fields.map((field) => {
                return field.charAt(0).toUpperCase() + field.slice(1);
            }).join(', ') : '';
        },
        formattedExcludeFieldValues(state) {
            return Object.keys(state.form.exclude_field_values).length ? Object.keys(state.form.exclude_field_values).map((key) => {
                if (state.form.exclude_field_values[key].length) {
                    return `${key.charAt(0).toUpperCase() + key.slice(1)}: [${state.form.exclude_field_values[key].map((val) => {
                        return val.charAt(0).toUpperCase() + val.slice(1);
                    }).join(', ')}]`;
                }
            }).filter((val) => val).join(', ') : '';
        }
    },

    actions: {
        async fill() {
            this.loading = true;
            const urlParams = buildURLQuery(getUrlParams(), true);

            try {
                const result = await axios.get(`${category}/all${urlParams ? `?${urlParams}` : ''}`);
                const {data, meta} = getItemAndMetaData(result.data);
                this.meta = meta;
                this.categories = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
            this.loading = false
        },

        async getAllCategories(params, subCategory = false) {
            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${category}/options${urlParams ? `?${urlParams}` : ''}`);

                if (subCategory) {
                    this.subCategoryOptions = result.data;
                } else {
                    this.categoryOptions = result.data;
                }
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
        },

        async getSelect2Options() {
            try {
                const result = await axios.get(`${category}/select2-parent-categories`);

                this.select2Options = result.data.results;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
        },

        resetForm() {
            this.editMode = false;
            this.form.id = null;
            this.form.parent_id = "";
            this.form.name = "";
            this.form.code = "";
            this.form.status = "active";
            this.form.exclude_for = "";
            this.form.exclude_fields = [];
            this.form.exclude_field_values = {
                where: [],
                when : [],
            };
            this.form.custom_label = {};
            this.excludeFields = '';
            this.excludeFieldValues = '';
        },

        editHandler(data) {
            if (data) {
                this.editMode = true;
                this.form.id = data.id ?? null;
                this.form.parent_id = data.parent?.id ?? "";
                this.form.name = data.name;
                this.form.code = data.code;
                this.form.status = data.status;
                this.form.exclude_for = data.exclude_for ?? "";
                this.form.exclude_fields = data.exclude_fields ?? "";
                this.excludeFields = this.formattedExcludeFields;
                this.form.exclude_field_values = data.exclude_field_values ?? "";
                this.excludeFieldValues = this.formattedExcludeFieldValues;
                this.form.custom_label = data.custom_label ?? {};
                this.isTypeLabels = Object.keys(this.form.custom_label.type ?? {}).length > 0;
                this.isWhereLabels = this.form.custom_label.hasOwnProperty('where') && this.form.custom_label.where !== '';
                this.isWhenLabels = Object.keys(this.form.custom_label.when ?? {}).length > 0;
                this.isCostLabels = Object.keys(this.form.custom_label.cost ?? {}).length > 0;
                this.isSummaryLabels = Object.keys(this.form.custom_label.summary ?? {}).length > 0;
                this.view = "form";
            }
        },

        async submit() {
            try {
                const formId = this.form.id;
                const url = !formId ? category : `${category}/${formId}`;
                if (this.form.id) {
                    this.form['_method'] = 'PUT';
                }

                const response = await axios.post(url, this.form);
                this.fill();
                this.resetForm();
                this.view = "list";
                flash(response.data.message);
            } catch (error) {
                if (error.response.status == 422) {
                    const errors = "errors" in error.response.data ? error.response.data.errors : error.response.data;
                    throw errors;
                }

                flash(error.response.data.message, "danger");
            }
            this.loading = false
        },

        delete(data) {
            confirm("Do you want to delete this request?").then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${category}/${data.id}`).then(response => {
                        this.fill();
                    });
                }
            });
        }
    }
});
