<script setup>
    import { debounce } from "lodash";
    import { useCollectionStore } from "@/stores/CollectionStore";
    import CollectionItems from "@/components/Collections/CollectionItems";
    import CollectionForm from "@/components/Collections/CollectionForm";

    const store = useCollectionStore();
    store.fill();

    const handleSearch = debounce(function (e) {
        const currentStr = e.target.value;
        const prevStr = store.search;
        
        if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
            return;
        }
        store.search = currentStr;
        
        store.fill();
    }, 500)
</script>

<template>
    <div class="card" :class="$setLoadingSpinner(store.loading)" style="min-height: 75vh;">
        <CardHeader title="Collections" class="d-flex justify-content-between align-items-cnter">
            <div style="display: grid; grid-template-columns: auto auto;">
                <button type="button" 
                    class="btn btn-sm btn-info me-2" 
                    @click="store.handleAddClick()"
                >
                    <span class="tf-icons bx bx-plus"></span>&nbsp; New Collection
                </button>

                <div class="input-group input-group-merge input-group-sm">
                    <span class="input-group-text" id="basic-addon-search31">
                        <i class="bx bx-search"></i>
                    </span>
                    <input type="search"
                        class="form-control form-control-sm" 
                        placeholder="Search..."
                        @keyup="handleSearch"
                        @click="handleSearch">
                </div>
            </div>
        </CardHeader>
        <hr />

        <div class="accordion collection-accordion no-arrow pt-2 p-4" id="accordionExample">
            <div class="accordion-item border-0 pb-2" v-if="store.isCollectionAddable && (!store.parentId || store.totalCollection <= 0)">
                <button type="button"
                    class="accordion-button collapsed py-0" 
                    data-toggle="collapse" 
                    data-target="#collection" 
                    aria-expanded="false" 
                    aria-controls="collection"
                >
                    <i class="bx bx-folder-open bg-info me-2 ms-3 fs-6 fw-bold text-white round-folder"></i>

                    <CollectionForm></CollectionForm>
                </button>
            </div>

            <h6 v-if="!store.isCollectionAddable && store.totalCollection <= 0" class="text-center">
                No collections found...
            </h6>

            <CollectionItems
                :level="1"
                :collections="store.collections">
            </CollectionItems>
        </div>
    </div>
</template>