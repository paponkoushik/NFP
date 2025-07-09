<script setup>
import {
    WHERE_OPTIONS,
    SUBURBS,
    STATES,
    RADIUS_OPTIONS
} from "@/core/categories_data";
import {computed, nextTick, watch} from "vue";
import {useLocationStore} from "../../../../stores/LocationStore";
import {debounce} from "lodash";


const locationStore = useLocationStore();
const props = defineProps({
    values            : {
        type    : Object,
        required: true
    },
    excludeFieldValues: {
        type    : Object,
        required: true
    },
    customLabels      : {
        type    : Object,
        required: true
    }
});

// setter and getter for the location
const location = computed({
    // getter
    get() {
        return props.values.where;
    },
    // setter
    set(newValue) {
        props.values.where = newValue;
    }
})

const radiusChangeHandler = (radius) => {
    props.values.radius = radius;
}

/*watch(() => props.values.where, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        whereChangeHandler();
    }
});
const whereChangeHandler = () => {
    props.values.suburbs = [];
    props.values.states = [];
    props.values.radius_location = '';
    props.values.radius = '';
    props.values.local_area = '';
    props.values.location_id = '';
    props.values.lat = '';
    props.values.long = '';
}*/

const whereLabel = computed(() => {
    return Object.keys(props.customLabels).length
    && props.customLabels.hasOwnProperty('where')
    && props.customLabels.where !== ''
        ? props.customLabels.where : 'Where';
});


const radiusLocationSearchHandler = debounce(function (e) {
    const currentStr = e.target.value;
    console.log("currentStr", currentStr)

    props.values.radius_location = currentStr

    console.log("values.radius_location", props.values.radius_location)

    if (currentStr.length > 2) {
        locationStore.getRadiusLocationOptions(currentStr);
    }
}, 500)

const radiusLocationSelectHandler = (location) => {
    console.log('radiusLocationSelectHandler', location)
    props.values.radius_location = location.locality + ', ' + location.postcode;
    props.values.location_id = location.id;
    props.values.lat = location.lat;
    props.values.lng = location.long;
    locationStore.radiusLocationOptions = [];
};

nextTick(() => {
    $(document).click(function (event) {
        const target = $(event.target);
        if (!target.closest('.radius-location-options').length && $('.radius-location-options').is(':visible')) {
            locationStore.radiusLocationOptions = [];
        }
    });
});
</script>

<template>
    <div>
        <label class="form-label" for="Where">
            {{ whereLabel }}
        </label>
        <div class="col-12">
            <Select2 :settings="{allowClear: true}"
                     placeholder="-----" name="where"
                     v-model="location"
                     :options="WHERE_OPTIONS.filter(
                     (optionItem) =>
                         Object.keys(excludeFieldValues).length &&
                         excludeFieldValues.hasOwnProperty('where') &&
                         excludeFieldValues.where.length &&
                         !excludeFieldValues.where.includes(optionItem.id)
                     )"/>
        </div>

        <div v-show="location === 'local-area' || location === 'location'"
             class="col-12 mt-2">
            <input type="text"
                   placeholder="Enter local area i.e. suburb, post code, council area etc."
                   name="local_area"
                   class="form-control" v-model="values.local_area"/>
        </div>

        <div v-show="location === 'states'">
            <div class="col-12">
                <Select2 :settings="{multiple: true}" class="mt-2" placeholder="State"
                         v-model="values.states"
                         :options="STATES" name="states"/>
            </div>
        </div>

        <div v-show="location === 'suburbs'">
            <div class="col-12">
                <Select2 :settings="{multiple: true}" class="mt-2" placeholder="Suburbs"
                         v-model="values.suburbs" name="suburbs"
                         :options="SUBURBS"/>
            </div>
        </div>

        <div v-show="location === 'radius'" class="col-12 mt-2">
            <div class="input-group position-relative">
                <input type="text" aria-labelledby="location-label"
                       placeholder="Search suburb, postcode" autocomplete="off"
                       name="radius_location" autocapitalize="none" spellcheck="false"
                       class="form-control" v-model="values.radius_location"
                       @input="radiusLocationSearchHandler($event)" @focus="radiusLocationSearchHandler($event)"/>
                <input type="hidden" name="radius" :value="values.radius">
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        class="btn btn-outline-secondary border-input dropdown-toggle">
                    {{ values.radius ? '+' + values.radius + 'km' : '--Select Radius--' }}
                </button>
                <div class="dropdown radius-location-options" v-if="locationStore.radiusLocationOptions.length">
                    <ul class="dropdown-menu show"
                        style="position: absolute; inset: 0px auto auto -160px; margin: 0px; transform: translate(-385px, 42px);"
                        data-popper-placement="bottom-start">
                        <li v-for="(location, index) in locationStore.radiusLocationOptions" :key="index">
                            <button class="dropdown-item" @click.prevent="radiusLocationSelectHandler(location)">
                                {{ location.locality + ', ' + location.postcode }}
                            </button>
                        </li>
                    </ul>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow"
                    style="z-index: 99999; ">
                    <li v-for="(radiusOption, radiusKey) in RADIUS_OPTIONS"
                        :key="radiusKey">
                        <button type="button" class="dropdown-item"
                                @click.prevent="radiusChangeHandler(radiusOption)">
                            {{ '+' + radiusOption + 'km' }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
