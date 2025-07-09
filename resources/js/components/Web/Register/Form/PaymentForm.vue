<script>

</script>

<template>
    <FormStep>
        <div class="content-header mb-3 fs-tiny">
            <h5 class="mb-1">Select Plan</h5>
            <span>Select plan as per your requirement</span>
        </div>

        <!-- Custom plan options -->
        <div class="row gap-md-0 gap-3 mb-4">
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="basicOption">
                        <span class="custom-option-body">
                            <h4 class="mb-2">Basic</h4>
                            <p class="mb-2">Small Organisation with under $500,000 annual revenue</p>
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
                            <h4 class="mb-2">Corporate</h4>
                            <p class="mb-2">Medium Organisation <br> with $500,000 to up to $3M annual revenue</p>
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
                            <p class="mb-2">Large Organisation with over 3M annual revenue</p>
                            <span class="d-flex justify-content-center">
                                <sup class="text-primary fs-big lh-1 mt-3">$</sup>
                                <span class="display-5 text-primary">250</span>
                                <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/month</sub>
                            </span>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="enterpriseOption" />
                    </label>
                </div>
            </div>
        </div>
        <!--/ Custom plan options -->

        <div class="content-header mb-3 fs-tiny">
            <h5 class="mb-1">Payment Information</h5>
            <span>Enter your card information</span>
        </div>

        <!-- Credit Card Details -->
        <div class="row g-3">
            <TextInput
                class="col-md-12"
                vlabel="card number"
                name="card_number"
                type="text"
                label="Card Number"
                placeholder="1356 3215 6548 7898"
            />
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
        </div>
        <!--/ Credit Card Details -->
    </FormStep>
</template>