<x-guest-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset(mix('/assets/css/app.css')) }}" />
    @endpush

    <x-slot:title>Register</x-slot>

    <x-auth-card layout="cover" step="multi">
        <x-slot name="coverImg" 
            class="bg-no-repeat bg-center bg-cover col-lg-4 justify-content-end p-5 pe-0" 
            style="background-image: url('{{ asset('assets/img/registration.jpg') }}')"
        >
            {{-- <img src="{{ asset('assets/img/illustrations/girl-with-laptop-light.png') }}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/girl-with-laptop-dark.png" data-app-light-img="illustrations/girl-with-laptop-light.png"> --}}
        </x-slot>

        <org-register class="mt-n3" type="{{ request('type', 'fp') }}"></org-register>

        {{-- <h4 class="mb-2">Adventure starts here 🚀</h4>
        <p class="mb-4">Make your app management easy and fun!</p>

        <div id="multiStepsValidation" class="bs-stepper shadow-none">
            <div class="bs-stepper-header border-bottom-0">
                <div class="step active" data-target="#accountDetailsValidation">
                    <button type="button" class="step-trigger" aria-selected="true">
                        <span class="bs-stepper-circle" ><i class="bx bx-home-alt"></i></span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Account</span>
                            <span class="bs-stepper-subtitle">Account Details</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#personalInfoValidation">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-user"></i></span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Personal</span>
                            <span class="bs-stepper-subtitle">Enter Information</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#billingLinksValidation">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-detail"></i></span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Billing</span>
                            <span class="bs-stepper-subtitle">Payment Details</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <form id="multiStepsForm" onSubmit="return false">
                    <!-- Account Details -->
                    <div id="accountDetailsValidation" class="content active dstepper-block fv-plugins-bootstrap5 fv-plugins-framework">
                        <div class="content-header mb-3">
                            <h3 class="mb-1">Account Information</h3>
                            <span>Enter Your Account Details</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsUsername">Username</label>
                                <input type="text" name="multiStepsUsername" id="multiStepsUsername" class="form-control" placeholder="johndoe" />
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsEmail">Email</label>
                                <input type="email" name="multiStepsEmail" id="multiStepsEmail" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                            </div>
                            <div class="col-sm-6 form-password-toggle">
                                <label class="form-label" for="multiStepsPass">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="multiStepsPass" name="multiStepsPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsPass2" />
                                    <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-6 form-password-toggle">
                                <label class="form-label" for="multiStepsConfirmPass">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="multiStepsConfirmPass"
                                        name="multiStepsConfirmPass"
                                        class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multiStepsConfirmPass2"
                                    />
                                    <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="multiStepsURL">Profile Link</label>
                                <input type="text" name="multiStepsURL" id="multiStepsURL" class="form-control" placeholder="johndoe/profile" aria-label="johndoe" />
                            </div>
                            <div class="mb-3 fv-plugins-icon-container">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                    I agree to
                                    <a href="javascript:void(0);">privacy policy &amp; terms</a>
                                    </label>
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" disabled>
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Personal Info -->
                    <div id="personalInfoValidation" class="content">
                        <div class="content-header mb-3">
                            <h3 class="mb-1">Personal Information</h3>
                            <span>Enter Your Personal Information</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsFirstName">First Name</label>
                                <input type="text" id="multiStepsFirstName" name="multiStepsFirstName" class="form-control" placeholder="John" />
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsLastName">Last Name</label>
                                <input type="text" id="multiStepsLastName" name="multiStepsLastName" class="form-control" placeholder="Doe" />
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsMobile">Mobile</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">US (+1)</span>
                                    <input type="text" id="multiStepsMobile" name="multiStepsMobile" class="form-control multi-steps-mobile" placeholder="202 555 0111" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsPincode">Pincode</label>
                                <input type="text" id="multiStepsPincode" name="multiStepsPincode" class="form-control multi-steps-pincode" placeholder="Postal Code" maxlength="6" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="multiStepsAddress">Address</label>
                                <input type="text" id="multiStepsAddress" name="multiStepsAddress" class="form-control" placeholder="Address" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="multiStepsArea">Landmark</label>
                                <input type="text" id="multiStepsArea" name="multiStepsArea" class="form-control" placeholder="Area/Landmark" />
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsCity">City</label>
                                <input type="text" id="multiStepsCity" class="form-control" placeholder="Jackson" />
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsState">State</label>
                                <select id="multiStepsState" class="select2 form-select" data-allow-clear="true">
                                    <option value="">Select</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District Of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Billing Links -->
                    <div id="billingLinksValidation" class="content">
                        <div class="content-header mb-3">
                            <h3 class="mb-1">Select Plan</h3>
                            <span>Select plan as per your requirement</span>
                        </div>
                        <!-- Custom plan options -->
                        <div class="row gap-md-0 gap-3 mb-4">
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="basicOption">
                                        <span class="custom-option-body">
                                            <h4 class="mb-2">Basic</h4>
                                            <p class="mb-2">A simple start for start ups & Students</p>
                                            <span class="d-flex justify-content-center">
                                                <sup class="text-primary fs-big lh-1 mt-3">$</sup>
                                                <span class="display-5 text-primary">0</span>
                                                <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/month</sub>
                                            </span>
                                        </span>
                                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="basicOption" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="standardOption">
                                        <span class="custom-option-body">
                                            <h4 class="mb-2">Standard</h4>
                                            <p class="mb-2">For small to medium businesses</p>
                                            <span class="d-flex justify-content-center">
                                                <sup class="text-primary fs-big lh-1 mt-3">$</sup>
                                                <span class="display-5 text-primary">99</span>
                                                <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/month</sub>
                                            </span>
                                        </span>
                                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="standardOption" checked />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="enterpriseOption">
                                        <span class="custom-option-body">
                                            <h4 class="mb-2">Enterprise</h4>
                                            <p class="mb-2">Solution for enterprise & organizations</p>
                                            <span class="d-flex justify-content-center">
                                                <sup class="text-primary fs-big lh-1 mt-3">$</sup>
                                                <span class="display-5 text-primary">499</span>
                                                <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/year</sub>
                                            </span>
                                        </span>
                                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="enterpriseOption" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!--/ Custom plan options -->
                        <div class="content-header mb-3">
                            <h3 class="mb-1">Payment Information</h3>
                            <span>Enter your card information</span>
                        </div>
                        <!-- Credit Card Details -->
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label w-100" for="multiStepsCard">Card Number</label>
                                <div class="input-group input-group-merge">
                                    <input id="multiStepsCard" class="form-control multi-steps-card" name="multiStepsCard" type="text" placeholder="1356 3215 6548 7898" aria-describedby="multiStepsCardImg" />
                                    <span class="input-group-text cursor-pointer" id="multiStepsCardImg"><span class="card-type"></span></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="multiStepsName">Name On Card</label>
                                <input type="text" id="multiStepsName" class="form-control" name="multiStepsName" placeholder="John Doe" />
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label" for="multiStepsExDate">Expiry Date</label>
                                <input type="text" id="multiStepsExDate" class="form-control multi-steps-exp-date" name="multiStepsExDate" placeholder="MM/YY" />
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label" for="multiStepsCvv">CVV Code</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="multiStepsCvv" class="form-control multi-steps-cvv" name="multiStepsCvv" maxlength="3" placeholder="654" />
                                    <span class="input-group-text cursor-pointer" id="multiStepsCvvHelp"><i class="bx bx-help-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Card Verification Value"></i></span>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-next btn-submit">Submit</button>
                            </div>
                        </div>
                        <!--/ Credit Card Details -->
                    </div>
                </form>
            </div>
        </div>
        

        <form method="POST" class="mb-3" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <x-label for="name" :value="__('Name')" />

                <x-input.text id="name" type="text" name="name" :value="old('name')" placeholder="Enter your name" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-label for="email" :value="__('Email')" />

                <x-input.text id="email" type="email" name="email" :value="old('email')" placeholder="Enter your email" required />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-label for="password" :value="__('Password')" />

                <x-input.text id="password"
                    type="password"
                    name="password"
                    placeholder="*********"
                    required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input.text id="password_confirmation"
                    type="password"
                    name="password_confirmation"                                 
                    placeholder="*********"
                    required />
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                        I agree to
                        <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                </div>
            </div>

            <x-button type="submit" class="btn-primary d-grid w-100">
                {{ __('Register') }}
            </x-button>
        </form> --}}

        <div class="divider my-4">
            <div class="divider-text">or</div>
        </div>

        <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">
                <span>{{ __('Login') }}</span>
            </a>
        </p>

        {{-- <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons bx bxl-facebook"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons bx bxl-google-plus"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons bx bxl-twitter"></i>
            </a>
        </div> --}}
    </x-auth-card>
</x-guest-layout>
