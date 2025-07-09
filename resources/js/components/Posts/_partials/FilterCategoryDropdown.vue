<script setup>
import CategoryChildDropdown from "./CategoryChildDropdown.vue";
import {nextTick, reactive} from "vue";

const props = defineProps({
    categories     : {
        type   : Array,
        default: () => []
    },
    categoriesCount: {
        type   : Number,
        default: 0
    },
});

const emit = defineEmits(['select', 'closeDropdown'])

const data = reactive({
    openDropdown: false,
});

const toggleDropdown = () => {
    data.openDropdown = !data.openDropdown;
    // category.open = !category.open by loop and also if childs then also do same thing
};

const selectCategory = (category) => {
    console.log(category);
    emit('select', category);
    // category has childs then category.open = !category.open and also if childs then also do same thing
    if (category.childs && category.childs.length) {
        category.childs.forEach((child) => {
            child.open = category.open;
            emit('select', child)
            if (child.childs && child.childs.length) {
                child.childs.forEach((subChild) => {
                    subChild.open = category.open;
                    emit('select', subChild)
                });
            }
        });
    }
};

nextTick(() => {
    $(document).click(function (event) {
        const target = $(event.target);
        if (!target.closest('.post-category-filter-dropdown').length && $('.post-category-filter-dropdown').is(':visible')) {
            data.openDropdown = false;
        }
    });
});

</script>

<template>
    <div class="dropdown post-category-filter-dropdown">
        <button class="btn btn-white text-nowrap btn-sm rounded-pill
        dropdown-toggle w-px-150" type="button" @click="toggleDropdown">
            {{ categoriesCount }} Categories
        </button>
        <CategoryChildDropdown :categories="categories" :is-open="data.openDropdown" @child-select="selectCategory"/>
    </div>
</template>
