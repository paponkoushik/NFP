<script setup>
import { onMounted } from "vue";
import { useLegalRequestStore } from "@/stores/LegalRequestStore";
import LegalFilters from '@/components/Legals/LegalFilters';
import ListingNfp from '@/components/Legals/ListingNfp';
import ListingOrgAdmin from '@/components/Legals/ListingOrgAdmin';

defineProps({
    statuses: Array,
    can: Object
});

const store = useLegalRequestStore();

onMounted(() => store.fill());
</script>

<template>
    <div class="col-12">
        <div class="card">
            <LegalFilters :statuses="statuses" />

            <ListingNfp v-if="can.edit" />

            <ListingOrgAdmin v-else />
        </div>
    </div>
</template>
