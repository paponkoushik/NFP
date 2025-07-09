<script setup>
    import LegalSupportModal from '@/components/Legals/LegalSupportModal';
    import ChatBox from '@/components/Shared/ChatBox';
    import { onMounted, ref } from "vue";
    import { useLocationStore } from "../../stores/LocationStore";

    const locationStore = useLocationStore();

    const props = defineProps({
        organisation: {
            type: Object,
            required: true,
        },

        canLegalSupport: {
            type: Boolean,
            default: true
        },
        authUserRole: {
            type: String,
            required: true,
        },
        googleApiKey: {
            type: String,
            required: false,
        }
    });
    onMounted(async () => {
        if (hasPrimaryLocation()) {
            callForLocation(
                null,
                props.organisation.org_locations.location.lat,
                props.organisation.org_locations.location.long,
                true
            )
        }
    });

    let selectedIndex = ref(null)
    let isPrimarySelected = ref(false)

    const callForLocation = (index, lat, long, isPrimary = false) => {
        isPrimarySelected.value = isPrimary
        selectedIndex.value = index
        locationStore.getLocationUrl(lat, long)
    }

    const hasPrimaryLocation = () => {
        return ! _.isEmpty(props.organisation.org_locations)
    }
</script>

<template>
    <slot name="heading" :organisation="organisation" />

    <section class="NFP-details">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12 col-sm-7 pe-0 pe-sm-5">
                    <section class="mt-2 py-3 px-4">
                        <h3 class="title text-uppercase mb-4">
                            {{ organisation.client_type }} Details
                        </h3>
                        <dl>
                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> Org Name: </dt>
                                <dd class="col-lg-7 m-0 text-truncate">
                                    <a href="#" class="text-blue">{{ organisation.org_name }}</a>
                                </dd>
                            </div>

                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> Org Type: </dt>
                                <dd class="col-lg-7 m-0 text-truncate">
                                    <a href="#" class="text-blue">{{ organisation.org_type }}</a>
                                </dd>
                            </div>

                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> Email: </dt>
                                <dd class="col-lg-7 m-0 text-truncate">
                                    <a href="#" class="text-blue">{{ organisation.contact_email }}</a>
                                </dd>
                            </div>

                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> Phone: </dt>
                                <dd class="col-lg-7 m-0 text-truncate">
                                    <a href="#" class="text-blue">{{ organisation.contact_phone ?? '--' }}</a>
                                </dd>
                            </div>

                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> Address: </dt>
                                <dd class="col-lg-7 m-0">
                                    <address class="m-0">
                                        {{organisation.org_locations?.postcode}}
                                        {{organisation.org_locations?.state ?? '--'}}<br />
                                        {{organisation.org_locations?.city ?? '--'}}<br />
                                        {{organisation.org_locations?.address}}
                                    </address>
                                </dd>
                            </div>

                            <div class="row mb-2" v-if="organisation.client_type === 'nfp'">
                                <dt class="col-lg-5 m-0"> ABN: </dt>
                                <dd class="col-lg-7 m-0 text-truncate">
                                    <a href="#" class="text-blue">{{ organisation.abn ?? '--' }}</a>
                                </dd>
                            </div>

                            <div class="row mb-2" v-if="organisation.client_type === 'nfp'">
                                <dt class="col-lg-5 m-0"> ACN: </dt>
                                <dd class="col-lg-7 m-0 text-truncate">
                                    <a href="#" class="text-blue">{{ organisation.acn ?? '--' }}</a>
                                </dd>
                            </div>

                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> Our Member since: </dt>
                                <dd class="col-lg-7 m-0"><time datetime="2022-06-28T06:30:34.0000000Z" class="text-nowrap">{{ organisation.created }}</time></dd>
                            </div>
                        </dl>
                    </section>

                    <section class="py-3 px-4">
                        <h5 class=" text-uppercase mb-4">Summary</h5>
                        <div v-html="organisation.summary"></div>
                    </section>

                    <section class="py-3 px-4">
                        <h5 class=" text-uppercase mb-4">More About Us</h5>
                        <div v-html="organisation.details"></div>
                    </section>

                    <!-- <section class="py-3 px-4">
                        <h5 class=" text-uppercase mb-3">Where we operate</h5>
                        <dl>
                            <div class="row mb-2">
                                <dt class="col-lg-5 m-0"> States: </dt>
                                <dd class="col-lg-7 m-0">
                                    <ul class="list-unstyled my-0">
                                        <li>{{ organisation.state }}</li>
                                    </ul>
                                </dd>
                            </div>
                        </dl>
                    </section> -->
                </div>

                <div class="col-12 col-sm-5">
                    <section class="mt-3 py-3 px-4">
                        <div class="pb-5 me-3" v-if="authUserRole ==='individual' || authUserRole === 'org-admin'">
                            <ChatBox :organisation="organisation"></ChatBox>
                        </div>
                        <!-- <h3 class="title text-uppercase mb-3">Contact Us</h3>
                        <p class="small">Use the following form to contact us.</p>

                        <div class="form-group mb-3">
                            <textarea cols="5" rows="5" class="form-control my-3" placeholder="Hi, I'm interested in 'Highly Profitable Short Term Rental Business...'. When can I inspect the property? Cheers."></textarea>

                            <div class="d-grid gap-2">
                                <button @click="swl('Your message successfully sent.')" class="btn btn-instagram btn-lg fw-semibold" type="button">
                                    <i class="bx bx-message me-2"></i> Send Message
                                </button>
                            </div>
                        </div> -->

                        <h3 class="title text-uppercase mb-3">WHERE WE OPERATE</h3>
                        <p class="small">The areas we are working.</p>
                        <ul class="p-0 m-0">
                            <li
                                v-if="hasPrimaryLocation"
                                @click="callForLocation(
                                    null,
                                    organisation.org_locations.location.lat,
                                    organisation.org_locations.location.long,
                                    true
                                )"
                                :class="{'selected' : isPrimarySelected}"
                                class="d-flex mb-4 pb-2 beautiful-list-item"
                            >
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-map"></i>
                                    </span>
                                </div>

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="black-text"
                                               :class="[isPrimarySelected ? 'selected-text-color' : 'text-muted']">
                                            {{ organisation.org_locations.city ?? '--' }} {{ organisation.org_locations.address }}
                                        </small>
                                        <small class="black-text"
                                               :class="[isPrimarySelected ? 'selected-text-color' : 'text-muted']">
                                            {{ organisation.org_locations.postcode }} {{ organisation.org_locations?.state ?? '--' }}</small>
                                    </div>
                                </div>
                            </li>

                            <template v-if="organisation.org_other_locations?.length > 0">
                                    <li
                                        v-for="(location, index) in organisation.org_other_locations"
                                        :key="index"
                                        class="d-flex mb-4 pb-2 beautiful-list-item"
                                        :class="{'selected' : selectedIndex === index}"
                                        @click="callForLocation(index, location.location.lat, location.location.long, false)"
                                    >
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-success">
                                                <i class="bx bx-map"></i>
                                            </span>
                                        </div>

                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="black-text"
                                                       :class="[selectedIndex === index ? 'selected-text-color' : 'text-muted']">
                                                    {{ location.city ?? '--' }} {{ location.address }}
                                                </small>
                                                <small class="black-text"
                                                       :class="[selectedIndex === index ? 'selected-text-color' : 'text-muted']">
                                                    {{ location.postcode }} {{ location?.state ?? '--' }}
                                                </small>

                                            </div>
                                        </div>
                                    </li>
                            </template>
                        </ul>
                            <div v-if="locationStore.loadLocation"
                                 :class="{'show': locationStore.loadLocation}">
                                <button class="btn btn-lg rounded-0 bg-label-instagram" type="button" disabled>
                                    <span class="spinner-border" role="status" aria-hidden="true"></span>
                                    <span class="ms-2">Please wait...</span>
                                </button>
                            </div>
                            <div v-else>
                                <div class="map overflow-hidden" v-if="locationStore.placeId.length > 0">
                                    <iframe width="600"
                                            height="350" style="border:0"
                                            loading="lazy"
                                            allowfullscreen
                                            :src="`https://www.google.com/maps/embed/v1/place?q=place_id:${locationStore.placeId}&key=${googleApiKey}`">
                                        >
                                    </iframe>
                                </div>
                                <div class="map overflow-hidden" v-else>
                                    No location found
                                </div>
                            </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    <LegalSupportModal
        from="org"
        :id="organisation.id"
        :data="{
            title: organisation.org_name,
            summary: organisation.details,
            canLegalSupport: canLegalSupport
        }" />
</template>
<style scoped>
.beautiful-list-item {
    background-color: #f7f7f7;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 8px;
    transition: background-color 0.3s;
    cursor: pointer;
}

.beautiful-list-item:hover {
    /*background-color: #e5e5e5;*/
    background-color: lightblue;

}

.beautiful-list-item:hover .black-text {
    color: black !important;
}

.beautiful-list-item .avatar {
    width: 40px;
    height: 40px;
    /* Add more styles for the avatar as needed */
}

.beautiful-list-item .avatar i {
    font-size: 24px;
    /* Customize the map icon size */
}
.selected {
    background-color: lightblue;
}
.selected-text-color {
    color: black
}
</style>
