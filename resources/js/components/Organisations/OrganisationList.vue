<script setup>
import OrganizationFilter from '@/components/Organisations/OrganizationFilter';
import {useOrganisationStore} from "@/stores/OrganisationStore";
import {onMounted, reactive} from "vue";
import {useUrlFunc} from "../../composables/useUrlFunc";
import OrgItem from "./OrgItem";

const props = defineProps({
    title: {
        default: 'NFPs that matches your preference'
    },
});


const {pushUrlState, getUrlParams} = useUrlFunc();

const data = reactive({
    has_org_preference: false,
});

const store = useOrganisationStore();

function pageChange({page, limit}) {
    pushUrlState({page, limit})
    store.getOrgList({page, limit})
}

const handleFilterOrg = () => {
    if (data.has_org_preference) {
        const params = {
            has_org_preference: data.has_org_preference
        };

        pushUrlState(params)
        store.getOrgList(params);
    } else {
        pushUrlState();
        store.getOrgList();
    }
}

const setDefaultUrlParams = () => {
    const urlParams = getUrlParams();
    if (urlParams && Object.keys(urlParams).length) {
        data.has_org_preference = urlParams.has_org_preference || false;
    }
};

onMounted(() => {
    setDefaultUrlParams();
    handleFilterOrg();
});
</script>

<template>
    <div class="row mt-2" :class="$setLoadingSpinner(store.loading)">
        <CardHeader class="d-flex justify-content-between align-items-center">
            <template #heading>
                <div class="head-label d-flex align-content-center">
                    <h5 class="card-title mb-0 me-3">{{ title }}</h5>

                    <label class="switch switch-success switch-square switch-sm">
                        <input type="checkbox" class="switch-input" v-model="data.has_org_preference"
                               @change="handleFilterOrg"/>
                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="bx bx-check"></i>
                            </span>
                            <span class="switch-off">
                                <i class="bx bx-x"></i>
                            </span>
                        </span>
                        <span class="switch-label" v-if="!data.has_org_preference">Match My Preferences</span>
                        <span class="switch-label" v-else>Clear My Preferences</span>
                    </label>
                </div>
            </template>
        </CardHeader>

        <OrganizationFilter v-if="!data.has_org_preference"></OrganizationFilter>

    </div>

    <section class="charity-details">
        <div class="row">
            <OrgItem
                v-for="organisation in store.organisationList"
                :key="organisation.id"
                :org="organisation"/>
        </div>
    </section>

    <div class="col-12" v-if="store.organisationList.length <= 0">
        <h5 class="text-center" v-text="store.loading ? 'Loading...' : 'No organization found yet!'"></h5>
    </div>

    <div class="col-12">
        <Pagination class="float-end" :meta="store.meta" @changed="pageChange"/>
    </div>
</template>


<style scoped>

</style>
