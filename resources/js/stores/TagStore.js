import useDatatableFunc from "@/composables/useDatatableFunc.js";
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import { tag } from "@/core/endpoints";
import { defineStore } from 'pinia';

const { destroy } = useUtilsFunc();
const { buildURLQuery } = useUrlFunc();
const { getItemAndMetaData } = useDatatableFunc();

export const useTagStore = defineStore('TagStore', {
    state: () => ({
        meta: {},
        tags: [],
        allTags: [],
        tagOptions: [],
        editTag: null,
        loading: false,
        isTagAddable: false,
        isTagInvalid: false,
        tagName: "",
        search: "",
    }),

    getters: {
        totalTag() {
            return this.meta?.total ?? this.tags.length;
        },
    },

    actions: {
        async fill(params) {
            this.loading = true;
            fullPageLoader.show();

            const queryParams = this.search ? {...params, query: this.search} : params;
            const urlParams = buildURLQuery(queryParams, true);

            try {
                const result = await axios.get(`${tag}/all${urlParams ? `?${urlParams}` : ''}`);
                const { data, meta } = getItemAndMetaData(result.data);
                this.meta = meta;
                this.tags = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async fetchTagOptions(params) {
            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${tag}/options${urlParams ? `?${urlParams}` : ''}`);
                this.allTags = result.data;
                this.tagOptions = Object.keys(result.data);
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
        },

        async handleSubmit() {
            this.loading = true;
            fullPageLoader.show();

            try {
                const formId = !this.isTagAddable ? this.editTag.id : null;
                const url = !formId ? tag : `${tag}/${formId}`;

                const formData = new FormData();
                formData.append('name', this.tagName);
                if (formId) formData.append("_method", "PUT");

                const response = await axios.post(url, formData);
                this.fill();
                this.resetForm();
                flash(response.data.message);
            } catch (error) {
                this.isTagInvalid = true;
                flash(error.response.data.message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        delete(data) {
            confirm("Do you want to delete this tag?").then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${tag}/${data.id}`).then(response => {
                        if (response) {
                            this.tags.splice(this.tags.indexOf(data), 1)
                            this.loading = false
                        }
                    });
                }
            });
        },

        handleAddClick() {
            this.tagName = "";
            this.isTagAddable = true;
            this.editTag = {id: 'new', name: ''};
            this.tags.unshift(this.editTag);
        },

        handleEdit(data) {
            this.editTag = data;
            this.tagName = data.name;
            this.isTagInvalid = false;
        },

        resetForm() {
            if (this.isTagAddable && this.editTag?.id == 'new') {
                this.tags.shift();
            }

            this.editTag = null;
            this.isTagAddable = false;
            this.isTagInvalid = false;
        }
    }
});
