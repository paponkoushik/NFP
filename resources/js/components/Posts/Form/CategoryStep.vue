<script setup>
import {ref, computed, onMounted} from 'vue';
import {usePostStore} from "@/stores/PostStore";
import CustomCheckbox from '@/components/Shared/CustomCheckbox';
import GroupDropdown from '@/components/Organisations/Form/GroupDropdown';

const store = usePostStore();
const {categories, form} = store;
const selectedCategory = ref(form.category ?? {});
const selectedSubCategory = ref({});

const subCategories = computed(() => {
    return selectedCategory.value?.childs;
});

function handleSelectCategory(category) {
    form.category = category;
    selectedCategory.value = category;
}

function handleSelectSubCategory(subCategory, subChildCategory = null) {
    form.sub_category = subCategory;
    form.sub_child_category = subChildCategory;

    selectedSubCategory.value = subCategory;
}

const toggle = (selectedObj, c1Name = null, pName = null) => {
    const {name: value} = selectedObj;

    console.log('selectedObj -> ', selectedObj);

    toggleSelectedItem('category_id', selectedObj.id);

    if (selectedObj.exclude_fields) {
        store.categoryExcludeFields = [...selectedObj.exclude_fields];
    }
    if (selectedObj.exclude_field_values) {
        store.categoryExcludeFieldValues = {...selectedObj.exclude_field_values};
    }

    if (selectedObj.custom_label) {
        store.categoryCustomLabels = {...selectedObj.custom_label};
    }

    if (pName) {
        if (value === form.sub_child_category) {
            toggleSelectedItem('sub_child_category', null);
            toggleSelectedItem('sub_category', null);
            toggleSelectedItem('category', null);
            return;
        }
        toggleSelectedItem('sub_child_category', value);
        toggleSelectedItem('sub_category', c1Name);
        toggleSelectedItem('category_name', pName);
    } else if (c1Name) {
        if (value === form.sub_category) {
            toggleSelectedItem('sub_child_category', null);
            toggleSelectedItem('sub_category', null);
            toggleSelectedItem('category_name', null);
            return;
        }
        toggleSelectedItem('sub_child_category', null);
        toggleSelectedItem('sub_category', value);
        toggleSelectedItem('category_name', c1Name);
    } else {
        if (value === form.category) {
            console.log('value -> three -> ', value)
            toggleSelectedItem('sub_child_category', null);
            toggleSelectedItem('sub_category', null);
            toggleSelectedItem('category_name', null);
            return;
        }
        toggleSelectedItem('sub_child_category', null);
        toggleSelectedItem('sub_category', null);
        toggleSelectedItem('category_name', value);
    }
};

const toggleSelectedItem = (key, value) => {
    form[key] = value;
};

onMounted(() => {
    if (store?.currentPost && store?.currentPost?.category) {
        toggle(store?.currentPost?.category, store?.currentPost?.category?.parent?.name, store?.currentPost?.category?.parent?.parent?.name);
    }
});
</script>

<template>
    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <h5 class="mb-1">Select Category</h5>
        </div>

        <div class="row gap-md-0 gap-3">
            <div v-for="(category, idx) in categories" :key="idx" class="col-md-6 mb-2">
                <GroupDropdown
                    v-if="category.childs.length"
                    class="col-10"
                    :label="category.name"
                    :is-selected="false"
                    :selected-values="form.category_name == category.name ? form.sub_category : null"
                >
                    <li v-for="(child1, c1Idx) in category.childs" :key="`sub-${c1Idx}`">
                        <GroupDropdown
                            v-if="child1.childs.length"
                            class="mb-2 mx-2"
                            :label="child1.name"
                            :is-selected="false"
                            :selected-values="form.sub_category == child1.name ? form.sub_child_category : null"
                        >
                            <li v-for="(child2, c2Idx) in child1.childs" :key="`sub-${c2Idx}`">
                                <a class="dropdown-item" href="javascript:void(0);">
                                    <CustomCheckbox
                                        @change="toggle(child2, child1.name, category.name)"
                                        class="col-md-4"
                                        as="checkbox"
                                        type="radio"
                                        name="category"
                                        :label="child2.name"
                                        :value="child2.id"/>
                                </a>
                            </li>
                        </GroupDropdown>

                        <a v-else class="dropdown-item" href="javascript:void(0);">
                            <CustomCheckbox
                                @change="toggle(child1, category.name)"
                                class="col-md-4"
                                as="checkbox"
                                type="radio"
                                name="category"
                                :label="child1.name"
                                :value="child1.id"/>
                        </a>
                    </li>
                </GroupDropdown>

                <CustomCheckbox v-else
                                @click="toggle(category)"
                                class="btn-group dropend d-flex col-10"
                                classes="flex-grow-1 d-block text-truncate text-start btn px-3 list-group-item-action border shadow-none"
                                as="button"
                                name="category"
                                :label="category.name"
                                :value="category.id"/>
            </div>

            <ErrorMessage class="invalid-feedback d-block" name="category"/>
        </div>
    </div>
</template>
