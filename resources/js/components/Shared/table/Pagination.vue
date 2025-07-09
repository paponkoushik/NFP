<script setup>
    import { ref, watch } from 'vue';

    const props = defineProps({
        meta: {
            type: Object,
            default: () => ({})
        }
    });

    const limit = ref(10);

    const emit = defineEmits(['changed']);

    function broadcast(page) {
        emit('changed', { page, limit: limit.value });
    }

    watch(() => props.meta.limit, value => limit.value = value);
</script>

<template>
    <div class="pagination-toolbar" v-if="meta.total > limit">
        <p class="pagination-selectLabel mb-0">Rows per page:</p>
        
        <select 
            class="border-0 border-bottom form-select py-1 px-2 rounded-0 w-px-50"
            v-model="limit" 
            @change="broadcast(1)"
            :disabled="meta.total <= 10"
        >
            <option value="10">10</option>
            <option value="25">25</option>
            <option v-show="meta.total > 25" value="50">50</option>
        </select>

        <p class="mb-0 pagination-displayedRows display-rows">
            {{ meta.from }}-{{ meta.to }} of {{ meta.total }}
        </p>
            
        <div class="pagination-actions">
            <!-- Previous Page Link -->
            <button
                type="button"
                tabindex="-1"
                class="page-arrow"
                rel="prev" 
                aria-label="@lang('pagination.previous')"
                :class="{ disabled: meta.current_page == 1 }"
                :disabled="meta.current_page == 1"
                @click.prevent="broadcast(meta.current_page - 1)"
            >
                <svg class="arrow-icon" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="KeyboardArrowLeftIcon">
                    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"></path>
                </svg>
            </button>

            <!-- Next Page Link -->
            <button 
                type="button" 
                class="page-arrow" 
                tabindex="0" 
                rel="next" 
                aria-label="@lang('pagination.next')"
                :class="{ disabled: meta.current_page == meta.last_page }"
                :disabled="meta.current_page == meta.last_page"
                @click.prevent="broadcast(meta.current_page + 1)"
            >
                <svg class="arrow-icon" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="KeyboardArrowRightIcon">
                    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"></path>
                </svg>
            </button>
        </div>
    </div>
</template>
