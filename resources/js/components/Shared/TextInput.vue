<script setup>
import { toRef } from 'vue';
import { useField } from 'vee-validate';

const props = defineProps({
    type: {
        type: String,
        default: 'text',
    },
    value: {
        type: String,
        default: '',
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    vlabel: {
        type: String,
        default: null,
    },
    successMessage: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
});

const name = toRef(props, 'name');

const {
    value: inputValue,
    errorMessage,
    handleBlur,
    handleChange,
    meta,
} = useField(name, undefined, {
    //initialValue: props.value,
    label: props.vlabel
});
</script>

<template>
    <div>
        <label class="form-label" :for="name">{{ label }}</label>
        <input
            :type="type"
            :id="name"
            :name="name"
            :class="{ 
                'form-control': true, 
                'is-invalid': !!errorMessage, 
                success: meta.valid 
            }"
            :value="inputValue"
            :placeholder="placeholder"
            @input="handleChange"
            @blur="handleBlur"
        />

        <p class="invalid-feedback mb-0" v-show="errorMessage">
            {{ errorMessage }}
        </p>
    </div>
</template>
