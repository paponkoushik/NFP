import { useUrlFunc } from '@/composables/useUrlFunc.js';
import { chat, message } from "@/core/endpoints";
import { defineStore } from 'pinia';
import {
    changeMessageSeenTime,
    listMessage,
    makeOffer,
    offerUpdate,
    organizationMessage,
    unSeenMessagesNumber
} from "../core/endpoints";

const { buildURLQuery, pushUrlState } = useUrlFunc();

export const useChatStore = defineStore('ChatStore', {
    state: () => ({
        groups: {},
        contacts: [],
        messages: [],
        authUser: {},
        groupKey: {},
        activeChat: {},
        loading: false,
        message: "",
        showOfferField: true,
        showFromOrgAnonymousCheckBox: true,
        fromOrgAnonymous: true,
        openFromOrgAnonymousConfirmModal: false,
        anonymousDialogCheckBox: true,
        toOrgAnonymous: true,
        isOffered: false,
        offer_amount: null,
        openOfferModal: false,
        newOfferAmount: null,
        unSeenMessageCount: 0,
        autoSelectedIndex: 0,
        pushAbleUrl: window.origin + '/messages',
    }),

    getters: {
        totalContacts() {
            return this.groups.length + this.contacts.length;
        },
    },

    actions: {
        async fill(params) {
            this.loading = true;
            const urlParams = buildURLQuery(params, true);

            try {
                const response = await axios.get(`${chat}${urlParams ? `?${ urlParams }` : ''}`);
                this.setGroups(response.data.groups)

                this.contacts = response.data.contacts.sort((c1, c2) => (c1.latest_message_at < c2.latest_message_at) ? 1 : (c1.latest_message_at > c2.latest_message_at) ? -1 : 0);
                this.setActiveChat();
            }
            catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
            this.loading = false
        },

        setGroups(groupMessages) {
            const filteredGroups = groupMessages.filter((item) => ! _.isEmpty( item.communications ))

            if (! _.isEmpty(filteredGroups)) {
                this.groups = filteredGroups.sort((g1, g2) => {
                    return (g1.latest_message_at < g2.latest_message_at) ? 1 : (g1.latest_message_at > g2.latest_message_at) ? -1 : 0
                })

                this.groups.forEach(item => {
                    return item.communications.sort((c1, c2) => {
                        return (c1.latest_message_at < c2.latest_message_at) ? 1 : (c1.latest_message_at > c2.latest_message_at) ? -1 : 0
                    })
                })
            }
        },

        setActiveChat() {
            let comms = {};

            if (this.groups.length) {
                comms = this.groups[0]?.communications[0];
                // const obj = {
                //     org: this.groups[0]?.communications[0].from_org_id,
                //     list: this.groups[0].id
                // }
                // pushUrlState(obj)

                if (window.location.search.length > 0) {
                    const split = window.location.search.split('?')[1].split('&')

                    if ( split.length > 1) {
                        const orgId = split[0].split('=')[1]
                        const listId = split[1].split('=')[1]

                        this.autoSelectedIndex = this.groups.findIndex(item => item.id === listId)
                        this.groups.forEach( item => {
                            if (item.id === listId) {
                                item.communications.forEach(element => {
                                    if (element.from_org_id === orgId) {
                                        comms = element
                                    }
                                })
                            }
                        })
                    } else {
                        const orgId = split[0].split('=')[1]
                        comms = this.contacts.find(({ from_org_id }) => from_org_id === orgId);
                    }

                }

            }
            else if (this.contacts.length) {
                comms = this.contacts[0];
            }

            this.getChatHistory(comms)
        },

        pushCommsUrl(communication) {
            const obj = {
                org: communication.from_org_id,
                list: communication.listing_id
            }
            pushUrlState(obj)
        },

        async getChatHistory(communication) {
            if (_.isEmpty(communication)) {
                return
            }
            this.activeChat = communication;
            this.loading = true;

            if(window.location.pathname === '/messages') {
                this.pushCommsUrl(communication)
            }

            try {
                const response = await axios.get(`${chat}/${communication.id}`);

                if (response.data.data.length > 0) {
                    this.buildMessages(response.data.data)
                }

            }
            catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            }
            this.loading = false
        },

        buildMessages(data) {
            const groupByDate= this.messageGroupBy(data, 'date')
            let number = 0

            const groupedData = Object.keys(groupByDate).map((key) => {
                const data = [key, groupByDate[key], number]
                number++
                return data
            });

            const sortedData = groupedData.sort((a, b) => {
                return b[2] - a[2]
            })

            sortedData.forEach(item => {
                return item[1].sort(
                    (i1, i2) => (i1.id > i2.id) ? 1 : (i1.id < i2.id) ? -1 : 0
                );
            })
            this.messages = sortedData

            // console.log(this.messages)

        },

        messageGroupBy(array, key) {
            return array.reduce(function(groupedArray, item) {
                (groupedArray[item[key]] = groupedArray[item[key]] || []).push(item);
                return groupedArray;
            }, {});
        },

        async offerAcceptOrReject(status) {
            this.loading = true
            this.activeChat.is_offered = false
            try {
                const formData = {
                    offer_status: status,
                    comms_id: this.activeChat.id
                };

                const response = await axios.put(`${offerUpdate}/${this.activeChat.id}`, formData);

                await this.getChatHistory(this.activeChat);
            } catch (e) {
                console.log(e)
                this.loading = false
            }
        },

        async sendMessage() {
            this.loading = true

            if (this.message == "" || this.message == null || _.isEmpty(this.activeChat)) {
                return false;
            }

            try {
                const formData = new FormData();

				formData.append('message', this.message);
				formData.append('comms_id', this.activeChat.id);
				formData.append('type', null);

                const response = await axios.post(chat, formData);
                this.message = ''
                this.getChatHistory(this.activeChat);
            }
            catch (error) {
                if (error.response.status == 422) {
                    const errors = "errors" in error.response.data ? error.response.data.errors : error.response.data;
                    throw errors;
                }

                flash(error.response.data.message, "danger");
            }
            this.loading = false
        },

        async sendNewMessage(params) {
            this.loading = true

            if (this.message == "" || this.message == null) {
                return false;
            }

            try {
                const formData = new FormData();

				formData.append('message', this.message);
				formData.append('from_org_anonymous', this.fromOrgAnonymous);
				formData.append('offered_amount', this.offer_amount ? this.offer_amount : null);
				formData.append('is_offered', this.offer_amount ? 1 : 0);
				formData.append('to_org_id', params.organisation?.id);
				formData.append('type', this.offer_amount ? 'offered' : null);
                if (params.listingId) {
                    formData.append('listing_id', params.listingId);
                }

                const response = await axios.post(message, formData);
                this.message = ''
                this.offer_amount = ''
                if (params.listingId) {
                    await this.getPreviousMessageForList(params.listingId)
                } else if (params.organisation?.id) {
                    await this.getPreviousMessageForOrganisation(params.organisation.id)
                }

            }
            catch (error) {
                if (error.response.status == 422) {
                    const errors = "errors" in error.response.data ? error.response.data.errors : error.response.data;
                    throw errors;
                }

                flash(error.response.data.message, "danger");
            }

            this.loading = false
        },

        async getPreviousMessageForList(listingId) {
            try {
                const response = await axios.get(`${listMessage}/${listingId}`)
                if (!_.isEmpty(response.data)) {
                    this.fromOrgAnonymous = response.data.from_org_anonymous
                    this.showFromOrgAnonymousCheckBox = response.data.from_org_anonymous
                    this.showOfferField = ! response.data.is_offered
                    this.offer_amount = response.data.is_offered.offered_amount
                    await this.getChatHistory(response.data)
                    this.pushAbleUrl = window.origin + `/messages?org=${response.data.from_org_id}&list=${listingId}`
                    console.log('calling list', this.pushAbleUrl)
                }

            } catch (error) {
                const message = error.response?.data?.message ?? error.message
                flash(message, 'danger')
            }
        },

        async getPreviousMessageForOrganisation(organisationId) {
            try {
                const response = await axios.get(`${organizationMessage}/${organisationId}`)

                if (!_.isEmpty(response.data)) {
                    this.pushAbleUrl = window.origin + `/messages?org=${response.data.from_org_id}`
                    await this.getChatHistory(response.data)
                }


            } catch (error) {
                const message = error.response?.data?.message ?? error.message
                flash(message, 'danger')
            }
        },
        openAnonymousDialog() {
            if (this.anonymousDialogCheckBox) {

                this.openFromOrgAnonymousConfirmModal = true
                this.anonymousDialogCheckBox = true

                return
            }
            this.anonymousDialogCheckBox = true
            this.fromOrgAnonymous = true
        },

        closeAnonymousDialog(fromOrgAnonymousValue) {
            this.fromOrgAnonymous = fromOrgAnonymousValue
            this.anonymousDialogCheckBox = fromOrgAnonymousValue
            emitter.emit('closeModal')
        },

        openOfferDialog() {
            this.openOfferModal = true
        },

        closeOfferDialog() {
            this.openOfferModal = false
            emitter.emit('closeModal')
        },

        async sendOffer() {
            try {
                const response = await axios.put(`${makeOffer}/${this.activeChat.id}`, {offered_amount: this.newOfferAmount});
                this.activeChat.is_offered = true
                this.activeChat.offered_amount = this.newOfferAmount
                this.openOfferModal = false
                emitter.emit('closeModal')
            } catch (e) {
                console.log(e)
            }
        },

        async getChatCount() {
            try {
                const response = await axios.get(unSeenMessagesNumber)

                this.unSeenMessageCount = response.data
            } catch (e) {
                console.log(e)
            }
        },

        async updateMessageSeenStatus() {
            try {
                if (! this.activeChat.id) return
                const response = await axios.put(`${changeMessageSeenTime}/${this.activeChat.id}`)

                this.unSeenMessageCount = response.data
            } catch (e) {
                console.log(e)
            }
        }

    }
});
