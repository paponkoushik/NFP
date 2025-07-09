<script setup>
import {usePostStore} from "@/stores/PostStore";
import CustomCheckbox from '@/components/Shared/CustomCheckbox.vue';

const {offerTypes} = usePostStore();
const store = usePostStore();
const {form} = store;

const typeChangeHandler = (type) => {
    form.type = type;
}
</script>

<template>
    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <!-- <h5 class="mb-1">Post Types</h5>
            <small>Pick the post type</small> -->
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <h6>Select post type</h6>

                <div class="row flex-column">
                    <CustomCheckbox
                        v-for="(type, idx) in offerTypes"
                        :key="`type-${idx}`"
                        :label="type"
                        :value="idx"
                        class="col-md mb-1"
                        :classes="`${type === form.type ? 'checked' : ''}`"
                        @click="typeChangeHandler(idx)"
                        name="type"
                    />
                    <ErrorMessage class="invalid-feedback d-block" name="type"/>
                </div>
            </div>
        </div>
    </div>
</template>
