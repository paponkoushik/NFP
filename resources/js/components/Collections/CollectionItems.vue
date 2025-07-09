<script setup>
    import { useCollectionStore } from "@/stores/CollectionStore";
    import CollectionItems from "@/components/Collections/CollectionItems";
    import CollectionForm from "@/components/Collections/CollectionForm";

    const store = useCollectionStore();

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
            class="accordion-button collapsed py-0"
            :class="`level-${level}`" 
            aria-expanded="false" 
            data-bs-toggle="collapse"
            :aria-controls="`#collection-${collection.id}`"
            :data-bs-target="`#collection-${collection.id}`" 
            @click="store.handleCollectionSelect(collection)"
        >
            <i class="bx bx-folder-open bg-primary me-2 ms-3 fs-6 fw-bold text-white round-folder">
            </i>

            <CollectionForm v-if="store.editCollection && store.editCollection?.id == collection.id"></CollectionForm>

            <div class="text-truncate"
                v-else
                :id="`parent${collection.id}`"
                @dblclick="store.handleEditClick(collection)"
            >
                {{ collection.title }}
            </div>
        </button>

        <div :id="`collection-${collection.id}`" class="accordion-collapse collapse">
            <div class="accordion-body">
                <ul class="list-unstyled m-0 ps-4">
                    <li class="d-flex ps-4 pt-2" 
                        v-if="store.isCollectionAddable && store.parentId == collection.id && level <= 2">
                        <CollectionForm></CollectionForm>
                    </li>

                    <li class="d-flex align-items-center">
                        <div class="w-100">
                            <CollectionItems
                                :level="level+1" 
                                :collections="collection.childs">
                            </CollectionItems>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> 
</template>