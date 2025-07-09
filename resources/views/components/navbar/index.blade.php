@props([
    'navType'
])
@php
    use App\Enums\UserRoles;
@endphp

    <!-- Navbar -->
<nav
    {{ $attributes->class(['layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme']) }} id="layout-navbar">
    @if($navType == 'horizontal')
        <!-- Content -->
        <div class="container-xxl">
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                <a href="/" class="app-brand-link gap-2">
                    <x-app-logo-img height="55px"/>
                    {{-- <span class="app-brand-text demo menu-text fw-bolder text-uppercase">{{ config('app.name') }}</span> --}}
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>
            @endif

            <!-- ! Not required for layout-without-menu -->
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="bx bx-menu bx-sm"></i>
                </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                @if($navType == 'vertical')
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                <i class="bx bx-search bx-sm"></i>
                                <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                            </a>
                        </div>
                    </div>
                    <!-- /Search -->
                @endif

                <ul class="navbar-nav flex-row align-items-center ms-auto">

                    @if($navType == 'horizontal')
                        <!-- Search -->
                        {{--<x-navbar.item
                                li-class="navbar-search-wrapper"
                                class="search-toggler"
                                href="#"
                                icon="bx bx-search bx-sm"
                        />--}}
                        <!-- /Search -->
                    @endif

                    <!-- Notification -->
                    {{--<x-navbar.item
                            li-class="dropdown-notifications navbar-dropdown me-3 me-xl-1"
                            href="javascript:void(0);"
                            icon="bx bx-bell bx-sm"
                            data-bs-auto-close="outside"
                            aria-expanded="false"
                    >
                        <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                        <x-slot:dropdown class="py-0">
                            <li class="dropdown-menu-header border-bottom">
                                <div class="dropdown-header d-flex align-items-center py-3">
                                    <h5 class="text-body mb-0 me-auto">Notification</h5>
                                    <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i
                                                class="bx fs-4 bx-envelope-open"></i></a>
                                </div>
                            </li>
                            <li class="dropdown-notifications-list scrollable-container">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="../assets/img/avatars/1.png" alt
                                                         class="w-px-40 h-auto rounded-circle"/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Congratulation Lettie 🎉</h6>
                                                <p class="mb-0">Won the monthly best seller gold badge</p>
                                                <small class="text-muted">1h ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span
                                                            class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Charles Franklin</h6>
                                                <p class="mb-0">Accepted your connection</p>
                                                <small class="text-muted">12hr ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="../assets/img/avatars/2.png" alt
                                                         class="w-px-40 h-auto rounded-circle"/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">New Message ✉️</h6>
                                                <p class="mb-0">You have new message from Natalie</p>
                                                <small class="text-muted">1h ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-success"><i
                                                                class="bx bx-cart"></i></span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Whoo! You have new order 🛒</h6>
                                                <p class="mb-0">ACME Inc. made new order $1,154</p>
                                                <small class="text-muted">1 day ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="../assets/img/avatars/9.png" alt
                                                         class="w-px-40 h-auto rounded-circle"/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Application has been approved 🚀</h6>
                                                <p class="mb-0">Your ABC project application has been approved.</p>
                                                <small class="text-muted">2 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-success"><i
                                                                class="bx bx-pie-chart-alt"></i></span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Monthly report is generated</h6>
                                                <p class="mb-0">July monthly financial report is generated</p>
                                                <small class="text-muted">3 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="../assets/img/avatars/5.png" alt
                                                         class="w-px-40 h-auto rounded-circle"/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Send connection request</h6>
                                                <p class="mb-0">Peter sent you connection request</p>
                                                <small class="text-muted">4 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="../assets/img/avatars/6.png" alt
                                                         class="w-px-40 h-auto rounded-circle"/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">New message from Jane</h6>
                                                <p class="mb-0">Your have new message from Jane</p>
                                                <small class="text-muted">5 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-warning"><i
                                                                class="bx bx-error"></i></span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">CPU is running high</h6>
                                                <p class="mb-0">CPU Utilization Percent is currently at 88.63%,</p>
                                                <small class="text-muted">5 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-menu-footer border-top">
                                <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">
                                    View all notifications
                                </a>
                            </li>
                        </x-slot:dropdown>
                    </x-navbar.item>--}}
                    <!--/ Notification -->

                    <!-- Quick links -->
                    @can('visible', UserRoles::OrgAdmin->value . '|' . UserRoles::Individual->value)
                         @php
                             $count = messageCount();
                         @endphp

                        <!-- Message -->
                        <header-message-count
                            :active-url="@js(request()->routeIs('messages'))"
                            :count="{{$count}}">
                        </header-message-count>
{{--                        <header-message-count :count="{{$count}}"></header-message-count>--}}
                        <!--/ Message -->
                    @endcan


                    <!-- cart icon -->
                    <header-cart-icon></header-cart-icon>

                    <!-- User -->
                    <x-navbar.item
                        li-class="navbar-dropdown dropdown-user"
                        href="javascript:void(0);"
                    >
                        <div class="avatar avatar-online">
                            <img src="{{ asset('/assets/img/avatars/1.png') }}" alt
                                 class="w-px-40 h-auto rounded-circle"/>
                        </div>

                        <x-slot:dropdown>
                            <x-navbar.dropdown-link href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('/assets/img/avatars/1.png') }}" alt
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span
                                            class="fw-semibold d-block">{{ optional(auth()->user())->full_name }}</span>
                                        <small class="text-muted">{{ optional(auth()->user())->email }}</small>
                                    </div>
                                </div>
                            </x-navbar.dropdown-link>

                            <x-navbar.dropdown-divider/>

                            <x-navbar.dropdown-link href="{{ route('account-settings') }}" icon="bx bx-user me-2">
                                <span class="align-middle">My Profile</span>
                            </x-navbar.dropdown-link>

                            @can('visible', UserRoles::OrgAdmin->value)
                                <x-navbar.dropdown-link href="{{ route('org.settings') }}" icon="bx bx-cog me-2">
                                    <span class="align-middle">Settings</span>
                                </x-navbar.dropdown-link>
                            @endcan

                            @can('visible',  UserRoles::Individual->value)
                                <x-navbar.dropdown-link href="{{ route('individual.settings') }}" icon="bx bx-cog me-2">
                                    <span class="align-middle">Settings</span>
                                </x-navbar.dropdown-link>
                            @endcan

                            {{--<x-navbar.dropdown-link href="#">
                        <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                            <span class="flex-grow-1 align-middle">Billing</span>
                            <span
                                class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                            </x-navbar.dropdown-link>--}}

                            <x-navbar.dropdown-divider/>

                            {{--<x-navbar.dropdown-link href="#" icon="bx bx-support me-2">
                                <span class="align-middle">Help</span>
                            </x-navbar.dropdown-link>

                            <x-navbar.dropdown-link href="#" icon="bx bx-help-circle me-2">
                                <span class="align-middle">FAQ</span>
                            </x-navbar.dropdown-link>

                            <x-navbar.dropdown-link href="#" icon="bx bx-dollar me-2">
                                <span class="align-middle">Pricing</span>
                            </x-navbar.dropdown-link>

                            <x-navbar.dropdown-divider/>--}}

                            <x-navbar.dropdown-link icon="bx bx-power-off me-2"
                                                    href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                <span class="align-middle">Logout</span>
                            </x-navbar.dropdown-link>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </x-slot:dropdown>
                    </x-navbar.item>
                    <!--/ User -->
                </ul>
            </div>

            <!-- Search Small Screens -->
            <div
                class="navbar-search-wrapper search-input-wrapper d-none {{ $navType == 'horizontal' ? 'container-xxl' : '' }}">
        <span class="twitter-typeahead" style="position: relative; display: inline-block;">
            <input type="text"
                   class="form-control search-input border-0 {{ $navType != 'horizontal' ? 'container-xxl' : '' }}"
                   placeholder="Search..." aria-label="Search..."/>
        </span>
                <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
            </div>

            @if($navType == 'horizontal')
        </div>
        <!--/ Content -->
    @endif
</nav>
<!-- / Navbar -->
