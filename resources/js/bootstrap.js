// import _ from 'lodash';
// window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.moment = require('moment')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import mitt from 'mitt';
import Swal from 'sweetalert2';
import { loadProgressBar } from '@/plugin/nprogress/axios-nprogress';

window.emitter = mitt();

loadProgressBar();
//window.Swal = Swal;

/* window.Vue = require('vue').default;
import ModalPlugin from './plugins/modal';
Vue.use(ModalPlugin);
window.events = new Vue(); */

window.flash = function(message, level = 'success', important = false) {
    emitter.emit('flash', {
        message,
        level,
        important
    });
};

window.flashSwal = function(msg, title = 'Success!', type = 'success', $timer = 5000) {
    Swal.fire({
        icon: type,
        title: title,
        text: msg,
        timer: type == 'error' ? ($timer > 5000 ? $timer : 5000) : $timer
    });
};

window.confirm = function(title = 'Are you sure?', obj = {}) {
    return Swal.fire({
        title: title,
        text: 'You won\'t be able to revert this!', 
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        customClass: {
            confirmButton: 'btn btn-danger me-1',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false,
        ...obj 
    }).then((result) => {
        return result.value || false
    });
};

window.fullPageLoader = {
    targetId: 'fullpage-spinner',
    
    show: function () {
        document.getElementById(this.targetId).classList.add("show");
    },

    hide: function () {
        document.getElementById(this.targetId).classList.remove("show");
    }
};


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
