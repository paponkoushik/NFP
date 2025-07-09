<script setup>
import {computed} from "vue";

const props = defineProps({
    labels: {
        type: Object,
        default: () => ({})
    },
    preferences: {
        type: Object,
        default: () => ({})
    },
    excludeFields: {
        type: Array,
        default: () => ([])
    },
    excludeFieldValues: {
        type: Object,
        default: () => ({})
    }
})

const costLabel = computed(() => {
    return Object.keys(props.labels).length
    && props.labels.hasOwnProperty('cost')
    && Object.keys(props.labels.cost).length
    && props.labels.cost.hasOwnProperty('title')
    && props.labels.cost.title !== ''
        ? props.labels.cost.title : 'Cost';
});

</script>

<template>
    <div class="list-group-item list-group-item-action">
        <div class="d-flex w-full ">
<!--            justify-content-between-->
            <i class="bx bx-dollar"></i>
            <strong class="mb-1 ms-1"> {{ costLabel }}</strong>
        </div>
        <div class="ps-4">
            <div v-if="props.preferences.cost === 'range'">
                <div><span>From Amount: </span>${{ props.preferences.from_amount }}</div>
                <div><span>To Amount: </span>${{ props.preferences.to_amount }}</div>
            </div>
            <p class="mb-1" v-else-if="props.preferences.cost === 'fixed'">
                <span>Amount: </span>${{ props.preferences.amount }}
            </p>
            <p class="mb-1" v-else-if="props.preferences.cost && props.preferences.cost !== 'free'">
                <span>Frequency: </span>{{ props.preferences.frequency.charAt(0).toUpperCase() + props.preferences.frequency.slice(1) }}
            </p>
            <p class="mb-1" v-else>
                <span>Amount : </span>{{ props.preferences.cost.charAt(0).toUpperCase() + props.preferences.cost.slice(1) }}
            </p>
            </div>
        </div>

</template>

<style scoped>
.list-group-item {
    border: 1px solid white;
}
</style>
