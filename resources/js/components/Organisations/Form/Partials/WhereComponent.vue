<script setup>
import {
    WHERE_OPTIONS,
    SUBURBS,
    STATES,
    RADIUS_OPTIONS
} from "@/core/categories_data";
import {computed, nextTick, watch} from "vue";
import {debounce} from "lodash";
import {useLocationStore} from "../../../../stores/LocationStore";


const props = defineProps({
    item   : {
        type    : Object,
        required: true
    },
    type   : {
        type    : String,
        required: false
    },
    values : {
        type: Object
    },
    loopKey: {
        type   : Number,
        default: 0
    }
});

const locationStore = useLocationStore();

// setter and getter for the location
const location = computed({
    // getter
    get() {
        return props.type ? props.values[props.type] : props.values.location
    },
    // setter
    set(newValue) {
        if (props.type) {
            props.values[props.type] = newValue
        } else {
            props.values.location = newValue
        }
    }
})

const whereLabel = computed(() => {
    return Object.keys(props.item.custom_labels).length
    && props.item.custom_labels.hasOwnProperty('where')
    && props.item.custom_labels.where !== ''
        ? props.item.custom_labels.where : 'Where';
});

const formattedWhereOptions = computed(() => {
    // add existing filter then map
    return WHERE_OPTIONS.filter((optionItem) => {
        return props.item.hasOwnProperty('excludeFieldValues') &&
            Object.keys(props.item.excludeFieldValues).length &&
            props.item.excludeFieldValues.hasOwnProperty('where') &&
            !props.item.excludeFieldValues.where.includes(optionItem.id)
    }).map((optionItem) => {
        return {
            id  : optionItem.id,
            text: optionItem.text
        }
    });
});

const radiusSelectionHandler = (radius) => {
    if (props.type !== 'both') {
        props.values.radius = radius;
        props.values.location = 'radius';
        return;
    }
    props.values[props.type] = radius;
    props.values.radius = radius;
};

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
    props.values.long = location.long;
    locationStore.radiusLocationOptions = [];
};


// Reset the values when location/where changes
/*watch(() => location.value, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        whereResetHandler();
    }
});
const whereResetHandler = () => {
    props.values.suburbs = [];
    props.values.states = [];
    props.values.radius_location = '';
    props.values.radius = '';
    props.values.local_area = '';
    props.values.location_id = '';
    props.values.lat = '';
    props.values.long = '';
}*/

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
        <label class="form-label">
            {{ whereLabel }}
        </label>
        <div class="col-12">
            <Select2 :settings="{allowClear: true}"
                     placeholder="-----" name="where"
                     v-model="location"
                     :options="formattedWhereOptions"/>
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
                        style="position: absolute; inset: 0px auto auto -140px; margin: 0px; transform: translate(-385px, 42px);"
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
                                @click.prevent="radiusSelectionHandler(radiusOption)">
                            {{ '+' + radiusOption + 'km' }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
