<script setup>
import {usePostStore} from "@/stores/PostStore";
import {useCategoryStore} from "../../../stores/CategoryStore";

const store = usePostStore();
const categoryStore = useCategoryStore();

defineProps({
    post    : {
        type: Object
    },
    editable: {
        default: false
    }
});
</script>

<template>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 hover:transition-up">
            <img class="img-fluid rounded-top post-image" :src="post.images[0]" alt="Card image cap"/>
            <div class="featured-date mt-n4 ms-4 bg-white rounded w-px-50 shadow text-center p-1">
                <h5 class="mb-0 text-dark">{{ post.created_day }}</h5>
                <span class="text-primary text-uppercase">{{ post.created_month }}</span>
            </div>

            <div class="card-body py-3">
                <a :href="`/posts/${post.id}`">
                    <h5 class="text-truncate">{{ post.title }}</h5>
                </a>

                <p class="h-50px overflow-hidden mb-2">
                    {{ post.clean_description }}
                </p>

                <div class="d-flex mt-3" v-if="post.category">
                    <div class="badge-container">
                        <div class="badge"
                             :class="{
                            'bg-label-secondary': !categoryStore.filterSelectedCategoryIds.length,
                            'bg-label-primary': (post.category.parent && post.category.parent.parent && categoryStore.filterSelectedCategoryIds.includes(post.category.parent.parent.id))
                            || (post.category.parent && categoryStore.filterSelectedCategoryIds.includes(post.category.parent.id))
                            || categoryStore.filterSelectedCategoryIds.includes(post.category.id)
                        }">
                            <span :class="{
                                    'text-warning': categoryStore.filterSelectedCategoryIds.includes(post.category.parent.parent.id),
                                    'text-gray': !categoryStore.filterSelectedCategoryIds.includes(post.category.parent.parent.id),
                                }" v-if="post.category.parent && post.category.parent.parent">
                                {{ post.category.parent.parent.name }}
                                <i class="bx bx-chevron-right"></i>
                            </span>

                            <span :class="{
                                'text-warning': categoryStore.filterSelectedCategoryIds.includes(post.category.parent.id),
                                'text-gray': !categoryStore.filterSelectedCategoryIds.includes(post.category.parent.id),
                            }" v-if="post.category.parent">
                                    {{ post.category.parent.name }}
                                    <i class="bx bx-chevron-right"></i>
                                </span>
                            <span :class="{
                                'text-warning': categoryStore.filterSelectedCategoryIds.includes(post.category.id),
                                'text-gray': !categoryStore.filterSelectedCategoryIds.includes(post.category.id),
                                'text-primary': !categoryStore.filterSelectedCategoryIds.includes(post.category.id)
                                 && !categoryStore.filterSelectedCategoryIds.length
                            }">
                                {{ post.category.name }}
                            </span>
                        </div>
                        <div class="badge bg-label-info">{{ post.state }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-3">
                    <div class="card-actions" v-if="post.is_own">
                        <a href="#" @click.prevent="store.openOurPostOffersModal(post.id)" class="text-muted me-3">
                            <span class="me-2">
                                <i class="tf-icons bx bxs-offer me-1" :style="{color: '#ffab00'}"></i>
                                {{ post.offers?.length }}
                            </span>
                            <span class="me-2">
                                <i class="tf-icons bx bxs-offer me-1"
                                   :style="{color: '#ff3e1d'}"></i> {{ post.offers_not_seen_count }}
                            </span>
                        </a>
                    </div>

                    <div class="dropup d-none d-sm-block" v-if="editable">
                        <button class="btn p-0" type="button" id="sharedList" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sharedList">
                            <a class="dropdown-item" :href="`/posts/${post.id}/edit`">
                                Edit
                            </a>
                            <!-- <a class="dropdown-item" :href="`/posts/${post.id}`">
                                Details
                            </a> -->
                            <a class="dropdown-item hover:text-red-600"
                               href="javascript:void(0);"
                               @click="store.delete(post)"
                            >
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.badge-container .badge {
    margin-right: 7px; /* Adjust the right margin to control the gap */
    margin-bottom: 7px;
}
</style>
