<script setup>
import FilterCategoryDropdown from "./_partials/FilterCategoryDropdown.vue";
import {usePostFilterComposable} from "../../composables/post/postFilter_composable";

const {
          filter,
          locationOptions,
          formattedRadius,
          formattedFilterStates,
          handleSearch,
          store,
          locationStore,
          categoryStore,
          orgStore,
          locationChangeHandler,
          clearFilter,
          radiusSelectionHandler,
          setCategoryOpenByFilterCategories,
          categorySelectHandler,
          radiusLocationSearchHandler,
          radiusLocationSelectHandler,
          handleFilterPost
      } = usePostFilterComposable();

</script>

<template>
    <div class="col-12">
        <div class="bg-label-secondary d-flex justify-content-between mb-3 p-2 rounded-3">
            <div class="d-flex">
                <filter-category-dropdown :categories="categoryStore.categoryOptions"
                                          @select="categorySelectHandler" :categories-count="filter.categories.length"/>

                <select class="form-select form-select-sm rounded-pill ms-2"
                        v-model="filter.location"
                        @change="locationChangeHandler"
                >
                    <option value="" selected disabled>Location</option>
                    <option v-for="location in locationOptions" :key="location.id" :value="location.id">
                        {{ location.text }}
                    </option>
                </select>

                <input type="text" v-if="filter.location === 'local-area' || filter.location === 'location'"
                       class="form-control form-control-sm rounded-pill ms-2"
                       placeholder="Enter local area i.e. suburb, post code, council area etc."
                       v-model="filter.local_area"/>

                <div class="dropdown" v-if="filter.location === 'states'">
                    <button class="btn btn-white text-nowrap btn-sm rounded-pill ms-2 dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{ formattedFilterStates || 'States' }}
                    </button>
                    <ul class="dropdown-menu">
                        <li v-for="state in orgStore.states" :key="state">
                            <label class="dropdown-item">
                                <input type="checkbox" :value="state.state" v-model="filter.states"
                                       class="form-check-input form-check-success">
                                <span class="ms-2">{{ state.state }}</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <select class="form-select form-select-sm rounded-pill ms-2"
                        v-model="filter.suburbs" v-if="filter.location === 'suburbs'"
                        @change="handleFilterPost">
                    <option value="" selected disabled>Suburb</option>
                    <option v-for="suburb in SUBURBS" :key="suburb" :value="suburb">
                        {{ suburb }}
                    </option>
                </select>

                <input type="text" aria-labelledby="location-label" v-if="filter.location === 'radius'"
                       placeholder="Search suburb, postcode" autocomplete="off"
                       name="radius_location" autocapitalize="none" spellcheck="false"
                       @input="radiusLocationSearchHandler($event)" @focus="radiusLocationSearchHandler($event)"
                       class="form-control form-control-sm rounded-pill ms-2" v-model="filter.radius_location"/>

                <select class="form-select form-select-sm rounded-pill ms-2" name="radius"
                        v-model="filter.radius" v-if="filter.location === 'radius'"
                        @change="radiusSelectionHandler">
                    <option v-for="radius in formattedRadius" :key="radius.id" :value="radius.id">
                        {{ radius.text }}
                    </option>
                </select>

                <div class="dropdown radius-location-options" v-if="locationStore.radiusLocationOptions.length">
                    <ul class="dropdown-menu show"
                        style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-290px, 30px);"
                        data-popper-placement="bottom-start">
                        <li v-for="(location, index) in locationStore.radiusLocationOptions" :key="index">
                            <button class="dropdown-item" @click.prevent="radiusLocationSelectHandler(location)">
                                {{ location.locality + ', ' + location.postcode }}
                            </button>
                        </li>
                    </ul>
                </div>

                <flatpickr
                    class="form-control form-control-sm rounded-pill ms-2"
                    placeholder="Form Date"
                    format="Y-m-d"
                    readonly
                    v-model="filter.fromDate"
                    @change="handleFilterPost"
                ></flatpickr>

                <flatpickr
                    class="form-control form-control-sm rounded-pill ms-2"
                    placeholder="To Date"
                    format="Y-m-d"
                    readonly
                    v-model="filter.toDate"
                    @change="handleFilterPost"
                ></flatpickr>

                <button type="button"
                        class="btn btn-warning text-nowrap btn-sm rounded-pill ms-2"
                        @click="clearFilter()">
                    Clear Filter
                </button>
            </div>

            <div>
                <input type="text"
                       class="form-control form-control-sm rounded-pill"
                       placeholder="Search..."
                       :value="filter.query"
                       @keyup="handleSearch"/>
            </div>
        </div>
    </div>
</template>
