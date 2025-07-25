<x-app-layout>
    <x-slot:title>Pricing</x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-pricing.css') }}">
    @endpush

    <div class="card overflow-hidden">
        <!-- Pricing Plans -->
        <div class="pb-sm-5 pb-2 rounded-top">
            <div class="container py-5">
                <h2 class="text-center mb-2 mt-0 mt-md-4">Find the right plan for your site</h2>
                <p class="text-center pb-3">
                    Get started with us - it's perfect for individuals and teams. Choose a subscription plan that meets your needs.
                </p>
                <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 py-5">
                    <label class="switch switch-primary ms-sm-5 ps-sm-5 me-0">
                        <span class="switch-label">Monthly</span>
                        <input type="checkbox" class="switch-input price-duration-toggler" checked />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                        <span class="switch-label">Annual</span>
                    </label>
                    <div class="mt-n5 ms-n5 ml-2 mb-2 d-none d-sm-inline-flex align-items-start">
                        <img src="../../assets/img/pages/pricing-arrow-light.png" alt="arrow img" class="scaleX-n1-rtl" data-app-dark-img="pages/pricing-arrow-dark.png" data-app-light-img="pages/pricing-arrow-light.png" />
                        <span class="badge badge-sm bg-label-primary">Save upto 10%</span>
                    </div>
                </div>
    
                <div class="row mx-0 gy-3 px-lg-5">
                    <!-- Basic -->
                    <div class="col-lg mb-md-0 mb-4">
                        <div class="card border rounded shadow-none hover:transition-up">
                            <div class="card-body">
                                <div class="my-3 pt-2 text-center">
                                    <img src="../../assets/img/icons/unicons/bookmark.png" alt="Starter Image" height="80" />
                                </div>
                                <h3 class="card-title fw-semibold text-center text-capitalize mb-1">Basic</h3>
                                <p class="text-center">A simple start for everyone</p>
                                <div class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                        <h1 class="fw-semibold display-4 mb-0 text-primary">0</h1>
                                        <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal">/month</sub>
                                    </div>
                                    <small class="price-yearly price-yearly-toggle text-muted">Free</small>
                                </div>
    
                                <ul class="ps-3 my-4 list-unstyled">
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        100 responses a month
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Unlimited forms and surveys
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Unlimited fields
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Basic form creation tools
                                    </li>
                                    <li class="mb-0">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Up to 2 subdomains
                                    </li>
                                </ul>
    
                                <a href="auth-register-basic.html" class="btn btn-label-success d-grid w-100">Your Current Plan</a>
                            </div>
                        </div>
                    </div>
    
                    <!-- Pro -->
                    <div class="col-lg mb-md-0 mb-4">
                        <div class="card border-primary border shadow-none hover:transition-up">
                            <div class="card-body position-relative">
                                <div class="position-absolute end-0 me-4 top-0 mt-4">
                                    <span class="badge bg-label-primary">Popular</span>
                                </div>
                                <div class="my-3 pt-2 text-center">
                                    <img src="../../assets/img/icons/unicons/wallet-round.png" alt="Pro Image" height="80" />
                                </div>
                                <h3 class="card-title fw-semibold text-center text-capitalize mb-1">Pro</h3>
                                <p class="text-center">For small to medium businesses</p>
                                <div class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                        <h1 class="price-toggle price-yearly fw-semibold display-4 text-primary mb-0">42</h1>
                                        <h1 class="price-toggle price-monthly fw-semibold display-4 text-primary mb-0 d-none">
                                            49
                                        </h1>
                                        <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal">/month</sub>
                                    </div>
                                    <small class="price-yearly price-yearly-toggle text-muted">$ 499 / year</small>
                                </div>
    
                                <ul class="ps-3 my-4 list-unstyled">
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Up to 5 users
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        120+ components
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Basic support on Github
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Monthly updates
                                    </li>
                                    <li class="mb-0">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Integrations
                                    </li>
                                </ul>
    
                                <a href="auth-register-basic.html" class="btn btn-primary d-grid w-100">Upgrade</a>
                            </div>
                        </div>
                    </div>
    
                    <!-- Enterprise -->
                    <div class="col-lg">
                        <div class="card border rounded shadow-none hover:transition-up">
                            <div class="card-body">
                                <div class="my-3 pt-2 text-center">
                                    <img src="../../assets/img/icons/unicons/briefcase-round.png" alt="Pro Image" height="80" />
                                </div>
                                <h3 class="card-title text-center text-capitalize fw-semibold mb-1">Enterprise</h3>
                                <p class="text-center">Solution for big organizations</p>
    
                                <div class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <sup class="h6 text-primary pricing-currency mt-3 mb-0 me-1">$</sup>
                                        <h1 class="price-toggle price-yearly fw-semibold display-4 text-primary mb-0">84</h1>
                                        <h1 class="price-toggle price-monthly fw-semibold display-4 text-primary mb-0 d-none">
                                            99
                                        </h1>
                                        <sub class="h6 pricing-duration mt-auto mb-2 fw-normal text-muted">/month</sub>
                                    </div>
                                    <small class="price-yearly price-yearly-toggle text-muted">$ 999 / year</small>
                                </div>
    
                                <ul class="ps-3 my-4 list-unstyled">
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Up to 10 users
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        150+ components
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Basic support on Github
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Monthly updates
                                    </li>
                                    <li class="mb-0">
                                        <span class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2"><i class="bx bx-check bx-xs"></i></span>
                                        Speedy build tooling
                                    </li>
                                </ul>
    
                                <a href="auth-register-basic.html" class="btn btn-label-primary d-grid w-100">Upgrade</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Pricing Plans -->
        
        <div class="pricing-free-trial d-flex flex-column align-items-center justify-content-center py-4">
            <p class="mb-0 fw-semibold">Payment is deducted each month from the start date of use.</p>
            <p class="mb-0">All payments are made throught a secure service - we do not store your credit card information.</p>
        </div>

        <!-- FAQS -->
        <div class="pricing-faqs bg-alt-pricing rounded-bottom">
            <div class="container py-5 px-lg-5">
                <div class="row mt-0 mt-md-4">
                    <div class="col-12 text-center mb-4">
                        <h2 class="mb-2">Frequently Asked Questions</h2>
                        <p class="mb-4">Let us help answer the most common questions you might have.</p>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-12">
                        <div id="faq" class="accordion accordion-popout">
                            <div class="card accordion-item">
                                <h6 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#faq-1" aria-controls="faq-1">
                                        What counts towards the 100 responses limit?
                                    </button>
                                </h6>
    
                                <div id="faq-1" class="accordion-collapse collapse" data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        We count all responses submitted through all your forms in a month. If you already received 100 responses this month, you won’t be able to receive any more of them until next month when the counter
                                        resets.
                                    </div>
                                </div>
                            </div>
    
                            <div class="card accordion-item active">
                                <h6 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-2" aria-expanded="true" aria-controls="faq-2">
                                        How do you process payments?
                                    </button>
                                </h6>
                                <div id="faq-2" class="accordion-collapse collapse show" data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        We accept Visa®, MasterCard®, American Express®, and PayPal®. So you can be confident that your credit card information will be kept safe and secure.
                                    </div>
                                </div>
                            </div>
    
                            <div class="card accordion-item">
                                <h6 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-3" aria-expanded="false" aria-controls="faq-3">
                                        What payment methods do you accept?
                                    </button>
                                </h6>
                                <div id="faq-3" class="accordion-collapse collapse" data-bs-parent="#faq">
                                    <div class="accordion-body">2Checkout accepts all types of credit and debit cards.</div>
                                </div>
                            </div>
    
                            <div class="card accordion-item">
                                <h6 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-4" aria-expanded="false" aria-controls="faq-4">
                                        Do you have a money-back guarantee?
                                    </button>
                                </h6>
                                <div id="faq-4" class="accordion-collapse collapse" data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        Yes. You may request a refund within 30 days of your purchase without any additional explanations.
                                    </div>
                                </div>
                            </div>
    
                            <div class="card accordion-item mb-0 mb-md-4">
                                <h6 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-5" aria-expanded="false" aria-controls="faq-5">
                                        I have more questions. Where can I get help?
                                    </button>
                                </h6>
                                <div id="faq-5" class="accordion-collapse collapse" data-bs-parent="#faq">
                                    <div class="accordion-body">Please <a href="javascript:void(0);">contact</a> us if you have any other questions or concerns. We’re here to help!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ FAQS -->
    </div>    
</x-app-layout>