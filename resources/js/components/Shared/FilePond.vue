<script setup>
import { ref } from 'vue';
import vueFilePond, { setOptions } from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

const props = defineProps({
    options: {
        type: Object,
        default: {}
    },
    maxFileSize: {
        type: String,
        default: '1MB'
    },
    fileTypes: {
        type: String,
        default: 'image/*'
    },
    labelIdle: {
        type: String,
        default: '<div class="fw-normal px-3">Drop your file here or <span class="filepond--label-action">Browse</span></div>'
    },
    url: {
        type: String,
        default: '/upload'
    },
    inputName: {
        type: String,
        default: 'file'
    },
});

// create filepond component
let serverMessage = {};
setOptions({
    server: {
        process: {
            url: props.url,
            onerror: (response) => {
                serverMessage = JSON.parse(response);
            },
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        }
    },
    labelFileProcessingError: () => serverMessage.error,
    credits: false,
    ...props.options
});

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
const pond = ref(null);
const emit = defineEmits(['processedFile']);

const filepondInitialized = () => {
    console.log('Filepond is ready!');

    console.log('Filepond object', pond.value)
}

const handleProcessedFile = (error, file) => {
    if(error) {
        console.error(error);
        return;
    }

    // push into render or emit to upload file location
    emit('processedFile', JSON.parse(file.serverId));
}
</script>

<template>
    <file-pond
        :name="inputName"
        ref="pond"
        :label-idle="labelIdle"
        @init="filepondInitialized"
        @processfile="handleProcessedFile"
        :accepted-file-types="fileTypes"
        :max-file-size="maxFileSize"
    />
</template>

<!-- Controller
// do validation
// $uploadFile = $request->file('name')
// Image::create([ 'name' => $uploadFile->hasName(), 'extension' => $uploadFile->extension(), 'size' => $uploadFile->getSize() ]);
 -->
