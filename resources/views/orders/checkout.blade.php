<x-app-layout>
    <x-slot:title>Posts</x-slot>

    @push('styles')
        <style>
            .bs-stepper.wizard-icons .bs-stepper-header .step-trigger .bs-stepper-icon i {
                font-size: 45px !important;
                margin-bottom: 5px;
            }

            .step.active .bs-stepper-icon i,
            .step.active .bs-stepper-label {
                color: #696cff !important;
            }
        </style>
    @endpush

    <!-- Checkout Wizard -->
    <div class="row">
        <div class="card-header px-3 pb-4 d-flex justify-content-between">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Documents </span> Checkout</h4>
        </div>

        <div class="col-12">
            <!-- <stepper class="vertical" :items="steps" :separator="false" @submit="onSubmit" /> -->
            <div class="bs-stepper wizard-icons wizard-icons-example">
                
                <div class="bs-stepper-content border-top">
                    <form onSubmit="return false">
                        <cart-details></cart-details>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <!--/ Checkout Wizard -->

    @push('scripts')
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script src="/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
        <script>
            setTimeout(() => {
                const wizardIcons = document.querySelector('.wizard-icons-example');

                if (typeof wizardIcons !== undefined && wizardIcons !== null) {
                    const wizardIconsBtnNextList = [].slice.call(wizardIcons.querySelectorAll('.btn-next')),
                        wizardIconsBtnPrevList = [].slice.call(wizardIcons.querySelectorAll('.btn-prev')),
                        wizardIconsBtnSubmit = wizardIcons.querySelector('.btn-submit');

                    const iconsStepper = new Stepper(wizardIcons, {
                        linear: false
                    });
                    if (wizardIconsBtnNextList) {
                        wizardIconsBtnNextList.forEach(wizardIconsBtnNext => {
                            wizardIconsBtnNext.addEventListener('click', event => {
                                iconsStepper.next();
                            });
                        });
                    }
                    if (wizardIconsBtnPrevList) {
                        wizardIconsBtnPrevList.forEach(wizardIconsBtnPrev => {
                            wizardIconsBtnPrev.addEventListener('click', event => {
                                iconsStepper.previous();
                            });
                        });
                    }
                    if (wizardIconsBtnSubmit) {
                        wizardIconsBtnSubmit.addEventListener('click', event => {
                            alert('Submitted..!!');
                        });
                    }
                }
            }, 500)
        </script>
    @endpush
</x-app-layout>

<style>
    .step.two {
    pointer-events: none;
}

.step.three {
    pointer-events: none;
}
</style>
