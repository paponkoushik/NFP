import VeeValidatePlugin from '@/plugin/vee-validate';
import autosize from 'autosize';
import { createPinia } from 'pinia';
import { createApp } from 'vue';
import './bootstrap';

/* core components */
import Flash from '@/components/Shared/Flash';

/* NFP components */
import OrgRegister from '@/components/Web/Register/OrgRegister';

const pinia = createPinia();
const app = createApp({
    components: {
        Flash,
        OrgRegister
    }
});

app.config.globalProperties.$setLoadingSpinner = (state = false) => state ? 'loader' : '';

app.config.compilerOptions.whitespace = 'preserve';

// Custom directives
app.directive('autosize', {
    mounted(el) {
        autosize(el);
    },

    updated(el) {
        autosize.update(el);
    },

    unmounted(el) {
        autosize.destroy(el);
    }
});

app.use(pinia);
app.use(VeeValidatePlugin);
app.mount('#app');