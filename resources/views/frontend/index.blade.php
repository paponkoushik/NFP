<x-frontend-layout>
    <x-slot:title>Home</x-slot>

    @push('styles')
        @include('frontend.join-us-style')
    @endpush

    <section class="video-wrapper bg-overlay bg-overlay-gradient px-0 mt-0 vh-100">
        <video poster="/assets/img/photos/movie2.jpg" src="/assets/media/movie2.mp4" autoplay loop playsinline muted></video>
        <div class="video-content">
            <div class="container text-center">
                <div class="row">
                    <div class="col-lg-8 col-xl-6 text-center text-white mx-auto">
                        <h1 class="display-1 text-white mb-4">
                            ShareBridge helps you on<br />
                            <span class="typer text-warning text-nowrap" data-delay="100" data-words="Collaboration, Potential Merger, Sharing Resources"></span><span class="cursor text-primary" data-owner="typer"></span>
                        </h1>
                        <p class="lead fs-24 lh-sm text-white mb-7">We carefully consider our solutions to support each and every stage of your growth.</p>
                        <div>
                            <a class="btn btn-lg btn-primary rounded">Get Started</a>
                        </div>
                    </div>
                    <!-- /column -->
                </div>
            </div>
            <!-- /.video-content -->
        </div>
        <!-- /.content-overlay -->
    </section>
    <!-- /Video header -->

    <!-- join us -->
    <section class="wrapper bg-gradient-reverse-sky join-us-section">
        <div class="container py-6 py-md-10">
            <h2 class="display-4 mb-3  mx-auto text-center">Join our platform and collaborate</h2>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="join-us-box mt-5">
                        <div class="thumbnail">
                            <a href="#">
                                <img class="w-100" src="https://i.ibb.co/b5nKQS9/blog-1.jpg" alt="Kiwi Business">
                            </a>
                        </div>
                        <div class="content">
                            <div class="inner">
                                <div class="heading">
                                    <div class="category">
                                        <a class="fs-30" href="{{ route('register') }}">NOT FOR PROFIT</a>
                                    </div>
                                    <p class="title mb-0">
                                        <a href="#">Whether you're new or you're a power user, this article will, Whether you're new or you're a power user, Whether you're new or you're a power user, this article will, Whether you're new or you're a power user this article will…</a>
                                    </p>
                                </div>
                                <div class="footer">
                                    <a class="btn btn-primary new-nv-btn rounded-3" href="{{ route('register') }}">REGISTER</a>
                                </div>
                            </div>
                            <a class="transparent_link" href="#"></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="join-us-box mt-5">
                        <div class="thumbnail">
                            <a href="#">
                                <img class="w-100"
                                src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Kiwi Business">
                            </a>
                        </div>
                        <div class="content">
                            <div class="inner">
                                <div class="heading">
                                    <div class="category">
                                        <a class="fs-30" href="{{ route('register') }}">
                                            FOR CHARITY
                                        </a>
                                    </div>
                                    <p class="title mb-0">
                                        <a href="#">Whether you're new or you're a power user, this article will, Whether you're new or you're a power user, Whether you're new or you're a power user, this article will, Whether you're new or you're a power user this article will…</a>
                                    </p>
                                </div>
                                <div class="footer">
                                    <a class="btn btn-info new-nv-btn rounded-3" href="{{ route('register') }}">REGISTER</a>
                                </div>
                            </div>
                            <a class="transparent_link" href="#"></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="join-us-box mt-5">
                        <div class="thumbnail">
                            <a href="#">
                                <img class="w-100" src="https://images.unsplash.com/photo-1556155092-490a1ba16284?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Kiwi Business">
                            </a>
                        </div>
                        <div class="content">
                            <div class="inner">
                                <div class="heading">
                                    <div class="category">
                                        <a class="fs-30" href="{{ route('register') }}">
                                            FOR PROFIT
                                        </a>
                                    </div>
                                    <p class="title mb-0">
                                        <a href="#">Whether you're new or you're a power user, this article will, Whether you're new or you're a power user, Whether you're new or you're a power user, this article will, Whether you're new or you're a power user this article will…</a>
                                    </p>
                                </div>
                                <div class="footer">
                                    <a class="btn btn-success new-nv-btn rounded-3" href="{{ route('register') }}">REGISTER</a>
                                </div>
                            </div>
                            <a class="transparent_link" href="#"></a>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="join-us-box mt-5">
                        <div class="thumbnail">
                            <a href="#">
                                <img class="w-100" src="https://images.unsplash.com/photo-1556155092-490a1ba16284?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Kiwi Business">
                            </a>
                        </div>
                        <div class="content">
                            <div class="inner">
                                <div class="heading">
                                    <div class="category">
                                        <a class="fs-30" href="{{ route('register') }}">
                                            FOR INDIVIDUAL
                                        </a>
                                    </div>
                                    <p class="title mb-0">
                                        <a href="#">Whether you're new or you're a power user, this article will, Whether you're new or you're a power user, Whether you're new or you're a power user, this article will, Whether you're new or you're a power user this article will…</a>
                                    </p>
                                </div>
                                <div class="footer">
                                    <a class="btn btn-success new-nv-btn rounded-3" href="{{ route('register') }}">REGISTER</a>
                                </div>
                            </div>
                            <a class="transparent_link" href="#"></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- end join us -->

    <section class="wrapper bg-light">
        <div class="container py-6 py-md-10">
            <div class="row text-center mb-10">
                <div class="col-md-10 col-lg-9 col-xxl-8 mx-auto">
                    <h3 class="display-3 px-xl-10 mb-0">The service we offer is specifically designed to meet your needs.</h3>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->

            <div class="row gx-lg-0 gy-10 mb-10 mb-md-12 align-items-center">
                <div class="col-lg-6">
                    <figure class="rounded mb-0">
                        <img class="img-fluid"
                            src="/assets/img/photos/ui4.png"
                            srcset="/assets/img/photos/ui4@2x.png 2x" alt="" />
                    </figure>
                </div>
                <!--/column -->
                <div class="col-lg-5 ms-auto">
                    <h3 class="fs-28 mb-3">COLLABORATION</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Praesent commodo cursus magna risus varius.</p>
                    <ul class="icon-list bullet-bg bullet-soft-primary">
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Aenean quam ornare curabitur blandit.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Nullam quis risus eget urna mollis ornare leo.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Etiam porta euismod mollis natoque ornare.</span>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-soft-primary rounded-pill mt-2 mb-0">More Details</a>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->

            <div class="row gx-lg-0 gy-10 mb-10 mb-md-12 align-items-center">
                <div class="col-lg-6 order-lg-2 ms-auto">
                    <figure class="rounded mb-0">
                        <img class="img-fluid" src="/assets/img/photos/ui1.png"
                            srcset="/assets/img/photos/ui1@2x.png 2x" alt="" />
                    </figure>
                </div>
                <!--/column -->
                <div class="col-lg-5">
                    <h3 class="fs-28 mb-3">SPONSORSHIP</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Praesent commodo cursus magna risus varius.</p>
                    <ul class="icon-list bullet-bg bullet-soft-primary">
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Aenean quam ornare curabitur blandit.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Nullam quis risus eget urna mollis ornare leo.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Etiam porta euismod mollis natoque ornare.</span>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-soft-primary rounded-pill mt-2 mb-0">More Details</a>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->

            <div class="row gx-lg-0 gy-10 mb-10 mb-md-12 align-items-center">
                <div class="col-lg-6">
                    <figure class="rounded mb-0">
                        <img class="img-fluid" src="/assets/img/photos/ui5.png"
                            srcset="/assets/img/photos/ui5@2x.png 2x" alt="" />
                        </figure>
                </div>
                <!--/column -->
                <div class="col-lg-5 ms-auto">
                    <h3 class="fs-28 mb-3">POTENTIAL MERGER</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Praesent commodo cursus magna risus varius.</p>
                    <ul class="icon-list bullet-bg bullet-soft-primary">
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Aenean quam ornare curabitur blandit.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Nullam quis risus eget urna mollis ornare leo.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Etiam porta euismod mollis natoque ornare.</span>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-soft-primary rounded-pill mt-2 mb-0">More Details</a>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->

            <div class="row gx-lg-0 gy-10 align-items-center">
                <div class="col-lg-6 order-lg-2 ms-auto">
                    <figure class="rounded mb-0">
                        <img class="img-fluid" src="/assets/img/photos/ui1.png"
                            srcset="/assets/img/photos/ui1@2x.png 2x" alt="" />
                    </figure>
                </div>
                <!--/column -->
                <div class="col-lg-5">
                    <h3 class="fs-28 mb-3">RESOURCES</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Praesent commodo cursus magna risus varius.</p>
                    <ul class="icon-list bullet-bg bullet-soft-primary">
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Aenean quam ornare curabitur blandit.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Nullam quis risus eget urna mollis ornare leo.</span>
                        </li>
                        <li>
                            <span><i class="uil uil-check"></i></span><span>Etiam porta euismod mollis natoque ornare.</span>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-soft-primary rounded-pill mt-2 mb-0">More Details</a>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.what we do -->

    <section class="wrapper image-wrapper bg-image bg-overlay" data-image-src="/assets/img/photos/bg1.jpg">
        <div class="container py-18">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="fs-16 text-uppercase text-line text-white mb-3">Join Our Community</h2>
                    <h3 class="display-4 mb-6 text-white pe-xxl-18">We are trusted by over 5000+ clients. Join them by using our services and grow your business.</h3>
                    <a href="#" class="btn btn-white rounded mb-0 text-nowrap">Join Us</a>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /Section Join Us -->

    <section class="wrapper bg-light angled upper-end">
        <div class="container py-8 py-md-10">
            <div class="row">
                <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto text-center">
                    <h3 class="display-4 mb-15 mb-md-6 px-lg-10">We offer great prices, premium products and quality service for your business.</h3>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
            <div class="pricing-wrapper">
                <div class="pricing-switcher-wrapper switcher">
                    <p class="mb-0 pe-3">Monthly</p>
                    <div class="pricing-switchers">
                        <div class="pricing-switcher pricing-switcher-active"></div>
                        <div class="pricing-switcher"></div>
                        <div class="switcher-button bg-primary"></div>
                    </div>
                    <p class="mb-0 ps-3">Yearly <span class="text-red">(Save 30%)</span></p>
                </div>
                <div class="row gx-0 gy-6 mt-2">
                    <div class="col-md-6 col-lg-3">
                        <div class="pricing card shadow-none">
                            <div class="card-body">
                                <div class="icon btn btn-circle btn-lg btn-soft-primary disabled"><i class="uil uil-shopping-bag"></i></div>
                                <h4 class="card-title">Free</h4>
                                <div class="prices text-dark">
                                    <div class="price price-show">
                                        <span class="price-currency">$</span><span class="price-value">0</span>
                                        <span class="price-duration">month</span>
                                    </div>
                                    <div class="price price-hide price-hidden">
                                        <span class="price-currency">$</span>
                                        <span class="price-value">0</span> <span class="price-duration">year</span>
                                    </div>
                                </div>
                                <!--/.prices -->
                                <ul class="icon-list bullet-bg bullet-soft-primary mt-8 mb-9">
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>1</strong> Project </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>100K</strong> API Access </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>100MB</strong> Storage </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-times bullet-soft-red"></i><span> Weekly <strong>Reports</strong> </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-times bullet-soft-red"></i><span> 7/24 <strong>Support</strong></span>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-soft-primary rounded-pill">Choose Plan</a>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.pricing -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-lg-3">
                        <div class="pricing card shadow-none">
                            <div class="card-body">
                                <div class="icon btn btn-circle btn-lg btn-soft-primary disabled"><i class="uil uil-shopping-cart-alt"></i></div>
                                <h4 class="card-title">Silver</h4>
                                <div class="prices text-dark">
                                    <div class="price price-show"><span class="price-currency">$</span><span class="price-value">19</span> <span class="price-duration">month</span></div>
                                    <div class="price price-hide price-hidden"><span class="price-currency">$</span><span class="price-value">199</span> <span class="price-duration">year</span></div>
                                </div>
                                <!--/.prices -->
                                <ul class="icon-list bullet-bg bullet-soft-primary mt-8 mb-9">
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>5</strong> Projects </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>100K</strong> API Access </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>200MB</strong> Storage </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span> Weekly <strong>Reports</strong></span>
                                    </li>
                                    <li>
                                        <i class="uil uil-times bullet-soft-red"></i><span> 7/24 <strong>Support</strong></span>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-soft-primary rounded-pill">Choose Plan</a>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.pricing -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-lg-3">
                        <div class="pricing card bg-soft-primary">
                            <div class="card-body">
                                <div class="icon btn btn-circle btn-lg btn-primary disabled"><i class="uil uil-store"></i></div>
                                <h4 class="card-title">Gold</h4>
                                <div class="prices text-dark">
                                    <div class="price price-show"><span class="price-currency">$</span><span class="price-value">29</span> <span class="price-duration">month</span></div>
                                    <div class="price price-hide price-hidden"><span class="price-currency">$</span><span class="price-value">299</span> <span class="price-duration">year</span></div>
                                </div>
                                <!--/.prices -->
                                <ul class="icon-list bullet-bg bullet-primary mt-8 mb-9">
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>20</strong> Projects </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>300K</strong> API Access </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>500MB</strong> Storage </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span> Weekly <strong>Reports</strong></span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span> 7/24 <strong>Support</strong></span>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-primary rounded-pill">Choose Plan</a>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.pricing -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-lg-3">
                        <div class="pricing card shadow-none">
                            <div class="card-body">
                                <div class="icon btn btn-circle btn-lg btn-soft-primary disabled"><i class="uil uil-store-alt"></i></div>
                                <h4 class="card-title">Platinum</h4>
                                <div class="prices text-dark">
                                    <div class="price price-show"><span class="price-currency">$</span><span class="price-value">49</span> <span class="price-duration">month</span></div>
                                    <div class="price price-hide price-hidden"><span class="price-currency">$</span><span class="price-value">499</span> <span class="price-duration">year</span></div>
                                </div>
                                <!--/.prices -->
                                <ul class="icon-list bullet-bg bullet-soft-primary mt-8 mb-9">
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>90</strong> Projects </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>900K</strong> API Access </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span><strong>900MB</strong> Storage </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span> Weekly <strong>Reports</strong> </span>
                                    </li>
                                    <li>
                                        <i class="uil uil-check"></i><span> 7/24 <strong>Support</strong></span>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-soft-primary rounded-pill">Choose Plan</a>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.pricing -->
                    </div>
                </div>
                <!--/.row -->
            </div>
            <!--/.pricing-wrapper -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section pricing -->

    <section class="wrapper bg-light angled upper-end lower-start">
        <div class="container py-8 py-md-10">
            <div class="row">
                <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto">
                    <h3 class="display-4 mb-6 text-center">Here are the latest company news from our blog that got the most attention.</h3>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="position-relative">
                <div class="shape bg-dot primary rellax w-17 h-20" data-rellax-speed="1" style="top: 0; left: -1.7rem;"></div>
                <div class="swiper-container dots-closer blog grid-view mb-6" data-margin="0" data-dots="true" data-items-xl="3" data-items-md="2" data-items-xs="1">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="item-inner">
                                    <article>
                                        <div class="card">
                                            <figure class="card-img-top overlay overlay-1 hover-scale">
                                                <a href="#"> <img src="/assets/img/photos/b4.jpg" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="card-body">
                                                <div class="post-header">
                                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Ligula tristique quis risus</a></h2>
                                                </div>
                                                <!-- /.post-header -->
                                                <div class="post-content">
                                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.</p>
                                                </div>
                                                <!-- /.post-content -->
                                            </div>
                                            <!--/.card-body -->
                                            <div class="card-footer">
                                                <ul class="post-meta d-flex mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>14 Apr 2021</span></li>
                                                    <li class="post-comments">
                                                        <a href="#"><i class="uil uil-comment"></i>4</a>
                                                    </li>
                                                    <li class="post-likes ms-auto">
                                                        <a href="#"><i class="uil uil-heart-alt"></i>5</a>
                                                    </li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.card-footer -->
                                        </div>
                                        <!-- /.card -->
                                    </article>
                                    <!-- /article -->
                                </div>
                                <!-- /.item-inner -->
                            </div>
                            <!--/.swiper-slide -->
                            <div class="swiper-slide">
                                <div class="item-inner">
                                    <article>
                                        <div class="card">
                                            <figure class="card-img-top overlay overlay-1 hover-scale">
                                                <a href="#"> <img src="/assets/img/photos/b5.jpg" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="card-body">
                                                <div class="post-header">
                                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Nullam id dolor elit id nibh</a></h2>
                                                </div>
                                                <!-- /.post-header -->
                                                <div class="post-content">
                                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.</p>
                                                </div>
                                                <!-- /.post-content -->
                                            </div>
                                            <!--/.card-body -->
                                            <div class="card-footer">
                                                <ul class="post-meta d-flex mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>29 Mar 2021</span></li>
                                                    <li class="post-comments">
                                                        <a href="#"><i class="uil uil-comment"></i>3</a>
                                                    </li>
                                                    <li class="post-likes ms-auto">
                                                        <a href="#"><i class="uil uil-heart-alt"></i>3</a>
                                                    </li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.card-footer -->
                                        </div>
                                        <!-- /.card -->
                                    </article>
                                    <!-- /article -->
                                </div>
                                <!-- /.item-inner -->
                            </div>
                            <!--/.swiper-slide -->
                            <div class="swiper-slide">
                                <div class="item-inner">
                                    <article>
                                        <div class="card">
                                            <figure class="card-img-top overlay overlay-1 hover-scale">
                                                <a href="#"> <img src="/assets/img/photos/b6.jpg" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="card-body">
                                                <div class="post-header">
                                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Ultricies fusce porta elit</a></h2>
                                                </div>
                                                <!-- /.post-header -->
                                                <div class="post-content">
                                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.</p>
                                                </div>
                                                <!-- /.post-content -->
                                            </div>
                                            <!--/.card-body -->
                                            <div class="card-footer">
                                                <ul class="post-meta d-flex mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>26 Feb 2021</span></li>
                                                    <li class="post-comments">
                                                        <a href="#"><i class="uil uil-comment"></i>6</a>
                                                    </li>
                                                    <li class="post-likes ms-auto">
                                                        <a href="#"><i class="uil uil-heart-alt"></i>3</a>
                                                    </li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.card-footer -->
                                        </div>
                                        <!-- /.card -->
                                    </article>
                                    <!-- /article -->
                                </div>
                                <!-- /.item-inner -->
                            </div>
                            <!--/.swiper-slide -->
                            <div class="swiper-slide">
                                <div class="item-inner">
                                    <article>
                                        <div class="card">
                                            <figure class="card-img-top overlay overlay-1 hover-scale">
                                                <a href="#"> <img src="/assets/img/photos/b7.jpg" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="card-body">
                                                <div class="post-header">
                                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Morbi leo risus porta eget</a></h2>
                                                </div>
                                                <!-- /.post-header -->
                                                <div class="post-content">
                                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.</p>
                                                </div>
                                                <!-- /.post-content -->
                                            </div>
                                            <!--/.card-body -->
                                            <div class="card-footer">
                                                <ul class="post-meta d-flex mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>7 Jan 2021</span></li>
                                                    <li class="post-comments">
                                                        <a href="#"><i class="uil uil-comment"></i>2</a>
                                                    </li>
                                                    <li class="post-likes ms-auto">
                                                        <a href="#"><i class="uil uil-heart-alt"></i>5</a>
                                                    </li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.card-footer -->
                                        </div>
                                        <!-- /.card -->
                                    </article>
                                    <!-- /article -->
                                </div>
                                <!-- /.item-inner -->
                            </div>
                            <!--/.swiper-slide -->
                        </div>
                        <!--/.swiper-wrapper -->
                    </div>
                    <!-- /.swiper -->
                </div>
                <!-- /.swiper-container -->
            </div>
            <!-- /.position-relative -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
</x-frontend-layout>
