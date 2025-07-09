<script setup>
import { ref, computed } from "vue";
import { debounce } from 'lodash';
import { useLegalRequestStore } from "@/stores/LegalRequestStore";

const props = defineProps(['selectedLegalReqId']);

let showLawyerList = ref(false);
let lawyers = ref([]);
let searchBox = ref(null);
let selectedUser = ref(null);
let loading = ref(false);
let store = useLegalRequestStore();

const selectedLegalReq = computed(() => {
    return props.selectedLegalReqId ? store.getLegalReqById(props.selectedLegalReqId) : null;
});

function handleVisibility() {
    showLawyerList.value = lawyers.value.length ? true : false;
}

const handleSearch = debounce( async (e) => {
    let inputVal = e.target.value
    
    if(inputVal.trim() == '') return

    loading.value = true
    showLawyerList.value = true
    let { data } = await axios.post('/usr/autocomplete', {search: inputVal, role: 'lawyer'})
    lawyers.value = data
    loading.value = false
}, 500);

function handleSelectedUser(user) {
    searchBox.value.value = user.name;
    showLawyerList.value = false;
    selectedUser.value = user;
}

async function assignLegalReq() {
    loading.value = true
    let { data } = await axios.post('/legal/assign-legal', {user_id: selectedUser.value.id, legal_req_id: props.selectedLegalReqId})
    let idx = store.legalRequests.findIndex(legal => legal.id == props.selectedLegalReqId);
    store.legalRequests[idx].assignedTo = {...data}
    loading.value = false
    searchBox.value.value = '';
    selectedUser.value = null;
}

function removeAssignLegalReq() {
    confirm('Do you want to delete?').then(isConfirm => {
        if(isConfirm) {
            loading.value = true
            axios.post('/legal/remove-legal', { legal_req_id: props.selectedLegalReqId }).then(res => {
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

            <div class="position-relative px-3 py-2">
                <div class="d-flex">
                    <input type="text" 
                        ref="searchBox"
                        placeholder="Search first name, last name or email..." 
                        class="form-control bg-label-secondary border-0 mr-3" 
                        @keyup="handleSearch" 
                        @focus="handleVisibility"
                    />
                    
                    <button 
                        @click="assignLegalReq" 
                        :disabled="selectedUser ? false : true" 
                        class="btn btn-dark ms-2"
                        :class="$setLoadingSpinner(loading)"
                    >
                        <i class="far fa-plus"></i>
                    </button>
                </div>

                <div class="row mt-3">
                    <div class="col-6 mb-2"
                        v-for="step in ['John Doe', 'Alex Billy', 'Smith Alex', 'Jaffery Way', 'Talowr Otwal']"
                        :key="step"
                    >
                        <div class="d-flex justify-content-between align-items-center border py-1 ps-3 pe-2 rounded-pill hover:shadow-sm">
                            <div class="d-flex flex-column">
                                <h6 class="mb-0 text-truncate">{{ step }}</h6>
                                <small class="text-truncate text-muted">iOS Developer</small>
                            </div>

                            <span class="btn btn-outline-linkedin btn-xs rounded-pill">
                                <i class="bx bx-user-plus fs-6"></i> Assign
                            </span>
                        </div>
                    </div>
                </div>

                <!-- autocomplete results -->
                <div v-show="showLawyerList" class="position-absolute bg-label-light zindex-1 shadow rounded w-50">
                    <p v-show="loading" class="p-2 mb-0 text-muted">Searching...</p>
                    
                    <ul v-if="lawyers.length" class="list-unstyled mb-0">
                        <li 
                            v-for="(user, idx) in lawyers" 
                            :key="idx" 
                            :class="{
                                'border-bottom px-2 py-1 hover:bg-slate-200': true
                            }"
                            @click.stop="handleSelectedUser(user)"
                        >
                            <a href="javascript:void(0)">
                                <p class="mb-0 fw-semibold">{{ user.name }}</p>
                                <p class="mb-0 text-muted">{{ user.email }}</p>
                            </a>
                        </li>
                    </ul>

                    <p v-else-if="!loading && lawyers.length == 0" class="p-2 mb-0 fw-bold text-warning">
                        No result found!
                    </p>
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