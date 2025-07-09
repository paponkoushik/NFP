<script setup>
    import { useChatStore } from "@/stores/ChatStore";
    import useUtilsFunc from "@/composables/useUtilsFunc.js";

    const { textAvatarBgClass } = useUtilsFunc();

    defineProps({
        communication: {
            default: {}
        },
        commsIndex: {
            default: 0
        }
    });

    const store = useChatStore();
</script>

<template>
    <li class="chat-contact-list-item" @click="store.getChatHistory(communication)" :class="store.activeChat?.id == communication.id ? 'active' : ''">
        <a class="d-flex align-items-center">
            <div class="flex-shrink-0 avatar" :class="communication?.organisation?.user?.is_online ? 'avatar-online' : 'avatar-offline'">
                <img v-if="!communication.is_anonymous && communication?.organisation?.user?.avatar" 
                    :src="communication?.organisation?.user?.avatar" 
                    alt="Avatar" 
                    class="rounded-circle" 
                />
                <span v-else class="avatar-initial rounded-circle" :class="textAvatarBgClass()">
                    {{ communication.is_anonymous ? communication?.organisation?.anonymous_short_name : communication?.organisation?.user?.short_name }}
                </span>
            </div>

            <div class="chat-contact-info flex-grow-1 ms-3">
                <h6 class="chat-contact-name text-truncate m-0">
                    {{ communication.is_anonymous ? communication?.organisation?.anonymous_name : communication?.organisation?.user?.full_name }}
                </h6>
                <p class="chat-contact-status text-truncate mb-0 text-muted">
                    {{ communication.is_anonymous ? "The user wants to communicate as an anonymous user" : communication?.organisation?.name }}
                </p>
            </div>

            <small class="text-muted mb-auto">{{ communication?.organisation?.user?.last_login_at }}</small>
        </a>
    </li>
</template>