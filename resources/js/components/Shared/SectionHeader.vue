<script setup>
    defineProps({
        title: {
            type: String,
        },

        subTitle: {
            type: String,
        },

        sectionClass: {
            type: String,
            default: "fw-bold py-3 mb-4"
        }
    });
</script>

<template>
    <h4 :class="sectionClass">
        <span class="text-muted fw-light">
            {{ title }} 
            <span v-if="subTitle">/</span>
        </span> 
        
        {{ subTitle}}
    </h4>
</template>