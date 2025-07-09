import useDatatableFunc from "@/composables/useDatatableFunc.js";
import { user } from "@/core/endpoints";
import axios from 'axios';
import { defineStore } from 'pinia';
import { computed, reactive, ref } from 'vue';

const { getItemAndMetaData } = useDatatableFunc();

export const useUserStore = defineStore('UserStore', () => {
    const users = ref([]);
    const meta = ref({});
    const userForm = ref(null);
    let loading = ref(false);
    let showModal = ref(false);
    const form = reactive({
        id: null,
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        role: '',
        status: '',
    });

    const totalUser = computed(() => meta.value?.total ?? users.value.length);

    async function getUsers() {
        loading.value = true
        
        try {
            const result = await axios.get(`${user}/all`);
            const response = getItemAndMetaData(result.data);
            users.value = response.items;
            meta.value = response.meta;
        }
        catch (error) {
            const message = error.response?.data?.message ?? error.message;
            flash(message, "danger");
        }
        finally {
            loading.value = false
        }
    }

    function handleAddUser() {
        showModal.value = true;
        console.log(userForm.value.resetForm());
    }

    return {users, meta, form, loading, showModal, userForm, totalUser, getUsers, handleAddUser};
});