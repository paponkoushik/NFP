import { defineStore } from "pinia/dist/pinia";
import { useUrlFunc } from '@/composables/useUrlFunc.js';
import {cancelOffer, listOffers, ownOffers} from "../core/endpoints";
import useDatatableFunc from "../composables/useDatatableFunc";

const { getUrlParams, buildURLQuery } = useUrlFunc();
const { getItemAndMetaData } = useDatatableFunc();

export const useOfferStore = defineStore('OrderStore', {
    state: () => ({
        meta: {},
        loading: false,
        ownOffers: [],
        openOfferCancelModal: false,
        openOfferDetailsModal: false,
        offerId: null,
        ownOffer: {},
        postId: null,
    }),

    getters: {
        totalOwnOffers() {
            return this.meta?.total ?? this.ownOffers.length;
        },
    },

    actions: {
        async fill() {
            this.loading = true
            const urlParams = buildURLQuery(getUrlParams(), true);
            try {
                let url = `${ownOffers}${urlParams ? `?${urlParams}` : ''}`
                if (this.postId) {
                    url = `${listOffers}/${this.postId}${urlParams ? `?${urlParams}` : ''}`
                }
                const result = await axios.get(url)
                const {data, meta} = getItemAndMetaData(result.data);
                this.ownOffers = data
                this.meta = meta
            } catch (e) {
                console.log(e)
            } finally {
                this.loading = false;
            }
        },

        openCancelDialog(offerId) {
            this.offerId = offerId
            this.openOfferCancelModal = true
        },

        closeOfferCancelModal() {
            this.offerId = null
            this.openOfferCancelModal = false
            emitter.emit('closeModal')
        },

        async cancelOffer() {
            try {
                const response = await axios.put(`${cancelOffer}/${this.offerId}`);
                await this.fill()
                this.openOfferCancelModal = false
                emitter.emit('closeModal')
            } catch (e) {
                console.log(e)
            }
        },
    }
})
