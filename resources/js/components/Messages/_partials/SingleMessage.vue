<script setup>
import { useChatStore } from "@/stores/ChatStore";
import { onMounted, ref, watch } from 'vue';

const store = useChatStore();

const props = defineProps({
    messages: {
        default: {}
    }
});

// watch(() => props.message, (first, second) => {
//     document.getElementById('papon').scrollIntoView({behavior: 'smooth'});
//     console.log(
//         "Watch props.selected function called with args:",
//         first,
//         second
//     );
// });
// const someElement = ref();
onMounted(async () => {

    const test =  document.getElementById('papon')

    test.scrollTo(0, test.scrollTop + 1)
});

</script>


<template>
<!--    <div>-->
        <div class="d-flex flex-row justify-content-center">
            <p class="text-center mx-3 mb-0" style="color: #a2aab7;">{{ messages[0] }}</p>
        </div>
        <div v-for="message in messages[1]">
            <div class="d-flex flex-row justify-content-start" v-if="! message.is_own">
                <img v-if="!store.activeChat.is_anonymous && store.activeChat?.sender_org?.user?.avatar"
                     :src="store.activeChat?.sender_org?.user?.avatar"
                     alt="Avatar" class="rounded-circle"
                     style="width: 35px; height: 50%;">

                <span v-else class="other-avatar-text" >
                {{ store.activeChat.is_anonymous ? store.activeChat?.sender_org?.anonymous_short_name : store.activeChat?.sender_org?.user?.short_name }}
            </span>
                <div>
                    <p class="small p-2 ms-2 mb-1 rounded-3" style="background-color: #f5f6f7;">{{ message.comment }}</p>
                    <p class="small ms-3 mb-2 rounded-3 text-muted">{{ message.time }}</p>
                </div>
            </div>

            <div v-else-if="message.is_own">
                <div class="d-flex flex-row justify-content-end">
                    <div>
                        <p class="small p-2 me-2 mb-1 text-white rounded-3 bg-primary">{{ message.comment }}</p>
                        <div class="d-flex flex-row justify-content-end me-3">
                            <i class="bx bx-check-double" :class="[message.is_seen ? 'text-success' : 'text-muted']"></i>
                            <p class="small mb-2 rounded-3 text-muted d-flex justify-content-end col-10">{{ message.time }}</p>
                        </div>
                    </div>

                    <img v-if="message.user?.avatar" :src="message.user?.avatar" alt="Avatar" class="rounded-circle" style="width: 35px; height: 50%;">
                    <span v-else class="self-avatar-text" >{{ message.user?.short_name }}</span>
                </div>
            </div>
        </div>


<!--    </div>-->
<!--    <div id="papon"></div>-->
</template>

<style scoped>

.self-avatar-text {
    margin-top: 3px;
    margin-right: 15px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 12px;
    line-height: 30px;
    text-align: center;
    background: #efe5f4 !important;
    color: #9A5EBC !important;
}

.other-avatar-text {
    margin-top: 3px;
    margin-left: 15px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 12px;
    line-height: 30px;
    text-align: center;
    background: #efe5f4 !important;
    color: #9A5EBC !important;
}
</style>
