<script setup>
import { toRefs } from 'vue';
import { useField } from 'vee-validate';

const props = defineProps({
    modelValue: {
        type: null,
    },
    as: {
        type: String,
        default: 'radio' // radio, checkbox, button
    },
    type: {
        type: String,
        default: 'radio'
    },
    label: String,
    name: String,
    value: {
        type: null,
    },
    classes: { 
        type: String,
        default: '' 
    }
});

const { name, as: fieldType } = toRefs(props);
const { checked, handleChange } = useField(name, undefined, {
    type: props.type,
    checkedValue: props.value,
    uncheckedValue: false,
});
</script>

<template>
    <div>
        <div v-if="fieldType == 'radio'"
            :class="{
                'form-check form-check-success custom-option custom-option-image custom-option-image-radio hover:shadow-sm': true,
                'checked': checked,
                [classes]: true
            }"
            @click="handleChange(value)"
        >
            <label class="form-check-label custom-option-content py-2 px-3">
                <span class="fw-semibold">{{ label }}</span>
            </label>
        </div>

        <label v-else-if="fieldType == 'checkbox'" :class="`switch switch-success switch-square ${classes}`">
            <input type="checkbox" class="switch-input" :checked="checked" @change="handleChange(value)" />
            <span class="switch-toggle-slider">
                <span class="switch-on"><i class="bx bx-check"></i></span>
                <span class="switch-off"><i class="bx bx-x"></i></span>
            </span>
            <span class="switch-label">{{ label }}</span>
        </label>

        <button v-else 
            type="button" 
            :class="{
                'bg-label-facebook': checked,
                [classes]: true
            }" 
            @click="handleChange(value)"
        >
            {{ label }}
        </button>
    </div>
</template>
