<script setup>
    import { useUserStore } from "@/stores/UserStore";
    import { ref, reactive, onMounted } from "vue";
    import useUtilsFunc from '@/composables/useUtilsFunc.js';
    import { useUrlFunc } from '@/composables/useUrlFunc.js';

    const { textAvatarBgClass, statusBgClass } = useUtilsFunc();
    const { buildURLQuery } = useUrlFunc();

    defineProps({
        roles: {
            type: Array,
        }
    });
    // use store
    const store = useUserStore();

    const userForm = ref(null);
    const state = reactive({
        page: 1,
        limit: store.meta.limit,
        query: '',
        orderBy: '',
        direction: '',
    });

    onMounted(() => {
        store.getUsers();
    });

    function handleAddUser() {
        store.showModal = true;
        userForm.value.resetForm();
    }

    function onSubmit() {
        store.submit().catch(errors => {
            userForm.value.setErrors(errors)
        });
    }

    function fetch(key, value) {
        state[key] = value;

        let requestParam = { page: state.page, limit: state.limit }

        console.log(state.orderBy);
        if (state.orderBy !== "") {
            requestParam["orderBy"] = state.orderBy;
            requestParam["direction"] = state.direction;
        }

        if (state.query !== "")
            requestParam["query"] = state.query;

        const urlParams = buildURLQuery(requestParam);
        // history.pushState(null, null, `?${urlParams}`);

        store.getUsers(urlParams);
    }

    function sortByColumn(fieldName) {
        if (fieldName == state.orderBy && state.direction == 'asc') {
            state.direction = "desc";
        } else {
            state.orderBy = fieldName;
            state.direction = "asc";
        }

        fetch();
    }
</script>

<template>
    <div class="col-12">
        <div class="card">
            <Datatable table-class="less-padding">
                <CardHeader title="Users">
                    <div class="dt-buttons">

                        <!-- <div class="btn-group me-3">
                            <button class="btn btn-label-primary btn-sm dropdown-toggle px-2 fw-semibold" type="button" id="exportMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-show me-1"></i>Export
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="exportMenu" style="min-width: 5rem;">
                                <li class="dropdown-item"><span><i class="bx bx-printer me-2"></i>Print</span></li>
                                <li class="dropdown-item"><span><i class="bx bx-file me-2"></i>Csv</span></li>
                                <li class="dropdown-item"><span><i class="bx bxs-file-pdf me-2"></i>Pdf</span></li>
                                <li class="dropdown-item"><span><i class="bx bx-copy me-2"></i>Copy</span></li>
                            </ul>
                        </div> -->

                        <button class="btn btn-info btn-sm fw-semibold" type="button" @click="handleAddUser">
                            <i class="bx bx-plus me-2"></i> <span class="d-none d-lg-inline-block">Add New User</span>
                        </button>
                    </div>
                </CardHeader>
                <Filter :total-item="store.totalUser" :limit="store.meta.limit" @event-action="fetch"></Filter>

                <template #head>
                    <Heading @click="sortByColumn('first_name')">Full Name</Heading>
                    <Heading>Email</Heading>
                    <Heading>Contact No</Heading>
                    <Heading>Join</Heading>
                    <Heading>Status</Heading>
                    <Heading :sortable="false">Action</Heading>
                </template>

                <template #body>
                    <template v-if="store.totalUser > 0">
                        <transition-group name="fade">
                            <Row v-for="user in store.users" :key="user.id">
                                <Cell>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2">
                                                <img v-if="user.avatar" :src="user.avatar" alt="Avatar" class="rounded-circle" />
                                                <span v-else class="avatar-initial rounded-circle" :class="textAvatarBgClass()" v-text="user.short_name"></span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <span class="text-truncate" v-text="user.full_name"></span>
                                            <small class="text-capitalize text-truncate text-muted">{{ user.role.replace("-", " ") }}</small>
                                        </div>
                                    </div>
                                </Cell>
                                <Cell>{{ user.email }}</Cell>
                                <Cell>{{ user.phone }}</Cell>
                                <Cell>{{ user.created }}</Cell>
                                <Cell>
                                    <span class="text-capitalize badge rounded px-3" :class="statusBgClass(user.status)" v-text="user.status"></span>
                                </Cell>
                                <Cell>
                                    <!-- <Dropdown>
                                        <DropdownLink icon="bx bxs-edit" modal>Edit</DropdownLink>
                                        <DropdownLink icon="bx bxs-search">Details</DropdownLink>
                                        <DropdownLink icon="bx bxs-trash">Delete</DropdownLink>
                                    </Dropdown> -->
                                    <a href="javascript:void(0);" class="btn btn-sm btn-icon" @click="store.handleUserEdit(user)">
                                        <i class="bx bxs-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-icon" @click="store.delete(user)">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </Cell>
                            </Row>
                        </transition-group>
                    </template>

                    <template v-else>
                        <Row>
                            <td colspan="7">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="font-medium py-8 text-cool-gray-400 text-xl">No users found...</span>
                                </div>
                            </td>
                        </Row>
                    </template>
                </template>

                <template #footer>
                    <Pagination :meta="store.meta" @event-action="fetch"></Pagination>
                </template>
            </Datatable>
        </div>

        <Modal
            :show="store.showModal"
            @close="store.showModal = false"
            :title="store.form.id ? 'Edit User' : 'Add New User'"
        >

            <template #body>
                <v-form ref="userForm" @submit="onSubmit">

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <InputGroup label="First Name">
                                <v-field name="first_name" label="first name" rules="required" v-model="store.form.first_name" v-slot="{ field, errors }">
                                    <input type="text"
                                        class="form-control"
                                        :class="{'is-invalid': errors[0]}"
                                        placeholder="Enter First Name"
                                        v-bind="field"
                                    />
                                    <error-message :class="{'invalid-feedback': errors[0]}" name="first_name"></error-message>
                                </v-field>
                            </InputGroup>
                        </div>

                        <div class="col-12 col-sm-6">
                            <InputGroup label="Last Name">
                                <v-field name="last_name" label="last name" rules="required" v-model="store.form.last_name" v-slot="{ field, errors }">
                                    <input type="text"
                                        class="form-control"
                                        :class="{'is-invalid': errors[0]}"
                                        placeholder="Enter Last Name"
                                        v-bind="field"
                                    />
                                    <error-message :class="{'invalid-feedback': errors[0]}" name="last_name"></error-message>
                                </v-field>
                            </InputGroup>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <InputGroup label="Phone" :required="false">
                                <v-field name="phone" rules="" v-model="store.form.phone" v-slot="{ field, errors }">
                                    <input type="text"
                                        class="form-control"
                                        :class="{'is-invalid': errors[0]}"
                                        placeholder="Enter Phone"
                                        v-bind="field"
                                    />
                                    <error-message :class="{'invalid-feedback': errors[0]}" name="phone"></error-message>
                                </v-field>
                            </InputGroup>
                        </div>

                        <div class="col-12 col-sm-6">
                            <InputGroup label="Role">

                                <v-field name="role" rules="required" v-model="store.form.role" v-slot="{ field, errors }">
                                    <select class="form-select text-capitalize" :class="{'is-invalid': errors[0]}" v-bind="field">
                                        <option disabled selected value=""> Choose user role </option>
                                        <option v-for="role in roles" :value="role" :key="role">{{ role.replace('-', ' ') }}</option>
                                    </select>
                                    <error-message :class="{'invalid-feedback': errors[0]}" name="role"></error-message>
                                </v-field>
                            </InputGroup>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <InputGroup label="Email">
                                <v-field name="email" rules="required" v-model="store.form.email" v-slot="{ field, errors }">
                                    <input type="email"
                                        class="form-control"
                                        :class="{'is-invalid': errors[0]}"
                                        placeholder="Enter Email"
                                        v-bind="field"
                                    />
                                    <error-message :class="{'invalid-feedback': errors[0]}" name="email"></error-message>
                                </v-field>
                            </InputGroup>
                        </div>
                    </div>

                    <ModalFooter class="px-0 py-2">
                        <button type="submit" class="btn btn-info">Save Changes</button>
                    </ModalFooter>
                </v-form>
            </template>
        </Modal>
    </div>
</template>
