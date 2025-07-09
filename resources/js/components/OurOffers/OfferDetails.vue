<script setup>
import {useOwnOrderComposable} from "../../composables/ownOrder/ownOrderComposable";

const {
    statusOfferClass,
    priceTypeOfferClass,
    store,
    fetch,
    pageChange
} = useOwnOrderComposable();
</script>
<template>
    <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> </h2>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td>
                                <div class="d-flex mb-2">
                                    <div class="flex-shrink-0">
                                        <img :src="store.ownOffer?.list?.images[0]" alt="" width="35" class="img-fluid">
                                    </div>
                                    <div class="flex-lg-grow-1 ms-3">
                                        <h6 class="small mb-0">
                                            <a href="#" class="text-reset">{{ store.ownOffer?.list?.title }}</a>
                                        </h6>
                                        <span class="small">{{ store.ownOffer?.list?.created_at_date || '--' }} {{ store.ownOffer?.list?.created_at_time || '--' }}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">Offered Amount</td>
                            <td class="text-end">${{ store.ownOffer?.offer_amount || '0'}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Type</td>
                            <td class="text-end">
                                <span class="text-capitalize badge rounded px-3"
                                      :class="statusOfferClass(store.ownOffer?.price_type)"
                                      v-text="store.ownOffer?.price_type">
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Status</td>
                            <td class="text-end">
                                <span class="text-capitalize badge rounded px-3"
                                      :class="statusOfferClass(store.ownOffer?.status)"
                                      v-text="store.ownOffer?.status">
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Offered Date</td>
                            <td class="text-end">{{ store.ownOffer?.offered_date || '--'}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Offered Time</td>
                            <td class="text-end">{{ store.ownOffer?.offered_time || '--'}}</td>
                        </tr>
                        <template v-if="store.ownOffer?.status == 'accept'">
                            <tr>
                                <td colspan="2">Offer Accepted Date</td>
                                <td class="text-end">{{ store.ownOffer?.offered_accepted_date || '--'}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Offer Accepted Time</td>
                                <td class="text-end">{{ store.ownOffer?.offered_accepted_time || '--'}}</td>
                            </tr>
                        </template>
                        <tr>
                            <td colspan="2">Offered Anonymously</td>
                            <td class="text-end">{{ store.ownOffer?.comms?.send_anonymously ? 'Yes' : 'No' }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h6">Notes</h3>
                    <p>{{ store.ownOffer?.note || 'No note for the offer' }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h6">Post Information</h3>
                    <strong>Title: </strong>
                    <span>{{ store.ownOffer?.list?.title }} </span>
                    <hr>
                    <address>
                        <strong>Address</strong>: {{ store.ownOffer?.list?.address || '----' }}<br>
                        <strong>City</strong>: {{ store.ownOffer?.list?.city || '----' }}<br>
                        <strong>State</strong>: {{ store.ownOffer?.list?.state || '----' }}<br>
                        <strong>PostCode</strong>: {{ store.ownOffer?.list?.postcode || '----' }}<br>
                    </address>
                </div>
            </div>
        </div>
    </div>
</template>
