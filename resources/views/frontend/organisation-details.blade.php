<x-app-layout>
    <div class="row">
        <x-slot:title>Organisation</x-slot>

        <organisation-details
            :auth-user-role="@js(auth()->user()->role)"
            :organisation="@js($organisation)"
            :google-api-key="@js(config()->get('app.google_map_api_key'))"
            :can-legal-support="@js($organisation->additional['canVisibleToSupport'])">
            <template #heading="{ organisation }">

                <section class="page-header position-relative">
                    <div class="container-xxl">
                        <!-- <h4 class="fw-bold py-3 mb-0">
                            <span class="text-muted fw-light">Home /</span> Organisations
                        </h4> -->

                        <div class="col-12">
                            <div class="card shadow-none">
                                <div class="d-flex flex-column flex-sm-row text-sm-start text-center align-items-center py-3">
                                    <div class="flex-shrink-0 mx-auto avatar avatar-xl me-3">
                                        <img
                                            :src="organisation?.logo"
                                            alt="user image"
                                            class="d-block border h-100px ms-0 ms-sm-4 rounded-circle" />
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info">
                                                <h4 class="mb-2">@{{ organisation.org_name }}</h4>
                                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                    <li class="list-inline-item fw-semibold text-warning">
                                                        <i class="bx bx-pen"></i>
                                                        @{{ organisation.type }}
                                                    </li>
                                                    <li class="list-inline-item fw-semibold text-info">
                                                        <i class="bx bx-map"></i>
                                                        @{{ organisation.address }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </template>
        </organisation-details>

    </div>
</x-app-layout>
