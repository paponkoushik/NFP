<script setup>
    import { useChatStore } from "@/stores/ChatStore";
    import SingleMessage from '@/components/Messages/_partials/SingleMessage';
    import { onMounted, ref } from "vue";
    import { useOrganisationStore } from "../../stores/OrganisationStore";

    const props = defineProps({
        directChat: {
            type: Boolean,
            default: false
        },
        organisation: {
            default: {}
        },
        listingId: {
            default: null
        }
    });

    const store = useChatStore();
    const org_store = useOrganisationStore();
    let isWonOrg = ref(true);

    const getPreviousMessage = async () => {
        if (props.listingId) {
            await store.getPreviousMessageForList(props.listingId)
        } else if (props.organisation) {
            await store.getPreviousMessageForOrganisation(props.organisation.id)
        }
    }

    onMounted(async () => {
        await org_store.getAuthOrg();
        checkOwn()
        setInterval(async () => {
            await getPreviousMessage()
        }, 100000)
        setInterval(() => {
            store.updateMessageSeenStatus()
        }, 30000)
        await getPreviousMessage()
    })

    const checkOwn = () => {
        isWonOrg.value = props.organisation.id === org_store.authOrg
    }

</script>

<template>
    <div class="card">
        <div class="card-body px-4" v-if="isWonOrg">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-md me-3">
                        <a href="/messages">
                            <span class="avatar-initial rounded-circle bg-label-secondary">
                            <i class="bx bx-comment-detail bx-sm"></i>
                        </span>
                        </a>

                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="/messages" class="text-body text-truncate">
                        <span class="fw-semibold fs-6">
                            Please check your messages.
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body px-4" v-else-if="! isWonOrg">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded-circle bg-label-secondary">
                            <i class="bx bx-building-house fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a :href="`${store.pushAbleUrl}`" target="_blank" class="text-body text-truncate">
                        <span class="fw-semibold fs-6">
                            {{ organisation?.org_name }}
                        </span>
                    </a>
                    <!-- <small class="text-muted">
                        Since 2022
                    </small> -->
                </div>
            </div>

            <hr class="my-4 mx-n4">
            <div class="card custom-card" id="chat2" v-if="store.messages.length > 0">
                <div class="card-body">
                    <single-message
                        v-for="message in store.messages"
                        :messages="message"
                    />
                </div>

            </div>


            <div class="form-group">
                <textarea cols="5" rows="5" class="form-control my-3" placeholder="Hi, I'm interested in Highly Profitable Short Term Rental Business... When can I inspect the property? Cheers." v-model="store.message"></textarea>

                <div class="d-grid gap-2 mb-3" v-if="listingId && store.showOfferField">
                    <a class="btn btn-primary col-12" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bx bx-credit-card me-md-1 me-0"></i> Make an offer
                    </a>
                    <div id="collapseExample" class="collapse" >
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input v-model="store.offer_amount" type="number" class="form-control" placeholder="Amount" aria-label="Amount" aria-describedby="button-addon2">
                        </div>
                    </div>
                </div>


                <div class="mb-3 form-check" v-if="store.showFromOrgAnonymousCheckBox">
                    <input type="checkbox"
                           class="form-check-input"
                           id="anonymousCheck"
                           v-model="store.anonymousDialogCheckBox"
                           :disabled="true"
                           >
                    <a class="" href="#" @click.prevent="store.openAnonymousDialog()">Send anonymously</a>
                </div>

                <div class="d-grid gap-2">
                    <button @click="store.sendNewMessage({organisation, listingId})" class="btn btn-instagram fw-semibold" type="button">
                        <i class="bx bx-message"></i>&nbsp; Send Message
                    </button>
                </div>
            </div>

            <Modal :show="store.openFromOrgAnonymousConfirmModal"
                   @close="store.openFromOrgAnonymousConfirmModal = false"
                   :title="'Anonymous Message'"
            >
                <template #body>
                    <div class="container">
                        <p class="text-center fw-semibold fs-6 display-3">Are you sure! You want to deselect anonymous message! </p>
                    </div>
                    <ModalFooter class="float-right pb-2">
                        <button type="button" class="btn  btn-primary" @click.prevent="store.closeAnonymousDialog(true)">
                            No
                        </button>
                        <button type="button" class="btn  btn-danger" @click.prevent="store.closeAnonymousDialog(false)">
                            Yes
                        </button>
                    </ModalFooter>
                </template>
            </Modal>
        </div>
    </div>
</template>
<style scoped>

.custom-card {
    display:block;
    width:100%;
    height:250px;
    overflow-y:scroll;
}
.card-body {
    padding-right: 0px;
    padding-left: 0px;
    padding-buttom: 0px;
}
#chat2 .form-control {
    border-color: transparent;
}

#chat2 .form-control:focus {
    border-color: transparent;
    box-shadow: inset 0px 0px 0px 1px transparent;
}

.divider:after,
.divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
}


#chat2::-webkit-scrollbar {
    width: 3px;
    background-color: #F5F5F5;
}


#chat2::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgba(102, 139, 244, 0.3);
}

#chat2::-webkit-scrollbar-thumb {
    background-color: slategrey;
    outline: 1px solid slategrey;
}
</style>
