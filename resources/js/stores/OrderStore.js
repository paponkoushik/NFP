import useDatatableFunc from "@/composables/useDatatableFunc.js";
import {useUrlFunc} from '@/composables/useUrlFunc.js';
import {order} from "@/core/endpoints";
import {defineStore} from 'pinia';

const {buildURLQuery} = useUrlFunc();
const {getItemAndMetaData} = useDatatableFunc();

export const useOrderStore = defineStore('OrderStore', {
    state: () => ({
        meta   : {},
        orders : [],
        loading: false,
        search : "",
        form   : {
            id     : null,
            title  : "",
            is_free: false,
        }
    }),

    getters: {
        totalOrders() {
            return this.meta?.total ?? this.orders.length;
        },
    },

    actions: {
        async fill(params) {
            this.loading = true;
            fullPageLoader.show();

            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${order}/all${urlParams ? `?${urlParams}` : ''}`);
                const {data, meta} = getItemAndMetaData(result.data);
                this.meta = meta;
                this.orders = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async getPurchaseDocuments(params) {
            this.loading = true;
            fullPageLoader.show();

            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${document}/purchase${urlParams ? `?${urlParams}` : ''}`);
                const {data, meta} = getItemAndMetaData(result.data);
                this.meta = meta;
                this.documents = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async handleBuyClick(data) {
            if (this.cartItems.includes(data.id) === true) {
                flash("Document already exists in cart!", "danger");
                return false;
            }

            this.loading = true;
            fullPageLoader.show();

            try {
                const response = await axios.post(document, {document_id: data.id});
                this.cartItems.push(data.id);
                flash(response.data.message);
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

            try {
                const formId = this.form.id;
                const formData = new FormData();

                for (let key in this.form) {
                    formData.append(key, this.form[key]);
                }
                formData.append("path", this.form.path ?? "");
                formData.append("tags", this.getTagIds());

                const url = !formId ? document : `${document}/${formId}`;
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

                    destroy(`${document}/${this.form.id}`).then(response => {
                        if (response) {
                            emitter.emit('closeModal');
                            this.fill();
                            this.loading = false
                        }
                    });
                }
            });
        },

        handleDocumentSelect(document) {
            this.form.id = document.id;
            this.form.title = document.title;
            this.form.price = !document.is_free ? document.price : "";
            this.form.path = document.type != 'link' ? document.path : null;
            this.form.is_free = document.is_free;
            this.form.is_external_link = document.type == 'link' ? true : false;
            this.form.external_link = document.type == 'link' ? document.path : "";
            this.form.tags = document.tags;
            this.form.collections = document.collections;
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
        },

        handleCollectionSelect(collection) {
            if (this.selectedCollectionId != collection.id) {
                this.selectedCollectionId = collection.id;
                this.emptyMsg = "Sorry ... it seems there is no data added in the collection yet."
                this.fill();
            }
        }
    }
});
