<script setup>
import {onBeforeMount, ref} from "vue";
import {useOrgSettingsStore} from "@/stores/OrgSettingsStore";
import FormWizard from "@/components/Shared/FormWizard";
import FormStep from "@/components/Shared/FormStep";
import OrgDetailsStep from "@/components/Organisations/Form/OrgDetailsStep.vue";
import ServiceAreaStep from "@/components/Organisations/Form/ServiceAreaStep.vue";
import OurInterestsStep from "@/components/Organisations/Form/OurInterestsStep.vue";
import OurPrefereancesStep from "@/components/Organisations/Form/OurPrefereancesStep.vue";

const props = defineProps(['organisation', 'serviceAreas', 'interests', 'preferences', 'demoInterests']);

const components = [OrgDetailsStep, ServiceAreaStep, OurInterestsStep, OurPrefereancesStep];

const schemas = [
    {
        org_name: props.organisation.client_type === 'nfp' ? 'required' : '',
        abn     : props.organisation.client_type === 'nfp' ? 'required' : '',
        acn     : '',
        address : '',
        summary : 'required',
        details : 'required',
        website : '',
        city    : '',
        state   : '',
        postcode: ''
    },
    {
        service_areas: 'required',
    },
    {
        our_interests: 'required'
    },
    {}
];

const currentStepIdx = ref(0);

const tabs = ref([
    {
        tabId   : 0,
        title   : props.organisation.client_type === 'nfp' ? 'Organisation' : 'Individual',
        subTitle: props.organisation.client_type === 'nfp' ? 'Organisations Details' : 'Your Details',
        icon    : 'bx-home-alt'
    },
    {
        tabId   : 1,
        title   : 'Service Areas',
        subTitle: 'The sevice areas you work',
        icon    : 'bx-user'
    },
    {
        tabId   : 2,
        title   : props.organisation.client_type === 'nfp' ? 'Our Interests' : 'Your Interests',
        subTitle: 'Your primary objective',
        icon    : 'bx-detail'
    },
    {
        tabId   : 3,
        title   : props.organisation.client_type === 'nfp' ? 'Our Preferences' : 'Your Preferences',
        subTitle: 'Choose your preferences',
        icon    : 'bx-detail'
    },
]);

const store = useOrgSettingsStore();

/**
 * Handle change steps
 */
const handleSteps = (stepId) => currentStepIdx.value = stepId;

/**
 * Only Called when the last step is submitted
 */
const onSubmit = (formData) => store.handleSubmit(formData);
const skipSettings = () => {
    // console.log('allll')
    window.location.replace('/posts')
};

onBeforeMount(() => {
    store.fill({...props});
    currentStepIdx.value = store.organisation.defaultStep;
});
</script>

<template>
    <div class="col-lg-10 mx-auto">
        <div class="mx-auto">
            <div class="bs-stepper shadow-none">
                <div class="bs-stepper-header border-bottom-0">
                    <div
                        v-for="tab in tabs"
                        :key="tab.tabId"
                        :class="{
                            'step d-flex align-items-center': true,
                            'active': tab.tabId === currentStepIdx
                        }">
                        <button type="button" class="step-trigger">
                            <span :class="{
                                'bs-stepper-circle': true,
                                'bg-label-success': tab.tabId < currentStepIdx
                            }">
                                <i :class="`bx ${tab.tabId < currentStepIdx ? 'bx-check fw-bold fs-3' : tab.icon}`"></i>
                            </span>
                            <span :class="{
                                'bs-stepper-label mt-1': true,
                                'text-success': tab.tabId < currentStepIdx
                            }">
                                <span class="bs-stepper-title">{{ tab.title }}</span>
                                <span
                                    :class="`bs-stepper-subtitle ${tab.tabId < currentStepIdx ? 'text-success' : ''}`">{{
                                        tab.subTitle
                                    }}</span>
                            </span>
                        </button>

                        <div class="line" v-show="tab.tabId < 3">
                            <i :class="`bx bx-chevron-right ${tab.tabId < currentStepIdx ? 'text-success': ''}`"></i>
                        </div>
                    </div>
                </div>

                <div class="bs-stepper-content pt-1">
                    <FormWizard
                        :form-values="organisation"
                        :showSkipButton="true"
                        @skipAction="skipSettings"
                        :validation-schema="schemas"
                        @stepChange="handleSteps"
                        @submit="onSubmit"
                        :default-step="currentStepIdx"
                    >
                        <FormStep v-for="(component, cIdx) in components" :key="cIdx">
                            <transition name="fade" mode="out-in">
                                <KeepAlive>
                                    <component :is="component"/>
                                </KeepAlive>
                            </transition>
                        </FormStep>
                    </FormWizard>
                </div>
            </div>
        </div>
    </div>
</template>
