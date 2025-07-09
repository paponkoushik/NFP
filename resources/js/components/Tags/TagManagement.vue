<script setup>
    import { debounce } from "lodash";
    import { useTagStore } from "@/stores/TagStore";

    const store = useTagStore();
    store.fill();

    function pageChange({ page, limit }) {
        store.fill({ page, limit })
    }

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
        <Datatable>
            <CardHeader title="Tags" class="pb-4">
                <div style="display: grid; grid-template-columns: auto auto;">
                    <button type="button" 
                        class="btn btn-sm btn-info me-2" 
                        @click="store.handleAddClick()"
                    >
                        <span class="tf-icons bx bx-plus"></span>&nbsp; New Tag
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

            <template #body>
                <template v-if="store.totalTag > 0">
                    <transition-group name="fade">
                        <Row v-for="tag in store.tags" :key="tag.id">
                            <Cell>
                                <input type="text"
                                    class="form-control form-control-sm"
                                    :class="{'is-invalid': store.isTagInvalid}"
                                    v-model="store.tagName"
                                    v-if="store.editTag && store.editTag?.id == tag.id"
                                    @keyup.enter="store.handleSubmit()"
                                >
                                <p class="m-0" v-else @dblclick="store.handleEdit(tag)">
                                    {{ tag.name }}
                                </p>
                            </Cell>
                            
                            <Cell>
                                <div class="d-flex justify-content-end">
                                    <template v-if="store.editTag && store.editTag?.id == tag.id">
                                        <button type="button" 
                                            class="btn btn-icon btn-outline-secondary btn-sm me-2"
                                            @click="store.handleSubmit()"
                                        >
                                            <i class="bx bx-save"></i>
                                        </button>

                                        <button type="button" 
                                            class="btn btn-icon btn-outline-secondary btn-sm"
                                            @click="store.resetForm()"
                                        >
                                            <i class="bx bx-revision"></i>
                                        </button>
                                    </template>

                                    <template v-else>
                                        <button type="button" 
                                            class="btn btn-icon btn-outline-secondary btn-sm me-2"
                                            @click="store.handleEdit(tag)"
                                        >
                                            <i class="bx bx-edit-alt"></i>
                                        </button>

                                        <button type="button" 
                                            class="btn btn-icon btn-outline-secondary btn-sm"
                                            @click="store.delete(tag)"
                                        >
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </template>
                                </div>
                            </Cell>
                        </Row>
                    </transition-group>
                </template>

                <template v-else>
                    <Row>
                        <td colspan="2">
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="font-medium py-8 text-cool-gray-400 text-xl">No tags found...</span>
                            </div>
                        </td>
                    </Row>
                </template>
            </template>

            <template #footer>
                <Pagination class="float-end" :meta="store.meta" @changed="pageChange" />
            </template>
        </Datatable>
    </div>
</template>