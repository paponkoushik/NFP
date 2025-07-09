<x-app-layout>
    <div class="row mt-2">
        <x-slot:title>Settings</x-slot>

        <organisation-settings></organisation-settings>

        <!--  Multi Steps Registration -->
        <div class="col-lg-10 mx-auto">
            <div class="mx-auto">
                <div id="multiStepsValidation" class="bs-stepper shadow-none">
                    <div class="bs-stepper-header border-bottom-0">
                        <div class="step" data-target="#accountDetailsValidation">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-home-alt"></i></span>
                                <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">Organisation</span>
                                    <span class="bs-stepper-subtitle">Organisations Details</span>
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
                                    <span class="bs-stepper-title">Service Areas</span>
                                    <span class="bs-stepper-subtitle">The sevice areas you work</span>
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
                                    <span class="bs-stepper-title">My Interests</span>
                                    <span class="bs-stepper-subtitle">Your primary objective</span>
                                </span>
                            </button>
                        </div>


                        <div class="line">
                            <i class="bx bx-chevron-right"></i>
                        </div>

                        <div class="step" data-target="#preferencesLinksValidation">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-detail"></i></span>
                                <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">My Preferences</span>
                                    <span class="bs-stepper-subtitle">Choose your preferences</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content pt-1">
                        <form id="multiStepsForm" onSubmit="return false">
                            <!-- Organisation Details -->
                            <div id="accountDetailsValidation" class="content">
                                <div class="content-header mb-3">
                                    <h5 class="mb-1">Organisation Information</h5>
                                    <small>The organisation information is important for other NFP or Charities to find and know about you and your activities. 
                                        Please provide a short summary, your logo and a detailed description of what you do, where you are locatioed etc that will be used on searching and represent you in your organisation profile.</sma>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <img src="{{ asset('/assets/img/preview.png') }}" alt="Your Logo" class="rounded img-fluid" height="100" width="110">
                                    </div>

                                    <div>
                                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                            <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" for="account-upload">Upload Organisation logo</label>
                                            <input type="file" id="account-upload" hidden="">
                                            <button class="btn btn-sm btn-secondary ms-2">Reset</button>
                                        </div>
                                        <p class="text-muted mt-1 mb-0">
                                            <small>Allowed JPG, GIF or PNG. Max size of 800kB</small>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-sm-5">
                                        <label class="form-label" for="org_name">Name of the Organisation</label>
                                        <input type="text" name="org_name" id="org_name" class="form-control" placeholder="Your Org. Name" required/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label" for="abn">ABN</label>
                                        <input type="text" name="abn" id="abn" class="form-control" placeholder="ABN" required/>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="org_website">Website (if any)</label>
                                        <input type="text" name="org_website" id="org_website" class="form-control" placeholder="https://your-org-url.com.au" />
                                    </div>


                                    <div class="col-sm-5">
                                        <label class="form-label" for="org_address">Address</label>
                                        <input type="text" name="org_address" id="org_address" class="form-control" placeholder="Address of the Organisation" required/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label" for="city">City</label>
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City"  required/>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label" for="Postcode">Postcode</label>
                                        <input type="text" name="Postcode" id="Postcode" class="form-control" placeholder="Postcode" required/>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label" for="state">State</label>
                                        <select name="state" id="state" class="form-control" required>
                                            @foreach(['', 'NSW', 'VIC', 'QLD', 'SA', 'WA', 'TAS', 'NT', 'ACT'] as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    

                                    <div class="col-md-12">
                                        <label class="form-label" for="summary">Summary</label>
                                        <textarea name="summary" id="" class="form-control" cols="3" rows="3" placeholder="A short summary of the organisation" required></textarea>
                                        <div>
                                            <small>The summary is restricted to 120 characters, please give a short description of your organisation specially the service you provide </small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="details">Details</label>
                                        <textarea name="details" id="" class="form-control" cols="3" rows="6" placeholder="Detailed description of the organisation" required></textarea>
                                        <div>
                                            <small>A detailed description of the organisation which will get displayed in your organisation page.</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 d-flex justify-content-between">
                                        <button class="btn btn-label-secondary btn-prev" disabled>
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next"><span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Area -->
                            <div id="personalInfoValidation" class="content">
                                <div class="content-header mb-3">
                                    <h5 class="mb-1">Service Areas</h5>
                                    <small>Pick the Service Areas you work</small>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                    <h5>Select serevice areas</h5>

                                    <div class="row flex-column">
                                        @foreach([
                                            'Disability',
                                            'Youth Services',
                                            'Family Violence',
                                            'Agriculture',
                                            'Arts and Culture',
                                            'Community development',
                                            'Economic development',
                                            'Education',
                                            'Environment Preservation',
                                            'Health',
                                            'Human rights',
                                            'Human Services',
                                            'Information & Communication', 'Other'
                                        ] as $key => $category)
                                            <div class="col-md">
                                                <div class="form-check form-check-success custom-option custom-option-image custom-option-image-radio hover:shadow-sm">
                                                    <label class="form-check-label custom-option-content py-2 px-3" for="category-{{ $key }}">
                                                        <input name="customRadioVariants" class="form-check-input" type="checkbox" value="" id="category-{{ $key }}" />
                                                        <span class="fw-semibold">{{ $category }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                    <div class="col-md-6">    
                                    <h6>Select sub-areas</h6>

                                    <div class="row flex-column">

                                        @foreach([
                                            'Basic and emergency aid',
                                            'Family services',
                                            'Human services information',
                                            'Job services',
                                            'Personal services',
                                            'Environment Preservation',
                                            'Health',
                                            'Human rghts',
                                            'Human Services',
                                            'Shelter and residential care', 'Other'
                                        ] as $key => $subCategory)
                                            <div class="col-md">
                                                <div class="border-1 custom-option custom-option-image custom-option-image-radio form-check form-check-success mb-2 hover:shadow-sm">
                                                    <label class="form-check-label custom-option-content py-2 px-3" for="sub-category-{{ $key }}">
                                                        <input name="customRadioVariants" class="form-check-input" type="checkbox" value="" id="sub-category-{{ $key }}" />
                                                        <span class="fw-semibold">{{ $subCategory }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev">
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next"><span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Work Links -->
                            <div id="billingLinksValidation" class="content">
                                <div class="content-header mb-3">
                                    <h5 class="mb-1">My Interests</h5>
                                    <small>Please lets us know what you are looking from this platform. This will help us to find any macthing interests and will send you the matched organisation lists in your daily emails</small>
                                </div>
                                <!-- Custom plan options -->
                                {{-- <div class="row gap-md-0 gap-3 mb-4">
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
                                </div> --}}
                                <!--/ Custom plan options -->
                                
                                <div class="row gap-md-0 gap-3">
                                    <div class="col-md-12">
                                        <div class="text-body fw-semibold mb-2">We are looking for - </div>
                                        <label class="switch switch-success switch-square">
                                            <input type="checkbox" class="switch-input" />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"><i class="bx bx-check"></i></span>
                                                <span class="switch-off"><i class="bx bx-x"></i></span>
                                            </span>
                                            <span class="switch-label">Collaboration</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="switch switch-success switch-square">
                                            <input type="checkbox" class="switch-input" />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"><i class="bx bx-check"></i></span>
                                                <span class="switch-off"><i class="bx bx-x"></i></span>
                                            </span>
                                            <span class="switch-label">Potential Merger</span>
                                        </label>
                                    </div>
                                </div>
                                    <!--/ Other ares of Interest-->
                                <div class="row  mt-2 g-3">
                                    <div class="col-md-12">
                                        <div class="text-body fw-semibold mb-3">Other areas of interest - </div>
                                    </div>
                                    <div class="col-md-4">
                                        @foreach([
                                            'Aboriginal and Torres Strait Islander people',
                                            'Adults - aged 25 to under 65',
                                            'Adults - aged 65 and over',
                                            'Animals',
                                            'Children - aged 6 to under 15',
                                            'Early childhood - aged under 6',
                                            'Environment',
                                            'Families'
                                        ] as $key => $otherAreas)
                                            <div class="col-md">
                                                <div class="border-1 custom-option custom-option-image custom-option-image-radio form-check form-check-success mb-2 hover:shadow-sm">
                                                    <label class="form-check-label custom-option-content py-2 px-3" for="sub-category-{{ $key }}">
                                                        <input name="customRadioVariants" class="form-check-input" type="checkbox" value="" id="sub-category-{{ $key }}" />
                                                        <span class="fw-semibold">{{ $otherAreas }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-4">
                                        @foreach([
                                        'Females',
                                        'Financially disadvantaged people',
                                        'Males',
                                        'Migrants, refugees or asylum seekers',
                                        'Other',
                                        'Rural/regional/remote communities',
                                        'People with chronic illness'
                                        ] as $key => $otherAreas)
                                            <div class="col-md">
                                                <div class="border-1 custom-option custom-option-image custom-option-image-radio form-check form-check-success mb-2 hover:shadow-sm">
                                                    <label class="form-check-label custom-option-content py-2 px-3" for="sub-category-{{ $key }}">
                                                        <input name="customRadioVariants" class="form-check-input" type="checkbox" value="" id="sub-category-{{ $key }}" />
                                                        <span class="fw-semibold">{{ $otherAreas }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                
                                    <div class="col-md-4">
                                        @foreach([
                                            'People with disabilities',
                                            'Pre/post-release offenders/their families',
                                            'Unemployed persons',
                                            'Veterans and/or their families',
                                            'Victims of crime (including family violence)',
                                            'Victims of disaster',
                                            'Youth - 15 to under 25'
                                        ] as $key => $otherAreas)
                                            <div class="col-md">
                                                <div class="border-1 custom-option custom-option-image custom-option-image-radio form-check form-check-success mb-2 hover:shadow-sm">
                                                    <label class="form-check-label custom-option-content py-2 px-3" for="sub-category-{{ $key }}">
                                                        <input name="customRadioVariants" class="form-check-input" type="checkbox" value="" id="sub-category-{{ $key }}" />
                                                        <span class="fw-semibold">{{ $otherAreas }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row flex-column">
                                    <!-- Buttons -->

                                    <div class="col-12 d-flex justify-content-between mt-3">
                                        <button class="btn btn-label-secondary btn-prev" disabled>
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next"><span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                                    </div>
                                </div>
                                
                                    

                                
                            </div>



                            <!-- My Prefereances -->
                            <div id="preferencesLinksValidation" class="content">
                                <div class="content-header mb-3">
                                    <h5 class="mb-1">My Preferences</h5>
                                    <small>The preferences to get emails based on what you are looking for &amp; offering</small>
                                </div>
                                <!-- Custom plan options -->
                                <div class="row gap-md-0 gap-3 mb-4">
                                   
                                        <div class="col-md-6 mt-2">
                                            <div class="content-header mb-3">
                                                <h6 class="mb-1">We are looking for the followings </h6>
                                            </div>


                                            @foreach([
                                            'Office space to Share',
                                            'Office space to rent',
                                            'Storage to share',
                                            'Storage to rent',
                                            'IT support',
                                            'Development Support',
                                            'NDIS provider',
                                            'Aged Care service'
                                            ] as $key => $otherAreas)
                                            <div class="mt-2">
                                                <label class="switch switch-success switch-square">
                                                    <input type="checkbox" class="switch-input" />
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                                    </span>
                                                    <span class="switch-label">{{ $otherAreas }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="col-md-6 mt-2">
                                            <div class="content-header mb-3">
                                                <h6 class="mb-1">We can offer others the following </h6>
                                            </div>


                                            @foreach([
                                            'Office space to Share',
                                            'Office space to rent',
                                            'Storage to share',
                                            'Storage to rent',
                                            'IT support',
                                            'Development Support',
                                            'NDIS provider',
                                            'Aged Care service'
                                            ] as $key => $otherAreas)
                                            <div class="mt-2">
                                                <label class="switch switch-success switch-square">
                                                    <input type="checkbox" class="switch-input" />
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                                    </span>
                                                    <span class="switch-label">{{ $otherAreas }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                   
                                </div>
                                <!--/ Custom plan options -->
                                
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-next btn-submit">Finish</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Multi Steps Registration -->

        @push('vendor-script')
            <script src="/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
        @endpush

        @push('scripts')
            <script>
                $(document).ready(() => {
                    window.Helpers.initCustomOptionCheck();

                    // const wizardVertical = document.querySelector(".bs-stepper");

                    // if (typeof wizardVertical !== undefined && wizardVertical !== null) {
                    //     const wizardVerticalBtnNextList = [].slice.call(wizardVertical.querySelectorAll('.btn-next')),
                    //         wizardVerticalBtnPrevList = [].slice.call(wizardVertical.querySelectorAll('.btn-prev')),
                    //         wizardVerticalBtnSubmit = wizardVertical.querySelector('.btn-submit');

                    //     const numberedVerticalStepper = new Stepper(wizardVertical, {
                    //         linear: false
                    //     });
                    //     if (wizardVerticalBtnNextList) {
                    //         wizardVerticalBtnNextList.forEach(wizardVerticalBtnNext => {
                    //         wizardVerticalBtnNext.addEventListener('click', event => {
                    //             numberedVerticalStepper.next();
                    //         });
                    //         });
                    //     }
                    //     if (wizardVerticalBtnPrevList) {
                    //         wizardVerticalBtnPrevList.forEach(wizardVerticalBtnPrev => {
                    //         wizardVerticalBtnPrev.addEventListener('click', event => {
                    //             numberedVerticalStepper.previous();
                    //         });
                    //         });
                    //     }
                    //     if (wizardVerticalBtnSubmit) {
                    //         wizardVerticalBtnSubmit.addEventListener('click', event => {
                    //         alert('Submitted..!!');
                    //         });
                    //     }
                    // }
                });
            </script>
        @endpush
    </div> 
</x-app-layout>