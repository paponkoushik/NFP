import { useUrlFunc } from "../useUrlFunc";
import useUtilsFunc from "../useUtilsFunc";
import { useOfferStore } from "../../stores/OfferStore";
import {onMounted, reactive} from "vue";

export function useOwnOrderComposable() {
    const { statusOfferClass, priceTypeOfferClass } = useUtilsFunc();
    const { getUrlParams, pushUrlState } = useUrlFunc();

    const store = useOfferStore();

    const urlQueryParams = getUrlParams();

    // const state = reactive({
    //     page     : 1,
    //     limit    : store.meta.limit,
    //     search   : '',
    //     orderBy  : '',
    //     direction: '',
    // });

    const fetch = async () => {
        await store.fill();
    }

    const pageChange = async ({page, limit}) => {
        pushUrlState({page, limit})
        await store.fill();
    }

    onMounted(async () => {
        await fetch();
    });

    return {
        statusOfferClass,
        priceTypeOfferClass,
        store,
        fetch,
        pageChange
    }
}
