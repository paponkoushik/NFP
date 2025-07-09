<script setup>
    defineProps({
        href: {
            type: String,
            default: "javascript:void(0);",
        },

        icon: {
            type: String,
        },

        modalName: {
            type: String,
        },

        divider: {
            type: Boolean,
            default: false,
        },
    });
</script>

<template>
    <div class="dropdown-divider" v-if="divider"></div>

    <a
        v-else-if="modalName"
        class="dropdown-item"
        :href="href"
        data-bs-toggle="modal"
        :data-bs-target="`#${modalName}`"
    >
        <i v-if="icon" :class="`${icon} me-2`"></i>

        <slot></slot>
    </a>

    <a v-else class="dropdown-item" :href="href">
        <i v-if="icon" :class="`${icon} me-2`"></i>

        <slot></slot>
    </a>
</template>
