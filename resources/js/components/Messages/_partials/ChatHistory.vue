<script setup>
    import LegalSupportModal from '@/components/Legals/LegalSupportModal';
    import { useChatStore } from "@/stores/ChatStore";
    import useUtilsFunc from "@/composables/useUtilsFunc.js";
    import MessageContent from '@/components/Messages/_partials/MessageContent';
    import { onMounted, ref } from 'vue'

    const { textAvatarBgClass } = useUtilsFunc();
    const store = useChatStore();

    const chat = ref(null);

    onMounted(() => {
        setInterval(() => {
            store.fill()
        }, 100000)
    })

    const showLegal = () => {
        return ! _.isEmpty(store.activeChat)
    }
</script>

<template>
    <div class="col app-chat-history">
        <div class="chat-history-wrapper position-relative">
            <div class="chat-history-header border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex overflow-hidden align-items-center">
                        <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                        <!--<div class="flex-shrink-0 avatar">
                            <img src="/assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right" />
                            <i class="bx bx-x bx-sm cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"></i>
                        </div>-->
                        <div class="flex-shrink-0 avatar" :class="store.activeChat?.organisation?.user?.is_online ? 'avatar-online' : 'avatar-offline'">
                            <img v-if="!store.activeChat.is_anonymous && store.activeChat?.organisation?.user?.avatar"
                                :src="store.activeChat?.organisation?.user?.avatar"
                                alt="Avatar"
                                class="rounded-circle"
                            />
                            <span v-else class="avatar-initial rounded-circle" :class="textAvatarBgClass()">
                                {{ store.activeChat.is_anonymous ? store.activeChat?.organisation?.anonymous_short_name : store.activeChat?.organisation?.user?.short_name }}
                            </span>
                        </div>

                        <div class="chat-contact-info flex-grow-1 ms-3">
                            <h6 class="m-0">
                                {{ store.activeChat.is_anonymous ? store.activeChat?.organisation?.anonymous_name : store.activeChat?.organisation?.user?.full_name }}
                            </h6>
                            <small class="user-status text-muted">
                                {{ store.activeChat.is_anonymous ? "The user wants to communicate as an anonymous user" : store.activeChat?.organisation?.name }}
                            </small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <LegalSupportModal
                            from="org"
                            id="12"
                            :data="{title: 'From Chat', summary: 'Chat history'}"
                        >
                            <template #supportIcon>
                                <a href="#"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#legalSupportOffcanvas"
                                    aria-controls="legalSupportOffcanvas"
                                >
                                    <i v-if="showLegal()"
                                        class="bx bx-support cursor-pointer d-sm-block d-none me-3 fs-4"
                                        data-bs-toggle="tooltip"
                                        data-bs-offset="0,4"
                                        title="Legal Support"
                                        alt="Legal Support"></i>
                                </a>
                            </template>
                        </LegalSupportModal>

<!--                        <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>-->
<!--                        <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i>-->
<!--                        <div class="dropdown">-->
<!--                            <i class="bx bx-dots-vertical-rounded cursor-pointer fs-4" id="chat-header-actions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> </i>-->
<!--                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">-->
<!--                                <a class="dropdown-item" href="javascript:void(0);">View Contact</a>-->
<!--                                <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>-->
<!--                                <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>-->
<!--                                <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>-->
<!--                                <a class="dropdown-item" href="javascript:void(0);">Report</a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>

            <!-- offer bar -->
            <div class="alert alert-primary position-absolute rounded-0 w-100 zindex-3" v-if="store.activeChat.is_offered && store.activeChat.offer_status !== 'accept'">
                <div class="d-flex justify-content-between align-items-center">
<!--                    offer on Feb 04, 2023,-->
                    <div class="d-flex align-items-center">Amount: ${{ store.activeChat.offered_amount }} </div>
                    <div class="d-flex align-items-center" v-if="! store.activeChat.own_offer">
                        <button type="button" class="btn btn-info btn-sm" @click.prevent="store.offerAcceptOrReject('accept')">Accept</button> &nbsp;
                        <button type="button" class="btn btn-light btn-sm" @click.prevent="store.offerAcceptOrReject('reject')">Reject</button>
                        <!--<i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>-->
                    </div>
                </div>
            </div>

            <div class="chat-history-body custom-chat" >
                <ul class="list-unstyled chat-history mb-0" ref="chat">
<!--                    {{store.messages}}-->
<!--                    :key="message.id"-->
                    <MessageContent
                        v-for="message in store.messages"
                        :messages="message"
                    />
                </ul>
            </div>

            <!-- Chat message form -->
            <div class="chat-history-footer">
                <form class="form-send-message d-flex justify-content-between align-items-center">
                    <input
                        class="form-control message-input border-0 me-3 shadow-none"
                        placeholder="Type your message here..."
                        v-model="store.message"
                        :readonly="! showLegal()"
                    />
                    <div class="message-actions d-flex align-items-center">
                        <!--<i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i>
                <label for="attach-doc" class="form-label mb-0">
                <i class="bx bx-paperclip bx-sm cursor-pointer mx-3"></i>
                <input type="file" id="attach-doc" hidden />
                </label>-->
                        <button type="button" class="btn btn-info d-flex send-msg-btn"
                                v-if="! store.activeChat.is_offered && store.activeChat.own_offer"
                                @click.prevent="store.openOfferDialog()"
                        >
                            <i class="bx bx-credit-card me-md-1 me-0"></i>
                            <span class="align-middle d-md-inline-block d-none">Offer</span>
                        </button>
                        &nbsp;
                        <button v-if="showLegal()" type="button" class="btn btn-primary d-flex send-msg-btn" @click="store.sendMessage">
                            <i class="bx bx-paper-plane me-md-1 me-0"></i>
                            <span class="align-middle d-md-inline-block d-none">Send</span>
                        </button>

                        <Modal :show="store.openOfferModal"
                               @close="store.openOfferModal = false"
                               :title="'Make an offer!'"
                        >
                            <template #body>
                                <div class="container">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input v-model="store.newOfferAmount"
                                                   type="number" class="form-control"
                                                   placeholder="Amount"
                                                   aria-label="Amount"
                                                   aria-describedby="button-addon2" />
                                        </div>
                                    </div>
                                </div>
                                <ModalFooter class="float-right pb-2">
                                    <button type="button" class="btn btn-primary" @click.prevent="store.closeOfferDialog()">
                                        close
                                    </button>
                                    <button type="button" class="btn btn-danger" @click.prevent="store.sendOffer()">
                                        Send
                                    </button>
                                </ModalFooter>
                            </template>
                        </Modal>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
