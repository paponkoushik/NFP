<script setup>
    import { useCollectionStore } from "@/stores/CollectionStore";

    const store = useCollectionStore();
</script>

<template>
    <input type="text" 
        v-model="store.title"
        class="form-control form-control-sm small me-2"
        :class="{'is-invalid': store.isTitleInvalid}"
        placeholder="Type collection name">
    
    <button type="button" 
        class="btn btn-icon small btn-outline-secondary btn-sm me-1"
        @click="store.handleSubmit()"
    >
        <i class="bx bx-save fs-6"></i>
    </button>

    <button type="button" 
        class="btn btn-icon small btn-outline-secondary btn-sm me-1"
        @click="store.resetForm()"
    >
        <i class="bx bx-revision fs-6"></i>
    </button>

    <button type="button" 
        v-if="!store.isCollectionAddable"
        class="btn btn-icon small btn-outline-secondary btn-sm"
        @click="store.delete()"
    >
        <i class="bx bx-trash fs-6"></i>
    </button>
</template>