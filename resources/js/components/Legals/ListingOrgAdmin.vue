<script setup>
import { ref } from "vue";
import { useLegalRequestStore } from "@/stores/LegalRequestStore";
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import ReadMore from '@/components/Shared/ReadMore.vue';

const store = useLegalRequestStore();
const { pushUrlState } = useUrlFunc();

const pageChange = ({ page, limit }) => {
    pushUrlState({ page, limit })
    store.fill()
}
</script>

<template>
    <div class="row mx-1 mt-1">
        <div class="col-md-6 col-lg-4 mb-4" v-for="legalRequest in store.legalRequests" :key="legalRequest.id">
            <div class="card h-100 org-item hover:transition-up">
                <div class="card-header flex-grow-0 pb-3">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-3">
                            <img :src="legalRequest?.request?.img" alt="NFP" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                            <div class="me-2">
                                <a :href="legalRequest?.request?.url">
                                    <h5 class="mb-0">
                                        {{ legalRequest?.request?.title }}
                                    </h5>
                                </a>
                                <small class="text-muted">Since {{ legalRequest.requested_date }}</small>
                            </div>
                            <a href="#" class="text-muted">
                                <span :class="`badge rounded-pill fs-tiny ${legalRequest.isPostReq ? ' bg-label-facebook' : 'bg-label-slack'}`">
                                    {{ legalRequest.request_from }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- <p class="mb-1">
                        <i class="bx bx-map"></i>
                        17 Gould Road Herston QLD AU
                    </p> -->

                    <p>
                        <!-- <i class="bx bx-message ms-1" title="Your Legal Support Message"></i> -->
                        <ReadMore :clamp="2" :min="50" :content="legalRequest.request_summary" />
                    </p>

                    <!-- <div class="d-flex align-items-center justify-content-between gap-2">
                        <div>
                            <span class="badge bg-label-secondary">
                                120
                            </span>
                        </div>

                        <div class="card-actions w-px-50 text-end">
                            <a href="javascript:;" class="text-muted">
                                22 <i class="bx bx-message ms-1"></i>
                            </a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <Pagination class="float-end" :meta="store.meta" @changed="pageChange" />
        </div>

        <div class="col-md-12" v-if="store.legalRequests.length == 0">
            <NotFound :message="store.loading ? 'Loading...' : 'No legal requests yet!'" />
        </div>
    </div>
</template>
