<script setup>
defineProps({
    org : {
        type: Object
    },
});
</script>

<template>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 org-item hover:transition-up">
            <div class="card-header flex-grow-0 pb-3">
                <div class="d-flex">
                    <div class="avatar flex-shrink-0 me-3">
                        <img :src="org.logo" alt="User" class="rounded"/>
                    </div>
                    <div
                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                        <div class="me-2">
                            <a :href="`/organisations/${org.id}`">
                                <h5 class="mb-0">{{ org.org_name }}</h5>
                            </a>
                            <small class="text-muted">
                                {{ org.created_at }}
                            </small>
                        </div>
                        <a href="#" class="text-muted">
                            <i class="bx bx-bookmark"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <p class="mb-1" v-if="org.other_locations.length > 0">
                    <i class="bx bx-map"></i>
                    {{ org.other_locations[0].address }}
                </p>

                <p v-if="org.contact_phone">
                    <i class="bx bx-phone"></i>
                    {{org.contact_phone}}
                </p>

                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div v-if="org.categories.length > 0">
                        <template v-for="orgCategory in org.categories">
                            <span class="badge bg-label-secondary m-1">
                                {{orgCategory.name}}
                            </span>
                        </template>

                    </div>

<!--                    <div class="card-actions w-px-50 text-end">-->
<!--                        <a href="javascript:;" class="text-muted">-->
<!--                            &lt;!&ndash;                                    {{ rand(1, 9) }} &ndash;&gt;-->
<!--                            rand number-->
<!--                            <i class="bx bx-message ms-1"></i>-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
