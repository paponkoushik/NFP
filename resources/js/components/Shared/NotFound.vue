<script setup>
    defineProps({
        image: {
            type: String,
            default: "empty.png",
        },
        message: {
            type: String,
            default:
                "Sorry ... it seems there is no data added in the system yet.",
        },
        height: {
            type: String,
            default: "50vh",
        },
    });
</script>

<template>
    <div class="d-flex flex-column align-items-center justify-content-center px-5" :style="`height: ${height}`">
        <img :src="`/assets/img/${image}`" 
            alt="No data" 
            v-if="image"
            class="not-found-image" />

        <slot>
            <p class="text-center text-dark px-5" style="font-size: 1rem" v-html="message"></p>
        </slot>
    </div>
</template>
