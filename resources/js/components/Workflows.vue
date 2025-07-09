<script setup>
import { ref, onMounted } from "vue";
import { workflow } from "@/core/endpoints";
import useUtilsFunc from "@/composables/useUtilsFunc.js";

defineProps({
    steps: Object
});

const loading = ref(false);
const workflows = ref([]);
const { handleFormError, destroy } = useUtilsFunc();

onMounted(() => fill());

async function fill() {
    loading.value = true;
    const { data } = await axios.get(`${workflow}/stage`);
    workflows.value = data;
    loading.value = false
}

function add(status) {
    workflows.value[status].unshift({
        editable: true,
        create: true,
        stage_code: status,
        status_name: ''
    })
}

function close(stage, stgIdx) {
    if(stage.create) {
        workflows.value[stage.stage_code].splice(stgIdx, 1);
    }
    stage.editable = false;
}

async function handleSubmit(values, formId, stgIdx) {
    try {
        loading.value = true
        const url = !formId ? workflow : `${workflow}/${formId}`;
        const { stage_code, status_name } = values;
        const { data } = await axios[formId ? 'put' : 'post'](url, { stage_code, status_name });
        
        if(!formId) {
            workflows.value[stage_code].push(data);
            flash('Workflow added successfully.');
        } else {
            flash(data.message);
        }

        close(values, stgIdx);
    } catch (error) {
        handleFormError(error.response);
    }

    loading.value = false
}

async function handleDestroy(data, stgIdx) {
    confirm("Do you want to delete this workflow stage?").then(isConfirm => {
        if (isConfirm) {
            loading.value = true

            destroy(`${workflow}/${data.id}`).then(isSuccess => {
                if (isSuccess) {
                    workflows.value[data.stage_code].splice(stgIdx, 1);
                    loading.value = false	
                }
            });
        }
    });
}
</script>

<template>
    <div :class="`row mx-2 ${$setLoadingSpinner(loading)}`">
        <div v-for="(step, idx) in steps" :key="idx" class="col-lg-3 col-md-4 col-sm-12">
            <h6 class="text-center mb-2">
                {{ step }}
                <a href="#" :class="{
                    'btn btn-xs rounded-pill px-1 py-0 ms-2 fs-tiny': true,
                    'btn-info': idx == 'new',
                    'btn-warning': idx == 'in-progress',
                    'btn-success': idx == 'done',
                }" @click.prevent="add(idx)">
                    <i class="bx bx-plus"></i>
                </a>
            </h6>
            
            <div>
                <ul :class="{
                    'wm__workflow-list rounded min-h-px-350 pb-3 list-unstyled': true,
                    'bg-label-info': idx == 'new',
                    'bg-label-warning': idx == 'in-progress',
                    'bg-label-success': idx == 'done',
                }">
                    <li v-for="(stage, stgIdx) in workflows[idx]" :key="`stg.${stgIdx}`" class="pe-2 pt-3">
                        <div>
                            <Transition name="slide-fade">
                                <div v-show="stage.editable" class="mb-1">
                                    <div class="d-flex jusitfy-content-start align-items-center">
                                        <i @click="close(stage, stgIdx)" class="bx bx-x text-muted hover:text-red-600 pointer"></i>
                                        <input v-model.trim="stage.status_name" class="form-control form-control-sm rounded-pill" placeholder="Stage Name">
                                        <div class="d-grid gap-2 mx-auto ms-2">
                                            <button @click="handleSubmit(stage, stage?.id, stgIdx)" :disabled="stage.status_name ? false : true" 
                                                type="button" 
                                                :class="`btn btn-dark bg-dark btn-sm rounded-pill shadow-none ${ $setLoadingSpinner(loading) }`"
                                            >
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </Transition>

                            <div v-if="!stage.editable" class="d-flex jusitfy-content-start align-items-center hover:visible-item-actions position-relative">
                                <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                <div class="align-items-center d-flex w-100 bg-label-light rounded-3 py-1">
                                    <span class="ps-2 text-dark w-100">{{ stage.status_name }}</span>

                                    <ul class="end-0 item-actions list-unstyled mx-1 pe-0 position-absolute">
                                        <li class="d-inline-block pointer me-1">
                                            <i @click="stage.editable = true" class="bx bx-edit text-muted hover:text-sky-600"></i> 
                                        </li>
                                        <li v-if="!stage.is_default" class="d-inline-block pointer">
                                            <i @click="handleDestroy(stage, stgIdx)" class="bx bx-trash text-muted hover:text-red-600"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>