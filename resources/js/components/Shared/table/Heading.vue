<script setup>
    defineProps({
        sortable: {
            type: Boolean,
            default: false,
        },

        direction: {
            type: String,
            default: 'asc',
        },

        multiColumn: {
            type: Boolean,
            default: false,
        },
    })
</script>

<template>
    <th :class="[{ sorting: sortable }, direction && sortable ? `sorting_${direction}` : '',]">
        <slot></slot>
    </th>
</template>
