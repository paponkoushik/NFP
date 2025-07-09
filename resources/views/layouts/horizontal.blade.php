<!-- Layout wrapper -->
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        <!-- Navbar -->
        <x-navbar nav-type="horizontal" />
        <!-- / Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Menu -->
                <x-menu nav-type="horizontal" class="layout-menu-horizontal menu-horizontal flex-grow-0" />
                <!-- / Menu -->

                <!-- Content v-cloak-->
                @include('layouts.container')
                <!--/ Content -->

                <!-- Footer -->
                @include('layouts._partials.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!--/ Layout wrapper -->