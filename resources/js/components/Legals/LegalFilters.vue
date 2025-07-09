<script setup>
import {ref, watch, computed} from 'vue';
import {useLegalRequestStore} from "@/stores/LegalRequestStore";
import {useUrlFunc} from '@/composables/useUrlFunc.js';
import debounce from 'lodash/debounce';

defineProps({statuses: Array});

const {getUrlParams, pushUrlState} = useUrlFunc();
const store = useLegalRequestStore();
const urlQueryParams = getUrlParams();
const search = ref(urlQueryParams?.search || '');
const filters = ref({
    status    : '',
    dateColumn: '',
    fromDate  : '',
    toDate    : '',
    sortBy    : '',
    direction : ''
});

for (let filterKey in filters.value) {
    filters.value[filterKey] = urlQueryParams[filterKey] || '';
}

const dateFilter = computed(() => {
    const {dateColumn, fromDate, toDate} = filters.value;
    return {dateColumn, fromDate, toDate};
});

const sortFilter = computed(() => {
    const {sortBy, direction} = filters.value;
    return {sortBy, direction};
});

watch(
    search,
    debounce(function (search) {
        _setFilterPayload({search});
        store.fill();
    }, 500)
);

watch(
    () => filters.status,
    (status) => {
        _setFilterPayload({status});
        store.fill();
    }
);

watch(dateFilter, (newDateFilter) => {
    const {dateColumn, fromDate, toDate} = newDateFilter;

    if (dateColumn && (fromDate || toDate)) {
        _setFilterPayload(newDateFilter);
        store.fill();
    }
}, {deep: true});

watch(sortFilter, (newSortFilter) => {
    if (newSortFilter.sortBy && newSortFilter.direction) {
        _setFilterPayload(newSortFilter);
        store.fill();
    }
}, {deep: true});

function handleFilter(key, value) {
    value = filters.value[key] = value || filters.value[key];
    _setFilterPayload({[key]: value});
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
    return pushUrlState({...payload, page: 1});
}
</script>

<template>
    <CardHeader class="d-flex justify-content-between align-items-center" title="Legal Requests">
        <Dropdown icon="bx bx-filter-alt" :group="true">
            <!-- <DropdownLink @click="filters.order = 'oldest'" :icon="`${!isRecentFirst ? 'bx bx-check text-success' : ''}`">Old First</DropdownLink>
            <DropdownLink @click="filters.order = 'recent'" :icon="`${isRecentFirst ? 'bx bx-check text-success' : ''}`">Recent First</DropdownLink> -->

            <p @click="handleResetFilters"
               class="bg-label-secondary border-bottom mb-0 mt-n2 pointer px-2 py-1 rounded-end-top rounded-start-top text-center text-uppercase hover:text-amber-600">
                Rest Filters</p>

            <div class="px-2">
                <p class="fw-normal mx-n2 mb-1 px-2 py-1 text-uppercase">Sort By</p>
                <div class="mb-1">
                    <select v-model="filters.sortBy" class="form-select form-select-sm form-select-position-sm">
                        <option value="">---</option>
                        <option value="created">Created at</option>
                        <option value="updated">Updated at</option>
                    </select>
                </div>
                <div class="mb-1">
                    <select v-model="filters.direction" class="form-select form-select-sm form-select-position-sm">
                        <option value="">---</option>
                        <option value="asc">ASC</option>
                        <option value="desc">DESC</option>
                    </select>
                </div>
            </div>

            <div class="px-2 mt-2">
                <p class="bg-label-secondary fw-normal mx-n2 mb-1 px-2 py-1 text-uppercase">Date Filter</p>
                <div class="mb-1">
                    <select v-model="filters.dateColumn" class="form-select form-select-sm form-select-position-sm">
                        <option value="">---</option>
                        <option value="requested">Requested Date</option>
                        <option value="offered">Offered Date</option>
                        <option value="agreed">Agreed Date</option>
                        <option value="completed">Completed Date</option>
                    </select>
                </div>
                <div class="mb-1">
                    <Flatpickr
                        v-model="filters.fromDate"
                        class="form-control form-control-sm"
                        placeholder="From Date"/>
                </div>
                <div class="mb-1">
                    <Flatpickr
                        v-model="filters.toDate"
                        class="form-control form-control-sm"
                        placeholder="To Date"/>
                </div>
            </div>
        </Dropdown>
    </CardHeader>

    <div class="row mb-2 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
<!--                <Dropdown label="Bulk Actions" btn-class="btn-sm border rounded-pill" :group="true" icon>
                    <DropdownLink class="text-uppercase">
                        <i class="bx bx-export align-text-bottom"></i> Export
                    </DropdownLink>
                </Dropdown>-->

                <Dropdown :label="filters.status || 'Status'" icon btn-class="ms-2 btn-sm border rounded-pill"
                          :group="true">
                    <DropdownLink
                        v-for="status in statuses"
                        :key="status.id"
                        :class="{
                            'py-1 text-uppercase': true,
                            'text-success': status.status_name == filters.status
                        }"
                        @click="handleFilter('status', status.status_name)"
                    >{{ status.status_name }}
                    </DropdownLink>
                </Dropdown>

                <!-- <Dropdown label="Location" icon btn-class="ms-2 btn-sm border rounded-pill" :group="true">
                    <DropdownLink class="py-1 text-uppercase">Location 1</DropdownLink>
                    <DropdownLink class="py-1 text-uppercase">Location 2</DropdownLink>
                    <DropdownLink class="py-1 text-uppercase">Location 3</DropdownLink>
                    <DropdownLink class="py-1 text-uppercase">Location 4</DropdownLink>
                    <DropdownLink class="py-1 text-uppercase">Location 5</DropdownLink>
                </Dropdown> -->
            </div>

            <div>
                <input v-model="search"
                       class="form-control form-control-sm rounded-pill"
                       placeholder="Search request no, org name..."/>
            </div>
        </div>
    </div>
</template>
