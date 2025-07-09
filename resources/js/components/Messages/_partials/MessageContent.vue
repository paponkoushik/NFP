<script setup>
    import { useChatStore } from "@/stores/ChatStore";

    const store = useChatStore();

    const props = defineProps({
        messages: {
            default: {}
        }
    });

</script>

<template>
    <div class="d-flex flex-row justify-content-center">
        <p class="text-center mx-3 mb-0" style="color: #a2aab7;">{{ messages[0] }}</p>
    </div>
    <div v-for="message in messages[1]">
        <li v-if="message.is_own" class="chat-message chat-message-right mt-5">
            <div class="d-flex overflow-hidden">
                <div class="chat-message-wrapper flex-grow-1">
                    <div class="chat-message-text">
                        <p class="mb-0">{{ message.comment }} </p>
                    </div>
                    <div class="text-end text-muted mt-1">
                        <i :class="[message.is_seen ? 'text-success' : 'text-muted']" class="bx bx-check-double"></i>
                        <small>{{ message.time }}</small>
                    </div>
                </div>

                <div class="user-avatar flex-shrink-0 ms-3">
                    <div class="avatar avatar-sm">
                        <img v-if="message.user?.avatar" :src="message.user?.avatar" alt="Avatar" class="rounded-circle" />
                        <span v-else class="avatar-initial rounded-circle bg-label-primary">{{ message.user?.short_name }}</span>
                    </div>
                </div>
            </div>
        </li>

        <li v-else class="chat-message mt-5">
            <div class="d-flex overflow-hidden">
                <div class="user-avatar flex-shrink-0 me-3">
                    <div class="avatar avatar-sm">
                    <span v-if="store.activeChat?.is_anonymous" class="avatar-initial rounded-circle bg-label-success">
                        {{ store.activeChat?.organisation?.anonymous_short_name }}
                    </span>
                        <img v-else-if="message.user?.avatar" :src="message.user?.avatar" alt="Avatar" class="rounded-circle" />
                        <span v-else class="avatar-initial rounded-circle bg-label-success">{{ message.user?.short_name }}</span>
                    </div>
                </div>

                <div class="chat-message-wrapper flex-grow-1">
                    <div class="chat-message-text">
                        <p class="mb-0">{{ message.comment }}</p>
                    </div>
                    <!-- <div class="chat-message-text mt-2">
                        <p class="mb-0">It should be Bootstrap 5 compatible.</p>
                    </div> -->
                    <div class="text-muted mt-1">
                        <small>{{ message.time }}</small>
                    </div>
                </div>
            </div>
        </li>
    </div>

</template>
