<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/card-analytics.css') }}" />
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
        <script defer src="{{ asset('assets/js/cards-statistics.js') }}"></script>
        <script defer src="{{ asset('assets/js/ui-cards-analytics.js') }}"></script>
        <script defer src="{{ asset('assets/js/charts-apex.js') }}"></script>

        {{-- <script defer src="{{asset('assets/js/dashboards-analytics.js')}}"></script> --}}
    @endpush

    @can('visible', 'legal-admin')
        <div class="row">
            <!-- Latest Request -->
            <legal-admin-dashboard :can="@js($can)" :statuses="@js($statuses)"></legal-admin-dashboard>
            <!-- ./ Matters -->
        </div>

        <div class="row">
        </div>
        <!-- =============== END Statistics ================= -->
    @elsecan('visible', 'lawyer')
        <!-- =============== START Statistics ================= -->
        <!-- Cards with unicons & charts -->
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <span class="d-block fw-semibold mb-2">Total Revenue</span>
                        <h3 class="card-title">$ 645</h3>
                    </div>
                    <div id="orderChart" class="mb-3"></div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <span class="d-block fw-semibold mb-2">This week</span>
                        <h3 class="card-title mb-2">$ 5465</h3>
                        <div id="revenueChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <span class="d-block fw-semibold mb-2">Leads vs Processed</span>
                        <h3 class="card-title mb-0">78|62</h3>
                        <div id="profitChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <span class="d-block fw-semibold mb-2">This Month Revenue</span>
                        <h3 class="card-title mb-2">$456</h3>
                    </div>
                    <div id="sessionsChart" class="mb-3"></div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <span class="d-block fw-semibold mb-2">Performance</span>
                    </div>
                    <div id="expensesChart" class="mb-2"></div>
                    <div class="p-3 pt-2">
                        <small class="text-muted d-block text-center">$21 more than last month</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block fw-semibold mb-2">Completed Requests</span>
                        <h3 class="card-title mb-2">482</h3>
                        <span class="badge bg-label-info mb-3">+34%</span> <small class="text-muted">Than last
                            month</small>
                        <small class="text-muted d-block">On time completion</small>
                        <div class="d-flex align-items-center">
                            <div class="progress w-75 me-2" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: 78%;" role="progressbar"
                                    aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span>78%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Cards with unicons & charts -->

        <div class="row">
            <!-- Latest Request -->
            <div class="col-md-6 col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Latest Request</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="matters" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="matters">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Request No</th>
                                    <th>Title</th>
                                    <th class="w-px-100">Client</th>
                                    <th>Assigned</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold lh-1">
                                                    <a href="#">1000135</a>
                                                </span>
                                                <small class="text-muted">Social Advocacy</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar me-2">
                                                <img src="/assets/img/post-preview.png" alt="Avatar" class="rounded">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-truncate">D'Amore Lock</h6>
                                                <small class="text-truncate text-muted">24 Feb 2023</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold small">NFP's</span>
                                            & <br />
                                            <span class="fw-semibold small">Grey Shack Ltd.</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-1 small">
                                                <span>Tanvir Gaus</span>
                                            </p>
                                            <span class="pointer badge badge-pill bg-label-primary py-1 fs-tiny">
                                                <i class="align-text-bottom bx bx-group fs-6"></i> Reassign
                                            </span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-warning">Yesterday</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-edit-alt me-1"></i> View Details</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Buy Again</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold lh-1">
                                                    <a href="#">1000139</a>
                                                </span>
                                                <small class="text-muted">Human Rights</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar me-2">
                                                <img src="https://cdn-icons-png.flaticon.com/128/5149/5149174.png"
                                                    alt="Avatar" class="rounded">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-truncate">Night's Delights</h6>
                                                <small class="text-truncate text-muted">01 Mar 2023</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold small">NFP's</span>
                                            & <br />
                                            <span class="fw-semibold small">Smart-catalog</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-1 small">
                                                <span>John Doe</span>
                                            </p>
                                            <span class="pointer badge badge-pill bg-label-primary py-1 fs-tiny">
                                                <i class="align-text-bottom bx bx-group fs-6"></i> Reassign
                                            </span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-warning">Yesterday</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-edit-alt me-1"></i> View Details</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Buy Again</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold lh-1">
                                                    <a href="#">1000149</a>
                                                </span>
                                                <small class="text-muted">Research</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar me-2">
                                                <img src="/assets/img/post-preview.png" alt="Avatar" class="rounded">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-truncate">The Vault Hunter</h6>
                                                <small class="text-truncate text-muted">02 Mar 2023</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold small">Bscheme</span>
                                            & <br />
                                            <span class="fw-semibold small">NFT's</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="pointer d-flex align-items-center hover:text-sky-600">
                                            <i class="bx bx-user-plus text-info me-1"></i> Assign
                                        </span>
                                    </td>
                                    <td><span class="badge bg-label-success">Today</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-edit-alt me-1"></i> View Details</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Buy Again</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold lh-1">
                                                    <a href="#">1000179</a>
                                                </span>
                                                <small class="text-muted">Legal Services</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar me-2">
                                                <img src="/assets/img/post-preview.png" alt="Avatar" class="rounded">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-truncate">Fuzzy Quilt</h6>
                                                <small class="text-truncate text-muted">02 Mar 2023</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold small">Greyshack</span>
                                            & <br />
                                            <span class="fw-semibold small">Smart-catalog</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-1 small">
                                                <span>Lawyer Panel</span>
                                            </p>
                                            <span class="pointer badge badge-pill bg-label-primary py-1 fs-tiny">
                                                <i class="align-text-bottom bx bx-group fs-6"></i> Reassign
                                            </span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-success">Today</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-edit-alt me-1"></i> View Details</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Buy Again</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold lh-1">
                                                    <a href="#">1000180</a>
                                                </span>
                                                <small class="text-muted">Education</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar me-2">
                                                <img src="https://cdn-icons-png.flaticon.com/128/5968/5968705.png"
                                                    alt="Avatar" class="rounded">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-truncate">Grey Shack Ltd.</h6>
                                                <small class="text-truncate text-muted">03 Mar 2023</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold small">Smart-catalog</span>
                                            & <br />
                                            <span class="fw-semibold small">Grey Shack Ltd.</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="pointer d-flex align-items-center hover:text-sky-600">
                                            <i class="bx bx-user-plus text-info me-1"></i> Assign
                                        </span>
                                    </td>
                                    <td><span class="badge bg-label-primary">Tomorrow</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-edit-alt me-1"></i> View Details</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Buy Again</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ./ Matters -->

            <!-- Total Balance -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Total Revenue (This Year)</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="totalBalance" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalBalance">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start">
                            <div class="d-flex pe-4">
                                <div class="me-3">
                                    <span class="badge bg-label-warning p-2"><i
                                            class="bx bx-wallet text-warning"></i></span>
                                </div>
                                <div>
                                    <h6 class="mb-0">$2.54k</h6>
                                    <small>Wallet</small>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-label-secondary p-2"><i
                                            class="bx bx-dollar text-secondary"></i></span>
                                </div>
                                <div>
                                    <h6 class="mb-0">$4.2k</h6>
                                    <small>Paypal</small>
                                </div>
                            </div>
                        </div>
                        <div id="totalBalanceChart" class="border-bottom mb-3"></div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">
                                You have done <span class="fw-bold">57.6%</span> more sales.<br />
                                Check your new badge in your profile.
                            </small>
                            <div>
                                <span class="badge bg-label-warning p-2"><i
                                        class="bx bx-chevron-right text-warning"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Balance -->

            <!-- Scatter Chart -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Lawyer Ratings</h5>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked
                                autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="dailyRadio">Daily</label>

                            <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio"
                                autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="monthlyRadio">Monthly</label>

                            <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio"
                                autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="yearlyRadio">Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="scatterChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Scatter Chart -->

            <!-- Performance -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Performance</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="performanceId" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="performanceId">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <small>Earnings: <span class="fw-semibold">$846.17</span></small>
                            </div>
                            <div class="col-6">
                                <small>Sales: <span class="fw-semibold">25.7M</span></small>
                            </div>
                        </div>
                    </div>
                    <div id="performanceChart"></div>
                </div>
            </div>
            <!--/ Performance -->

            <!-- Conversion rate -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Conversion Rate</h5>
                            <small class="text-muted">Compared To Last Month</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="conversionRate" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="conversionRate">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center gap-1 mb-4">
                                <h2 class="mb-2">8.72%</h2>
                                <small class="text-success fw-semibold">
                                    <i class="bx bx-chevron-up"></i>
                                    4.8%
                                </small>
                            </div>
                            <div id="conversionRateChart"></div>
                        </div>
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4">
                                <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Impressions</h6>
                                        <small class="text-muted">12.4k Visits</small>
                                    </div>
                                    <div class="user-progress"><i class="bx bx-up-arrow-alt text-success me-2"></i>
                                        <strong>12.8%</strong>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4">
                                <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Added To Cart</h6>
                                        <small class="text-muted">32 Product in cart</small>
                                    </div>
                                    <div class="user-progress"><i class="bx bx-down-arrow-alt text-danger me-2"></i>
                                        <strong>- 8.5% </strong>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4">
                                <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Checkout</h6>
                                        <small class="text-muted">21 Products checkout</small>
                                    </div>
                                    <div class="user-progress"><i class="bx bx-up-arrow-alt text-success me-2"></i>
                                        <strong>9.12%</strong>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Purchased</h6>
                                        <small class="text-muted">12 Orders</small>
                                    </div>
                                    <div class="user-progress"><i class="bx bx-up-arrow-alt text-success me-2"></i>
                                        <strong>2.83%</strong>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Conversion rate -->

            <div class="col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../../assets/img/icons/unicons/cc-warning.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt5" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt5">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="d-block mb-1">Revenue</span>
                                <h3 class="card-title text-nowrap mb-2">$42,389</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +52.18%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <span class="d-block fw-semibold">Sales</span>
                                <h3 class="card-title mb-2">482k</h3>
                                <span class="badge bg-label-info mb-3">+34%</span>
                                <small class="text-muted d-block">Sales Target</small>
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-info" style="width: 78%;" role="progressbar"
                                            aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>78%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between gap-3">
                                    <div class="d-flex align-items-start flex-column justify-content-between">
                                        <div class="card-title">
                                            <h5 class="mb-0">Expenses</h5>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="mt-auto">
                                                <h3 class="mb-2">$84.7k</h3>
                                                <small class="text-danger text-nowrap fw-semibold"><i
                                                        class="bx bx-down-arrow-alt"></i> 8.2%</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-label-secondary rounded-pill">2021 Year</span>
                                    </div>
                                    <div id="expensesBarChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        </div>
    @else
       <nfp-admin-dashboard></nfp-admin-dashboard>
    @endcan

</x-app-layout>
