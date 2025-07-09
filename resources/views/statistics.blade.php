<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/card-analytics.css') }}" />    
    @endpush

    @push('scripts')
        <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>                
        <script defer src="{{asset('assets/js/cards-statistics.js')}}"></script>
        <script defer src="{{asset('assets/js/ui-cards-analytics.js')}}"></script>
        <script defer src="{{asset('assets/js/charts-apex.js')}}"></script>
    @endpush

    <!-- =============== START Statistics ================= -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Cards Statistics</h4>
        <!-- Cards with few info -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Session</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">58,352</h4>
                                    <small class="text-success">(+29%)</small>
                                </div>
                                <small>Last Week Analytics</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class="bx bx-trending-up bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Time On Site</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">28m 14s</h4>
                                    <small class="text-success">(+18%)</small>
                                </div>
                                <small>Last Week Analytics</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-info rounded p-2">
                                    <i class="bx bx-time-five bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Bounce Rate</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">62%</h4>
                                    <small class="text-danger">(-14%)</small>
                                </div>
                                <small>Last Week Analytics</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-danger rounded p-2">
                                    <i class="bx bx-pie-chart-alt bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Users</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">18,472</h4>
                                    <small class="text-success">(+42%)</small>
                                </div>
                                <small>Last Week Analytics</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded p-2">
                                    <i class="bx bx-user bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Cards with few info -->
    
        <!-- Centered align Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title m-0 me-2">Total Sales</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm p-0" type="button" id="totalSalesList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Today <i class="bx bx-chevron-down"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalSalesList">
                                <a class="dropdown-item" href="javascript:void(0);">Yesterday</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-primary rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-trending-up bx-sm"></i></span>
                        </div>
                        <h3 class="card-title mb-1 me-2">8,352</h3>
                        <small class="d-block mb-2">12% of target</small>
                        <span class="text-success">+29% <i class="bx bx-chevron-up"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title m-0 me-2">Referral Income</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm p-0" type="button" id="referralsList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Today <i class="bx bx-chevron-down"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="referralsList">
                                <a class="dropdown-item" href="javascript:void(0);">Yesterday</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-info rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-dollar bx-sm"></i></span>
                        </div>
                        <h3 class="card-title mb-1 me-2">$1,271</h3>
                        <small class="d-block mb-2">34% of target</small>
                        <span class="text-danger">-23% <i class="bx bx-chevron-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title m-0 me-2">Customers</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm p-0" type="button" id="customersList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Today <i class="bx bx-chevron-down"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customersList">
                                <a class="dropdown-item" href="javascript:void(0);">Yesterday</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-success rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-user bx-sm"></i></span>
                        </div>
                        <h3 class="card-title mb-1 me-2">24,680</h3>
                        <small class="d-block mb-2">29% of target</small>
                        <span class="text-success">+42% <i class="bx bx-chevron-up"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="card-title m-0 me-2">Orders Received</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm p-0" type="button" id="orderReceivedList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Today <i class="bx bx-chevron-down"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orderReceivedList">
                                <a class="dropdown-item" href="javascript:void(0);">Yesterday</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-warning rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-archive bx-sm"></i></span>
                        </div>
                        <h3 class="card-title mb-1 me-2">1,862</h3>
                        <small class="d-block mb-2">47% of target</small>
                        <span class="text-success">+82% <i class="bx bx-chevron-up"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Centered align Cards -->
    
        <!-- Cards with unicons & charts -->
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Transactions</span>
                        <h4 class="card-title mb-2">$14,857</h4>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/cube-secondary.png" alt="cube" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Order</span>
                        <h4 class="card-title mb-2">$1,286</h4>
                        <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -13.24%</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h4 class="card-title mb-2">$12,628</h4>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/paypal.png" alt="paypal" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Payments</span>
                        <h4 class="card-title mb-2">$2,456</h4>
                        <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt5">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Revenue</span>
                        <h4 class="card-title mb-2">$42,389</h4>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +52.18%</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Sales</span>
                        <h4 class="card-title mb-2">$4,679</h4>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <span class="d-block fw-semibold mb-2">Order</span>
                        <h3 class="card-title">276k</h3>
                    </div>
                    <div id="orderChart" class="mb-3"></div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <span class="d-block fw-semibold mb-2">Revenue</span>
                        <h3 class="card-title mb-2">425k</h3>
                        <div id="revenueChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <span class="d-block fw-semibold mb-2">Profit</span>
                        <h3 class="card-title mb-0">624k</h3>
                        <div id="profitChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <span class="d-block fw-semibold mb-2">Sessions</span>
                        <h3 class="card-title mb-2">2,845</h3>
                    </div>
                    <div id="sessionsChart" class="mb-3"></div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <span class="d-block fw-semibold mb-2">Expenses</span>
                    </div>
                    <div id="expensesChart" class="mb-2"></div>
                    <div class="p-3 pt-2">
                        <small class="text-muted d-block text-center">$21k Expenses more than last month</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block fw-semibold mb-2">Sales</span>
                        <h3 class="card-title mb-2">482k</h3>
                        <span class="badge bg-label-info mb-4">+34%</span>
                        <small class="text-muted d-block">Sales Target</small>
                        <div class="d-flex align-items-center">
                            <div class="progress w-75 me-2" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: 78%;" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span>78%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Cards with unicons & charts -->
    
        <!-- Cards with charts & info -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body row g-4">
                        <div class="col-md-6 pe-md-4 card-separator">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <h5 class="mb-0">New Visitors</h5>
                                <small>Last Week</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="mt-auto">
                                    <h2 class="mb-2">23%</h2>
                                    <small class="text-danger text-nowrap fw-semibold"><i class="bx bx-down-arrow-alt"></i> -13.24%</small>
                                </div>
                                <div id="visitorsChart"></div>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <h5 class="mb-0">Activity</h5>
                                <small>Last Week</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="mt-auto">
                                    <h2 class="mb-2">82%</h2>
                                    <small class="text-success text-nowrap fw-semibold"><i class="bx bx-up-arrow-alt"></i> 24.8%</small>
                                </div>
                                <div id="activityChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="card-title mb-auto">
                                    <h5 class="mb-0">Generated Leads</h5>
                                    <small>Monthly Report</small>
                                </div>
                                <div class="chart-statistics">
                                    <h3 class="card-title mb-1">4,230</h3>
                                    <small class="text-success text-nowrap fw-semibold"><i class="bx bx-up-arrow-alt"></i> +12.8%</small>
                                </div>
                            </div>
                            <div id="leadsReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Cards with charts & info -->
    </div>
    <!-- =============== END Statistics ================= -->


    <!-- =============== START Card Analytics ================= -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Cards Analytics</h4>
    
        <div class="row">
            <!-- Customer Ratings -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Customer Ratings</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="customerRatings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customerRatings">
                                <a class="dropdown-item" href="javascript:void(0);">Featured Ratings</a>
                                <a class="dropdown-item" href="javascript:void(0);">Based on Task</a>
                                <a class="dropdown-item" href="javascript:void(0);">See All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <h1 class="display-3 mb-0">4.0</h1>
                            <div class="ratings">
                                <i class="bx bxs-star bx-sm text-warning"></i>
                                <i class="bx bxs-star bx-sm text-warning"></i>
                                <i class="bx bxs-star bx-sm text-warning"></i>
                                <i class="bx bxs-star bx-sm text-warning"></i>
                                <i class="bx bxs-star bx-sm text-lighter"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-primary me-3">+5.0</span>
                            <span>Points from last month</span>
                        </div>
                    </div>
                    <div id="customerRatingsChart"></div>
                </div>
            </div>
            <!--/ Customer Ratings -->
    
            <!-- Sales Stats -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Sales Stats</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="salesStatsID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesStatsID">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div id="salesStats"></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-around">
                            <div class="d-flex align-items-center lh-1 mb-3 mb-sm-0"><span class="badge badge-dot bg-success me-2"></span> Conversion Ratio</div>
                            <div class="d-flex align-items-center lh-1 mb-3 mb-sm-0"><span class="badge badge-dot bg-label-secondary me-2"></span> Total requirements</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sales Stats -->
    
            <!-- Sales Analytics -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-start justify-content-between">
                        <div>
                            <h5 class="card-title m-0 me-2 mb-2">Sales Analytics</h5>
                            <span class="badge bg-label-success me-1">+42.6%</span> <span>Than last year</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-label-primary dropdown-toggle" type="button" id="salesAnalyticsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                2022
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesAnalyticsId">
                                <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                <a class="dropdown-item" href="javascript:void(0);">2019</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="salesAnalyticsChart"></div>
                    </div>
                </div>
            </div>
            <!--/ Sales Analytics -->
    
            <!-- Overview & Sales Activity -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Overview & Sales Activity</h5>
                        <small class="card-subtitle">Check out each column for more details</small>
                    </div>
                    <div id="salesActivityChart"></div>
                </div>
            </div>
            <!--/ Overview & Sales Activity -->
    
            <!-- Total Income -->
            <div class="col-md-12 col-lg-8 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Total Income</h5>
                                <small class="card-subtitle">Yearly report overview</small>
                            </div>
                            <div class="card-body">
                                <div id="totalIncomeChart"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-0">Report</h5>
                                    <small class="card-subtitle">Monthly Avg. $45.578k</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="totalIncome" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalIncome">
                                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="report-list">
                                    <div class="report-list-item rounded-2 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="report-list-icon shadow-sm me-2">
                                                <img src="../../assets/svg/icons/paypal-icon.svg" width="22" height="22" alt="Paypal" />
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                                <div class="d-flex flex-column">
                                                    <span>Income</span>
                                                    <h5 class="mb-0">$42,845</h5>
                                                </div>
                                                <small class="text-success">+2.34k</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="report-list-item rounded-2 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="report-list-icon shadow-sm me-2">
                                                <img src="../../assets/svg/icons/shopping-bag-icon.svg" width="22" height="22" alt="Shopping Bag" />
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                                <div class="d-flex flex-column">
                                                    <span>Expense</span>
                                                    <h5 class="mb-0">$38,658</h5>
                                                </div>
                                                <small class="text-danger">-1.15k</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="report-list-item rounded-2">
                                        <div class="d-flex align-items-start">
                                            <div class="report-list-icon shadow-sm me-2">
                                                <img src="../../assets/svg/icons/wallet-icon.svg" width="22" height="22" alt="Wallet" />
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                                <div class="d-flex flex-column">
                                                    <span>Profit</span>
                                                    <h5 class="mb-0">$18,220</h5>
                                                </div>
                                                <small class="text-success">+1.35k</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Income -->
            </div>
            <!--/ Total Income -->
        </div>
        <div class="row">
            <!-- Expense Overview -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income" aria-selected="true">
                                    Income
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab">Expenses</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab">Profit</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body px-0">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                <div class="d-flex px-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../../assets/img/icons/unicons/wallet.png" alt="User" />
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Balance</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">$459.10</h6>
                                            <small class="text-success fw-semibold">
                                                <i class="bx bx-chevron-up"></i>
                                                42.9%
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div id="incomeChart"></div>
                                <div class="d-flex justify-content-center pt-3 gap-2">
                                    <div class="flex-shrink-0">
                                        <div id="expensesOfWeek"></div>
                                    </div>
                                    <div>
                                        <p class="mb-n1 mt-1">Expenses This Week</p>
                                        <small class="text-muted">$39 less than last week</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Expense Overview -->
    
            <!-- Performance -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Performance</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="performanceId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    
            <!-- Total Balance -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Total Balance</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="totalBalance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <span class="badge bg-label-warning p-2"><i class="bx bx-wallet text-warning"></i></span>
                                </div>
                                <div>
                                    <h6 class="mb-0">$2.54k</h6>
                                    <small>Wallet</small>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-label-secondary p-2"><i class="bx bx-dollar text-secondary"></i></span>
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
                                <span class="badge bg-label-warning p-2"><i class="bx bx-chevron-right text-warning"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Balance -->
    
            <!-- Session Overview -->
            <div class="col-12 col-lg-6 col-xl-6 col-xxl-5 order-lg-0 order-1 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Session Overview</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="sessionOverview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sessionOverview">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row gap-md-0 gap-4">
                        <div class="col-md-5">
                            <h1 class="mb-0 text-nowrap">32,754</h1>
                            <small class="text-success"> +0.7645% </small>
    
                            <div id="sessionOverviewChart" class="ms-n3"></div>
                        </div>
                        <div class="col-md-7 d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-column">
                                    <small class="text-muted">Today</small>
                                    <span class="fw-semibold">+ $340</span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">Last Week</small>
                                    <span class="fw-semibold">+ $680</span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">Today</small>
                                    <span class="fw-semibold">+ $3,540</span>
                                </div>
                            </div>
                            <div class="progress-wrapper mb-4">
                                <div class="mb-3">
                                    <small class="text-muted">Effective Return</small>
                                    <div class="d-flex align-items-center">
                                        <div class="progress w-100 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: 74%;" role="progressbar" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">74%</small>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted">Invalid Session</small>
                                    <div class="d-flex align-items-center">
                                        <div class="progress w-100 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: 40%;" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">40%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Session Overview -->
    
            <!-- Score -->
            <div class="col-md-6 col-lg-3 order-lg-1 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <small class="card-subtitle mb-2">Your score is</small>
                        <h5 class="card-title mb-0 mt-1">Awesome</h5>
                    </div>
                    <div class="card-body">
                        <div id="scoreChart"></div>
    
                        <div class="d-flex flex-column align-items-center mt-2">
                            <small class="text-muted">Your score is based on the last</small>
                            <small class="fw-semibold">287 Transactions</small>
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary mt-2" role="button">View My Account</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Score -->
        </div>
        <div class="row">
            <!-- Total Revenue -->
            <div class="col-12 col-lg-9 col-xl-9 col-xxl-8 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-2">Total Revenue</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-label-primary dropdown-toggle" type="button" id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            2022
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                            <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>
    
                            <div class="d-flex p-4 gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2022</small>
                                        <h6 class="mb-0">$32.5k</h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2021</small>
                                        <h6 class="mb-0">$41.2k</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
        </div>
    </div>
    <!-- =============== END Card Analytics ================= -->

    <!-- =============== START Apex Charts ================= -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Charts /</span> Apex</h4>
    
        <div class="row">
            <!-- Line Area Chart -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Last updates</h5>
                            <small class="text-muted">Commercial networks</small>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-calendar"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lineAreaChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Line Area Chart -->
    
            <!-- Bar Chart -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
                        <h5 class="card-title mb-0">Data Science</h5>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-calendar"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="barChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Bar Chart -->
    
            <!-- Scatter Chart -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">New Technologies Data</h5>
                        <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="dailyRadio">Daily</label>
    
                            <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio" autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="monthlyRadio">Monthly</label>
    
                            <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio" autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="yearlyRadio">Yearly</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="scatterChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Scatter Chart -->
    
            <!-- Line Chart -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Balance</h5>
                            <small class="text-muted">Commercial networks & enterprises</small>
                        </div>
                        <div class="d-sm-flex d-none align-items-center">
                            <h5 class="fw-bold mb-0 me-3">$ 100,000</h5>
                            <span class="badge bg-label-secondary">
                                <i class="bx bx-down-arrow-alt bx-xs text-danger"></i>
                                <span class="align-middle">20%</span>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Line Chart -->
    
            <!-- Bar Chart -->
            <div class="col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-subtitle text-muted mb-1">Balance</p>
                            <h5 class="card-title fw-bold mb-0">$74,382.72</h5>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-calendar"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="horizontalBarChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Bar Chart -->
    
            <!-- Candlestick Chart -->
            <div class="col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">Stocks Prices</h5>
                            <p class="text-muted mb-0">$50,863.98</p>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-calendar"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="candleStickChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Candlestick Chart -->
    
            <!-- Heat map Chart -->
            <div class="col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daily Sales States</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="heatChartDd" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="heatChartDd">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="heatMapChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Heat map Chart -->
    
            <!-- Radial bar Chart -->
            <div class="col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Statistics</h5>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-calendar"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="radialBarChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Radial bar Chart -->
    
            <!-- Radar Chart -->
            <div class="col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Mobile Comparison</h5>
                        <div class="dropdown">
                            <button class="btn px-0" type="button" id="heatChartDd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="heatChartDd1">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="radarChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Radar Chart -->
    
            <!-- Donut Chart -->
            <div class="col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Expense Ratio</h5>
                            <small class="text-muted">Spending on various categories</small>
                        </div>
                        <div class="dropdown d-none d-sm-flex">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-calendar"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="donutChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Donut Chart -->
        </div>
    </div>        
    <!-- =============== END Apex Charts ================= -->
    
</x-app-layout>