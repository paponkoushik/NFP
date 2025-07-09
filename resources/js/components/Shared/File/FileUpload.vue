<script setup>
import {ref, reactive, onMounted} from 'vue';
import vueFilePond, {setOptions} from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

setOptions({
    server: {
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        url    : props.url,
    }
});

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

const props = defineProps({
    modelValue     : Array | String,
    files          : {
        default: null
    },
    inputName      : {
        type   : String,
        default: 'tmp_file'
    },
    label          : {
        type   : String,
        default: 'Drag & Drop your files or <span class="filepond--label-action"> Browse </span>'
    },
    inputClass     : {
        type   : String,
        default: 'my-filepond'
    },
    required       : {
        type   : Boolean,
        default: false
    },
    disabled       : {
        type   : Boolean,
        default: false
    },
    multiple       : {
        type   : Boolean,
        default: false
    },
    parallelUploads: {
        type   : Number,
        default: 1,
    },
    acceptedTypes  : {
        type   : String,
        default: 'image/*'
    },
    maxFiles       : {
        type: Number,
    },
    instantUpload  : {
        type   : Boolean,
        default: true
    },
    fileSize       : {
        type   : String,
        default: '1MB'
    },
    url            : {
        type   : String,
        default: '/file-upload'
    },
});

const emit = defineEmits(['update:modelValue', 'fileRemoved', 'processedFile']);

const filepondRef = ref(null);
const state = reactive({
    myFiles: []
});

onMounted(() => {
    // state.myFiles = props.files;
    // console.log('mounted')
});

function handleFilePondInit() {
    if (Array.isArray(props.files)) {
        filepondRef.addFiles(props.files.join());
    } else if (props.files) {
        filepondRef.addFile(props.files);
    }

    /*filepondRef.getFiles();
    console.log('init')*/
}

function handleRemoveFile(error, {serverId}) {
    state.myFiles.splice(state.myFiles.indexOf(serverId), 1);
    emit('update:modelValue', props.multiple ? state.myFiles : null);
    emit('fileRemoved', serverId);
}

function handleProcessFile(file, {serverId}) {
    console.log('handleProcessFile -> ', serverId)
    state.myFiles.push(JSON.parse(serverId));
    emit('update:modelValue', props.multiple ? state.myFiles : state.myFiles[0]);
    emit('processedFile', JSON.parse(serverId));
}
</script>

<template>
    <div>
        <file-pond
            ref="filepondRef"
            :name="inputName"
            :label-idle="label"
            :max-files="maxFiles"
            :required="required"
            :disabled="disabled"
            :files="state.myFiles"
            :class-name="inputClass"
            :max-file-size="fileSize"
            :allow-multiple="multiple"
            :instant-upload="instantUpload"
            :accepted-file-types="acceptedTypes"
            :max-parallel-uploads="parallelUploads"
            @init="handleFilePondInit"
            @removefile="handleRemoveFile"
            @processfile="handleProcessFile"
        />
    </div>
</template>
