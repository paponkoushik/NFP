import {computed, onBeforeMount, onUnmounted} from "vue";
import {useOrgSettingsStore} from "@/stores/OrgSettingsStore";
import {PREFERENCES_DATA} from "@/core/preference_data";
import {cloneDeep} from "lodash";
import {WHERE_LOOKING_PREFERENCES, WHERE_OFFER_PREFERENCES, WHERE_PREFERENCES} from "../../../core/preference_data";

export function useOurPreferencesComposable() {
    const store = useOrgSettingsStore();
    const {interests, organisation} = store;
    let preferenceFormData = {...PREFERENCES_DATA};

    const groupedOurInterests = computed(() => organisation.groupedOurInterests);
    const groupedExcludeFields = computed(() => organisation.groupedCategoryExcludeFields);
    const groupedExcludeFieldValues = computed(() => organisation.groupedCategoryExcludeFieldValues);
    const groupedCustomLabels = computed(() => organisation.groupedCategoryCustomLabels);

    // Function to generate a slug from a string
    function generateSlug(str) {
        return str.split(" ").map(word => word.toLowerCase()).join('-');
    }

    // Function to set preferences for a single level field
    function setSingleLevelPreference(key, value, excludeFields, excludeFieldValues, custom_labels, category) {
        let formData = cloneDeep(preferenceFormData); // Create a new object for each item
        // Check if the organisation has preferences for this category
        if (organisation.our_preferences.hasOwnProperty(key)) {
            formData.type = organisation.our_preferences[key].type;
            formData.where = organisation.our_preferences[key].where ?? {...WHERE_PREFERENCES};
            formData.where_looking = organisation.our_preferences[key].where_looking ?? {...WHERE_LOOKING_PREFERENCES};
            formData.where_offer = organisation.our_preferences[key].where_offer ?? {...WHERE_OFFER_PREFERENCES};
            formData.summary = organisation.our_preferences[key].summary;
        }

        // Determine excludeFields and excludeFieldValues based on the key
        let excFields = excludeFields.hasOwnProperty(key) ? excludeFields[key] : [];
        let excFieldVals = excludeFieldValues.hasOwnProperty(key) ? excludeFieldValues[key] : {};
        let cusLabels = custom_labels.hasOwnProperty(key) ? custom_labels[key] : {};

        formData.category = category; // Set the category

        return {
            ...formData,
            sub1_category     : value,
            excludeFields     : excFields && excFields.length ? excFields : [],
            excludeFieldValues: excFieldVals && Object.keys(excFieldVals).length ? excFieldVals : {},
            custom_labels     : cusLabels && Object.keys(cusLabels).length ? cusLabels : {},
        };
    }

    // Function to set preferences for multi-level fields
    function setMultiLevelPreferences(key, value, options, excludeFields, excludeFieldValues, custom_labels, category) {
        let subCatLabel = key.split("-")
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');

        let multiLevelFields = [];

        for (let val of value) {
            let formData = cloneDeep(preferenceFormData); // Create a new object for each item
            let excFields = [];
            let excFieldVals = {};
            let cusLabels = {};
            let slugSubCat = generateSlug(val);
            slugSubCat = generateSlug(key) + '-' + slugSubCat;

            // Check if the organisation has preferences for this sub-category
            if (organisation.our_preferences.hasOwnProperty(slugSubCat)) {
                formData.type = organisation.our_preferences[slugSubCat].type;
                formData.where = organisation.our_preferences[slugSubCat].where;
                formData.where_looking = organisation.our_preferences[slugSubCat].where_looking;
                formData.where_offer = organisation.our_preferences[slugSubCat].where_offer;
                formData.summary = organisation.our_preferences[slugSubCat].summary;
            }

            // Determine excludeFields and excludeFieldValues based on the key and sub-category
            if (excludeFields.hasOwnProperty(key)
                && excludeFields[key].hasOwnProperty(slugSubCat)
                && excludeFields[key][slugSubCat]
                && excludeFields[key][slugSubCat].length) {
                excFields = excludeFields[key][slugSubCat];
            }

            if (excludeFieldValues.hasOwnProperty(key)
                && excludeFieldValues[key].hasOwnProperty(slugSubCat)
                && excludeFieldValues[key][slugSubCat]
                && Object.keys(excludeFieldValues[key][slugSubCat]).length) {
                excFieldVals = excludeFieldValues[key][slugSubCat];
            }

            // Determine custom labels based on the key and sub-category
            if (custom_labels.hasOwnProperty(key)
                && custom_labels[key].hasOwnProperty(slugSubCat)
                && custom_labels[key][slugSubCat]
                && Object.keys(custom_labels[key][slugSubCat]).length) {
                cusLabels = custom_labels[key][slugSubCat];
            }

            multiLevelFields.push({
                ...formData, // Create a new object for each item
                sub_category      : subCatLabel,
                sub1_category     : val,
                excludeFields     : excFields && excFields.length ? excFields : [],
                excludeFieldValues: excFieldVals && Object.keys(excFieldVals).length ? excFieldVals : {},
                custom_labels     : cusLabels && Object.keys(cusLabels).length ? cusLabels : {},
                category          : category, // Set the category
            });
        }

        return multiLevelFields;
    }

    // Main function
    const setPreferenceFields = (interestKey, category) => {
        let options = groupedOurInterests.value[interestKey] || {};
        let excludeFields = groupedExcludeFields.value[interestKey] || [];
        let excludeFieldValues = groupedExcludeFieldValues.value[interestKey] || {};
        let customLabels = groupedCustomLabels.value[interestKey] || {};

        let singleLevelFields = [];
        let multiLevelFields = [];

        let keys = Object.keys(options);

        for (let key of keys) {
            let value = options[key];
            if (Array.isArray(value)) {
                multiLevelFields.push(...setMultiLevelPreferences(key, value, options, excludeFields, excludeFieldValues, customLabels, category));
            } else {
                singleLevelFields.push(setSingleLevelPreference(key, value, excludeFields, excludeFieldValues, customLabels, category));
            }
        }

        return [...singleLevelFields, ...multiLevelFields];
    };


    // init preferences fields and set default values for each field by
    // looping interests array and push in preferencesFields by using setPreferenceFields
    const initPreferencesFields = () => {
        for (let i = 0; i < interests.length; i++) {
            let interest = interests[i];
            let category = interest.name;
            let interestKey = interest.code;
            let fields = setPreferenceFields(interestKey, category);
            store.our_preferences.push(...fields);
        }
    };

    // get slug from item
    const getSlug = (item) => {
        let slug = item.category;
        if (item.sub_category) {
            slug = item.sub_category + '-' + item.sub1_category;
        }
        if (item.sub1_category) {
            slug = item.sub1_category;
        }
        return slug.split(" ")
            .map(word => word.toLowerCase())
            .join('-');
    };

    // type change handler
    const typeChangeHandler = (type, key) => {
        let item = store.our_preferences[key];
        item.type = type;
    };

    // email preference change handler
    const emailPreferenceChangeHandler = (preference) => {
        store.email_preference = preference;
    };

    const checkExcludeField = (key, fieldName) => {
        let item = store.our_preferences[key];
        return item.excludeFields && item.excludeFields.length && item.excludeFields.includes(fieldName);
    };

    const renderTypeCustomLabel = (key, type) => {
        let item = store.our_preferences[key];
        return Object.keys(item.custom_labels).length
        && item.custom_labels.hasOwnProperty('type')
        && item.custom_labels['type'].hasOwnProperty(type)
            ? item.custom_labels['type'][type] :
            type === 'offer'
                ? 'We are offering' :
                type === 'looking'
                    ? 'We are searching' : 'Both';
    };

    onBeforeMount(() => {
        initPreferencesFields();
    });

    onUnmounted(() => {
        store.our_preferences = [];
    });

    return {
        store,
        typeChangeHandler,
        getSlug,
        emailPreferenceChangeHandler,
        checkExcludeField,
        renderTypeCustomLabel,
    };
}
