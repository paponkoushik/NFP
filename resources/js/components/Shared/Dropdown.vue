<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        group: {
            type: Boolean,
            default: false,
        },

        hover: {
            type: Boolean,
            default: false,
        },

        clickable: {
            type: Boolean,
            default: false,
        },

        icon: {
            type: String,
            default: "bx bx-dots-vertical-rounded",
        },

        label: {
            type: String,
        },

        btnClass: {
            type: String,
            default: ''
        }
    });

    const btnBindings = computed(() => {
        let obj = {};
        if(props.hover) {
            obj['data-trigger'] = 'hover';
        }

        if(props.clickable) {
            obj['data-bs-auto-close'] = props.clickable;
            obj['aria-expanded'] = 'false';
        }

        return obj;
    });
</script>

<template>
    <div :class="group ? 'btn-group' : 'd-inline-block float-end'">
        <button
            type="button"
            data-bs-toggle="dropdown"
            :class="{ 
                [`btn dropdown-toggle ${btnClass}`]: true,
                'btn-icon hide-arrow': !group 
            }"
            v-bind="btnBindings"
        >
            <i v-show="icon" :class="icon"></i>

            <span v-show="label" v-html="label"></span>
        </button>

        <div class="dropdown-menu" :class="{ 'dropdown-menu-end m-0': !group }">
            <slot></slot>
        </div>
    </div>
</template>
