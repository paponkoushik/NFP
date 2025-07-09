import {useUrlFunc} from '@/composables/useUrlFunc.js';
import {url} from '@vee-validate/rules';

let {getUrlParams, buildURLQuery} = useUrlFunc();

export default function useUtilsFunc() {
    async function destroy(url, params = {}) {
        return await axios.delete(url, params)
            .then(response => {
                flash(response.data.message)
                return true
            })
            .catch(error => {
                flash(error.response.data.message, 'danger')
                return false
            })
    }

    function textAvatarBgClass() {
        return _.sample(['bg-label-danger', 'bg-label-success', 'bg-label-primary', 'bg-label-info', 'bg-label-secondary', 'bg-label-warning']);
    }

    function statusBgClass(status) {
        return (status == 'active') ? 'bg-label-success' : ((status == 'inactive') ? 'bg-label-warning' : 'bg-label-danger')
    }

    function statusOfferClass(status) {
        return (status == 'offered') || (status == 'pending') ? 'bg-label-warning' : (status == 'accept') ? 'bg-label-success' : 'bg-label-danger'
    }

    function priceTypeOfferClass(status) {
        return (status == 'na') ? 'bg-label-warning' : (status == 'free') ? 'bg-label-success' : 'bg-label-danger'
    }

    function pushUrlState(params) {
        const urlQueryParams = getUrlParams();

        if (params) {
            params = {...urlQueryParams, ...params};
            params = Object.entries(params).reduce((acc, [key, value]) => (value ? (acc[key] = value, acc) : acc), {});
        }

        history.pushState(null, null, `?${buildURLQuery(params)}`)
    }

    function handleFormError(error, veeFormActions = null) {
        if (error.status === 422) {
            if (error.data.errors) {
                const errors = error.data.errors;
                if (veeFormActions) {
                    veeFormActions.setErrors(errors);
                    //veeFormActions.setErrors({[key]: error.data.errors[key][0]})
                } else {
                    let errHtml = `
                        <ul>
                            ${Object.keys(errors).map(key => `<li>${errors[key][0]}</li>`).join('')}
                        </ul>
                    `
                    flash(errHtml, 'danger');
                }
            }
            return
        }

        flash(error.data.message, 'danger');
    }

    function areAllPropertiesNullOrEmpty(obj) {
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const value = obj[key];
                if (value !== null && value !== "" && !(Array.isArray(value) && value.length === 0)) {
                    return false;
                }
            }
        }
        return true;
    }

    return {
        textAvatarBgClass,
        statusBgClass,
        statusOfferClass,
        priceTypeOfferClass,
        destroy,
        pushUrlState,
        handleFormError,
        areAllPropertiesNullOrEmpty,
    };
}
