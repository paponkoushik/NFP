<script setup>
    import { useDocumentManagementStore } from "@/stores/DocumentManagementStore";
    import DocumentLocation from "@/components/DocumentManagement/Form/DocumentLocation";

    const store = useDocumentManagementStore();

    defineProps({
        collections: {
            type: Array,
            default: () => [],
        },

        level: {
            type: Number,
            default: 1
        }
    });
</script>

<template>
    <div class="accordion-item border-0 pb-0 pt-2" 
        v-for="collection in collections" 
        :key="collection.id"
    >
        <button type="button"
            class="accordion-button d-flex justify-content-between py-0"
            :class="`level-${level}`" 
            aria-expanded="false" 
            data-bs-toggle="collapse"
            :aria-controls="`#document-collection-${collection.id}`"
            :data-bs-target="`#document-collection-${collection.id}`" 
        >
            <div class="text-truncate">
                <i class="bx bx-folder-open bg-primary me-1 ms-3 fs-6 fw-bold text-white round-folder"></i>
                {{ collection.title }}
            </div>

            <div class="form-check form-check-success" data-bs-toggle="collapse" data-bs-target="none">
                <input class="form-check-input" type="checkbox" :value="collection.id" v-model="store.form.collections" />
            </div>
        </button>

        <div :id="`document-collection-${collection.id}`" class="accordion-collapse collapse show">
            <div class="accordion-body pe-0">
                <ul class="list-unstyled m-0 ps-4">
                    <li class="d-flex align-items-center">
                        <div class="w-100">
                            <DocumentLocation
                                :level="level+1" 
                                :collections="collection.childs">
                            </DocumentLocation>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> 
</template>