<script setup>
import {usePostStore} from "@/stores/PostStore";
import PostFilter from '@/components/Posts/PostFilter';
import PostItem from '@/components/Posts/_partials/PostItem';
import PostOffers from "./_partials/PostOffers";
import {onMounted, reactive} from "vue";
import {useUrlFunc} from "../../composables/useUrlFunc";

const props = defineProps({
    title  : {
        default: 'Posts'
    },
    user_id: {
        default: null
    }
});


const {pushUrlState, getUrlParams} = useUrlFunc();

const data = reactive({
    has_my_preference: false,
});

const store = usePostStore();

function pageChange({page, limit}) {
    pushUrlState({page, limit})
    store.fill({page, limit})
}

const handleFilterPost = () => {
    store.post_author = props.user_id;
    if (data.has_my_preference) {
        const params = {
            has_my_preference: data.has_my_preference
        };

        pushUrlState(params)
        store.fill(params);
    } else {
        pushUrlState();
        store.fill();
    }
}

const setDefaultUrlParams = () => {
    const urlParams = getUrlParams();
    if (urlParams && Object.keys(urlParams).length) {
        data.has_my_preference = urlParams.has_my_preference || false;
    }
};

onMounted(() => {
    setDefaultUrlParams();
    handleFilterPost();
});
</script>

<template>
    <div class="row mt-2" :class="$setLoadingSpinner(store.loading)">
        <CardHeader class="d-flex justify-content-between align-items-center">
            <template #heading>
                <div class="head-label d-flex align-content-center">
                    <h5 class="card-title mb-0 me-3">{{ title }}</h5>

                    <label class="switch switch-success switch-square switch-sm">
                        <input type="checkbox" class="switch-input" v-model="data.has_my_preference"
                               @change="handleFilterPost"/>
                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="bx bx-check"></i>
                            </span>
                            <span class="switch-off">
                                <i class="bx bx-x"></i>
                            </span>
                        </span>
                        <span class="switch-label" v-if="!data.has_my_preference">Match My Preferences</span>
                        <span class="switch-label" v-else>Clear My Preferences</span>
                    </label>
                </div>
            </template>

            <a v-if="title === 'Our Posts'" href="/posts/create" class="btn btn-info btn-sm rounded-pill">
                <i class="bx bx-plus"></i>
                Post an ad
            </a>
        </CardHeader>

        <PostFilter v-if="!data.has_my_preference"></PostFilter>

        <PostItem
            v-for="post in store.posts"
            :key="post.id"
            :post="post"
            :editable="title != 'Posts' && title != 'Organisation Posts'"></PostItem>

        <!-- Oder cancel modal -->
        <Modal :show="store.openPostOffersModal"
               @close="store.closeOurPostOffersModal"
               maxWidth="xl"
        >
            <template #body>
                <post-offers v-if="store.postId"/>
            </template>
        </Modal>

        <div class="col-12" v-if="store.totalPost <= 0">
            <h5 class="text-center" v-if="store.loading">Loading...</h5>
            <h5 class="text-center" v-else>No post found yet!</h5>
        </div>

        <div class="col-12">
            <Pagination class="float-end" :meta="store.meta" @changed="pageChange"/>
        </div>
    </div>
</template>
