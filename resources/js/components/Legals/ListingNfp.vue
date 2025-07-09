<script setup>
import { ref, computed } from "vue";
import { useLegalRequestStore } from "@/stores/LegalRequestStore";
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import AssignLawyer from '@/components/Legals/AssignLawyer';
import EditLegalRequest from '@/components/Legals/EditLegalRequest';

const loading = ref(false);
const showModal = ref(false);
const selectedLegalReqId = ref(false);
const store = useLegalRequestStore();
const { pushUrlState } = useUrlFunc();

const canAssign = computed(() =>  store.can && store.can.assign);

const edit = data => {
    store.handleEditLegalRequest(data);
    showModal.value = true;
}

const pageChange = ({ page, limit }) => {
    pushUrlState({ page, limit })
    store.fill()
}
</script>

<template>
    <Datatable :class="$setLoadingSpinner(store.loading)" table-class="table-sm table-hover" thead-class="bg-label-secondary">
        <template #head>
            <Heading class="w-px-100">Request No</Heading>
            <Heading>Title</Heading>
            <Heading>Requested By</Heading>
            <Heading v-if="canAssign">Assign To</Heading>
            <!-- <Heading>Stage</Heading> -->
            <Heading class="text-center">Charged Amount</Heading>
            <Heading class="w-px-100">Status</Heading>
            <Heading class="text-end">Actions</Heading>
        </template>

        <template #body>
            <Row v-for="legalRequest in store.legalRequests" :key="legalRequest.id">
                <Cell>
                    {{ legalRequest.request_no }}
                    <p class="mb-0" v-show="legalRequest.is_archived">
                        <span class="badge rounded-3 bg-label-danger">
                            Archived
                        </span>
                    </p>
                </Cell>
                <Cell>
                    <div class="d-flex flex-column">
                        <a :href="legalRequest.request.url">
                            {{ legalRequest.request.title }}

                            <span :class="`badge rounded-pill fs-tiny ${legalRequest.isPostReq ? ' bg-label-facebook' : 'bg-label-slack'}`">
                                {{ legalRequest.request_from }}
                            </span>
                        </a>
                        <small class="emp_post text-truncate text-muted">
                            {{ legalRequest.request.type }}
                        </small>
                    </div>
                </Cell>
                <Cell>
                    <div class="d-flex flex-column">
                        <span class="text-truncate">{{ legalRequest.requestedUser.full_name }}</span>
                        <small class="text-muted">
                            <!-- <i class="bx bx-user align-baseline small"></i> John Doe  -->
                            <i class="bx bx-envelope small"></i> {{ legalRequest.requestedUser.email }}
                        </small>
                        <small class="text-muted">
                            <i class="bx bx-phone small"></i> {{ legalRequest.requestedUser.phone }}
                        </small>
                    </div>
                </Cell>
                <Cell v-if="canAssign">
                    <div v-if="legalRequest.assignedTo">
                        <p class="mb-1">
                            <span>
                                {{ legalRequest.assignedTo?.full_name }}
                            </span>
                        </p>
                        <span @click.stop="selectedLegalReqId = legalRequest.id" class="pointer badge badge-pill bg-label-info py-1"><i class="align-text-bottom bx bx-group"></i> Reassign</span>
                    </div>

                    <span v-else @click.stop="selectedLegalReqId = legalRequest.id" class="pointer d-flex align-items-center hover:text-sky-600">
                        <i class="bx bx-user-plus text-info me-1"></i> Assign
                    </span>
                </Cell>
                <!-- <Cell>
                    <div class="lh-1 me-3 mb-3 mb-sm-0">
                        <span :class="`badge badge-dot me-1 bg-${ legalRequest.status_badge }`"></span>
                        <span>{{ legalRequest.workflow_status }}</span>
                    </div>
                </Cell> -->
                <Cell class="text-center">
                    <span v-if="legalRequest.workflow_stage == 'done'" class="badge bg-label-slack fw-semibold rounded-pill">
                        {{ legalRequest.billed_amount }}
                    </span>
                    <span v-else>-</span>
                </Cell>
                <Cell>
                    <div class="lh-1 me-3 mb-2">
                        <span :class="`badge badge-dot me-1 bg-${ legalRequest.status_badge }`"></span>
                        <span>{{ legalRequest.workflow_status }}</span>
                    </div>
                    <span :class="{
                        'badge rounded-3': true,
                        'bg-label-info': legalRequest.workflow_stage == 'new',
                        'bg-label-warning': legalRequest.workflow_stage == 'in-progress',
                        'bg-label-success': legalRequest.workflow_stage == 'done'
                    }">
                        {{ legalRequest.stage_name }}
                    </span>
                </Cell>
                <Cell>
                    <Dropdown>
                        <DropdownLink icon="bx bxs-edit" @click="edit(legalRequest)">Edit</DropdownLink>
                        <DropdownLink icon="bx bx-data" @click="store.archived(legalRequest.id)">Archived</DropdownLink>
                        <!-- <DropdownLink icon="bx bx-trash">Delete</DropdownLink> -->
                    </Dropdown>
                </Cell>
            </Row>

            <EmptyRow v-if="store.legalRequests.length == 0" colspan="8" :msg="store.loading ? 'Loading...' : 'No legal requests yet!'" />
        </template>

        <template #footer>
            <Pagination class="float-end" :meta="store.meta" @changed="pageChange" />
        </template>
        <!-- Footer -->
    </Datatable>

    <!-- edit modal -->
    <EditLegalRequest @close="showModal = false" :showLegalModal="showModal" />

    <!-- assign modal -->
    <AssignLawyer v-if="canAssign" @close="selectedLegalReqId = false" :selectedLegalReqId="selectedLegalReqId" />
</template>
