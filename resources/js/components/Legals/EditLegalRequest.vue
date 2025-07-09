<script setup>
import { computed, ref } from 'vue';
import { legalRequestNote } from "@/core/endpoints";
import { useLegalRequestStore } from "@/stores/LegalRequestStore";
import useUtilsFunc from "@/composables/useUtilsFunc.js";
import Carousel from '@/components/Shared/Carousel.vue';
import ReadMore from '@/components/Shared/ReadMore.vue';

defineProps({
    showLegalModal: Boolean
});

const isCompletedDateValid = computed(() => {
  return legalRequest.completed_date && legalRequest.completed_date.length > 0;
});

let loading = ref(false);
let store = useLegalRequestStore();
const { handleFormError, destroy } = useUtilsFunc();

const formSchema = {
    status: 'required',
    note: 'required|min:10',

};

async function addNote(values, veeFormActions) {
    try {
        loading.value = true;
        const { data } = await storeLegalReqNote(values);
        setLegalReqNote(data);
        veeFormActions.resetForm();
        flash('Note added successfully.');
    } catch (error) {
        handleFormError(error.response, veeFormActions);
    }

    loading.value = false
}

async function storeLegalReqNote(values) {
    const formId = values?.id;
    const url = !formId ? legalRequestNote : `${legalRequestNote}/${formId}`;
    return await axios[formId ? 'put' : 'post'](url, {
        legal_req_id: store.editLegalRequest.id,
        stage: store.editLegalRequest.workflow_stage,
        ...values
    });
}

function setLegalReqNote(data) {
    store.editLegalRequest.legalNotes.unshift(data);
    store.editLegalRequest.workflow_status = data.step;
    store.editLegalRequest.status_badge = data.badgeClass;
    store.editLegalRequest.workflow_stage = data.stage;
}

async function handleNoteDestroy(data) {
    confirm("Do you want to delete this note?").then(isConfirm => {
        if (isConfirm) {
            loading.value = true

            destroy(`${legalRequestNote}/${data.id}`).then(isSuccess => {
                if (isSuccess) {
                    store.editLegalRequest.legalNotes.splice(store.editLegalRequest.legalNotes.indexOf(data), 1)
                    loading.value = false
                }
            });
        }
    });

}const completedDateValidationMessage = ref('');

const validateCompletedDateAndSubmit = (type) => {
  if (!legalRequest.value.completed_date || legalRequest.value.completed_date.trim() === '') {
    completedDateValidationMessage.value = 'Please enter a completed date.';
  } else {
    completedDateValidationMessage.value = ''; // Clear the validation message
    handleSubmit(type); // Continue with the submission logic
  }
};

async function handleSubmit(type) {
    const statuses = {
        completed: 'Completed',
        cancelled: 'Invalid',
        'on-hold': 'On Hold'
    };
    const selectedType = statuses[type].toLowerCase();

    const response = await confirm(`Do you want to ${ selectedType } this request?`, {
        icon: null,
        text: '',
        input: 'textarea',
        inputLabel: 'Enter Your Reason: ',
        inputPlaceholder: 'Type your reason here...',
        inputAttributes: {
            'aria-label': 'Type your reason here'
        },
        showLoaderOnConfirm: true,
        inputValidator: (value) => {
            if (!value) {
                return 'You need to write something!'
            }
        },
        preConfirm: (msg) => {
            loading.value = true;
            return storeLegalReqNote({
                stage: type == 'on-hold' ? 'in-progress' : 'done',
                status: statuses[type],
                note: msg,
                completed_date:  store.editLegalRequest.completed_date,
                billed_amount:  store.editLegalRequest.billed_amount,
            }).then(response => {
                flash(`Your request has been ${selectedType}.`);
                loading.value = false;
                return response;
            }).catch(error => {
                loading.value = false;
                const validateMsg = document.getElementById('swal2-validation-message');
                validateMsg.style.display = 'flex';
                validateMsg.innerHTML = `Request failed: ${error.response.data.message}`;
            });
        },
        allowOutsideClick: () => !loading.value,
        confirmButtonText: `Yes, ${selectedType} it!`
    });

    if(response) {
        setLegalReqNote(response.data);
        store.editLegalRequest.stage_name = response.data.stage;
        emitter.emit('closeModal');
        const key = type == 'cancelled' ? 'isCancelled' : (type == 'completed' ? 'isCompleted' : 'isOnHold');
        store.editLegalRequest[key] = true;
    }
}

const legalRequest = computed(() => store.editLegalRequest);
</script>

<template>
    <Modal
        :show="showLegalModal"
        @close="$emit('close', false)"
        maxWidth="xl"
        position="centered"
        title="Request Details"
    >
        <template #body v-if="legalRequest">
            <div class="row g-2">
                <div class="col-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="mb-1">{{  legalRequest.request.title  }}</h4>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-1 text-secondary">
                                            <small class="emp_post text-truncate text-muted">
                                                {{  legalRequest.request.type  }} POST
                                                <i class="bx bx-chevron-right mx-1"></i>
                                            </small>
                                        </p>
                                        <span :class="{
                                            'badge rounded-3': true,
                                            'bg-label-info': legalRequest.workflow_stage == 'new',
                                            'bg-label-warning': legalRequest.workflow_stage == 'in-progress',
                                            'bg-label-success': legalRequest.workflow_stage == 'done'
                                        }">
                                            {{ legalRequest.stage_name }}
                                        </span>
                                        <span class="mx-1">
                                            <i class="bx bx-chevron-right me-1"></i>
                                            <span :class="`badge rounded-pill bg-${ legalRequest.status_badge } text-capitalize`">
                                                {{ legalRequest.workflow_status }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <p class="fw-bold small mb-1 text-uppercase">
                                        Details:
                                    </p>

                                    <ReadMore :content="legalRequest.request_summary" />
                                </div>

                                <div v-if="legalRequest.request_from == 'post'" class="col-4 rounded-3 shadow-sm">
                                    <div class="px-2 py-3">
                                        <div class="d-flex flex-column mb-2">
                                            <span class="fw-semibold">Offered Amount: </span>
                                            <span class="d-flex justify-content-between">
                                                <span class="text-success">{{ legalRequest.offered_amount || 0 }}</span>
                                                <span><i class="bx bx-calendar-check"></i> {{ legalRequest.offered_date }}</span>
                                            </span>
                                        </div>

                                        <div class="d-flex flex-column mb-2">
                                            <span class="fw-semibold">Agreed Amount: </span>
                                            <span class="d-flex justify-content-between">
                                                <span class="text-info">{{ legalRequest.agreed_amount || 0 }}</span>
                                                <span><i class="bx bx-calendar-check"></i> {{ legalRequest.agreed_date }}</span>
                                            </span>
                                        </div>

                                        <span :class="`badge bg-label-${legalRequest.is_offer_accepted ? 'success' : 'danger' } rounded-pill`">
                                            <i :class="`bx ${legalRequest.is_offer_accepted ? 'bxs-check-circle' : 'bxs-x-circle'}`"></i>
                                            {{ legalRequest.is_offer_accepted ? 'Offer Accepted' : 'Not yet' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shadow-sm rounded p-3">
                        <!-- ./ Additional lawyer note tab -->
                        <div v-show="legalRequest?.isLawyerNoteVisible" class="mb-3">
                            <label class="form-label" for="lawyer-note">Additional Lawyer Note: </label>
                            <textarea
                                v-model="legalRequest.additional_lawyer_note"
                                class="form-control"
                                id="lawyer-note"
                                rows="3"
                                placeholder="Enter additional lawyer note"></textarea>
                        </div>

                        <!-- ./ Notes  -->
                        <p class="fw-bold mb-1 text-uppercase">
                            <i class="bx bx-pencil"></i> Notes:
                        </p>

                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <thead class="bg-label-secondary">
                                    <tr>
                                        <th class="w-px-150">Status</th>
                                        <th>Notes</th>
                                        <th class="w-px-100">Who/When</th>
                                        <th class="w-px-20"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <v-form as="tr" class="align-top" v-slot="{ handleSubmit }" :validation-schema="formSchema">
                                        <td>
                                            <v-field name="status" v-slot="{ field, errors }">
                                                <select v-bind="field"
                                                    :class="{
                                                        'form-control form-control-sm': true,
                                                        'border-danger': errors[0]
                                                    }">
                                                    <option value="">Select a Status</option>
                                                    <option
                                                        v-for="(stageName, stgIdx) in legalRequest.workflowStages"
                                                        :key="stgIdx"
                                                        :value="stageName">{{ stageName }}</option>
                                                </select>
                                            </v-field>

                                            <error-message class="fs-tiny text-danger" name="status"></error-message>
                                        </td>
                                        <td colspan="2">
                                            <v-field name="note" v-slot="{ field, errors }">
                                                <textarea
                                                    v-bind="field"
                                                    name="note"
                                                    :class="{
                                                        'form-control form-control-sm': true,
                                                        'border-danger': errors[0]
                                                    }"
                                                    cols="1"
                                                    rows="1"
                                                    placeholder="Enter Note"
                                                    v-autosize></textarea>
                                            </v-field>

                                            <error-message class="fs-tiny text-danger" name="note"></error-message>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-info rounded-pill px-1"
                                                title="Add New Note"
                                                @click="handleSubmit($event, addNote)"
                                                :disabled="loading"
                                                :class="$setLoadingSpinner(loading)"
                                            >
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </td>
                                    </v-form> -->

                                    <!-- render legal request notes -->
                                    <tr v-for="note in legalRequest.legalNotes" :key="note.id">
                                        <td>
                                            <span :class="`badge bg-label-${note.badgeClass}`">{{ note.step.replace('-', ' ') }}</span>
                                        </td>
                                        <td>{{  note.note  }}</td>
                                        <td>
                                            <span class="fs-tiny fw-semibold">{{  note.who?.full_name  }}</span>
                                            <span class="d-block mt-1 fs-tiny fw-semibold">
                                                {{  note.when  }}
                                                {{  note.time  }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <i @click.prevent="handleNoteDestroy(note)" class="bx bx-trash text-danger pointer"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div v-if="legalRequest.request_from == 'post'" class="card ms-4 mb-3">
                        <carousel class="carousel rounded">
                            <div class="carousel-cell h-px-200">
                                <img class="carousel-cell-image"
                                data-flickity-lazyload="/assets/img/backgrounds/1.jpg" alt="Image 1" />
                            </div>
                            <div class="carousel-cell h-px-200">
                                <img class="carousel-cell-image"
                                data-flickity-lazyload="/assets/img/backgrounds/2.jpg" alt="Image 2" />
                            </div>
                        </carousel>
                    </div>

                    <div class="card ms-4">
                        <p class=" card-title fw-bold mb-0 px-3 py-2 border-bottom">Contract Between: </p>
                        <div class="card-body p-3">
                            <div>
                                <p class="mb-0 fw-bold">{{ legalRequest.primaryOrg.title }}</p>
                                <p class="mb-0">{{ legalRequest.requestedUser.full_name }}</p>
                                <p class="my-1">&</p>
                                <p class="mb-0 fw-bold">{{ legalRequest.secondaryOrg.title }}</p>
                                <p class="mb-0">{{ legalRequest.secondaryOrg.owner?.full_name }}</p>
                            </div>

                            <hr class="my-2 mx-n3">

                            <div class="row g-2">
                                <div class="col-12">
                                    <label for="receive-date" class="form-label">Requested Date </label>
                                    <input type="text"
                                        label="Requested Date"
                                        class="form-control"
                                        id="receive-date"
                                        :value="legalRequest.requested_date"
                                        disabled
                                        readonly
                                        placeholder="Enter Requested Date" />
                                </div>

                                <div class="col-12">
                                    <label for="completed-date" class="form-label">Completed Date </label>
                                    <Flatpickr label="Completed Date"
                                        v-model="legalRequest.completed_date"
                                        format="Y-m-d"
                                        id="completed-date"
                                        placeholder="Enter Completed Date" />
                                         <!-- Validation error message for completed_date -->
      <div v-if="completedDateValidationMessage" class="text-danger">
        {{ completedDateValidationMessage }}
      </div>
                                        <!-- <div v-if="!isCompletedDateValid" class="text-danger">Please enter a valid completed date.</div> -->
                                </div>

                                <div class="col-12">
                                    <label for="amount-charged" class="form-label">Amount Charged</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">$</span>
                                        <input type="text"
                                            v-model="legalRequest.billed_amount"
                                            class="form-control"
                                            placeholder="1500"
                                            aria-label="Amount (to the nearest dollar)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ModalFooter class="justify-content-between px-0 py-2">
                <div>
                    <button class="btn btn-outline-danger ps-2"
                        :disabled="legalRequest.isCancelled"
                        @click="handleSubmit('cancelled')"
                    >
                        <i class="bx bx-x-circle me-1"></i> Cancel Request
                    </button>

                    <button class="btn btn-outline-warning ps-2 ms-2"
                        :disabled="legalRequest.isOnHold"
                        @click="handleSubmit('on-hold')"
                    >
                        <i class="bx bx-pause-circle me-1"></i> On Hold
                    </button>
                </div>

                <div>
                    <button class="btn btn-info ps-2 me-2"
                        @click="store.handleSubmit()"
                    >
                        <i class="bx bx-up-arrow-circle me-1"></i> Save & Exit
                    </button>

                    <button class="btn btn-success ps-2"
                        :disabled="legalRequest.isCompleted"
                        
                        @click="validateCompletedDateAndSubmit('completed')"
                    >
                        <i class="bx bx-check-circle me-1"></i> Complete
                    </button>
                </div>
            </ModalFooter>
        </template>
    </Modal>
</template>
