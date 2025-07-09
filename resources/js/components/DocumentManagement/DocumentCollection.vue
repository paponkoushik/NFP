<script setup>
    import DocumentCollection from "@/components/DocumentManagement/DocumentCollection";
    import DocumentItem from "@/components/DocumentManagement/DocumentItem";

    defineProps({
        collections: {
            type: Array,
            default: () => [],
        },

        level: {
            type: Number,
            default: 1
        },

        store: null,
    });
</script>

<template>
    <div class="accordion-item border-0 pb-0 pt-2" 
        v-for="collection in collections" 
        :key="collection.id"
    >
        <button type="button"
            class="accordion-button collapsed py-0 px-0"
            :class="`level-${level}`"
            aria-expanded="false" 
            data-bs-toggle="collapse"
            :aria-controls="`#collection-${collection.id}`"
            :data-bs-target="`#collection-${collection.id}`" 
            @click="store ? store.handleCollectionSelect(collection) : null"
        >
            <i class="bx bx-folder-open bg-primary me-2 ms-3 fs-6 fw-bold text-white round-folder"></i>
            <div class="text-truncate">{{ collection.title }}</div>
        </button>

        <div :id="`collection-${collection.id}`" class="accordion-collapse collapse">
            <div class="accordion-body">
                <ul class="list-unstyled m-0 ps-4">
                    <li class="d-flex align-items-center">
                        <div class="w-100">
                            <DocumentCollection
                                :level="level+1" 
                                :store="store"
                                :collections="collection.childs">
                            </DocumentCollection>

                            <DocumentItem
                                :level="level+1" 
                                :has-child="collection.childs?.length > 0 ? true : false"
                                :documents="collection.documents">
                            </DocumentItem>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> 
</template>