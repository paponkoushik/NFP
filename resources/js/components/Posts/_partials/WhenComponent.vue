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

const whenLabel = computed(() => {
    return Object.keys(props.labels).length
    && props.labels.hasOwnProperty('when')
    && Object.keys(props.labels.when).length
    && props.labels.when.hasOwnProperty('title')
    && props.labels.when.title !== ''
        ? props.labels.when.title : 'When';
});
</script>

<template>
    <div class="list-group-item list-group-item-action">
        <div class="d-flex w-full">
            <i class="bx bx-time"></i>
            <strong class="mb-1 ms-1"> {{ whenLabel }}</strong>
        </div>
        <div class="ps-4">
            <div class="" v-if="props.preferences.when === 'range'">
                <div><span>From Date: </span>{{ props.preferences.from_date }}</div>
                <div><span>To Date: </span>{{ props.preferences.to_date }}</div>
            </div>
            <p class="mb-1" v-else-if="props.preferences.when === 'fixed'">
                <span>Date: </span>{{ props.preferences.date }}
            </p>
            <p class="mb-1" v-else>
                <span>Date: </span>{{ props.preferences.when.charAt(0).toUpperCase() + props.preferences.when.slice(1) }}
            </p>
        </div>

    </div>
</template>

<style scoped>
.list-group-item {
    border: 1px solid white;
}
</style>
