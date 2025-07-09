<template>
    <div class="trix-editor">
        <input type="hidden" :id="id" :value="modelValue" name="content">
        <trix-editor ref="trix" :input="id" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script setup>
    import 'trix';
    import { ref, onMounted, watch } from 'vue';
    
    const props = defineProps({
        modelValue: String,
        placeholder: {
            type: String,
            default: ''
        },
        shouldClear: {
            default: null
        },
        id: {
            default: 'trix'
        } 
    });

    const emit = defineEmits(['update:modelValue']);

    const trix = ref(null);

    onMounted(() => {
        trix.value.addEventListener('trix-change', e => {
            emit('update:modelValue', e.target.innerHTML);
        });
    });

    // watch(
    //     () => props.shouldClear, 
    //     () => {
    //         trix.value.value = ''
    //     }
    // );
</script>