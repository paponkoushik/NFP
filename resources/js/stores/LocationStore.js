import useDatatableFunc from "@/composables/useDatatableFunc.js";
import {useUrlFunc} from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import {location, mapLocation} from "@/core/endpoints";
import {defineStore} from 'pinia';

const {getItemAndMetaData} = useDatatableFunc();
const {destroy} = useUtilsFunc();
const {buildURLQuery} = useUrlFunc();

export const useLocationStore = defineStore('LocationStore', {
    state: () => ({
        meta                 : {},
        locations            : [],
        locationOptions      : [],
        radiusLocationOptions: [],
        loading              : false,
        showModal            : false,
        form                 : {
            id        : null,
            first_name: '',
            last_name : '',
            email     : '',
            phone     : '',
            role      : '',
            status    : '',
        },
        placeId: '',
        loadLocation: false,
    }),

    getters: {
        totalLocation() {
            return this.meta?.total ?? this.locations.length;
        },
    },

    actions: {
        async fill(params) {
            this.loading = true;
            const urlParams = buildURLQuery(params, true);

            try {
                const result = await axios.get(`${location}/all${urlParams ? `?${urlParams}` : ''}`);
                const {data, meta} = getItemAndMetaData(result.data);
                this.meta = meta;
                this.locations = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
            this.loading = false
        },

        async getAllLocations() {
            try {
                const result = await axios.get(`${location}/options`);
                this.locationOptions = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
        },

        async submit() {
            try {
                const formId = this.form.id;
                const formData = new FormData();

                for (let key in this.form) {
                    formData.append(key, this.form[key]);
                }
                const url = !formId ? location : `${location}/${formId}`;
                if (formId) {
                    formData.append("_method", "PUT");
                }

                const response = await axios.post(url, formData);
                this.fill();
                emitter.emit('closeModal');
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

                    destroy(`${location}/${data.id}`).then(response => {
                        if (response) {
                            this.locations.splice(this.locations.indexOf(data), 1)
                            this.loading = false
                        }
                    });
                }
            });
        },

        async getRadiusLocationOptions(search) {
            try {
                const result = await axios.get(`${location}/get-by-city-postcode?search=${search}`);
                this.radiusLocationOptions = result.data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
        },

        async getLocationUrl(lat, long) {
            this.loadLocation = true;
            try {
                const result = await axios.get(`${mapLocation}?lat=${lat}&long=${long}`);
                this.placeId = result.data.place_id

            } catch (error) {
                const message = error.response?.data?.message ?? error.message;

                // flash(message, "danger");
            } finally {
                this.loadLocation = false;
            }
        }
    }
});
