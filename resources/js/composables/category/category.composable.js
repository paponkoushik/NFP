import {reactive, onMounted, ref, watch, nextTick} from "vue";
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import {useUrlFunc} from '@/composables/useUrlFunc.js';
import {useCategoryStore} from "@/stores/CategoryStore";
import debounce from "lodash/debounce";
import {COST_OPTIONS, TYPES, WHEN_OPTIONS} from "../../core/categories_data";

export function useCategoryComposable() {
    const {statusBgClass} = useUtilsFunc();
    const {getUrlParams, pushUrlState} = useUrlFunc();

    // use store
    const store = useCategoryStore();


    const urlQueryParams = getUrlParams();

    const state = reactive({
        page     : 1,
        limit    : store.meta.limit,
        search   : '',
        orderBy  : '',
        direction: '',
    });

    const search = ref(urlQueryParams?.search || '');

    watch(
        search,
        debounce(function (search) {
            state.search = search;
            pushUrlState({search, page: 1})
            fetch();
        }, 500)
    );

    function createHandler() {
        console.log("createHandler")
        store.view = "form";
        store.resetForm();
    }

    function onSubmit() {
        store.submit()
            .catch(errors => {
                categoryForm.value.setErrors(errors)
            });
    }

    function fetch() {
        store.fill();
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

    const typeChangeHandler = (event) => {
        if (event.target.checked) {
            nextTick(() => {
                store.form.custom_label.type = {};
                TYPES.forEach((type) => {
                    // add type to form
                    // store.form.custom_label.type[type] = ''; // it will throw error undefined
                    store.form.custom_label.type[type] = '';
                });

                nextTick(() => {
                    store.isTypeLabels = true;
                });
            });
        } else {
            store.isTypeLabels = false;
            delete store.form.custom_label.type;
        }
    };

    const whereChangeHandler = () => {
        if (store.isWhereLabels) {
            store.form.custom_label.where = '';
            return;
        }
        delete store.form.custom_label.where;
    }

    const whenChangeHandler = (event) => {
        if (event.target.checked) {
            nextTick(() => {
                store.form.custom_label.when = {
                    title: ''
                };
                WHEN_OPTIONS.forEach((when) => {
                    store.form.custom_label.when[when] = '';
                });

                nextTick(() => {
                    store.isWhenLabels = true;
                });
            });
        } else {
            store.isWhenLabels = false;
            delete store.form.custom_label.when;
        }
    };

    const costChangeHandler = (event) => {
        if (event.target.checked) {
            nextTick(() => {
                store.form.custom_label.cost = {
                    title: ''
                };
                COST_OPTIONS.forEach((cost) => {
                    store.form.custom_label.cost[cost] = '';
                });

                nextTick(() => {
                    store.isCostLabels = true;
                });
            });
        } else {
            store.isCostLabels = false;
            delete store.form.custom_label.cost;
        }
    };

    const summaryChangeHandler = (event) => {
        if (event.target.checked) {
            nextTick(() => {
                store.form.custom_label.summary = {
                    label      : '',
                    placeholder: ''
                };

                nextTick(() => {
                    store.isSummaryLabels = true;
                });
            });
        } else {
            store.isSummaryLabels = false;
            delete store.form.custom_label.summary;
        }
    };

    const pageChange = ({page, limit}) => {
        pushUrlState({page, limit})
        store.fill();
    }

    onMounted(() => {
        fetch();
        store.getSelect2Options();
    });

    return {
        statusBgClass,
        store,
        search,
        createHandler,
        onSubmit,
        fetch,
        sortByColumn,
        pageChange,
        typeChangeHandler,
        whereChangeHandler,
        whenChangeHandler,
        costChangeHandler,
        summaryChangeHandler,
    };
}
