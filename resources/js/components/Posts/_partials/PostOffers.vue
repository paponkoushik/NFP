<script setup>

import {usePostStore} from "../../../stores/PostStore";
import {useOfferStore} from "../../../stores/OfferStore";
import OurOfferList from "@/components/OurOffers/OurOfferList.vue";

const store = usePostStore();
const offerStore = useOfferStore();
offerStore.postId = store.postId

</script>

<template>
    <our-offer-list></our-offer-list>
</template>
