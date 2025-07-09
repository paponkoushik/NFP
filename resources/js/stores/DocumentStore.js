import useDatatableFunc from "@/composables/useDatatableFunc.js";
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import { document } from "@/core/endpoints";
import { defineStore } from 'pinia';

const { buildURLQuery } = useUrlFunc();
const { getItemAndMetaData } = useDatatableFunc();

export const useDocumentStore = defineStore('DocumentStore', {
    state: () => ({
        meta: {},
        documents: [],
        cartItems: [],
        orderItems: [],
        orderInfo: [],
        selectedDocument: {},
        selectedCollectionId: null,
        emptyMsg: `You haven't selected any collection to view. <br>Please select any collection from the collection pane to load & view the page here.`,
        loading: false,
        form: {
            id: null,
            title: "",
            is_free: false,
        }
    }),

    getters: {
        totalDocuments() {
            return this.meta?.total ?? this.documents.length;
        },
    },

    actions: {
        async fill(params) {
            this.loading = true;
            fullPageLoader.show();

            const queryParams = this.selectedCollectionId ? {...params, collection: this.selectedCollectionId} : params;
            const urlParams = buildURLQuery(queryParams, true);

            try {
                const result = await axios.get(`${document}/all${urlParams ? `?${urlParams}` : ''}`);
                const { data, meta } = getItemAndMetaData(result.data);
                this.meta = meta;
                this.documents = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async getCartItems(params) {
            this.loading = true;
            fullPageLoader.show();

            const queryParams = this.selectedCollectionId ? {...params, collection: this.selectedCollectionId} : params;
            const urlParams = buildURLQuery(queryParams, true);

            try {
                const result = await axios.get(`${document}/cartItems${urlParams ? `?${urlParams}` : ''}`);
                const { data, meta } = getItemAndMetaData(result.data);
                this.meta = meta;
                this.cartItems = data;
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
                const { data, meta } = getItemAndMetaData(result.data);
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

        async deleteCart(id) {
            const isConfirmed = await confirm("Would you like to remove this item from your shopping bag?");
            if (!isConfirmed) {
              return;
            }

            this.loading = true;

            try {
              const result = await axios.delete(`${document}/delete-cartItems/${id}`);
              if (result) {
                emitter.emit('closeModal');
                await this.getCartItems();
              }
            } catch (error) {
              const message = error.response?.data?.message || error.message;
              flash(message, "danger");
            }

            this.loading = false;
          },

          async storeCartItems() {
            this.loading = true;
            this.orderItems = [];
            this.orderInfo = [];
            try {
              const result = await axios.get(`${document}/store-cartItems`);
              if (result) {
                await this.getOrderDetails(); // Update cartItems with the new data
              }
            } catch (error) {
              const message = error.response?.data?.message || error.message;
              flash(message, "danger");
            }
            this.loading = false;
          },


          async getOrderDetails() {
            this.loading = true;
            fullPageLoader.show();

            try {
                const result = await axios.get(`${document}/orderDetails`);
                const { data, meta } = getItemAndMetaData(result.data);
                this.meta = meta;
                this.orderItems = data;
                await this.getUserOrderInfo();
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async getUserOrderInfo() {
            this.loading = true;
            fullPageLoader.show();

            try {
                const result = await axios.get(`${document}/getUserOrderInfo`);
                this.orderInfo = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
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
            this.selectedDocument = document;
            this.showModal = true;
            // this.form.id = document.id;
            // this.form.title = document.title;
            // this.form.summary = document.summary;
            // this.form.price = !document.is_free ? document.price : "";
            // this.form.path = document.type != 'link' ? document.path : null;
            // this.form.is_free = document.is_free;
            // this.form.is_external_link = document.type == 'link' ? true : false;
            // this.form.external_link = document.type == 'link' ? document.path : "";
            // this.form.tags = document.tags;
            // this.form.collections = document.collections;
            // this.uploadPath = (document.type != 'link' && document.path) ? document.path : null;
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
