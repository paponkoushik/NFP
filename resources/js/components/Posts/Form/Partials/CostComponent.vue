<script setup>
import {COST_OPTIONS, FREQUENCY_OPTIONS} from "@/core/categories_data";
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
    customLabels      : {
        type    : Object,
        required: true
    }
});


const costLabel = computed(() => {
    return Object.keys(props.customLabels).length
    && props.customLabels.hasOwnProperty('cost')
    && Object.keys(props.customLabels.cost).length
    && props.customLabels.cost.hasOwnProperty('title')
    && props.customLabels.cost.title !== ''
        ? props.customLabels.cost.title : 'Cost';
});

const costFieldValueLabel = (fieldValue) => {
    return Object.keys(props.customLabels).length
    && props.customLabels.hasOwnProperty('cost')
    && Object.keys(props.customLabels.cost).length
    && props.customLabels.cost.hasOwnProperty(fieldValue)
    && props.customLabels.cost[fieldValue] !== ''
        ? props.customLabels.cost[fieldValue] : fieldValue;
};

const formattedCostOptions = computed(() => {
    return COST_OPTIONS.map((optionItem) => {
        return {
            id  : optionItem,
            text: costFieldValueLabel(optionItem)
        }
    });
});

// Reset the values when -> cost value changes
/*watch(() => props.values.cost, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        costResetHandler();
    }
});
const costResetHandler = () => {
    props.values.amount = '';
    props.values.from_amount = '';
    props.values.to_amount = '';
    props.values.frequency = '';
}*/
</script>

<template>
    <div>
        <div class="row">
            <div
                :class="{
                    'col-md-12': !values.cost,
                     'col-md-4': values.cost === 'fixed',
                     'col-md-3': values.cost === 'range'
                }">
                <label class="form-label">
                    {{ costLabel }}
                </label>
                <Select2 :settings="{allowClear: true}"
                         placeholder="-----" name="cost"
                         v-model="values.cost"
                         :options="formattedCostOptions"/>
            </div>

            <div class="col-md-6 mt-1" v-show="values.cost === 'range'">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label d-flex">From Amount</label>
                        <input type="number" class="form-control"
                               placeholder="From amount" name="from_amount"
                               v-model.number="values.from_amount">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-flex">To Amount</label>
                        <input type="number" class="form-control" placeholder="To amount"
                               v-model.number="values.to_amount" name="to_amount">
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-1"
                 v-show="values.cost === 'fixed'">
                <label class="form-label d-flex">Amount</label>
                <input type="number" class="form-control" placeholder="To amount"
                       v-model.number="values.amount" name="amount">
            </div>

            <div class="col-md-3" v-if="values.cost && values.cost !== 'free'"
                 :class="{'col-md-4': values.cost === 'fixed', 'col-md-3': !values.cost ||
                                                values.cost !== 'fixed'}">
                <label class="form-label">Frequency</label>
                <Select2 :settings="{allowClear: true}" name="frequency"
                         placeholder="-----"
                         v-model="values.frequency"
                         :options="FREQUENCY_OPTIONS.map((optionItem) => ({id: optionItem, text:
                                                optionItem.charAt(0).toUpperCase() + optionItem.slice(1)}))"/>
            </div>
        </div>
    </div>
</template>
