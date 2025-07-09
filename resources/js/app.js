import VeeValidatePlugin from '@/plugin/vee-validate';
import autosize from 'autosize';
import {createPinia} from 'pinia';
import {createApp} from 'vue';
import './bootstrap';

/* core components */
import Example from '@/components/Example';
import ModalExample from '@/components/ModalExample';
import Avatar from '@/components/Shared/Avatar';
import CardHeader from '@/components/Shared/CardHeader';
import Dropdown from '@/components/Shared/Dropdown';
import DropdownLink from '@/components/Shared/DropdownLink';
import FilePreview from '@/components/Shared/File/FilePreview';
import FileUpload from '@/components/Shared/File/FileUpload';
import Flash from '@/components/Shared/Flash';
import Flatpickr from '@/components/Shared/Flatpickr';
import CustomInput from '@/components/Shared/form/CustomInput';
import InputGroup from '@/components/Shared/form/InputGroup';
import Modal from '@/components/Shared/Modal';
import ModalFooter from '@/components/Shared/ModalFooter';
import SectionHeader from '@/components/Shared/SectionHeader';
import Select2 from '@/components/Shared/Select2';
import Stepper from "@/components/Shared/Stepper";
import Cell from '@/components/Shared/table/Cell';
import VueTrix from "@/components/Shared/VueTrix.vue";
import Datatable from '@/components/Shared/table/Datatable';
import EmptyRow from '@/components/Shared/table/EmptyRow';
import Filter from '@/components/Shared/table/Filter';
import Heading from '@/components/Shared/table/Heading';
import Pagination from '@/components/Shared/table/Pagination';
import Row from '@/components/Shared/table/Row';
import NotFound from '@/components/Shared/NotFound';
import HeaderCartIcon from '@/components/Shared/HeaderCartIcon';
import VueApexCharts from "vue3-apexcharts";



/* NFP components */
import HeaderMessageCount from '@/components/Messages/HeaderMessageCount';
import CollectionManagement from '@/components/Collections/CollectionManagement';
import DocumentCollection from '@/components/DocumentManagement/DocumentCollection';
import DocumentManagement from '@/components/DocumentManagement/DocumentManagement';
import Document from '@/components/Documents/Document';
import LegalRequest from '@/components/Legals/LegalRequest';
import OrganisationSettings from '@/components/Organisations/Settings';
import LegalAdminDashboard from '@/components/Legals/LegalAdminDashboard';
import NfpAdminDashboard from '@/components/Nfp/Dashboard';


import Post from '@/components/Posts/Post';
import PostForm from '@/components/Posts/PostForm';
import PostDetails from '@/components/Posts/PostDetails';
import TagManagement from '@/components/Tags/TagManagement';
import User from '@/components/User';
import Workflows from '@/components/Workflows';
import OrderManagement from '@/components/Orders/OrderManagement';
import Organisation from '@/components/Organisations/Organisation';
import OrganisationDetails from '@/components/Organisations/OrganisationDetails';
import AppChat from '@/components/Messages/AppChat';
import CategoryIndex from "@/components/Category/CategoryIndex.vue";
import OurOfferList from "@/components/OurOffers/OurOfferList.vue";
import CartDetails from "@/components/Cart/CartDetails.vue";

import OrganisationList from '@/components/Organisations/OrganisationList';


const pinia = createPinia();
const app = createApp({
    components: {
        Flash,
        Example,
        ModalExample,
        User,
        Post,
        PostForm,
        PostDetails,
        Workflows,
        LegalRequest,
        SectionHeader,
        OrganisationSettings,
        LegalAdminDashboard,
        NfpAdminDashboard,
        CartDetails,
        TagManagement,
        CollectionManagement,
        DocumentManagement,
        DocumentCollection,
        Document,
        OrderManagement,
        Organisation,
        OrganisationDetails,
        AppChat,
        HeaderMessageCount,
        CategoryIndex,
        OurOfferList,
        OrganisationList
    },
    data() {
        return {
            id: null
        }
    },
    methods: {
        onSubmit(values) {
            console.log('mixin: ', values)
            flash('Test flash message', values.name)
            //alert(JSON.stringify(values, null ,2));
        },

        swalConfirm(msg = 'Are you sure?') {
            confirm(msg, {confirmButtonText: 'Yes!'}).then(isTrue => console.log(isTrue));
        },

        swl(msg, title = 'Sent!', type = 'success') {
            flashSwal(msg, title, type);
        }
    }
});

// Global component
app
    .component("Select2", Select2)
    .component("Modal", Modal)
    .component("ModalFooter", ModalFooter)
    .component("Datatable", Datatable)
    .component("Pagination", Pagination)
    .component("Filter", Filter)
    .component("Heading", Heading)
    .component("Row", Row)
    .component("Cell", Cell)
    .component("VueTrix", VueTrix)
    .component("EmptyRow", EmptyRow)
    .component("InputGroup", InputGroup)
    .component("CustomInput", CustomInput)
    .component("Flatpickr", Flatpickr)
    .component("Dropdown", Dropdown)
    .component("FileUpload", FileUpload)
    .component("FilePreview", FilePreview)
    .component("DropdownLink", DropdownLink)
    .component("Avatar", Avatar)
    .component("Stepper", Stepper)
    .component("NotFound", NotFound)
    .component("HeaderCartIcon", HeaderCartIcon)
    .component("HeaderMessageCount", HeaderMessageCount)
    .component("CardHeader", CardHeader)
    .component("apexchart", VueApexCharts);


app.config.globalProperties.$closeModal = () => emitter.emit('closeModal');

app.config.globalProperties.$setLoadingSpinner = (state = false) => state ? 'loader' : '';

app.config.compilerOptions.isCustomElement = (tag) => tag.startsWith('trix-editor');

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

app.directive('focus', (el) => el.focus());

app.use(pinia);
app.use(VeeValidatePlugin);
app.use(VueApexCharts);
app.mount('#app');


// navbar app
const headerApp = createApp();
headerApp.component("HeaderCartIcon", HeaderCartIcon)
headerApp.component("HeaderMessageCount", HeaderMessageCount)
headerApp.use(pinia);
headerApp.mount('#layout-navbar');
