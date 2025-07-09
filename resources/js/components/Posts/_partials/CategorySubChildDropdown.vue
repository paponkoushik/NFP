<script setup>
const props = defineProps({
    categories: {
        type   : Array,
        default: () => []
    },
    isOpen    : {
        type   : Boolean,
        default: false,
    },
});

const emit = defineEmits(['sub-select'])

const toggleDropdown = (category) => {
    category.open = !category.open;
    emit('sub-select', category);
};

const handleSubSelect = (category) => {
    console.log("categorySubchild", category);
    emit('sub-select', category);
};
</script>
<template>
    <ul class="list-unstyled ms-3 background-gray" v-if="isOpen" :class="{'d-block': isOpen}">
        <template v-for="category in categories" :key="category.id">
            <li v-if="category.childs && category.childs.length">
                <label class="dropdown-item">
                    <input type="checkbox" :value="category.id" @click="toggleDropdown(category)"
                           class="form-check-input form-check-success" :checked="category.open">
                    <span class="ms-2">{{ category.name }}</span>
                </label>
                <!-- Recursive call to the same component -->
                <CategorySubChildDropdown :categories="category.childs" :isOpen="category.open"
                                          @sub-select="handleSubSelect"/>
            </li>
            <li v-else>
                <label class="dropdown-item">
                    <input type="checkbox" :value="category.id" @click="toggleDropdown(category)"
                           class="form-check-input form-check-success" :checked="category.open">
                    <span class="ms-2">{{ category.name }}</span>
                </label>
            </li>

        </template>
    </ul>
</template>

<style scoped>
.background-gray {
    background-color: #f7f7f7;
}
</style>
