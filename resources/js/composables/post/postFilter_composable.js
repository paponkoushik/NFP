import {reactive, onMounted, watch, computed, nextTick, onBeforeMount} from "vue";
import {usePostStore} from "@/stores/PostStore";
import {useLocationStore} from "@/stores/LocationStore";
import {useCategoryStore} from "@/stores/CategoryStore";
import {debounce} from "lodash";
import {RADIUS_OPTIONS, WHERE_OPTIONS} from "../../core/categories_data";
import {useUrlFunc} from "../../composables/useUrlFunc";
import {useOrganisationStore} from "../../stores/OrganisationStore";
import useUtilsFunc from "../useUtilsFunc";

export function usePostFilterComposable() {
    const store = usePostStore();
    const locationStore = useLocationStore();
    const categoryStore = useCategoryStore();
    const orgStore = useOrganisationStore();
    const {pushUrlState, getUrlParams} = useUrlFunc();
    const locationOptions = WHERE_OPTIONS;
    const {areAllPropertiesNullOrEmpty} = useUtilsFunc();

    const filter = reactive({
        location_id    : '',
        status         : '',
        category       : '',
        categories     : [],
        location       : '',
        fromDate       : '',
        toDate         : '',
        query          : '',
        local_area     : '',
        states         : [],
        radius         : '',
        radius_location: '',
        suburbs        : '',
    });

    const setDefaultUrlParams = () => {
        const urlParams = getUrlParams();
        if (urlParams && Object.keys(urlParams).length) {
            filter.status = urlParams.status || '';
            filter.category = urlParams.category || '';
            filter.categories = urlParams.categories ? urlParams.categories.split(',').map(Number) : [];
            categoryStore.filterSelectedCategoryIds = urlParams.categories ? urlParams.categories.split(',').map(Number) : [];
            filter.location = urlParams.location || '';
            filter.fromDate = urlParams.fromDate || '';
            filter.toDate = urlParams.toDate || '';
            filter.query = urlParams.query || '';
            filter.local_area = urlParams.local_area || '';
            filter.states = urlParams.states ? urlParams.states.split(',') : [];
            filter.radius = urlParams.radius || '';
            filter.radius_location = urlParams.radius_location || '';
            filter.suburbs = urlParams.suburbs || '';
            filter.location_id = urlParams.location_id || '';
        }

        setCategoryOpenByFilterCategories();
    };

    const handleSearch = debounce(function (e) {
        const currentStr = e.target.value;
        const prevStr = filter.query;

        if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
            return;
        }
        filter.query = currentStr

        handleFilterPost()
    }, 500)

    const handleFilterPost = debounce(function () {
        const params = _.pickBy(filter);
        console.log("params", params)
        console.log("areAllPropertiesNullOrEmpty(params)", areAllPropertiesNullOrEmpty(params));
        if (areAllPropertiesNullOrEmpty(params)) {
            clearFilter();
            return;
        }
        pushUrlState(params)
        store.fill(params);
    }, 500);

    const locationChangeHandler = () => {
        if (filter.location === 'local-area' || filter.location === 'location') {
            filter.local_area = '';
        } else if (filter.location === 'states') {
            filter.states = [];
        } else if (filter.location === 'suburbs') {
            filter.suburbs = '';
        } else if (filter.location === 'radius') {
            filter.radius_location = '';
            filter.radius = '5';
            filter.location_id = '';
        } else {
            handleFilterPost();
        }
    };

    const formattedRadius = RADIUS_OPTIONS.map((radius) => {
        return {
            id  : radius,
            text: '+ ' + radius + 'km',
        };
    });

// watch on states
    watch(() => filter.states, (newVal, oldVal) => {
        if (newVal.length > 0) {
            filter.location = 'states';
            handleFilterPost();
        }
    });

// watch on filter.radius_location
    /*watch(() => filter.radius_location, (newVal, oldVal) => {
        if (newVal.length > 0) {
            filter.location = 'radius';
            handleFilterPost();
        }
    });*/

    const formattedFilterStates = computed(() => {
        // comma separated string of states
        return filter.states.join(', ');
    });

    function clearFilter() {
        filter.status = ''
        filter.category = ''
        filter.categories = []
        filter.location = ''
        filter.fromDate = ''
        filter.toDate = ''
        filter.query = ''
        filter.local_area = ''
        filter.states = []
        filter.radius = '5'
        filter.radius_location = ''
        filter.suburbs = ''
        filter.location_id = ''

        pushUrlState()
        store.fill();
        setCategoryOpenByFilterCategories();
    }

    const radiusSelectionHandler = () => {
        if (!filter.radius_location || filter.radius_location === '' || filter.radius_location === null) {
            filter.radius_location = '';
            filter.location_id = '';
            filter.radius = '';
            //focus on radius_location input
            nextTick(() => {
                document.querySelector('input[name="radius_location"]').focus();
            });
            return;
        }
        handleFilterPost();
    };

    const setCategoryOpenByFilterCategories = () => {
        nextTick(() => {
            categoryStore.categoryOptions.forEach((category) => {
                if (filter.categories.includes(Number(category.id))) {
                    category.open = true;
                } else {
                    category.open = false;
                }
                if (category.childs && category.childs.length) {
                    category.childs.forEach((child) => {
                        if (filter.categories.includes(Number(child.id))) {
                            child.open = true;
                        } else {
                            child.open = false;
                        }
                        if (child.childs && child.childs.length) {
                            child.childs.forEach((subChild) => {
                                if (filter.categories.includes(Number(subChild.id))) {
                                    subChild.open = true;
                                } else {
                                    subChild.open = false;
                                }
                            });
                        }
                    });
                }
            });
        })
    }

    const categorySelectHandler = (category) => {
        console.log("category", category);
        // check category_id is already in filter.categories
        if (category.open) {
            filter.categories.push(category.id);
            categoryStore.filterSelectedCategoryIds.push(category.id);
        } else {
            filter.categories = filter.categories.filter((cat) => cat !== category.id);
            categoryStore.filterSelectedCategoryIds = categoryStore.filterSelectedCategoryIds.filter((cat) => cat !== category.id);
        }
        handleFilterPost();
    };


// lodash debounce
    const radiusLocationSearchHandler = debounce(function (e) {
        const currentStr = e.target.value;
        console.log("currentStr", currentStr)

        filter.radius_location = currentStr

        console.log("filter.radius_location", filter.radius_location)

        if (currentStr.length > 2) {
            locationStore.getRadiusLocationOptions(currentStr);
        }
    }, 500)

    const radiusLocationSelectHandler = (location) => {
        console.log('radiusLocationSelectHandler', location)
        filter.radius_location = location.postcode;
        filter.location_id = location.id;
        locationStore.radiusLocationOptions = [];
        handleFilterPost();
    };

    onMounted(async () => {
        locationStore.getAllLocations();
        await categoryStore.getAllCategories();
        await orgStore.getStates();
        setDefaultUrlParams();
    });

    nextTick(() => {
        $(document).click(function (event) {
            const target = $(event.target);
            if (!target.closest('.radius-location-options').length && $('.radius-location-options').is(':visible')) {
                locationStore.radiusLocationOptions = [];
            }
        });
    });


    return {
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
        handleFilterPost,
    };
}
