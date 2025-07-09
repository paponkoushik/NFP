<script setup>
import {useCategoryComposable} from "@/composables/category/category.composable";
import CategoriesList from "./CategoriesList.vue";
import CategoryForm from "./CategoryForm.vue";

const props = defineProps({
    excludeFields     : {
        type    : Array,
        default : () => [],
        required: true
    },
    excludeFieldValues: {
        type    : Object,
        default : () => ({}),
        required: true
    },
});

const {
          store
      } = useCategoryComposable();
</script>

<template>
    <categories-list v-if="store.view === 'list'"></categories-list>
    <category-form v-else :exclude-fields="excludeFields"
                   :exclude-field-values="excludeFieldValues">
    </category-form>
</template>
