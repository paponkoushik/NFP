import useDatatableFunc from "@/composables/useDatatableFunc.js";
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import { legalRequest } from "@/core/endpoints";
import { defineStore } from 'pinia';

const { getItemAndMetaData } = useDatatableFunc();
const { handleFormError, destroy } = useUtilsFunc();
const { getUrlParams, buildURLQuery } = useUrlFunc();

export const useLegalRequestStore = defineStore('LegalRequestStore', {
    state: () => ({
        can: null,
        meta: {},
        legalRequests: [],
        editLegalRequest: null,
        loading: false,
        showModal: false
    }),

    getters: {
        getLegalReqById: (state) => {
            return (leaglReqId) => state.legalRequests.find((legal) => legal.id === leaglReqId)
        },
    },

    actions: {
        async fill() {
            this.loading = true;
            const urlParams = buildURLQuery(getUrlParams(), true);

            try {
                const result = await axios.get(`${legalRequest}${urlParams ? `?${ urlParams }`:''}`);
                const { data, meta } = getItemAndMetaData(result.data);
                this.can = result.data.can;
                this.meta = meta;
                this.legalRequests = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }

            this.loading = false;
        },

        handleEditLegalRequest(data) {
            this.editLegalRequest = data
        },

        async handleSubmit() {
            try {
                this.loading = true;
                //fullPageLoader.show();
                const { id, completed_date, additional_lawyer_note, billed_amount } = this.editLegalRequest;
                const { data } = await axios.put(`${legalRequest}/${id}`, { completed_date, additional_lawyer_note, billed_amount });
                emitter.emit('closeModal');
                flash(data.message);
            } catch (error) {
                handleFormError(error.response);
            }

            this.loading = false;
        },

        archived(legalReqId) {
            confirm("Do you want to archived this request?", {confirmButtonText: 'Yes, archived it!'}).then(isConfirm => {
                if (isConfirm) {
                    this.loading = true;

                    axios.post(`${legalRequest}/${legalReqId}/archived`).then(({ data }) => {
                        flash(data.message);
                        this.loading = false;
                        this.getLegalReqById(legalReqId).is_archived = true;
                    });
                }
            });
        },

        delete(data) {
            confirm("Do you want to delete this request?").then(isConfirm => {
                if (isConfirm) {
                    this.loading = true

                    destroy(`${user}/${data.id}`).then(response => {
                        if (response) {
                            this.legalRequests.splice(this.legalRequests.indexOf(data), 1)
                            this.loading = false
                        }
                    });
                }
            });
        }
    }
});
