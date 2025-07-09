<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    isSelected: Boolean|Number,
    selectedValues: {
        default: []
    }
});

const selectedObjValues = computed(() => {
    let values = props.selectedValues;

    if (typeof values === "object"  && values !== null && !Array.isArray(values)) {
        return Object.keys(values)
            .map(key => key.split("-")
                .map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
            ).join(', ');
    } else if(typeof values === "string" && values !== null) {
        return values;
    }

    return false;
});

</script>

<template>
    <div :class="{
        'btn-group dropend d-flex': true,
        'bg-label-facebook': isSelected || selectedObjValues
    }">
        <button 
            type="button" 
            class="flex-grow-1 d-block text-truncate text-start btn px-3 list-group-item-action btn-parent border shadow-none"
        >
            {{ label }}
            
            <span v-if="selectedObjValues">({{ selectedObjValues }})</span>

            <span v-else-if="selectedValues?.length">({{ selectedValues.join(', ') }})</span>
        </button>

        <button
            type="button"
            class="btn btn-icon hide-arrow dropdown-toggle dropdown-toggle-split px-2 border list-group-item-action w-auto shadow-none"
            data-bs-toggle="dropdown"
            data-bs-auto-close="outside"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="bx bx-chevron-right fs-3"></i>
        </button>

        <ul class="dropdown-menu">
            <slot />
        </ul>
    </div>
</template>