<script setup>
import {reactive, onMounted} from 'vue';
import Carousel from '@/components/Shared/Carousel.vue';

const props = defineProps({
    modelValue : Array | String,
    files      : {
        type   : Array,
        default: () => []
    },
    url        : {
        type   : String,
        default: '/file-upload'
    },
    deleteable : {
        type   : Boolean,
        default: true
    },
    fullscreen : {
        type   : Boolean,
        default: true
    },
    previewType: {
        type   : String,
        default: 'carousel'     // single, carousel
    },
    itemClass  : {
        type: String,
    },
    data       : {
        default: {}
    },
});

const state = reactive({
    myFiles: []
});

const emit = defineEmits(['update:modelValue', 'deletedFile']);

onMounted(() => {
    state.myFiles = props.files;
});

function handleFileRemove(path) {
    confirm("Do you want to delete this file?").then(isConfirm => {
        if (isConfirm) {
            deleteFile(path);
        }
    });

}

function deleteFile(path) {
    const headers = {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
    }


    try {
        const content = {...props.data, path};

        axios.delete(props.url, {data: content}, headers);

        state.myFiles.splice(state.myFiles.indexOf(path), 1);

        emit('update:modelValue', state.myFiles);
        emit('deletedFile', path);
    } catch (error) {
        console.log(error)
        flash(error.response?.data?.message, "danger");
    }
}
</script>

<template>
    <div v-if="previewType == 'carousel'">
        <carousel class="carousel rounded" :fullscreen="fullscreen">
            <div class="carousel-cell h-px-200"
                 :class="[{'overlay-cell': deleteable}, itemClass]"
                 v-for="file in state.myFiles"
                 :key="file"
            >
                <div class="overlay" v-if="deleteable">
                    <i class="bx bx-trash" @click="handleFileRemove(file)"></i>
                </div>
                <img class="carousel-cell-image"
                     :data-flickity-lazyload="file"
                     alt="Image"/>
            </div>
        </carousel>
    </div>

    <template v-else>
        <carousel class="carousel rounded carousel-small"
                  :fullscreen="fullscreen"
                  :prevNextButtons="false"
                  v-for="file in state.myFiles"
                  :key="file"
        >
            <div class="carousel-cell h-px-100"
                 :class="[{'overlay-cell': deleteable}, itemClass]"
            >
                <div class="overlay" v-if="deleteable">
                    <i class="bx bx-trash" @click="handleFileRemove(file)"></i>
                </div>
                <img class="carousel-cell-image"
                     :data-flickity-lazyload="file"
                     alt="Image"/>
            </div>
        </carousel>
    </template>
</template>

<style scoped>
.carousel.is-fullscreen .overlay {
    display: none !important;
}

.carousel.is-fullscreen .carousel-cell:hover .carousel-cell-image {
    opacity: 1;
}

.carousel.carousel-small {
    width: 150px;
    margin-right: 8px;
    display: inline-block;
}

.carousel.is-fullscreen.carousel-small {
    width: 100% !important;
}

.carousel.small .carousel-cell-image {
    border-radius: 4px;
}

.overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    opacity: 0;
    text-align: center;
    transition: .5s ease;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}

.carousel-cell:hover .overlay {
    opacity: 1;
    z-index: 99;
}

.carousel-cell.overlay-cell:hover .carousel-cell-image {
    opacity: 0.6;
}

.overlay i {
    opacity: .9;
    font-size: 20px;
    color: #f3f3f3;
    border-radius: 2px;
    padding: 12px 15px;
    background: #e51212;
}
</style>
