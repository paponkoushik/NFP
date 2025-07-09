<script setup>
    import { useDocumentManagementStore } from "@/stores/DocumentManagementStore";

    const store = useDocumentManagementStore();

    defineProps({
        documents: {
            type: Array,
            default: () => [],
        },

        level: {
            type: Number,
            default: 1
        },

        hasChild: {
            type: Boolean,
            default: false,
        }
    });
</script>

<template>
    <div class="accordion-item documents-item border-0 pb-0 pt-2" 
        v-for="document in documents" 
        :key="document.id"
        @click="store.handleDocumentSelect(document)"
    >
        <i class="bx bx-file bg-info me-2 fs-6 fw-bold text-white round-folder" :class="{'ms-3': hasChild}"></i>
        <div class="text-truncate cursor-pointer" :title="document.title">{{ document.title }}</div>
    </div> 
</template>