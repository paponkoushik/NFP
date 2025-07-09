<script setup>
import CostComponent from '@/components/Posts/_partials/CostComponent';
import WhereComponent from '@/components/Posts/_partials/WhereComponent';
import WhenComponent from '@/components/Posts/_partials/WhenComponent';
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

console.log('label', props.labels, 'preferences', props.preferences, 'excludeFields', props.excludeFields, 'excludeFieldValues', props.excludeFieldValues)
</script>
<template>

    <div class="widget">
        <h4 class="widget-title mb-3">Matching Preferences</h4>

        <div class="list-group w-100">
            <cost-component
                v-if="!props.excludeFields?.includes('cost')"
                :labels=props.labels
                :preferences=props.preferences
                :excludeFields=props.excludeFields
                :excludeFieldValues=props.excludeFieldValues
            />

            <where-component
                v-if="!props.excludeFields?.includes('where')"
                :labels=props.labels
                :preferences=props.preferences
                :excludeFields=props.excludeFields
                :excludeFieldValues=props.excludeFieldValues
            />

            <when-component
                v-if="!props.excludeFields?.includes('when')"
                :labels=props.labels
                :preferences=props.preferences
                :excludeFields=props.excludeFields
                :excludeFieldValues=props.excludeFieldValues
            />
        </div>

    </div>
</template>

