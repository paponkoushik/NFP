<script setup>
import { ref, watch, computed } from 'vue';
import { useDashboardStore } from "@/stores/DashboardStore";
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import debounce from 'lodash/debounce';

defineProps({ statuses: Array });

const { getUrlParams, pushUrlState } = useUrlFunc();
const store = useDashboardStore();
const urlQueryParams = getUrlParams();
const search = ref(urlQueryParams?.search || '');
const filters = ref({
    status: '',
    dateColumn: '',
    fromDate: '',
    toDate: '',
    sortBy: '',
    direction: ''
});

for (let filterKey in filters.value) {
    filters.value[filterKey] = urlQueryParams[filterKey] || '';
}

const dateFilter = computed(() => {
    const { dateColumn, fromDate, toDate } = filters.value;
    return { dateColumn, fromDate, toDate };
});

const sortFilter = computed(() => {
    const { sortBy, direction } = filters.value;
    return { sortBy, direction };
});

watch(
    search,
    debounce(function (search) {
        _setFilterPayload({ search });
        store.fill();
    }, 500)
);

watch(
    () => filters.status,
    (status) => {
        _setFilterPayload({ status });
        store.fill();
    }
);

watch(dateFilter, (newDateFilter) => {
    const { dateColumn, fromDate, toDate } = newDateFilter;

    if (dateColumn && (fromDate || toDate)) {
        _setFilterPayload(newDateFilter);
        store.fill();
    }
}, { deep: true });

watch(sortFilter, (newSortFilter) => {
    if (newSortFilter.sortBy && newSortFilter.direction) {
        _setFilterPayload(newSortFilter);
        store.fill();
    }
}, { deep: true });

function handleFilter(key, value) {
    value = filters.value[key] = value || filters.value[key];
    _setFilterPayload({ [key]: value });
    store.fill();
}

function handleResetFilters() {
    let obj = {};
    for (let key of ['sortBy', 'direction', 'dateColumn', 'fromDate', 'toDate']) {
        obj[key] = filters.value[key] = '';
    }

    pushUrlState(obj);
    store.fill();
}

function _setFilterPayload(payload) {
    return pushUrlState({ ...payload, page: 1 });
}
</script>

<template>
    <CardHeader class="d-flex justify-content-between align-items-center" title="New Legal Requests">
        <Dropdown icon="bx bx-filter-alt" :group="true">
            <!-- <DropdownLink @click="filters.order = 'oldest'" :icon="`${!isRecentFirst ? 'bx bx-check text-success' : ''}`">Old First</DropdownLink>
            <DropdownLink @click="filters.order = 'recent'" :icon="`${isRecentFirst ? 'bx bx-check text-success' : ''}`">Recent First</DropdownLink> -->

            <p @click="handleResetFilters"
                class="bg-label-secondary border-bottom mb-0 mt-n2 pointer px-2 py-1 rounded-end-top rounded-start-top text-center text-uppercase hover:text-amber-600">
                Rest Filters</p>

            <div class="px-2 mt-2">
                <p class="bg-label-secondary fw-normal mx-n2 mb-1 px-2 py-1 text-uppercase">Date Filter</p>
                <div class="mb-1">
                    <select v-model="filters.dateColumn" class="form-select form-select-sm form-select-position-sm">
                        <option value="">---</option>
                        <option value="created">Created at</option>
                    </select>
                </div>
                <div class="mb-1">
                    <Flatpickr v-model="filters.fromDate" class="form-control form-control-sm" placeholder="From Date" />
                </div>
                <div class="mb-1">
                    <Flatpickr v-model="filters.toDate" class="form-control form-control-sm" placeholder="To Date" />
                </div>
            </div>
        </Dropdown>
        <div class="row mb-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input v-model="search" class="form-control form-control-sm rounded-pill"
                        placeholder="Search request no, org name..." />
                </div>
            </div>
        </div>
    </CardHeader>
</template>
