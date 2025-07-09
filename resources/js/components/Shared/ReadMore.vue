<script setup>
import { ref } from 'vue';

defineProps({
    content: { default: '' },
    clamp: { default: 6 },
    min: { type: Number, default: 200 }
});

let showMore = ref(false);
</script>

<template>
    <div :class="{'line-clamp': !showMore}" v-html="content"></div>

    <div v-show="content && content.length > min" class="pointer" @click="showMore = !showMore">
        <span class="fw-bold text-black text-decoration-underline">Show {{ showMore ? 'less' : 'more' }}</span>
        <i :class="`bx bx-chevron-${showMore ? 'up' : 'right'} fs-4`"></i>
    </div>
</template>

<style scoped>
.line-clamp {
    -webkit-line-clamp: v-bind('clamp');
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
}
</style>