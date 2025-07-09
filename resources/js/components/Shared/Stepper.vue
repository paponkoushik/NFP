<script setup>
    import { computed, onMounted, reactive } from 'vue';

    const props = defineProps({
        items: {
            type: Array,
            default: () => []
        },
        initialStep: {
            type: Number,
            default: 1
        },
        separator: {
            type: Boolean,
            default: true
        },
        prevBtnClass: {
            type: String,
            default: 'btn btn-label-secondary'
        },
        nextBtnClass: {
            type: String,
            default: 'btn btn-primary'
        },
        submitBtnClass: {
            type: String,
            default: 'btn btn-success'
        }
    });

    const emit = defineEmits(['submit']);

    const state = reactive({
        steps: [],
        currentStep: 0,
        effect: "in-out-translate-fade",
    });

    const stepComponent = computed(() => props.items[state.currentStep].component);
    const lastStepIndex = computed(() => state.steps.length - 1);
    const isLastStep = computed(() => (lastStepIndex.value == state.currentStep) ? true : false);

    onMounted(() => {
        setStepInitialData()
    });

    function setStepInitialData() {
        state.steps = JSON.parse(JSON.stringify(props.items));
        state.currentStep = props.initialStep - 1;
        state.steps[state.currentStep].disabled = false;
    }

    function onNextOrSubmitClick(values, formActions) {
        if (isLastStep.value !== true) {
            state.effect = "in-out-translate-fade";
            state.steps[state.currentStep].valid = true;
            state.currentStep++;
            state.steps[state.currentStep].disabled = false;
            return;
        }

        setStepInitialData();
        emit('submit', values, formActions);
    }

    function onInvalidSubmit() {
        state.steps[state.currentStep].valid = false;
    }

    function handlePreviousClick() {
        if (state.currentStep > 0) {
            state.effect = "out-in-translate-fade";
            state.currentStep--;
        }
    }

    function stepClasses(stepIndex) {
        return {
            'active': state.currentStep == stepIndex,
            'success': state.steps[stepIndex]?.valid === true,
            'danger': state.steps[stepIndex]?.valid === false,
        }
    }

    function isDisabledStep(stepIndex) {
        return state.steps[stepIndex]?.disabled === false ? false : true;
    }

    function stepIconClasses(stepIndex) {
        const step = state.steps[stepIndex];

        if (state.currentStep !== stepIndex && step?.valid === true) {
            return `<i class="bx bx-check fs-2 text-white"></i>`;
        } else if (step?.valid === false) {
            return `<i class="bx bx-error-circle fs-3 text-white"></i>`;
        }
        return step?.icon ? `<i class="${step.icon}"></i>` : ++stepIndex;
    }
</script>

<template>
    <div class="bs-stepper">
        <div class="bs-stepper-header border-0">
            <template v-for="(step, index) in state.steps" :key="index">
                <div class="step" :class="stepClasses(index)">
                    <button type="button" class="step-trigger" :disabled="isDisabledStep(index)">
                        <span class="bs-stepper-circle" v-html="stepIconClasses(index)"></span>
                        <span class="bs-stepper-label mt-1" v-if="step.title">
                            <span class="bs-stepper-title">
                                {{ step.title }}
                            </span>
                            <span class="bs-stepper-subtitle" v-if="step.subTitle">
                                {{ step.subTitle }}
                            </span>
                        </span>
                    </button>
                </div>

                <div class="line" v-if="separator && lastStepIndex != index">
                    <i class="bx bx-chevron-right"></i>
                </div>
            </template>
        </div>

        <div class="bs-stepper-content">
            <div class="content active">
                <v-form keepValues v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
                    <transition :name="state.effect" mode="out-in">
                        <component :is="stepComponent" />
                    </transition>

                    <div class="col-12 d-flex justify-content-between">
                        <button type="button" 
                            :class="prevBtnClass"
                            :disabled="state.currentStep === 0"
                            @click="handlePreviousClick"
                        > 
                            <slot name="prevButton">
                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </slot>
                        </button>

                        <button type="button" 
                            :class="isLastStep ? submitBtnClass : nextBtnClass"
                            @click="handleSubmit($event, onNextOrSubmitClick)"
                        >
                            <slot v-if="isLastStep" name="submitButton">Submit</slot>

                            <slot v-else name="prevButton">
                                <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                            </slot>
                        </button>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
</template>