import { localize } from '@vee-validate/i18n';
import en from '@vee-validate/i18n/dist/locale/en.json';
import { alpha, alpha_dash, confirmed, email, ext, image, url, integer, max, max_value, mimes, min, min_value, numeric, required, size } from '@vee-validate/rules';
import { Field, Form, ErrorMessage, configure, defineRule } from 'vee-validate';
import debounce from 'lodash/debounce';

export default (app) => {
    let validated = {};

    // define rules
    defineRule("required", required);
    defineRule("email", email);
    defineRule("confirmed", confirmed);
    defineRule("alpha", alpha);
    defineRule("alpha_dash", alpha_dash);
    defineRule("min", min);
    defineRule("max", max);
    defineRule("max_value", max_value);
    defineRule("min_value", min_value);
    defineRule("ext", ext);
    defineRule("image", image);
    defineRule("mimes", mimes);
    defineRule("size", size);
    defineRule("numeric", numeric);
    defineRule("integer", integer);
    defineRule("url", url);

    defineRule('unique', async (value, args) => {
        let endpoint, field;
        if(Array.isArray(args)) {
            [ endpoint, field ] = args;
        } else {
            ({ endpoint, field } = args);
        }

        if(validated[field] == value) return validated.status;

        try {
            const { data } = await axios.post(`/api/validate/${endpoint}/unique`, {'key': field, [field]: value});
            
            validated = { [field]: value, status:  data.isValidate};

            return data.isValidate;
        } catch(err) {
            validated = { [field]: value, status: err.response.data.error};
            return err.response.data.error;
        }
    });

    // Default values
    configure({
        //bails: false,
        //validateOnBlur: false, // controls if `blur` events should trigger validation with `handleChange` handler
        //validateOnChange: true, // controls if `change` events should trigger validation with `handleChange` handler
        validateOnInput: true,
        generateMessage: localize({
            en
        })
    });

    app
        .component("VForm", Form)
        .component("VField", Field)
        .component("ErrorMessage", ErrorMessage)
}