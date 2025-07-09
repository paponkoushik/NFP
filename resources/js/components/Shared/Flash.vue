<template>
    <transition 
        name="custom-classes"
        enter-active-class="animate__animated animate__shakeX"
        leave-active-class="animate__animated animate__bounceOutRight"
    >
    <div 
        :class="`bs-toast toast toast-ex my-2 show bg-${type}`"
        role="alert" 
        v-show="show"
    >
        <div class="toast-header">
            <i :class="`bx bx-${icons[type] || 'bell'} me-2`"></i>
            <div class="me-auto fw-semibold">{{ alertTypes[type] || 'INFO' }}</div>
            
            <button type="button" class="btn-close" @click="closed()" aria-label="Close"></button>
        </div>
        <div class="toast-body" v-html="msg"></div>
    </div>
    </transition>
</template>

<script>
	export default {
        props: {
            message: String,

            level: {
                default: 'success'
            },

            important: {
                default: false
            },

            icon: {
                default: true
            },
        },

        data() {
            return {
                timerId: null,
                msg: this.message,
                type: this.level,
                alwaysVisible: this.important,
                show: false,
                icons: {
                    'success': 'check',
                    'warning': 'error',
                    'danger': 'error-circle',
                    'default': 'bell',
                },
                alertTypes: {
                    'success': 'SUCCESS!',
                    'warning': 'WARNING!',
                    'info': 'INFO!',
                    'danger': 'ERROR!',
                    'error': 'ERROR!'
                }
            }
        },

        created() {
            if (this.message) {
                this.flash();
            }

            window.emitter.on(
                'flash', data => this.flash(data)
            )
        },

        methods: {
            flash(data) {
                if (data) {
                    this.msg = data.message;
                    this.type = data.level;
                    this.alwaysVisible = data.important;
                }
                
                this.show = true;

                if (!this.alwaysVisible) {
                    this.hide();
                }
            },

            hide() {
                this.clearTimerId();
                this.timerId = setTimeout(() => this.show = false, 5000);
            },

            clearTimerId() {
                this.timerId ? clearTimeout(this.timerId) : null
            },

            closed() {
                this.show = false;
            }
        }
	}
</script>
