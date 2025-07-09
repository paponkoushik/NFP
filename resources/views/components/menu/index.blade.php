@aware(['navType'])

@php
    use App\Enums\UserRoles;

    $isActiveVerticalMode = $navType === 'vertical' ? true : false;
@endphp

<!-- Menu -->
<aside id="layout-menu" {{ $attributes->class(['menu bg-menu-theme']) }}>
    @if ($isActiveVerticalMode)
        <div class="app-brand demo">
            <a href="/" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo-dark.png') }}" height="90px" alt="Logo" />
                </span>
                {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">{{ config('app.name') }}</span> --}}
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>
    @else
        <!-- Horizontal Container -->
        <div class="container-xxl d-flex h-100">
    @endif

    <ul class="menu-inner {{ $isActiveVerticalMode ? 'py-1' : '' }}">
        <!-- Dashboards -->

        {{-- @can(UserRoles::SuperAdmin->value)
            @if ($isActiveVerticalMode)
                <x-menu.item-label label="Setups" />
            @endif

            <x-menu.item href="{{ route('plans') }}" icon="menu-icon tf-icons bx bx-food-menu">
                <div data-i18n="Plans">Plans</div>
            </x-menu.item>

            <x-menu.item href="{{ route('subscribers') }}" icon="menu-icon tf-icons bx bx-buildings">
                <div data-i18n="Subscribers">Subscribers</div>
            </x-menu.item>
        @endcan  --}}

        <!-- Apps & Pages -->
        @if ($isActiveVerticalMode)
            <x-menu.item-label label="Apps &amp; Pages" />
        @endif

        {{-- @can('visible', UserRoles::LegalAdmin->value . '|' . UserRoles::Lawyer->value)
            <x-menu.item href="{{ route('dashboard') }}" icon="menu-icon tf-icons bx bx-building-house">
                <div data-i18n="Dashboard">Dashboard</div>
            </x-menu.item> --}}

        @can('visible', UserRoles::LegalAdmin->value)
            <x-menu.item href="{{ route('dashboard') }}" icon="menu-icon tf-icons bx bx-building-house">
                <div data-i18n="Dashboard">Dashboard</div>
            </x-menu.item>

            @can(UserRoles::LegalAdmin->value)
                <x-menu.item href="{{ url('users') }}" icon="menu-icon tf-icons bx bx-user">
                    <div data-i18n="Manager Lawyers">Manager Lawyers</div>
                </x-menu.item>

                <x-menu.item href="{{ route('legal-requests') }}" icon="menu-icon tf-icons bx bxs-book-content">
                    <div data-i18n="Liaison Requests">Liaison Requests</div>
                </x-menu.item>
            @else
                <x-menu.item href="{{ route('legal-requests') }}" icon="menu-icon tf-icons bx bxs-book-content">
                    <div data-i18n="My Liaison Requests">My Liaison Requests</div>
                </x-menu.item>
            @endcan
        @elsecan(UserRoles::Individual->value)
            <x-menu.items :menus="[
                ['url' => route('posts.index'), 'name' => 'Home', 'icon' => 'bx-home-circle'],
                [
                    'name' => 'Posts',
                    'icon' => 'bxs-megaphone',
                    'slug' => ['our-posts', 'our-offers', 'offers'],
                    'submenus' => [
                        ['url' => route('posts.create'), 'name' => 'Post an ad', 'icon' => 'bx-plus'],
                        ['url' => route('our-posts'), 'name' => 'My Posts', 'icon' => 'bx-news'],
                        ['url' => route('our-offers'), 'name' => 'My Offers', 'icon' => 'bxs-discount'],
                    ],
                ],
                ['url' => route('documents.index'), 'name' => 'Documents', 'icon' => 'bx-file'],
                [
                    'name' => 'Orders',
                    'icon' => 'bx-store',
                    'slug' => ['orders.index', 'purchase-documents'],
                    'submenus' => [
                        ['url' => route('orders.index'), 'name' => 'Order History', 'icon' => 'bx-store'],
                        ['url' => route('purchase-documents'), 'name' => 'My Documents', 'icon' => 'bxs-file'],
                    ],
                ],
                ['url' => route('legal-requests'), 'name' => 'Legal Requests', 'icon' => 'bxs-book-content'],
            ]" :vertical="$isActiveVerticalMode" />
        @elsecan(UserRoles::OrgAdmin->value)
            <x-menu.items :menus="[
                ['url' => route('posts.index'), 'name' => 'Home', 'icon' => 'bx-home-circle'],
                [
                    'name' => 'Posts',
                    'icon' => 'bxs-megaphone',
                    'slug' => ['our-posts', 'our-offers', 'offers'],
                    'submenus' => [
                        ['url' => route('posts.create'), 'name' => 'Post an ad', 'icon' => 'bx-plus'],
                        ['url' => route('our-posts'), 'name' => 'Our Posts', 'icon' => 'bx-news'],
                        ['url' => route('our-offers'), 'name' => 'Our Offers', 'icon' => 'bxs-discount'],
                    ],
                ],
                ['url' => route('documents.index'), 'name' => 'Documents', 'icon' => 'bx-file'],
                [
                    'name' => 'Orders',
                    'icon' => 'bx-store',
                    'slug' => ['orders.index', 'purchase-documents'],
                    'submenus' => [
                        ['url' => route('orders.index'), 'name' => 'Order History', 'icon' => 'bx-store'],
                        ['url' => route('purchase-documents'), 'name' => 'Our Documents', 'icon' => 'bxs-file'],
                    ],
                ],
                ['url' => route('legal-requests'), 'name' => 'Legal Requests', 'icon' => 'bxs-book-content'],
            ]" :vertical="$isActiveVerticalMode" />
        @elsecan('lawyer')
            <x-menu.item href="{{ route('legal-requests') }}" icon="menu-icon tf-icons bx bxs-book-content">
                <div data-i18n="Legal Requests">Legal Requests</div>
            </x-menu.item>
        @elsecan('admins')
            <x-menu.item href="{{ route('dashboard') }}" icon="menu-icon tf-icons bx bx-building-house">
                <div data-i18n="Dashboard">Dashboard</div>
            </x-menu.item>

            @can(UserRoles::SuperAdmin->value)
                <x-menu.item href="{{ route('workflows') }}" icon="menu-icon tf-icons bx bx-network-chart">
                    <div data-i18n="Workflows">Workflows</div>
                </x-menu.item>
            @endcan

            <x-menu.item href="{{ route('setup') }}" icon="menu-icon tf-icons bx bxs-cog">
                <div data-i18n="Settings">Settings</div>
            </x-menu.item>

            <x-menu.item href="{{ route('categories.index') }}" icon="menu-icon tf-icons bx bx-list-ul">
                <div data-i18n="Categories">Categories</div>
            </x-menu.item>

            <x-menu.item href="{{ url('document-management') }}" icon="menu-icon tf-icons bx bxs-file-plus">
                <div data-i18n="Document Management">Document Management</div>
            </x-menu.item>

            <x-menu.item href="{{ url('organisation-management') }}" icon="menu-icon tf-icons bx bx bx-building-house">
                <div data-i18n="Organisations">Organisations</div>
            </x-menu.item>

            <x-menu.item href="{{ url('users') }}" icon="menu-icon tf-icons bx bx-user">
                <div data-i18n="User Management">Users Management</div>
            </x-menu.item>

            <x-menu.item href="{{ route('legal-requests') }}" icon="menu-icon tf-icons bx bxs-book-content">
                <div data-i18n="Legal Requests">Legal Requests</div>
            </x-menu.item>
        @elsecan('admins')
            <x-menu.item href="{{ route('dashboard') }}" icon="menu-icon tf-icons bx bx-building-house">
                <div data-i18n="Dashboard">Dashboard</div>
            </x-menu.item>

            @can(UserRoles::SuperAdmin->value)
                <x-menu.item href="{{ route('workflows') }}" icon="menu-icon tf-icons bx bx-network-chart">
                    <div data-i18n="Workflows">Workflows</div>
                </x-menu.item>
            @endcan

            <x-menu.item href="{{ route('setup') }}" icon="menu-icon tf-icons bx bxs-cog">
                <div data-i18n="Settings">Settings</div>
            </x-menu.item>

            <x-menu.item href="{{ route('categories.index') }}" icon="menu-icon tf-icons bx bx-list-ul">
                <div data-i18n="Categories">Categories</div>
            </x-menu.item>

            <x-menu.item href="{{ url('document-management') }}" icon="menu-icon tf-icons bx bxs-file-plus">
                <div data-i18n="Document Management">Document Management</div>
            </x-menu.item>

            <x-menu.item href="{{ url('organisation-management') }}" icon="menu-icon tf-icons bx bx bx-building-house">
                <div data-i18n="Organisations">Organisations</div>
            </x-menu.item>

            <x-menu.item href="{{ url('users') }}" icon="menu-icon tf-icons bx bx-user">
                <div data-i18n="User Management">Users Management</div>
            </x-menu.item>

            <x-menu.item href="{{ route('legal-requests') }}" icon="menu-icon tf-icons bx bxs-book-content">
                <div data-i18n="Legal Requests">Legal Requests</div>
            </x-menu.item>
        @endcan

        @if (session()->has('IS_IMPERSONATE'))
            <x-menu.item href="{{ route('impersonate.remove') }}" icon="menu-icon tf-icons bx bx-log-out me-2">
                <div data-i18n="Remove Impersonate">Remove Impersonate</div>
            </x-menu.item>
        @endif
    </ul>

    @if (!$isActiveVerticalMode)
        </div>
        <!--/ Horizontal Container -->
    @endif
</aside>
<!-- / Menu -->
{{-- ['url' => route('offers'), 'name' => 'Offer Received', 'icon' => 'bxs-offer'], --}}
