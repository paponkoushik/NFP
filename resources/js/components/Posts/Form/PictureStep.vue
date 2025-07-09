<script setup>
import {usePostStore} from "@/stores/PostStore";
import FilePond from "../../Shared/FilePond.vue";
import {nextTick} from "vue";

const store = usePostStore();

const uploadedFile = (logo) => {
    store.images.push('/storage/' + logo);
};

const deleteFileHandler = (path) => {
    // remove first slash
    const pathWithoutSlash = path.substring(1);
    store.uploadImages = store.uploadImages.filter((image) => image !== pathWithoutSlash);
};

const fileRemoveHandler = (file) => {
    nextTick(() => {
        store.images = store.images.filter((image) => image !== '/storage/' + file);
    });
};
</script>

<template>
    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <h5 class="mb-1">Post Pictures</h5>
            <small>For best results, we recommend choosing landscape images.</small>
        </div>

        <div class="col-md-12">
            <file-upload
                :multiple="true"
                url="/posts/images"
                input-name="file"
                v-model="store.uploadImages"
                @processed-file="uploadedFile"
                @file-removed="fileRemoveHandler"
            ></file-upload>
        </div>

        <div class="col-md-12" v-if="store.images && store.images.length">
            <file-preview
                url="/posts/images"
                :data="{post_id: store.form.id}"
                :files="store.images"
                preview-type="single"
                v-model="store.images"
                @deleted-file="deleteFileHandler"
            ></file-preview>
        </div>

        <!-- <div class="d-flex align-items-center mb-2">
            <div class="me-3">
                <img src="/assets/img/preview.png" alt="Your Logo" class="rounded img-fluid" height="100" width="110">
            </div>

            <div>
                <FilePond class="filepond" />
                <p class="text-muted mt-n3 mb-0">
                    <small>Allowed JPG, GIF or PNG. Max size of 1MB</small>
                </p>
            </div>
        </div> -->
    </div>
</template>
