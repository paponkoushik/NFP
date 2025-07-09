<script setup>
import {WHEN_OPTIONS} from "@/core/categories_data";
import {computed, watch} from "vue";

const props = defineProps({
    item  : {
        type    : Object,
        required: true
    },
    values: {
        type: Object
    }
});

const whenLabel = computed(() => {
    return Object.keys(props.item.custom_labels).length
    && props.item.custom_labels.hasOwnProperty('when')
    && Object.keys(props.item.custom_labels.when).length
    && props.item.custom_labels.when.hasOwnProperty('title')
    && props.item.custom_labels.when.title !== ''
        ? props.item.custom_labels.when.title : 'When';
});

const whenFieldValueLabel = (fieldValue) => {
    return Object.keys(props.item.custom_labels).length
    && props.item.custom_labels.hasOwnProperty('when')
    && Object.keys(props.item.custom_labels.when).length
    && props.item.custom_labels.when.hasOwnProperty(fieldValue)
    && props.item.custom_labels.when[fieldValue] !== ''
        ? props.item.custom_labels.when[fieldValue] : fieldValue;
};

const formattedWhenOptions = computed(() => {
    // add existing filter then map
    return WHEN_OPTIONS.filter((optionItem) => {
        return props.item.hasOwnProperty('excludeFieldValues') &&
            props.item.excludeFieldValues.hasOwnProperty('when') &&
            props.item.excludeFieldValues.when.length &&
            !props.item.excludeFieldValues.when.includes(optionItem)
    }).map((optionItem) => {
        return {
            id  : optionItem,
            text: whenFieldValueLabel(optionItem)
        }
    });
});


// Reset the values when -> when value changes
/*watch(() => props.values.when, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        whenResetHandler();
    }
});
const whenResetHandler = () => {
    props.values.date = '';
    props.values.from_date = '';
    props.values.to_date = '';
}*/

</script>

<template>
    <div>
        <div class="row">
            <div class="col-md-12 mb-2">
                <label class="form-label" for="when-inv">
                    {{ whenLabel }}
                </label>
                <Select2 :settings="{allowClear: true}"
                         placeholder="-----"
                         v-model="values.when" name="when"
                         :options="formattedWhenOptions"/>
            </div>

            <!--                                            Date range picker-->
            <div class="col-md-12" v-if="values.when === 'range'">
                <div class="row">
                    <div class="col-md-6">
                        <Flatpickr id="from-date-inv" class="form-control"
                                   name="from_date"
                                   placeholder="From date"
                                   v-model="values.from_date"/>
                    </div>

                    <div class="col-md-6">
                        <Flatpickr id="to-date-inv" class="form-control" name="to_date"
                                   placeholder="To date" v-model="values.to_date"/>
                    </div>
                </div>
            </div>

            <!--                                            Fixed date picker-->
            <div class="col-md-12" v-if="values.when === 'fixed'">
                <Flatpickr id="date-inv" class="form-control" name="date"
                           placeholder="Date" v-model="values.date"/>
            </div>
        </div>
    </div>
</template>
