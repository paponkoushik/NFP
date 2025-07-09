<script setup>
import { reactive, onMounted } from "vue";
import { useDashboardStore } from "@/stores/DashboardStore";
import { useUrlFunc } from "@/composables/useUrlFunc";
import { debounce } from "lodash";

const { pushUrlState, getUrlParams, buildURLQuery } = useUrlFunc();
const urlQueryParams = getUrlParams();

const store = useDashboardStore();

const filter = reactive({
  category: "",
  fromDate: "",
  toDate: "",
  query: "",
});

function handleFilterLawyer() {
  const params = _.pickBy(filter);
  pushUrlState(params);
  const queryString = buildURLQuery(params);
  store.fillFilter(queryString);
}

function clearFilter() {
  filter.category = "";
  filter.fromDate = "";
  filter.toDate = "";
  filter.query = "";
  pushUrlState();
  store.fillFilter();
}
</script>


<template>
  <div class="col-12">
    <div
      class="d-flex justify-content-between mb-3 p-2 rounded-3"
    >
      <div class="d-flex">
        <select
          class="form-select form-select-sm rounded-pill ms-2"
          v-model="filter.category"
          @change="handleFilterLawyer"
        >
          <option value="" selected disabled>---</option>
          <option value="this_week">This Week</option>
          <option value="last_week">Last Week</option>
          <option value="this_month">Last Month</option>
          <option value="this_quarter">This quarter</option>
          <option value="last_quarter">Last quarter</option>
          <option value="this_year">This Year</option>
          <option value="last_year">Last Year</option>
        </select>

        <flatpickr
          class="form-control form-control-sm rounded-pill ms-2"
          placeholder="Form Date"
          format="Y-m-d"
          readonly
          v-model="filter.fromDate"
          @input="handleFilterLawyer"
        ></flatpickr>

        <flatpickr
          class="form-control form-control-sm rounded-pill ms-2"
          placeholder="To Date"
          format="Y-m-d"
          readonly
          v-model="filter.toDate"
          @input="handleFilterLawyer"
        ></flatpickr>

        <button
          type="button"
          class="btn btn-warning text-nowrap btn-sm rounded-pill ms-2"
          @click="clearFilter()"
        >
          Clear Filter
        </button>
      </div>
    </div>
  </div>
</template>

