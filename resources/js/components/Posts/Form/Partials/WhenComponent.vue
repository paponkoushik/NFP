<script setup>
import {WHEN_OPTIONS} from "@/core/categories_data";
import {computed, watch} from "vue";

const props = defineProps({
    values            : {
        type    : Object,
        required: true
    },
    excludeFieldValues: {
        type    : Object,
        required: true
    },
    customLabels: {
        type    : Object,
        required: true
    }
});


const whenLabel = computed(() => {
    return Object.keys(props.customLabels).length
    && props.customLabels.hasOwnProperty('when')
    && Object.keys(props.customLabels.when).length
    && props.customLabels.when.hasOwnProperty('title')
    && props.customLabels.when.title !== ''
        ? props.customLabels.when.title : 'When';
});

const whenFieldValueLabel = (fieldValue) => {
    return Object.keys(props.customLabels).length
    && props.customLabels.hasOwnProperty('when')
    && Object.keys(props.customLabels.when).length
    && props.customLabels.when.hasOwnProperty(fieldValue)
    && props.customLabels.when[fieldValue] !== ''
        ? props.customLabels.when[fieldValue] : fieldValue;
};

const formattedWhenOptions = computed(() => {
    // add existing filter then map
    return WHEN_OPTIONS.filter((optionItem) => {
        return props.hasOwnProperty('excludeFieldValues') &&
            props.excludeFieldValues.hasOwnProperty('when') &&
            props.excludeFieldValues.when.length &&
            !props.excludeFieldValues.when.includes(optionItem)
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
