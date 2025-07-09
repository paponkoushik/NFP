import useDatatableFunc from "@/composables/useDatatableFunc.js";
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import { user } from "@/core/endpoints";
import { defineStore } from 'pinia';

import { useUrlFunc } from "@/composables/useUrlFunc";

const { buildURLQuery } = useUrlFunc();

const { getItemAndMetaData } = useDatatableFunc();
const { destroy } = useUtilsFunc();

export const useUserStore = defineStore('UserStore', {
    state: () => ({
        meta: {},
        cardData: {},
        users: [],
        loading: false,
        showModal: false,
        form: {
            id: null,
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            role: '',
            status: '',
        }
    }),

    getters: {
        totalUser() {
            return this.meta?.total ?? this.users.length;
        },
    },

    actions: {
        async getUsers(params) {
            this.loading = true;
            let urlParams = params ? `?${params}` : '';

            try {
                const result = await axios.get(`${user}/all${urlParams}`);
                let { data, meta } = getItemAndMetaData(result.data);
                this.meta = meta;
                this.users = data;
            }
            catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
            finally {
                this.loading = false
            }
        },

        async nfpDashboard(params) {
            this.loading = true;
            const urlParams = params ? `?${params}` : '';
            try {
                const result =  await axios.get(`/nfp-admin/dashboard${urlParams}`);
                this.cardData = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
        },

        async submit() {
            try {
				const formId = this.form.id;
                const formData = new FormData();

				for (let key in this.form) {
					formData.append(key, this.form[key]);
				}
				const url = !formId ? user : `${user}/${formId}`;
                if (formId) {
                    formData.append("_method", "PUT");
                }

                const response = await axios.post(url, formData);
                this.getUsers();
                emitter.emit('closeModal');
                flash(response.data.message);
            }
            catch (error) {
                if (error.response.status == 422) {
                    const errors = "errors" in error.response.data ? error.response.data.errors : error.response.data;
                    throw errors;
                }

                flash(error.response.data.message, "danger");
            }
            finally {
                this.loading = false
            }
        },

        handleUserEdit(data) {
            if (data) {
                this.showModal = true;
                this.form.id = data.id;

                for (let key in data) {
                    this.form[key] = data[key] ? data[key] : "";
                }
            }
        },

        delete(data) {
            confirm("Do you want to delete this user?").then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${user}/${data.id}`).then(response => {
                        if (response) {
                            this.users.splice(this.users.indexOf(data), 1)
                            this.loading = false
                        }
                    });
                }
            });
        },
    }
});
