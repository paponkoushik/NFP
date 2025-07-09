<header class="wrapper">
    <nav class="navbar navbar-expand-lg classic transparent position-absolute navbar-dark">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand w-100 mt-n2">
                <a href="{{ url('/') }}">
                    <img class="logo-dark" src="/assets/img/logo-dark.png" alt="{{ config('app.name') }}" height="70" />
                    <img class="logo-light" src="/assets/img/logo-light.png" alt="{{ config('app.name') }}" height="70" />
                </a>
            </div>

            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                <div class="offcanvas-header d-lg-none">
                    <a href="{{ url('/') }}">
                        <img class="logo-light ms-n3 mt-n1" src="/assets/img/logo-light.png" height="50" />
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
                    {{--<ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Posts</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="dropdown-item" href="#">Blog without Sidebar</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="#">Blog with Sidebar</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="#">Blog with Left Sidebar</a></li>
                            </ul>
                        </li>
                    </ul>--}}
                    <!-- /.navbar-nav -->
                    <div class="offcanvas-footer d-lg-none">
                        <div>
                            <a href="mailto:first.last@email.com" class="link-inverse">info@email.com</a>
                            <br />
                            00 (123) 456 78 90 <br />
                            <nav class="nav social social-white mt-4">
                                <a href="#"><i class="uil uil-twitter"></i></a>
                                <a href="#"><i class="uil uil-facebook-f"></i></a>
                                <a href="#"><i class="uil uil-dribbble"></i></a>
                                <a href="#"><i class="uil uil-instagram"></i></a>
                                <a href="#"><i class="uil uil-youtube"></i></a>
                            </nav>
                            <!-- /.social -->
                        </div>
                    </div>
                    <!-- /.offcanvas-footer -->
                </div>
                <!-- /.offcanvas-body -->
            </div>
            <!-- /.navbar-collapse -->

            <div class="navbar-other ms-lg-4">
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    @if(auth()->check())
                        <li class="nav-item d-none d-md-block">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary rounded-pill py-0" type="button">
                                Hello, {{ auth()->user()->last_name }} <span class="tf-icons bx bx-user-circle ms-1"></span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item d-none d-md-block ms-1">
                            <a href="{{ route('login') }}" class="nav-link text-end w-11">
                                Log In
                            </a>
                        </li>

                        <li class="nav-item d-none d-md-block">
                            <a href="{{ route('register') }}" class="btn btn-sm btn-blue py-0 rounded-pill">
                                <span class="fw-normal pr-1">Sign Up</span> — It’s free
                            </a>
                        </li>
                    @endif

                    <li class="nav-item d-lg-none">
                        <button class="hamburger offcanvas-nav-btn"><span></span></button>
                    </li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- /.navbar -->

    <div class="offcanvas offcanvas-top bg-light" id="offcanvas-search" data-bs-scroll="true">
        <div class="container d-flex flex-row py-6">
            <form class="search-form w-100">
                <input id="search-form" type="text" class="form-control" placeholder="Type keyword and hit enter" />
            </form>
            <!-- /.search-form -->
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.offcanvas -->
</header>
<!-- /header -->
