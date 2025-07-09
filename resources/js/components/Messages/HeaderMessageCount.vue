<script setup>
import {useChatStore} from "@/stores/ChatStore";
import {onMounted} from "vue";

const props = defineProps({
    activeUrl: {
        type   : Boolean,
        default: false
    },
    count: {
        type   : Number,
        default: 5,
    }

});

// const store = useChatStore();

// onMounted(() => {
//     console.log(props.count)
// })
</script>

<template>
    <li class="dropdown-notifications navbar-dropdown me-3 me-xl-1">
        <a class="nav-link hide-arrow" :class="{active: props.activeUrl}"
           href="/messages"
           data-bs-auto-close="outside"
           aria-expanded="false"
           data-bs-toggle="tooltip"
           data-bs-offset="0,4"
           data-bs-placement="bottom"
           data-bs-html="true"
           title="Messages"
        >
            <i class="bx bx-comment-detail bx-sm"></i>
            <span
                v-if="props.count > 0"
                id="message-count"
                class="badge bg-danger rounded-pill badge-notifications"
            >
                {{ props.count }}
            </span>
        </a>
    </li>
</template>
