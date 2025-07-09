<script setup>
import { ref, onMounted, computed, watch, onBeforeUnmount } from 'vue';

const props = defineProps({
    modelValue: String,
    noCalendar: {
        default: false
    },
    dateTime: {
        default: false
    },
    step: {
        default: 5
    },
    format: {
        type: String,
        default: 'd/m/Y'
    },
    timeFormat: {
        type: String,
        default: 'H:i'
    },
    minDate: {
        default: ''
    },
    maxDate: {
        default: null
    },
    config: {
        type: Object,
        default() {
            return {}
        },
    }
});

const emit = defineEmits(['update:modelValue']);

let pickr = ref(null);
let el = ref(null);

onMounted(() => {
    pickr = flatpickr(el.value, defaultConfig)
});

const defaultConfig = computed(() => {
    let initConfig = {};
    if(!props.noCalendar) {
        initConfig = {
            ...props.config,
            enableTime: props.dateTime,
            dateFormat: (props.dateTime) ? `${props.format} ${props.timeFormat}` : props.format,
            minDate: props.minDate,
            maxDate: props.maxDate,
            onOpen: [
                function(selectedDates, dateStr, instance){
                    instance.set('minDate', props.minDate)
                    instance.set('maxDate', props.maxDate)
                }
            ],
            onChange: function(selectedDates, dateStr, instance) {
                if(dateStr) {
                    emit('update:modelValue', dateStr)
                }
            },
        };
    } else if(props.noCalendar) { // if only time picker need
        initConfig = {
            ...props.config,
            enableTime: props.noCalendar,
            noCalendar: true,
            dateFormat: props.timeFormat,
        };
    }

    if(props.dateTime || props.noCalendar) {
        initConfig['minuteIncrement'] = props.step
    }

    return initConfig
});

watch(
    () => props.minDate, 
    (newVal, oldVal) => {
        console.log(newVal, oldVal)
    }
);

onBeforeUnmount(() => pickr.destroy());

// export default {
//     data() {
//         return {
//             pickr: null
//         }
//     },

//     mounted() {
//         this.pickr = flatpickr(this.$el, this.defaultConfig)
//     },

//     watch: {
//         minDate(val, oldVal) {
//             if(val > this.value) {
//                 this.update('')
//             }
//         }
//     },

//     computed: {
//         defaultConfig() {
//             const self = this
//             let initConfig = {};
//             if(!props.noCalendar) {
//                 initConfig = {
//                     ...props.config,
//                     enableTime: props.dateTime,
//                     dateFormat: (props.dateTime) ? `${props.format} ${this.timeFormat}` : props.format,
//                     minDate: props.minDate,
//                     maxDate: props.maxDate,
//                     onOpen: [
//                         function(selectedDates, dateStr, instance){
//                             instance.set('minDate', props.minDate)
//                             instance.set('maxDate', props.maxDate)
//                         }
//                     ],
//                     onChange: function(selectedDates, dateStr, instance) {
//                         if(dateStr) {
//                             props.$emit('update:modelValue', dateStr)
//                         }
//                     },
//                 };
//             } else if(props.noCalendar) { // if only time picker need
//                 initConfig = {
//                     ...this.config,
//                     enableTime: props.noCalendar,
//                     noCalendar: true,
//                     dateFormat: this.timeFormat,
//                 };
//             }

//             if(props.dateTime || props.noCalendar) {
//                 initConfig['minuteIncrement'] = props.step
//             }

//             return initConfig
//         }
//     },

//     beforeUnmount() {
//         this.pickr.flatpickr("destroy");
//     }
// }
</script>

<template>
	<input ref="el"
        type="text"
		class="form-control flatpickr flatpickr-input" 
		:value="modelValue" 
		@input="$emit('update:modelValue', $event.target.value)"
		autocomplete="off">
</template>