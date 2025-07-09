<script setup>
    defineProps({
        title: {
            type: String,
        }
    });
</script>

<template>
    <div class="card-header px-3 pb-2">
        <slot name="heading">
            <div class="head-label" v-if="title">
                <h5 class="card-title mb-0">{{ title }}</h5>
            </div>
        </slot>

        <div class="float-right">
            <slot></slot>
        </div>
    </div>
</template>
