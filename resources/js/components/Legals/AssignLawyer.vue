<script setup>
import { ref, computed, onMounted } from "vue";
import { useLegalRequestStore } from "@/stores/LegalRequestStore";
import { usrAutocomplete, legalAssignLawyer, legalRemoveLawyer } from "@/core/endpoints";

const props = defineProps(['selectedLegalReqId']);

const loading = ref(false);
const lawyers = ref([]);
const store = useLegalRequestStore();
const search = ref('');

onMounted(() => fill());

const selectedLegalReq = computed(() => {
    return props.selectedLegalReqId ? store.getLegalReqById(props.selectedLegalReqId) : null;
});

const filteredLawyers = computed(() => {
    let query = search.value.toLowerCase();

    return lawyers.value.filter(usr => {
        return usr.name.toLowerCase().includes(query) || usr.email.toLowerCase().includes(query);
    });
});

async function fill() {
    loading.value = true
    let { data } = await axios.post(usrAutocomplete, { role: 'lawyer', autocomplete: false })
    lawyers.value = data
    loading.value = false
}

async function assignLegalReq(usr) {
    confirm('Do you want to assign this lawyer?', {confirmButtonText: 'Yes, assign it!'}).then(isConfirm => {
        if(isConfirm) {
            loading.value = true
            let { data } = axios.post(legalAssignLawyer, {
                user_id: usr.id, 
                legal_req_id: props.selectedLegalReqId
            }).then(({ data }) => {
                let idx = store.legalRequests.findIndex(legal => legal.id == props.selectedLegalReqId);
                store.legalRequests[idx].assignedTo = {...data}
                loading.value = false
            })
        }
    });
}

function removeAssignLegalReq() {
    confirm('Do you want to delete?').then(isConfirm => {
        if(isConfirm) {
            loading.value = true
            axios.post(legalRemoveLawyer, { legal_req_id: props.selectedLegalReqId }).then(res => {
                let idx = store.legalRequests.findIndex(legal => legal.id == props.selectedLegalReqId);
                store.legalRequests[idx].assignedTo = null
                loading.value = false

                flash(res.data.message)
            });
        }
    });
}
</script>

<template>    
    <Modal 
        :show="selectedLegalReqId ? true : false"
        @close="$emit('close', false)"
        position="centered"
    >
        <template #body>           
            <div class="text-center">
                <h3 class="mb-2">Assign Lawyer</h3>
                <p>Share post with a legal team</p>
            </div>

            <div :class="$setLoadingSpinner(loading)" class="position-relative px-3 py-2">
                <div class="input-group input-group-merge rounded-pill">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" v-model="search" class="form-control" placeholder="Search...">
                </div>

                <div class="row mt-3">
                    <div class="col-6 mb-2"
                        v-for="usr in filteredLawyers"
                        :key="usr.email"
                    >
                        <div class="d-flex justify-content-between align-items-center border py-1 ps-3 pe-2 rounded-pill hover:shadow-sm position-relative">
                            <div class="d-flex flex-column">
                                <h6 class="mb-0 text-truncate">{{ usr.name }}</h6>
                                <small class="text-truncate text-muted w-75">{{ usr.email }}</small>
                            </div>

                            <span 
                                v-if="selectedLegalReq && selectedLegalReq.assignedTo?.id !== usr.id"
                                @click="assignLegalReq(usr)" 
                                class="btn btn-outline-linkedin btn-xs rounded-pill me-2 position-absolute end-0"
                            >
                                <i class="bx bx-user-plus fs-6"></i> Assign
                            </span>
                            <span v-else class="me-2 position-absolute end-0">
                                <i class="bx bx-check-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="mb-0 mt-2 mx-n4" />

            <!-- assigned lawyer -->
            <div v-if="selectedLegalReq && selectedLegalReq.assignedTo" class="list-group mx-n4">
                <li class="list-group-item list-group-item-action border-0 d-flex fw-normal justify-content-between align-items-center">
                    <span class="fw-semibold">{{ selectedLegalReq.assignedTo?.full_name }}</span> 

                    <span @click="removeAssignLegalReq" class="text-secondary pointer hover:text-red-600">
                        <i class="far fa-trash-alt"></i>
                    </span>
                </li>
            </div>

            <div v-else class="text-center fw-bold p-3 text-info">No lawyer has been assigned yet!</div>
        </template>
    </Modal>   
</template>