<script setup>
    import { debounce } from "lodash";
    import { useDocumentManagementStore } from "@/stores/DocumentManagementStore";
    import DocumentCollection from "@/components/DocumentManagement/DocumentCollection";
    import CreateDocument from "@/components/DocumentManagement/Form/CreateDocument";

    const store = useDocumentManagementStore();
    store.fill();

    function pageChange({ page, limit }) {
        store.fill({ page, limit })
    }

    // const handleSearch = debounce(function (e) {
    //     const currentStr = e.target.value;
    //     const prevStr = store.search;
        
    //     if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
    //         return;
    //     }
    //     store.search = currentStr;
        
    //     store.fill();
    // }, 500)
</script>

<template>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card" :class="$setLoadingSpinner(store.loading)" style="min-height: 75vh;">
                <CardHeader title="Documents" class="d-flex justify-content-between align-items-cnter">
                    <div style="display: grid; grid-template-columns: auto auto;">
                        <button type="button" 
                            class="btn btn-sm btn-info me-2" 
                            @click="store.handleAddClick()"
                        >
                            <span class="tf-icons bx bx-plus"></span>&nbsp; New Document
                        </button>
                    </div>
                </CardHeader>
                <hr />

                <div class="accordion collection-accordion pt-2 p-4" id="accordionExample">
                    <h6 v-if="store.totalDocumentCollection <= 0" class="text-center">
                        No doument collections found...
                    </h6>

                    <DocumentCollection
                        :level="1"
                        :store="store"
                        :collections="store.documentCollections">
                    </DocumentCollection>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-8">
            <div class="card" style="min-height: 75vh;">
                <div class="documents-container px-3 py-3" v-if="store.selectedCollections.length || store.selectedDocuments.length">
                    <label class="document-item" 
                        v-for="collectionItem in store.selectedCollections"
                        :key="collectionItem.id"
                        @click="store.handleCollectionSelect(collectionItem)"
                    >
                        <div class="document-content item px-2">
                            <i class="bx bx-folder icon"></i>
                            <p :title="collectionItem.title" class="title line-clamp-3">
                                {{ collectionItem.title }}
                            </p>
                        </div>
                    </label>

                    <label class="document-item" 
                        v-for="document in store.selectedDocuments"
                        :key="document.id"
                        @click="store.handleDocumentSelect(document)"
                    >
                        <div class="document-content item px-2">
                            <i class="bx bx-file icon"></i>
                            <p :title="document.title" class="title line-clamp-3">
                                {{ document.title }}
                            </p>
                        </div>
                    </label>
                </div>

                <not-found height="70vh" :message="store.emptyMsg" v-else></not-found>
            </div>
        </div>

        <CreateDocument></CreateDocument>
    </div>
</template>