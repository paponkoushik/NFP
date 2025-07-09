<script setup>
    import { onMounted, ref, reactive, computed, watch } from 'vue';

    const props = defineProps({
        title: String,
        maxWidth: String, // .modal-{sm|lg|xl}
        position: String, // .modal-{dialog-centered|fullscreen}
        id: {
            type: String,
            default: 'modal'
        },
        backdrop: {
            type: String,
            default: 'static'
        },
        bodyClass: {
            type: String,
            default: 'py-2'
        },
        footerClass: {
            type: String,
            default: 'pb-3'
        },
        formAction: String,
        show: Boolean
    });

    let emit = defineEmits(['close']);

    const modal = ref(null);

    let state = reactive({
        modal: null
    });

    onMounted(() => {
        window.emitter.on('closeModal', () => closeModal());
    });

    const modalPosition = computed(() => {
        let position = {
            centered: 'modal-dialog-centered',
            fullscreen: 'modal-fullscreen'
        }
        return position[props.position] || null;
    });

    watch(props, (newPropsVal) => {
        if(newPropsVal.show) {
            openModal();
        }
    }, {deep: true});


    function openModal() {
        if(!state.modal) {
            state.modal = new bootstrap.Modal(modal.value, {
                keyboard: false
            });

            jQuery(modal.value).on('shown.bs.modal', function() {
                //jQuery(this).find('[autofocus]').focus();
                jQuery(this).find('[data-bs-toggle="tooltip"]').tooltip();
            });
        }

        state.modal.show();

        //   const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        //   tooltipTriggerList.map(function (tooltipTriggerEl) {
        //     return new bootstrap.Tooltip(tooltipTriggerEl);
        //   });
    }

    function closeModal() {
        if(state.modal) {
            emit('close');
            state.modal.hide();
        }
    }
</script>

<template>
    <Teleport to="body">
        <!-- Modal -->
        <div
            ref="modal"
            class="modal fade"
            :data-bs-backdrop="props.backdrop"
            data-bs-focus="false"
            aria-hidden="true"
            tabindex="-1"
        >
            <div
                :class="{
                    'modal-dialog': true,
                    [`modal-${props.maxWidth}`]: props.maxWidth ? true : false,
                    [modalPosition]: props.position ? true : false,
                }"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="header">
                            <h5 v-if="props.title" class="modal-title">{{ props.title }}</h5>
                        </slot>

                        <button
                            type="button"
                            class="btn-close"
                            aria-label="Close"
                            @click="closeModal()"></button>
                    </div>

                    <div :class="`modal-body ${props.bodyClass}`">
                        <slot name="body" />
                    </div>

                    <div v-if="$slots.footer" :class="`modal-footer ${props.footerClass}`">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
