<script setup>
import {useForm} from 'vee-validate';
import {ref, computed, provide, watch, onMounted} from 'vue';

const props = defineProps({
    validationSchema: {
        type    : Array,
        required: true,
    },
    formValues      : {
        type   : Object,
        default: {}
    },
    defaultStep     : {default: 0},
    maxStep         : {default: null},
    stepLabel       : {default: 'Submit'},
    loading         : {default: false},
    showSkipButton  : {default: false},
});

const emit = defineEmits(['submit', 'stepChange']);
const currentStepIdx = ref(0);

// Injects the starting step, child <form-steps> will use this to generate their ids
const stepCounter = ref(0);
provide('STEP_COUNTER', stepCounter);

// Inject the live ref of the current index to child components
// will be used to toggle each form-step visibility
provide('CURRENT_STEP_INDEX', currentStepIdx);

// if this is the last step
const isLastStep = computed(() => {
    if (props.maxStep) {
        return currentStepIdx.value === props.maxStep - 1;
    }

    return currentStepIdx.value === stepCounter.value - 1;
});

// If the `previous` button should appear
const hasPrevious = computed(() => {
    return currentStepIdx.value > 0;
});

// extracts the indivdual step schema
const currentSchema = computed(() => {
    return props.validationSchema[currentStepIdx.value];
});

watch(currentStepIdx, (newStepIdx) => emit('stepChange', newStepIdx));

const {values, handleSubmit} = useForm({
    // vee-validate will be aware of computed schema changes
    validationSchema: currentSchema,
    // turn this on so each step values won't get removed when you move back or to the next step
    keepValuesOnUnmount: true,

    initialValues: props.formValues,
});

// We are using the "submit" handler to progress to next steps
// and to submit the form if its the last step
const onSubmit = handleSubmit((values) => {
    setTimeout(() => window.scrollTo({top: 45, behavior: 'smooth'}), 500);

    if (!isLastStep.value) {
        currentStepIdx.value++;

        return;
    }

    // Let the parent know the form was filled across all steps
    emit('submit', values);
});

function goToPrev() {
    if (currentStepIdx.value === 0) {
        return;
    }

    currentStepIdx.value--;
}
// function skipAction() {
//
// }

onMounted(() => {
    // set the starting step
    currentStepIdx.value = props.defaultStep;
});
</script>

<template>
    <form @submit="onSubmit">
        <slot/>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <button class="btn btn-label-secondary btn-prev" type="button" :disabled="!hasPrevious" @click="goToPrev">
                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>

            <div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="p-2" v-if="showSkipButton && isLastStep">
                        <button type="button"
                                class="btn btn-next btn-primary"
                                :disabled="loading"
                                @click="$emit('skipAction')"
                        >
                            <span v-show="loading" class="spinner-border spinner-border-sm me-1"></span>
                            <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Skip</span>
                            <i class="bx bx bx-skip-next bx-sm me-sm-n2"></i>
                        </button>
                    </div>

                    <button type="submit"
                            :class="`btn btn-next btn-${isLastStep ? 'success' : 'primary'}`"
                            :disabled="loading"
                    >
                        <span v-show="loading" class="spinner-border spinner-border-sm me-1"></span>
                        <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">{{
                                isLastStep ? stepLabel : 'Next'
                            }}</span>
                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- <pre>{{ values }}</pre> -->
    </form>
</template>
