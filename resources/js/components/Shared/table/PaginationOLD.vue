<script setup>
    import { computed } from "vue";
    import _ from 'lodash';

    const props = defineProps({
        meta: {
            type: Object,
            default: () => ({})
        }
    });

    const emit = defineEmits(['changed']);

    const startPage = computed(() => {
        let minPage = props.meta.current_page - 2;

        if (minPage <= 0) return 1;
        else if (minPage + 5 >= props.meta.last_page)
            return props.meta.last_page - 4;
        else 
            return props.meta.current_page - 2;
    });

    const endPage = computed(() => {
        let maxPage = startPage.value + 5;

        if (maxPage > props.meta.last_page) 
            return props.meta.last_page + 1;
        else 
            return maxPage;
    });

    function broadcast(page) {
        emit('changed', { page });
    }
</script>

<template>
    <div class="d-flex justify-content-between row py-2" v-if="meta.total">
        <div class="col-sm-12 col-md-6">
            <div
                class="dataTables_info"
                id="DataTables_Table_0_info"
                role="status"
                aria-live="polite"
            >
                Showing {{ meta.from }} to {{ meta.to }} of
                {{ meta.total }} entries
            </div>
        </div>

        <div class="col-sm-12 col-md-6" v-if="meta.total && meta.last_page > 1">
            <div
                class="dataTables_paginate paging_simple_numbers"
                id="DataTables_Table_0_paginate"
            >
                <ul class="pagination" v-if="meta.last_page < 5">
                    <li
                        v-for="(page, key) in meta.last_page"
                        :key="key"
                        class="paginate_button page-item"
                        :class="{ active: meta.current_page == page }"
                    >
                        <a href="#" aria-controls="DataTables_Table_0" tabindex="0" class="page-link" @click.prevent="broadcast(page)">
                            {{ page }}
                        </a>
                    </li>
                </ul>

                <ul class="pagination" v-else>
                    <li
                        class="paginate_button page-item first"
                        :class="{ disabled: meta.current_page == 1 }"
                    >
                        <a href="#" aria-controls="DataTables_Table_0" tabindex="0" class="page-link" @click.prevent="broadcast(1)">
                            <i class="bx bxs-chevrons-left"></i>
                        </a>
                    </li>

                    <li
                        class="paginate_button page-item previous"
                        :class="{ disabled: meta.current_page == 1 }"
                    >
                        <a href="#" aria-controls="DataTables_Table_0" tabindex="0" class="page-link" @click.prevent="broadcast(meta.current_page - 1)">
                            <i class="bx bxs-chevron-left"></i>
                        </a>
                    </li>

                    <li
                        v-for="(page, key) in _.range(startPage, endPage)"
                        :key="key"
                        class="paginate_button page-item"
                        :class="{ active: meta.current_page == page }"
                    >
                        <a href="#" aria-controls="DataTables_Table_0" tabindex="0" class="page-link" @click.prevent="broadcast(page)">
                            {{ page }}
                        </a>
                    </li>

                    <li
                        class="paginate_button page-item next"
                        :class="{ disabled: meta.current_page == meta.last_page }"
                    >
                        <a href="#" aria-controls="DataTables_Table_0" tabindex="0" class="page-link" @click.prevent="broadcast(meta.current_page + 1)">
                            <i class="bx bxs-chevrons-right"></i>
                        </a>
                    </li>

                    <li
                        class="paginate_button page-item last"
                        :class="{ disabled: meta.current_page == meta.last_page }"
                    >
                        <a href="#" aria-controls="DataTables_Table_0" tabindex="0" class="page-link" @click.prevent="broadcast(meta.last_page)">
                            <i class="bx bxs-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
