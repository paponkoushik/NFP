import { reactive, onMounted, watch, computed, nextTick } from "vue";
import { useLocationStore } from "@/stores/LocationStore";
import { debounce } from "lodash";
import { RADIUS_OPTIONS, WHERE_OPTIONS } from "../../core/categories_data";
import { useUrlFunc } from "../../composables/useUrlFunc";
import { useOrganisationStore } from "../../stores/OrganisationStore";

export function useOrgFilterComposable() {
    const locationStore = useLocationStore();
    const orgStore = useOrganisationStore();
    const {pushUrlState, getUrlParams} = useUrlFunc();
    const locationOptions = WHERE_OPTIONS;

    const filter = reactive({
        org_location_id    : '',
        org_status         : '',
        org_location       : '',
        org_fromDate       : '',
        org_toDate         : '',
        org_query          : '',
        org_local_area     : '',
        org_states         : [],
        org_radius         : '',
        org_radius_location: '',
        org_suburbs        : '',
    });

    const setDefaultUrlParams = () => {
        const urlParams = getUrlParams();
        if (urlParams && Object.keys(urlParams).length) {
            filter.org_status = urlParams.org_status || '';
            filter.org_location = urlParams.org_location || '';
            filter.org_fromDate = urlParams.org_fromDate || '';
            filter.org_toDate = urlParams.org_toDate || '';
            filter.org_query = urlParams.org_query || '';
            filter.org_local_area = urlParams.org_local_area || '';
            filter.org_states = urlParams.org_states ? urlParams.states.split(',') : [];
            filter.org_radius = urlParams.org_radius || '';
            filter.org_radius_location = urlParams.org_radius_location || '';
            filter.org_suburbs = urlParams.org_suburbs || '';
            filter.org_location_id = urlParams.org_location_id || '';
        }

    };

    const handleSearch = debounce(function (e) {
        const currentStr = e.target.value;
        const prevStr = filter.org_query;

        if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
            return;
        }
        filter.org_query = currentStr

        handleFilterOrg()
    }, 500)

    const handleFilterOrg = () => {
        setTimeout(() => {
            const params = _.pickBy(filter);
            // console.log("params", params)
            pushUrlState(params)
            orgStore.getOrgList(params);
        }, 200)
    }

    const locationChangeHandler = () => {
        if (filter.org_location === 'local-area' || filter.org_location === 'location') {
            filter.org_local_area = '';
        } else if (filter.org_location === 'states') {
            filter.org_states = [];
        } else if (filter.org_location === 'suburbs') {
            filter.org_suburbs = '';
        } else if (filter.org_location === 'radius') {
            filter.org_radius_location = '';
            filter.org_radius = '5';
            filter.org_location_id = '';
        } else {
            handleFilterOrg();
        }
    };

    const formattedRadius = RADIUS_OPTIONS.map((radius) => {
        return {
            id  : radius,
            text: '+ ' + radius + 'km',
        };
    });

// watch on states
    watch(() => filter.org_states, (newVal, oldVal) => {
        if (newVal.length > 0) {
            filter.org_location = 'states';
            handleFilterOrg();
        }
    });

// watch on filter.radius_location
    /*watch(() => filter.radius_location, (newVal, oldVal) => {
        if (newVal.length > 0) {
            filter.location = 'radius';
            handleFilterOrg();
        }
    });*/

    const formattedFilterStates = computed(() => {
        // comma separated string of states
        return filter.org_states.join(', ');
    });

    function clearFilter() {
        filter.org_status = ''
        filter.org_location = ''
        filter.org_fromDate = ''
        filter.org_toDate = ''
        filter.org_query = ''
        filter.org_local_area = ''
        filter.org_states = []
        filter.org_radius = '5'
        filter.org_radius_location = ''
        filter.org_suburbs = ''
        filter.org_location_id = ''

        pushUrlState()
        orgStore.getOrgList();
    }

    const radiusSelectionHandler = () => {
        if (!filter.org_radius_location || filter.org_radius_location === '' || filter.org_radius_location === null) {
            filter.org_radius_location = '';
            filter.org_location_id = '';
            filter.org_radius = '';

            nextTick(() => {
                document.querySelector('input[name="org_radius_location"]').focus();
            });
            return;
        }
        handleFilterOrg();
    };


// lodash debounce
    const radiusLocationSearchHandler = debounce(function (e) {
        const currentStr = e.target.value;

        filter.org_radius_location = currentStr

        if (currentStr.length > 2) {
            locationStore.getRadiusLocationOptions(currentStr);
        }
    }, 500)

    const radiusLocationSelectHandler = (location) => {
        filter.org_radius_location = location.postcode;
        filter.org_location_id = location.id;
        locationStore.radiusLocationOptions = [];
        handleFilterOrg();
    };

    onMounted(async () => {
        locationStore.getAllLocations();
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
        locationStore,
        orgStore,
        locationChangeHandler,
        clearFilter,
        radiusSelectionHandler,
        radiusLocationSearchHandler,
        radiusLocationSelectHandler,
        handleFilterOrg,
    };
}
