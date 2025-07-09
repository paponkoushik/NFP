<script setup>
import { computed } from 'vue';

const props = defineProps({
    avatar: { default: null },
    label: { default: '' },
    color: { default: null }
});

const bgColor = computed(() => {
    let colors = ['info', 'primary', 'secondary', 'warning', 'linkedin', 'facebook', 'slack', 'vimeo', 'twitter'];
    return props.color ?? colors[Math.floor(Math.random() * colors.length)];
});

const shortLabel = computed(() => {
    return props.label.match(/(^\S\S?|\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
});
</script>

<template>    
    <div class="avatar-wrapper">
        <div class="avatar me-2">
            <img v-if="avatar" :src="avatar" alt="Avatar" class="rounded-circle" />
            <span v-else :class="`avatar-initial rounded-circle bg-label-${ bgColor }`">{{ shortLabel }}</span>
        </div>

        <slot />
    </div>
</template>