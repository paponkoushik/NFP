import {useUrlFunc} from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import useDatatableFunc from "@/composables/useDatatableFunc.js";
import {organisationManagement, authOrganization} from "@/core/endpoints";
import {defineStore} from 'pinia';
import axios from 'axios';
import {cities, states, postcode, cityAndState, organization} from "../core/endpoints";

const {buildURLQuery} = useUrlFunc();
const {handleFormError, destroy} = useUtilsFunc();
const {getItemAndMetaData} = useDatatableFunc();

export const useOrganisationStore = defineStore('OrganisationStore', {
    state: () => ({
        meta            : {},
        posts           : [],
        organisationList: [],
        organisations   : [],
        selectedOrg     : {},
        selectedOrgId   : null,
        search          : "",
        loading         : false,
        uploadPath      : null,
        isCreateOrg     : false,
        cities          : [],
        states          : [],
        form            : {
            id                 : null,
            org_name           : "",
            org_type           : "",
            alias              : "",
            address            : "",
            state              : "",
            city               : "",
            postcode           : "",
            contact_email      : "",
            contact_phone      : "",
            logo               : "",
            abn                : "",
            acn                : "",
            status             : false,
            is_trial           : true,
            activation_date    : "",
            subscription_period: "",
            expiry_date        : "",
            path               : null
        }
    }),

    getters: {
        totalOrganisation() {
            return this.organisations.length;
        },
    },

    actions: {
        async fill() {
            this.loading = true;
            fullPageLoader.show();

            const params = this.search ? {query: this.search} : null;
            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${organisationManagement}/all${urlParams ? `?${urlParams}` : ''}`);
                this.organisations = result.data;
                if (result.data.length > 0) {
                    this.handleOrganisationSelect(result.data[0]);
                }
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        async getStates() {
            this.loading = true;

            try {
                const result = await axios.get(`${states}`);
                this.states = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            } finally {
                this.loading = false
            }
        },

        async getCities(state = null) {
            this.loading = true;
            const paramState = state ? state : this.form.state
            try {
                const result = await axios.get(`${cities}/${paramState}`);
                this.cities = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            } finally {
                this.loading = false
            }
        },

        async getPostCode(city = null) {
            this.loading = true;
            const paramCity = city ? city : this.form.city
            try {
                const result = await axios.get(`${postcode}/${paramCity}`);
                this.form.postcode = result.data.postcode
                this.form.address = result.data.address
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            } finally {
                this.loading = false
            }
        },

        async getCityAndState(postcode) {
            this.loading = true
            try {
                const result = await axios.get(`${cityAndState}/${postcode}`);
                this.form.postcode = result.data.postcode
                this.form.state = result.data.state
                await this.getCities()
                this.form.city = result.data.locality
            } catch (error) {
                console.log('error', error)
            } finally {
                this.loading = false
            }
        },


        async handleSubmit(values, veeForm) {
            this.loading = true;
            fullPageLoader.show();

            try {
                const formId = this.form.id;
                const formData = new FormData();

                for (let key in this.form) {
                    formData.append(key, this.form[key] ? this.form[key] : "");
                }
                formData.append("is_trial", this.form.is_trial ? 1 : 0);
                formData.append("status", this.form.status ? 'suspend' : 'active');

                const url = !formId ? organisationManagement : `${organisationManagement}/${formId}`;
                if (formId) {
                    formData.append("_method", "PUT");
                }

                const response = await axios.post(url, formData);
                this.selectedOrgId = null;
                this.fill();
                this.resetForm();
                veeForm.resetForm();
                flash(response.data.message);
            } catch (error) {
                handleFormError(error.response, veeForm);
            }

            this.loading = false;
            fullPageLoader.hide();
        },

        delete(data) {
            let message = "Do you want to delete this organisation?";
            if (data.hasUsers) {
                message = "This organisation has users. Do you want to delete this organisation?";
            }
            confirm(message).then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${organisationManagement}/${data.id}`).then(response => {
                        if (response) {
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
                const response = await axios.post(`${organisationManagement}/file-delete`, {
                    id  : this.form.id,
                    path: this.uploadPath
                });
                this.uploadPath = null;
                flash(response.data.message);
            } catch (error) {
                handleFormError(error.response);
            }

            this.loading = false;
        },

        handleOrganisationSelect(organisation) {
            // console.log(organisation)
            this.selectedOrg = organisation;
            this.selectedOrgId = organisation.id;
            this.editOrganisation();
        },

        editOrganisation() {
            for (let key in this.form) {
                this.form[key] = this.selectedOrg[key];
            }

            this.uploadPath = this.selectedOrg.logo;
            this.form.status = this.selectedOrg.status == 'suspend' ? true : false;
            this.form.is_trial = this.selectedOrg.subscription?.is_trial;
            this.form.activation_date = this.selectedOrg.subscription?.subs_start_date;
            this.form.subscription_period = this.selectedOrg.subscription?.subscription_period;
            this.form.expiry_date = this.selectedOrg.subscription?.to;
            this.form.city = this.selectedOrg.org_locations?.city;
            this.form.state = this.selectedOrg.org_locations?.state;
            this.form.postcode = this.selectedOrg.org_locations?.postcode;
            this.form.address = this.selectedOrg.org_locations?.address;
        },

        handleAddClick() {
            this.resetForm();
            this.selectedOrg = {};
            this.selectedOrgId = null;
            this.isCreateOrg = true;
        },

        resetForm() {
            for (let key in this.form) {
                this.form[key] = "";
            }

            this.form.id = null;
            this.form.status = false;
            this.form.is_trial = true;
            this.uploadPath = null;
            this.isCreateOrg = false;
            this.calculateExpiryDate();
        },

        getIconClass(data) {
            return data.status === 'suspend' ? "bg-danger" : (data.expired === true ? "bg-warning" : "bg-primary");
        },

        calculateExpiryDate() {
            const subs = this.getSubscriptionPeriod();
            const fromDate = !this.form.is_trial && this.form.activation_date ? moment(this.form.activation_date) : moment();

            this.form.expiry_date = fromDate.add(subs?.days, subs?.type).format("YYYY-MM-DD");
        },

        getSubscriptionPeriod() {
            const period = this.form.subscription_period;

            if (this.form.is_trial || period == "") {
                return {
                    days: 13,
                    type: 'days'
                }
            } else if (period && this.form.activation_date) {
                const arr = period.split("-");

                return {
                    days: arr[0],
                    type: `${arr[1]}s`
                }
            }
        },
        async getAuthOrg() {
            try {
                const response = await axios.get(`${authOrganization}`);
                this.authOrg = response.data.authOrg
            } catch (e) {
                console.log(e)
            }

        },


        async getOrgList(params) {
            fullPageLoader.show();

            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${organization}/all${urlParams ? `?${urlParams}` : ''}`);
                const {data, meta} = getItemAndMetaData(result.data);
                this.meta = meta;
                this.organisationList = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            fullPageLoader.hide();
        },
    }
});
