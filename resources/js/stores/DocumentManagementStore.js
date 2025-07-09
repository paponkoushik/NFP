import { useUrlFunc } from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import { documentManagement } from "@/core/endpoints";
import { defineStore } from 'pinia';
import { useTagStore } from "@/stores/TagStore";

const { buildURLQuery } = useUrlFunc();
const { handleFormError, destroy } = useUtilsFunc();

export const useDocumentManagementStore = defineStore('DocumentManagementStore', {
    state: () => ({
        documentCollections: [],
        selectedDocuments: [],
        selectedCollections: [],
        selectedCollectionId: null,
        emptyMsg: `You haven't selected any collection to view. <br>Please select any collection from the collection pane to load & view the page here.`,
        loading: false,
        showModal: false,
        uploadPath: null,
        form: {
            id: null,
            title: "",
            is_free: false,
            price: "",
            summary: "",
            is_external_link: false,
            external_link: "",
            path: null,
            tags: [],
            collections: [],
        }
    }),

    getters: {
        totalDocumentCollection() {
            return this.documentCollections.length;
        },
    },

    actions: {
        async fill() {
            this.loading = true;
            fullPageLoader.show();

            const params = this.search ? {query: this.search} : null;
            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${documentManagement}/all${urlParams ? `?${urlParams}` : ''}`);
                this.documentCollections = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async handleSubmit(values, veeForm) {
            if (this.checkValidation() === false) return false;

            this.loading = true;
            fullPageLoader.show();
            console.log('calling')

            try {
                const formId = this.form.id;
                const formData = new FormData();

                for (let key in this.form) {
					formData.append(key, this.form[key] ? this.form[key] : null);
				}
                formData.append("path", this.form.path ?? "");
                formData.append("tags", this.getTagIds());

				const url = !formId ? documentManagement : `${documentManagement}/${formId}`;
                if (formId) {
                    formData.append("_method", "PUT");
                }

                const response = await axios.post(url, formData);
                this.fill();
                this.resetForm();
                veeForm.resetForm();
                emitter.emit('closeModal');
                flash(response.data.message);
            } catch (error) {
                handleFormError(error.response);
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        delete() {
            confirm("Do you want to delete this document?").then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${documentManagement}/${this.form.id}`).then(response => {
                        if (response) {
                            emitter.emit('closeModal');
                            this.fill();
                            this.loading = false
                        }
                    });
                }
            });
        },

        async deleteFile() {
            this.loading = true;

            try {
                const response = await axios.post(`${documentManagement}/file-delete`, {id: this.form.id, path: this.uploadPath});
                this.uploadPath = null;
                flash(response.data.message);
            } catch (error) {
                handleFormError(error.response);
            }

            this.loading = false;
        },

        handleDocumentSelect(document) {
            this.form.id = document.id;
            this.form.title = document.title;
            this.form.price = !document.is_free ? document.price : "";
            this.form.path = document.type != 'link' ? document.path : null;
            this.form.is_free = document.is_free;
            this.form.summary = document.summary && document.summary != 'null' ? document.summary : "";
            this.form.is_external_link = document.type == 'link' ? true : false;
            this.form.external_link = document.type == 'link' ? document.path : "";
            this.form.tags = document.tags;
            this.form.collections = document.documentCollections;
            this.uploadPath = (document.type != 'link' && document.path) ? document.path : null;
            this.showModal = true;
        },

        handleAddClick() {
            this.resetForm();
            this.showModal = true;
        },

        resetForm() {
            this.form.id = null;
            this.form.title = "";
            this.form.price = "";
            this.form.summary = "";
            this.form.path = null;
            this.form.is_free = false;
            this.form.is_external_link = false;
            this.form.external_link = "";
            this.form.tags = [];
            this.form.collections = [];
        },

        getTagIds() {
            if (this.form.tags?.length > 0) {
                const tagStore = useTagStore();
                let tagIds = [];
                for (let tag of this.form.tags) {
                    tagIds.push(tagStore.allTags[tag]);
                }
                return tagIds;
            }
            return [];
        },

        checkValidation() {
            console.log(this.form.path)
            if (this.form.collections?.length <= 0) {
                flash("Select at least one collection from collection pane.", "danger");
                return false;
            } else if (!this.form.is_external_link && !this.form.path) {
                flash("Upload a file or add an external link.", "danger");
                return false;
            }

            return true;
        },

        handleCollectionSelect(collection) {
            if (this.selectedCollectionId != collection.id) {
                this.selectedCollectionId = collection.id;
                this.selectedCollections = collection.childs ?? [];
                this.selectedDocuments = collection.documents ?? [];
                this.emptyMsg = "Sorry ... it seems there is no data added in the collection yet."
            }
        }
    }
});
