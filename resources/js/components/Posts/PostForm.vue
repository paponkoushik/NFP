<script setup>
import {onBeforeMount, ref} from "vue";
import {usePostStore} from "@/stores/PostStore";
import FormWizard from "@/components/Shared/FormWizard";
import FormStep from "@/components/Shared/FormStep";
import CategoryStep from "@/components/Posts/Form/CategoryStep";
import TypeStep from "@/components/Posts/Form/TypeStep";
import DetailsStep from "@/components/Posts/Form/DetailsStep";
import PictureStep from "@/components/Posts/Form/PictureStep";

const props = defineProps(['post', 'types', 'locations', 'categories']);

const components = [TypeStep, CategoryStep, DetailsStep, PictureStep];

const currentStepIdx = ref(0);

const tabs = ref([
    {
        tabId   : 0,
        title   : 'Post Type',
        subTitle: 'Choose a post type',
        icon    : 'bx bx-duplicate fs-4'
    },
    {
        tabId   : 1,
        title   : 'Post Category',
        subTitle: 'Choose a post category',
        icon    : 'bx bx-file fs-4'
    },
    {
        tabId   : 2,
        title   : 'Post Details',
        subTitle: 'Fill your post details',
        icon    : 'bx bx-box fs-4'
    },
    {
        tabId   : 3,
        title   : 'Pictures',
        subTitle: 'For best results',
        icon    : 'bx bx-images fs-4'
    }
]);

const store = usePostStore();


const schemas = [
    {
        type: 'required',
    },
    {
        category       : 'required',
        sub_category_id: '',
    },
    {
        title       : 'required',
        description : '',
        is_anonymous: '',
        address     : '',
        city        : '',
        state       : '',
        postcode    : '',
    },
    {
        images: '',
    }
];

/**
 * Handle change steps
 */
function handleSteps(stepId) {
    currentStepIdx.value = stepId;
}

/**
 * Only Called when the last step is submitted
 */
function onSubmit(formData) {
    store.submit(formData);
}

onBeforeMount(() => {
    store.fillProps({...props});
});
</script>

<template>
    <div class="row">
        <CardHeader class="d-flex justify-content-between" title="Posts">
            <template #heading>
                <h4 class="fw-bold mb-0">
                    <span class="text-muted fw-light">{{ post?.id ? 'Edit' : 'Create' }} </span> Post
                </h4>
            </template>

            <a href="/my-posts" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> BACK
            </a>
        </CardHeader>

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
                            :form-values="store.form"
                            :validation-schema="schemas"
                            @stepChange="handleSteps"
                            @submit="onSubmit"
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
    </div>
</template>
