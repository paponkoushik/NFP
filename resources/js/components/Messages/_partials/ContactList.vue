<script setup>
    import { useChatStore } from "@/stores/ChatStore";
    import useUtilsFunc from "@/composables/useUtilsFunc.js";
    import ChatUser from '@/components/Messages/_partials/ChatUser';
    import {onMounted} from "vue";

    const { textAvatarBgClass } = useUtilsFunc();

    const store = useChatStore();

    onMounted(async () => {
        await store.fill();
        setInterval(() => {
            store.updateMessageSeenStatus()
        }, 30000)
    })

</script>

<template>
    <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
        <div class="sidebar-header pt-3 px-3 mx-1">
            <div class="d-flex align-items-center me-3 me-lg-0">
                <div class="flex-shrink-0 avatar avatar-online me-2" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                    <img class="user-avatar rounded-circle cursor-pointer" :src="store?.authUser?.avatar ? authUser?.avatar : '/assets/img/avatars/1.png'" alt="Avatar" />
                </div>

                <div class="flex-grow-1 input-group input-group-merge rounded-pill ms-1">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search fs-4"></i></span>
                    <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
                </div>
            </div>
            <i class="bx bx-x cursor-pointer position-absolute top-0 end-0 mt-2 me-1 fs-4 d-lg-none d-block" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
        </div>
        <hr class="container-m-nx mt-3 mb-0" />
        <div class="sidebar-body">
            <!-- Chats -->
            <span v-if="store.groups.length">
                <h5 class="px-4 pt-3 text-primary mb-2">Messages from the Posts</h5>

                <div class="accordion accordion-header-primary" id="accordionStyle1">
                    <div class="card accordion-item mb-2 border-0" v-for="(group, index) in store.groups" :key="group.id">
                        <h2 class="accordion-header mx-2">
                            <button type="button"
                                class="accordion-button text-body pb-0 w-100"
                                :class="index != store.autoSelectedIndex ? 'collapsed' : ''"
                                data-bs-toggle="collapse"
                                :data-bs-target="`#accordionStyle1-${index}`"
                                aria-expanded="true"
                            >
                                <div class="flex-shrink-0 me-3">
                                    <!-- <span class="badge rounded-pill bg-danger badge-notifications">10</span> -->
                                </div>
                                <div class="flex-grow-1 me-1" style="width: 90%;">
                                    <h6 class="fw-medium chat-contact-name text-truncate mb-1">{{ group.title }}</h6>
                                    <span class="small text-muted">{{ group.created_at }}</span>
                                </div>
                            </button>
                        </h2>

                        <div :id="`accordionStyle1-${index}`"
                            class="accordion-collapse collapse"
                            :class="index == store.autoSelectedIndex ? 'show' : ''"
                            data-bs-parent="#accordionStyle1"
                        >
                            <div class="accordion-body pb-0">
                                <ul class="list-unstyled chat-contact-list pt-1 mb-0" id="chat-list">
                                    <ChatUser
                                        v-for="(communication, commsIndex) in group.communications"
                                        :key="communication.id"
                                        :communication="communication"
                                        :commsIndex="commsIndex"
                                    />
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </span>

            <!-- Contacts -->
            <ul class="list-unstyled chat-contact-list mb-0" id="contact-list">
                <li class="chat-contact-list-item chat-contact-list-item-title">
                    <h5 class="text-primary mb-0">Direct Messages</h5>
                </li>
                <li class="chat-contact-list-item contact-list-item-0 d-none" v-if="store.contacts.length < 1">
                    <h6 class="text-muted mb-0">No Contacts Found</h6>
                </li>

                <ChatUser
                    v-for="(contact, contactIndex) in store.contacts"
                    :key="contact.id"
                    :communication="contact"
                    :commsIndex="contactIndex"
                />
            </ul>
        </div>
    </div>
</template>
