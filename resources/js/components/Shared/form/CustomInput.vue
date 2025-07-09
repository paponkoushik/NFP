<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        modelValue: {
            default: null
        },
        value: {
            default: null
        },
        type: {
            type: String,
            default: 'radio'
        },
        name: {
            type: String,
            default: 'custom'
        },
        label: {
            type: String
        }
    });

    const isChecked = computed(() => (props.modelValue != null && props.modelValue == props.value) ? true : false);
</script>

<template>
    <div class="form-check form-check-success custom-option custom-option-basic hover:shadow-sm"
        :class="{'checked':isChecked}">
        <label class="form-check-label custom-option-content">
            <input :type="type"
                :name="name"
                :checked="isChecked"
                class="form-check-input"
                @change="$emit('update:modelValue', value)"
            />
            <slot>
                <span class="fw-semibold" v-if="label">{{ label }}</span>
            </slot>
        </label>
    </div>
</template>
