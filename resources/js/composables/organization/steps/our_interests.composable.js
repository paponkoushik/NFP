import {useOrgSettingsStore} from "@/stores/OrgSettingsStore";
import {computed} from "vue";

export function useOurInterestsComposable() {
    const store = useOrgSettingsStore();
    const {interests, organisation} = store;
    const groupedOurInterests = computed(() => organisation.groupedOurInterests);

    // Function to toggle nested grouped interests (used in toggle function)
    const toggleNestedGroupedInterests = (groupedKey, subGroupKey, key, value) => {
        let grouped = organisation.groupedOurInterests[groupedKey];
        // Push group interests
        if (grouped
            && grouped[subGroupKey]) {
            let c2Grouped = grouped[subGroupKey];
            if (c2Grouped
                && c2Grouped.includes(value)) {
                if (c2Grouped.length === 1) {
                    if (grouped
                        && grouped.hasOwnProperty(subGroupKey)) {
                        delete grouped[subGroupKey];
                        return;
                    }
                }
                c2Grouped.splice(c2Grouped.indexOf(value), 1);
                return;
            } else if (c2Grouped && c2Grouped.length) {
                c2Grouped.push(value);
                return;
            } else {
                delete grouped[subGroupKey];
                return;
            }
        }

        if (grouped && grouped.hasOwnProperty(subGroupKey)) {
            delete grouped[subGroupKey];
            return;
        }

        // check grouped has any properties if not then delete grouped, also check grouped has subGroupKey if not then delete subGroupKey
        if (grouped && Object.keys(grouped).length === 0) {
            delete organisation.groupedOurInterests[groupedKey];
            return;
        }

        organisation.groupedOurInterests[groupedKey] = !grouped ?
            {[subGroupKey]: [value]} : {...grouped, [subGroupKey]: [value]};
    };

    // Function to toggle nested grouped exclude fields (used in toggle function)
    const toggleNestedGroupedExcludeFields = (groupedKey, subGroupKey, key, value) => {
        let grouped = organisation.groupedCategoryExcludeFields[groupedKey];
        // Push group exclude fields with c1Slug & key and push exclude_fields by key
        if (grouped
            && grouped[subGroupKey]) {
            let c2GroupedExcFlds = grouped[subGroupKey];
            if (c2GroupedExcFlds && c2GroupedExcFlds.hasOwnProperty(key)) {
                if (c2GroupedExcFlds.length === 1) {
                    if (grouped
                        && grouped.hasOwnProperty(subGroupKey)) {
                        delete grouped[subGroupKey];
                        return;
                    }
                }
                delete c2GroupedExcFlds[key];
                return;
            }

            c2GroupedExcFlds[key] = value;

            return;
        }

        // Delete group exclude fields with c1Slug and delete exclude_fields by key
        if (grouped
            && grouped.hasOwnProperty(subGroupKey)) {
            if (grouped[subGroupKey].hasOwnProperty(key)) {
                delete grouped[subGroupKey][key];
                return;
            }
        }

        organisation.groupedCategoryExcludeFields[groupedKey] = !grouped ?
            {[subGroupKey]: {[key]: value}} : {
                ...grouped,
                [subGroupKey]: {[key]: value}
            };
    };


    // Function to toggle nested grouped exclude field values (used in toggle function)
    const toggleNestedGroupedExcludeFieldValues = (groupedKey, subGroupKey, key, value) => {
        // Push group exclude field values with c1Slug & key and push exclude_field_values by key
        if (organisation.groupedCategoryExcludeFieldValues[groupedKey]
            && organisation.groupedCategoryExcludeFieldValues[groupedKey][subGroupKey]) {
            let c2GroupedExcFldVals = organisation.groupedCategoryExcludeFieldValues[groupedKey][subGroupKey];
            if (c2GroupedExcFldVals && c2GroupedExcFldVals.hasOwnProperty(key)) {
                if (c2GroupedExcFldVals.length === 1) {
                    if (organisation.groupedCategoryExcludeFieldValues[groupedKey]
                        && organisation.groupedCategoryExcludeFieldValues[groupedKey].hasOwnProperty(subGroupKey)) {
                        delete organisation.groupedCategoryExcludeFieldValues[groupedKey][subGroupKey];
                        return;
                    }
                }
                delete c2GroupedExcFldVals[key];
                return;
            }

            c2GroupedExcFldVals[key] = value;

            return;
        }

        // Delete group exclude field values with c1Slug and delete exclude_field_values by key
        if (organisation.groupedCategoryExcludeFieldValues[groupedKey]
            && organisation.groupedCategoryExcludeFieldValues[groupedKey].hasOwnProperty(subGroupKey)) {
            if (organisation.groupedCategoryExcludeFieldValues[groupedKey][subGroupKey].hasOwnProperty(key)) {
                delete organisation.groupedCategoryExcludeFieldValues[groupedKey][subGroupKey][key];
                return;
            }
        }

        organisation.groupedCategoryExcludeFieldValues[groupedKey] = !organisation.groupedCategoryExcludeFieldValues[groupedKey] ?
            {[subGroupKey]: {[key]: value}} : {
                ...organisation.groupedCategoryExcludeFieldValues[groupedKey],
                [subGroupKey]: {[key]: value}
            };
    };

    // Function to toggle nested grouped custom labels (used in toggle function)
    const toggleNestedGroupedCustomLabels = (groupedKey, subGroupKey, key, value) => {
        // Push group custom labels with c1Slug & key and push custom_label by key
        if (organisation.groupedCategoryCustomLabels[groupedKey]
            && organisation.groupedCategoryCustomLabels[groupedKey][subGroupKey]) {
            let c2GroupedCusLabl = organisation.groupedCategoryCustomLabels[groupedKey][subGroupKey];
            if (c2GroupedCusLabl && c2GroupedCusLabl.hasOwnProperty(key)) {
                if (c2GroupedCusLabl.length === 1) {
                    if (organisation.groupedCategoryCustomLabels[groupedKey]
                        && organisation.groupedCategoryCustomLabels[groupedKey].hasOwnProperty(subGroupKey)) {
                        delete organisation.groupedCategoryCustomLabels[groupedKey][subGroupKey];
                        return;
                    }
                }
                delete c2GroupedCusLabl[key];
                return;
            }

            c2GroupedCusLabl[key] = value;

            return;
        }

        // Delete group exclude field values with c1Slug and delete exclude_field_values by key
        if (organisation.groupedCategoryCustomLabels[groupedKey]
            && organisation.groupedCategoryCustomLabels[groupedKey].hasOwnProperty(subGroupKey)) {
            if (organisation.groupedCategoryCustomLabels[groupedKey][subGroupKey].hasOwnProperty(key)) {
                delete organisation.groupedCategoryCustomLabels[groupedKey][subGroupKey][key];
                return;
            }
        }

        organisation.groupedCategoryCustomLabels[groupedKey] = !organisation.groupedCategoryCustomLabels[groupedKey] ?
            {[subGroupKey]: {[key]: value}} : {
                ...organisation.groupedCategoryCustomLabels[groupedKey],
                [subGroupKey]: {[key]: value}
            };
    }

    const toggle = (selectedObj, c1Slug = null, c2Slug = null) => {
        const {code: key, name: value, exclude_fields, exclude_field_values, custom_label} = selectedObj;

        if (c2Slug !== null) {
            // Push group interests
            toggleNestedGroupedInterests(c2Slug, c1Slug, key, value);

            // Push group exclude fields with c1Slug & key and push exclude_fields by key
            toggleNestedGroupedExcludeFields(c2Slug, c1Slug, key, exclude_fields);

            // Push group exclude field values with c1Slug & key and push exclude_field_values by key
            toggleNestedGroupedExcludeFieldValues(c2Slug, c1Slug, key, exclude_field_values);

            // Push group custom labels with c1Slug & key and push custom_label by key
            toggleNestedGroupedCustomLabels(c2Slug, c1Slug, key, custom_label);
        } else if (c1Slug !== null) {
            toggleSelectedItem(key, value, exclude_fields, exclude_field_values, custom_label, c1Slug)
        } else {
            toggleSelectedItem(key, value, exclude_fields, exclude_field_values, custom_label, key)
        }
    };

    // Function to toggle Grouped Interests (used in toggleSelectedItem function)
    const toggleGroupedInterests = (groupedKey, key, value) => {
        if (organisation.groupedOurInterests[groupedKey]
            && organisation.groupedOurInterests[groupedKey].hasOwnProperty(key)) {
            console.log("toggleGroupedInterests delete -> ", key, value)
            delete organisation.groupedOurInterests[groupedKey][key];

            if (Object.keys(organisation.groupedOurInterests[groupedKey]).length === 0) {
                delete organisation.groupedOurInterests[groupedKey];
            }
            return;
        }

        organisation.groupedOurInterests[groupedKey] = !organisation.groupedOurInterests[groupedKey] ? {[key]: value} : {
            ...organisation.groupedOurInterests[groupedKey],
            [key]: value
        };
    };

    // Function to toggle Grouped Exclude Fields (used in toggleSelectedItem function)
    const toggleGroupedExcludeFields = (groupedKey, key, value) => {
        if (organisation.groupedCategoryExcludeFields[groupedKey]
            && organisation.groupedCategoryExcludeFields[groupedKey].hasOwnProperty(key)) {
            console.log("toggleGroupedExcludeFields delete -> ", key, value)
            delete organisation.groupedCategoryExcludeFields[groupedKey][key];

            if (Object.keys(organisation.groupedCategoryExcludeFields[groupedKey]).length === 0) {
                delete organisation.groupedCategoryExcludeFields[groupedKey];
            }

            return;
        }

        organisation.groupedCategoryExcludeFields[groupedKey] = !organisation.groupedCategoryExcludeFields[groupedKey] ? {[key]: value} : {
            ...organisation.groupedCategoryExcludeFields[groupedKey],
            [key]: value
        };
    };

    // Function to toggle Grouped Exclude Field Values (used in toggleSelectedItem function)
    const toggleGroupedExcludeFieldValues = (groupedKey, key, value) => {
        if (organisation.groupedCategoryExcludeFieldValues[groupedKey]
            && organisation.groupedCategoryExcludeFieldValues[groupedKey].hasOwnProperty(key)) {
            delete organisation.groupedCategoryExcludeFieldValues[groupedKey][key];

            if (Object.keys(organisation.groupedCategoryExcludeFieldValues[groupedKey]).length === 0) {
                delete organisation.groupedCategoryExcludeFieldValues[groupedKey];
            }

            return;
        }
        organisation.groupedCategoryExcludeFieldValues[groupedKey] = !organisation.groupedCategoryExcludeFieldValues[groupedKey] ? {[key]: value} : {
            ...organisation.groupedCategoryExcludeFieldValues[groupedKey],
            [key]: value
        };
    };

    // Function to toggle Grouped Custom Labels (used in toggleSelectedItem function)
    const toggleGroupedCustomLabels = (groupedKey, key, value) => {
        if (organisation.groupedCategoryCustomLabels[groupedKey]
            && organisation.groupedCategoryCustomLabels[groupedKey].hasOwnProperty(key)) {
            delete organisation.groupedCategoryCustomLabels[groupedKey][key];

            if (Object.keys(organisation.groupedCategoryCustomLabels[groupedKey]).length === 0) {
                delete organisation.groupedCategoryCustomLabels[groupedKey];
            }

            return;
        }
        organisation.groupedCategoryCustomLabels[groupedKey] = !organisation.groupedCategoryCustomLabels[groupedKey] ? {[key]: value} : {
            ...organisation.groupedCategoryCustomLabels[groupedKey],
            [key]: value
        };
    };

    // Function to toggle Selected Item (used in toggle function)
    const toggleSelectedItem = (key, value, exclude_fields, exclude_field_values, custom_label, groupedKey) => {
        if (groupedKey !== null) {
            toggleGroupedInterests(groupedKey, key, value);
            toggleGroupedExcludeFields(groupedKey, key, exclude_fields);
            toggleGroupedExcludeFieldValues(groupedKey, key, exclude_field_values);
            toggleGroupedCustomLabels(groupedKey, key, custom_label);
        }
    };


    return {
        store,
        interests,
        groupedOurInterests,
        toggle
    };
}
