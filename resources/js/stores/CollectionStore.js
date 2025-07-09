import { useUrlFunc } from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import { collection } from "@/core/endpoints";
import { defineStore } from 'pinia';

const { destroy } = useUtilsFunc();
const { buildURLQuery } = useUrlFunc();

export const useCollectionStore = defineStore('CollectionStore', {
    state: () => ({
        collections: [],
        loading: false,
        parentId: null,
        editCollection: null,
        isTitleInvalid: false,
        isCollectionAddable: false,
        title: "",
        search: "",
    }),

    getters: {        
        totalCollection() {
            return this.collections.length;
        },
    },

    actions: {
        async fill() {
            this.loading = true;
            fullPageLoader.show();
            
            const params = this.search ? {query: this.search} : null;
            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${collection}/all${urlParams ? `?${urlParams}` : ''}`);
                this.collections = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async handleSubmit() {
            this.loading = true;
            fullPageLoader.show();

            try {
                const formId = !this.isCollectionAddable ? this.editCollection.id : null;
                const url = !formId ? collection : `${collection}/${formId}`;

                const formData = { title: this.title };
                if (formId) {
                    formData._method = 'PUT';
                }
                if (!formId && this.totalCollection > 0){
                    formData.parent_id = this.parentId;
                }

                const response = await axios.post(url, formData);
                this.fill();
                this.resetForm();
                flash(response.data.message);
            } catch (error) {
                this.isTitleInvalid = true;
                flash(error.response.data.message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        delete() {
            confirm("Do you want to delete this collection?").then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${collection}/${this.editCollection.id}`).then(response => {
                        if (response) {
                            this.fill();
                            this.loading = false
                        }
                    });
                }
            });
        },

        handleAddClick() {
            this.resetForm();
            this.isCollectionAddable = true;
        },

        handleEditClick(data) {
            this.resetForm();
            this.title = data.title;
            this.editCollection = data;
        },

        resetForm() {
            this.title = "";
            this.editCollection = null;
            this.isTitleInvalid = false;
            this.isCollectionAddable = false;
        },

        handleCollectionSelect(data) {
            if (this.parentId != data.id) {
                this.resetForm();
                this.parentId = data.id;
            }
        }
    }
});