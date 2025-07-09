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

const whereLabel = computed(() => {
    return Object.keys(props.labels).length
    && props.labels.hasOwnProperty('where')
    && props.labels.where !== ''
        ? props.labels.where : 'Where';
});
</script>

<template>
    <div class="list-group-item list-group-item-action">
        <div class="d-flex w-full ">
            <i class="bx bx-location-plus"></i>
            <strong class="mb-1 ms-1"> {{ whereLabel }}</strong>
        </div>
        <div class="ps-4">
            <p class="mb-1" v-if="props.preferences.where === 'local-area' || props.preferences.where === 'location'">
                <span>Location: </span>{{ props.preferences.local_area }}
            </p>
            <p class="mb-1" v-else-if="props.preferences.where === 'states'">
                <span>States: </span>
                {{ props.preferences.states.join(', ') }}
            </p>
            <p class="mb-1" v-else-if="props.preferences.where === 'suburbs'">
                <span>Suburbs: </span>
                {{ props.preferences.suburbs.join(', ') }}
            </p>
            <div class="" v-else-if="props.preferences.where === 'radius'">
                <div><span>Radius Location: </span>{{ props.preferences.radius_location }}</div>
                <div><span>Radius: </span>{{ '+' + props.preferences.radius + 'km' }}</div>
            </div>
            <p class="mb-1" v-else>
                <span>Location: </span>Australia Wide
            </p>
        </div>

    </div>
</template>

<style scoped>
.list-group-item {
    border: 1px solid white;
}
</style>
