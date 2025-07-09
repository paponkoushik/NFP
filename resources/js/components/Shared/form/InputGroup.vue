<script setup>
    defineProps({
        label: {
            type: String
        },

        required: {
            type: Boolean,
            default: true,
        }
    });
</script>

<template>
    <div class="mb-3">
        <label v-if="label" :for="label" class="form-label">
            {{ label }} 
            <span class="text-danger" v-if="required"> *</span>
        </label>

        <slot></slot>
    </div>
</template>
