import useUtilsFunc from '@/composables/useUtilsFunc.js';
import {orgSetting} from "@/core/endpoints";
import {defineStore} from 'pinia';

const {handleFormError} = useUtilsFunc();

export const useOrgSettingsStore = defineStore('OrgSettingsStore', {
    state: () => ({
        organisation    : {},
        serviceAreas    : [],
        interests       : [],
        our_preferences : [],
        email_preference: '',
        loading         : false
    }),

    getters: {},

    actions: {
        fill({organisation, serviceAreas, interests}) {
            this.organisation = organisation;
            this.serviceAreas = serviceAreas;
            this.interests = interests;
            this.email_preference = organisation.email_preference;
        },

        async handleSubmit(formData) {
            try {
                // modify the form data
                formData['email_preference'] = this.email_preference;
                formData['our_preferences'] = this.our_preferences;

                fullPageLoader.show();
                const {data} = await axios.post(orgSetting, formData);
                flash(data.message);
                window.location.replace('/posts')
            } catch (error) {
                handleFormError(error.response);
            } finally {
                fullPageLoader.hide();
            }
        }
    }
});
