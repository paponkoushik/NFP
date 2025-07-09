<script setup>
import {useOrderStore} from "@/stores/OrderStore";
import useUtilsFunc from "@/composables/useUtilsFunc.js";
import {useUrlFunc} from "../../composables/useUrlFunc";
import {debounce} from "lodash";
import {onMounted, reactive} from "vue";

const store = useOrderStore();

const {textAvatarBgClass} = useUtilsFunc();

const downloadLink = (orderId) => {
  return `/invoicepdf?download=pdf&id=${orderId}`; // Replace this with the actual route or URL for downloading the invoice
};

const filter = reactive({
    query: ''
});

const {pushUrlState, getUrlParams} = useUrlFunc();

function pageChange({page, limit}) {
    store.fill({page, limit})
}

const handleFilter = () => {
    const params = _.pickBy(filter);
    pushUrlState(params)

    store.fill({page: 1, limit: 10, ...params});

};

const setDefaultUrlParams = () => {
    const urlParams = getUrlParams();
    if (urlParams && Object.keys(urlParams).length) {
        filter.query = urlParams.query || '';
    }
};

const handleSearch = debounce(function (e) {
    const currentStr = e.target.value;
    const prevStr = filter.query;
    console.log(currentStr, prevStr)

    if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
        return;
    }
    filter.query = currentStr;

    handleFilter();
}, 500)

onMounted(() => {
    setDefaultUrlParams();
    handleFilter();
});
</script>

<template>
    <div class="row">
        <div class="col-12">
            <div class="card" style="min-height: 75vh;">
                <Datatable>
                    <CardHeader title="Orders" class="pb-3">
                        <div class="dt-buttons">
                            <div class="input-group input-group-merge input-group-sm">
                                <span class="input-group-text" id="basic-addon-search31"><i
                                    class="bx bx-search"></i></span>
                                <input type="text" class="form-control form-control-sm" placeholder="Search..."
                                       aria-label="Search..." aria-describedby="basic-addon-search31"
                                       :value="filter.query" @keyup="handleSearch">
                            </div>
                        </div>
                    </CardHeader>

                    <template #head>
                        <Heading sortable>#Order</Heading>
                        <Heading sortable>Purchase Date</Heading>
                        <Heading sortable>Amount</Heading>
                        <Heading sortable>No. Doc</Heading>
                        <Heading></Heading>
                    </template>

                    <template #body>
                        <template v-if="store.totalOrders > 0">
                            <transition-group name="fade">
                                <Row v-for="order in store.orders" :key="order.id">
                                    <Cell><a :href="`/invoice/${order.id}`">#{{ order.order_no }}</a></Cell>
                                    <Cell>{{ order.created }}</Cell>
                                    <Cell>
                                        <div class="text-muted lh-1">
                                            <span class="text-info fw-semibold">${{ order.total_amount }}</span>
                                        </div>
                                    </Cell>
                                    <Cell>
                                        <span class="badge bg-label-secondary rounded-pill badge-center">
                                            {{ order.docs_count }}
                                        </span>
                                    </Cell>
                                    <Cell class="text-nowrap">
                                        <div class="d-flex justify-content-end">
                                            <a :href="downloadLink(order.id)" class="btn btn-icon me-2 btn-label-secondary">
                                                <span class="tf-icons bx bx-download"></span>
                                            </a>
                                        </div>
                                    </Cell>
                                </Row>
                            </transition-group>
                        </template>

                        <template v-else>
                            <Row>
                                <td colspan="8">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span
                                            class="font-medium py-8 text-cool-gray-400 text-xl">No orders found...</span>
                                    </div>
                                </td>
                            </Row>
                        </template>
                    </template>

                    <template #footer>
                        <Pagination class="float-right" :meta="store.meta" @event-action="pageChange"></Pagination>
                    </template>
                </Datatable>
            </div>
        </div>
    </div>
</template>
