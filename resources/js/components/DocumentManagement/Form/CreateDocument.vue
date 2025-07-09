<script setup>
import {useTagStore} from "@/stores/TagStore";
import {useDocumentManagementStore} from "@/stores/DocumentManagementStore";
import {useCollectionStore} from "@/stores/CollectionStore";
import DocumentLocation from "@/components/DocumentManagement/Form/DocumentLocation";
import FilePond from "../../Shared/FilePond"

const store = useDocumentManagementStore();

const uploadedFile = ({uploadPath}) => {
    store.form.path = uploadPath;
};

const tagStore = useTagStore();
tagStore.fetchTagOptions();

const collectionStore = useCollectionStore();
collectionStore.fill();
</script>

<template>
    <Modal max-width="lg"
           :show="store.showModal"
           @close="store.showModal = false"
           :title="store.form.id ? 'Edit Document' : 'Add Document'"
    >
        <template #body>
            <v-form v-slot="{ handleSubmit }">
                <div class="row">
                    <div class="col-sm-6 col-md-7">
                        <div class="row">
                            <div class="col-12">
                                <InputGroup label="Title">
                                    <v-field name="title" rules="required" v-model="store.form.title"
                                             v-slot="{ field, errors }">
                                        <input type="text"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter title"
                                               v-bind="field"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="title"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <InputGroup label="Summary" :required="false">
                                    <v-field name="summary" rules="" v-slot="{ errors }">
                                        <VueTrix
                                            v-if="store.showModal"
                                            placeholder="Summary..."
                                            v-model="store.form.summary">
                                        </VueTrix>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="summary"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 col-md-4">
                                <InputGroup label="Is Free ?">
                                    <br/>
                                    <label class="switch switch-success mt-2">
                                        <input type="checkbox" class="switch-input" v-model="store.form.is_free">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">{{ store.form.is_free ? 'Free' : 'Paid' }}</span>
                                    </label>
                                </InputGroup>
                            </div>

                            <div class="col-6 col-md-8">
                                <InputGroup label="Price">
                                    <v-field name="price" :rules="{'required': !store.form.is_free}"
                                             v-model="store.form.price" v-slot="{ field, errors }">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">$</span>
                                            <input type="number"
                                                   class="form-control"
                                                   :class="{'is-invalid': errors[0]}"
                                                   placeholder="Enter price"
                                                   v-bind="field"
                                                   :disabled="store.form.is_free"
                                            />
                                        </div>
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="price"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 col-md-4">
                                <InputGroup label="Is External Link ?">
                                    <br/>
                                    <label class="switch switch-success mt-2">
                                        <input type="checkbox" class="switch-input"
                                               v-model="store.form.is_external_link">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">{{
                                                store.form.is_external_link ? 'Yes' : 'No'
                                            }}</span>
                                    </label>
                                </InputGroup>
                            </div>

                            <div class="col-6 col-md-8">
                                <InputGroup label="Link">
                                    <v-field name="external_link" label="link"
                                             :rules="store.form.is_external_link ? 'required|url' : ''"
                                             v-model="store.form.external_link" v-slot="{ field, errors }">
                                        <input type="text"
                                               class="form-control"
                                               :class="{'is-invalid': errors[0]}"
                                               placeholder="Enter external link"
                                               v-bind="field"
                                               :disabled="!store.form.is_external_link"
                                        />
                                        <error-message :class="{'invalid-feedback': errors[0]}"
                                                       name="external_link"></error-message>
                                    </v-field>
                                </InputGroup>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12" :class="store.form.id && store.uploadPath ? 'col-md-8' : 'col-md-12'">
                                <h6 class="mb-2">File</h6>
                                <p class="m-0 small">Please select a document (docx, pdf)</p>
                                <p class="mb-2 small">Max file size 8MB</p>

                                <!--                                <file-upload-->
                                <!--                                    v-if="store.showModal"-->
                                <!--                                    file-size="8MB"-->
                                <!--                                    accepted-types="application/doc,application/docx,application/pdf"-->
                                <!--                                    :disabled="(store.form.is_external_link || (store.form.id && store.uploadPath)) ? true : false"-->
                                <!--                                    v-model="store.form.path">-->
                                <!--                                </file-upload>-->
                                <FilePond
                                    v-if="store.showModal"
                                    file-size="8MB"
                                    inputName="tmp_file"
                                    accepted-file-types="application/doc,application/docx,application/pdf"
                                    url="/file-upload-document"
                                    :disabled="(store.form.is_external_link || (store.form.id && store.uploadPath)) ? true : false"
                                    @processed-file="uploadedFile"
                                />


                            </div>

                            <div class="col-md-4">
                                <label v-if="store.form.id && store.uploadPath" class="document-item small">
                                    <div class="document-content item px-2">
                                        <i class="bx bx-file icon"></i>
                                        <i class="bx bx-trash d-none icon hidden-icon" @click="store.deleteFile()"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <Select2
                                    class="mt-2"
                                    placeholder="Tags"
                                    v-model="store.form.tags"
                                    :settings="{multiple: true}"
                                    :options="tagStore.tagOptions"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-5 ps-md-0">
                        <div class="accordion collection-accordion no-arrow h-450 custom-scroll card p-0 pt-3 pb-4"
                             id="documentAccordion">
                            <DocumentLocation
                                :level="1"
                                :collections="collectionStore.collections">
                            </DocumentLocation>
                        </div>
                    </div>
                </div>

                <ModalFooter class="px-0 py-2 d-flex flex-row-reverse justify-content-between">
                    <button type="button" class="btn btn-info" @click="handleSubmit($event, store.handleSubmit)">Save
                        Changes
                    </button>
                    <button type="button" class="btn btn-outline-danger ps-2" v-if="store.form.id"
                            @click="store.delete()">
                        <i class="bx bx-x-circle me-1"></i> Delete Document
                    </button>
                </ModalFooter>
            </v-form>
        </template>
    </Modal>
</template>

<style>
.light-style .select2-dropdown {
    z-index: 9999;
}
</style>
