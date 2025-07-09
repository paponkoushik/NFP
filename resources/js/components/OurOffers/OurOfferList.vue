<script setup>

    import CardHeader from "../Shared/CardHeader";
    import { useOwnOrderComposable } from "../../composables/ownOrder/ownOrderComposable";
    // import OfferDetails from "./OfferDetails";
    import Cell from "../Shared/table/Cell";

    const {
        statusOfferClass,
        priceTypeOfferClass,
        store,
        fetch,
        pageChange
    } = useOwnOrderComposable();

</script>

<template>
    <div class="col-12 pb-4">
        <div class="card">
            <Datatable table-class="less-padding">
                <CardHeader v-if="store.postId" title="Post Offers">
                </CardHeader>
                <CardHeader v-else title="Our Offers">
                </CardHeader>

                <template #head>
                    <Heading>Post</Heading>
                    <Heading>Amount</Heading>
                    <Heading>Date</Heading>
                    <Heading>Accepted</Heading>
                    <Heading>Anonymously</Heading>
                    <Heading :sortable="false" v-if="! store.postId">Action</Heading>
                </template>

                <template #body>
                    <template v-if="store.ownOffers.length > 0">
                        <transition-group name="fade">
                            <Row v-for="ownOffer in store.ownOffers" :key="ownOffer.id"
                                 :style="{'background-color': ! ownOffer.is_offer_seen ? '#F8F3EA' : ''}">
                                <Cell :style="{'border-left':
                                               ownOffer.status == 'accept' ? '3px solid  #71dd37'
                                               : ownOffer.status == 'pending' ? '3px solid  #ffab00' : '3px solid #ff3e1d'}">
<!--                                    <div class="row">-->
<!--                                        <div class="col-1">-->
<!--                                            <i class="bx bx-bullseye mt-2 mb-2"-->
<!--                                               style="font-size: 1.5em"-->
<!--                                               :style="{color:-->
<!--                                               ownOffer.status == 'accept' ? '#71dd37'-->
<!--                                               : ownOffer.status == 'pending' ? '#ffab00' : '#ff3e1d'}"-->
<!--                                            ></i>-->
<!--                                        </div>-->


                                        <div class="d-flex flex-column col-10">
                                            <a v-if="store.postId" :href="`/messages?org=${ownOffer.comms?.from_org_id}&list=${ownOffer.list?.id}`" target="_blank">
                                                <span class="emp_name text-truncate">{{ ownOffer.list?.title || '--' }}</span>
                                            </a>
                                            <a v-else :href="`/posts/${ownOffer.list?.id}`" target="_blank">
                                                <span class="emp_name text-truncate">{{ ownOffer.list?.title || '--' }}</span>
                                            </a>
                                            <span class="emp_post text-truncate text-muted">{{ ownOffer.offer_note || '--' }}</span>
                                        </div>
<!--                                    </div>-->
                                </Cell>
                                <Cell>
                                    <div class="text-muted lh-1">
                                        <span class="">${{ ownOffer.offer_amount }}</span>
                                    </div>
                                </Cell>
                                <Cell>
                                    <div class="d-flex flex-column">
                                        <span class="emp_name text-truncate">{{ ownOffer?.offered_date || '--'}}</span>
                                        <span class="emp_post text-truncate text-muted">{{ ownOffer?.offered_time || '--'}}</span>
                                    </div>
                                </Cell>
                                <Cell>
                                    <div class="d-flex flex-column">
                                        <span class="emp_name text-truncate">{{ ownOffer?.offered_accepted_date || '--'}}</span>
                                        <span class="emp_post text-truncate text-muted">{{ ownOffer?.offered_accepted_time || '--'}}</span>
                                    </div>
                                </Cell>
                                <Cell>
                                    <i v-if="ownOffer?.comms?.send_anonymously"
                                       class="bx bx-check"
                                       style="color: #71dd37;font-size: 2em"
                                    ></i>
                                    <i v-else class="bx bx-dots-horizontal-rounded" style="font-size: 2em"></i>
                                </Cell>
                                <Cell v-if="! store.postId">
                                    <a v-if="ownOffer.status == 'pending'"
                                       class="btn btn-sm btn-icon"
                                       @click.prevent="store.openCancelDialog(ownOffer.id)"
                                    >
                                        <i class="bx bx-x-circle"></i>
                                    </a>
                                </Cell>
                            </Row>
                        </transition-group>
                    </template>

                    <template v-else>
                        <Row>
                            <td colspan="7">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span
                                        class="font-medium py-8 text-cool-gray-400 text-xl">
                                      {{ store.loading ? 'Loading...' : 'No offers found!' }}
                                    </span>
                                </div>
                            </td>
                        </Row>
                    </template>
                </template>

                <template #footer>
                    <Pagination :meta="store.meta" @changed="pageChange"></Pagination>
                </template>
            </Datatable>

            <!-- Oder cancel modal -->
            <Modal :show="store.openOfferCancelModal"
                   @close="store.openOfferCancelModal = false"
                   :title="'Cancel Offer!'"
            >
                <template #body>
                    <div class="container">
                        <div class="mb-3">
                            <div class="text-center">
                                Would you like to cancel this offer?
                            </div>
                        </div>
                    </div>
                    <ModalFooter class="float-right pb-2">
                        <button type="button" class="btn btn-primary" @click.prevent="store.closeOfferCancelModal()">
                            No
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="store.cancelOffer()">
                            Yes
                        </button>
                    </ModalFooter>
                </template>
            </Modal>

        </div>
    </div>
</template>
