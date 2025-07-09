<form wire:loading.class.delay="opacity-50">
    <x-modal id="modal" maxWidth="xl" title="Request Details">
        <x-slot:body>
            <div class="row g-2">
                <div class="col-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                {{-- <div class="avatar avatar-lg me-2">
                                    <span class="avatar-initial rounded-circle bg-label-warning">
                                        <i class="bx bx-image fs-4"></i>
                                    </span>
                                </div> --}}
                                <div>
                                    <h4 class="mb-1">Case file of Real Estate</h4>
                                    <p class="mb-0 text-secondary">
                                        <small class="emp_post text-truncate text-muted">
                                            Web & Development <small>></small> Software Engineer
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <p class="fw-bold small mb-1 text-uppercase">
                                        Post Details:
                                    </p>

                                    <p>
                                        Lump-sum refers to a large amount of money and lump-sum payment is a significant amount of money someone pays in a single payment, unlike making a series of payments over time or in regular intervals. It has advantages and disadvantages and the benefits vary....
                                    </p>

                                    <div class="pointer">
                                        <span class="fw-bold text-black text-decoration-underline">Show more</span>
                                        <i class="bx bx-chevron-right fs-4"></i>
                                    </div>
                                </div>
                                <div class="col-4 rounded-3 shadow-sm">
                                    <div class="px-2 py-3">
                                        <div class="d-flex flex-column mb-2">
                                            <span class="fw-semibold">Offered Amount: </span>
                                            <span class="text-success">$15,548.00</span>
                                        </div>

                                        <div class="d-flex flex-column mb-2">
                                            <span class="fw-semibold">Agreed Amount: </span>
                                            <span class="text-info">$15,015.00</span>
                                        </div>

                                        <span class="badge bg-label-success rounded-pill">
                                            <i class="bx bxs-check-circle"></i>
                                            Offer Accepted
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shadow-sm rounded p-3">
                        {{-- ./ Summary tab --}}
                        <div class="row">
                            <x-input.group class="col mb-3" for="goals" label="Summary:" :error="$errors->first('form.notes')">
                                <x-input.textarea wire:model.defer="form.goals_objectives" rows="3" placeholder="Enter Summary" />
                            </x-input.group>
                        </div>
                        {{-- ./ Summary tab --}}

                        <p class="fw-bold mb-1 text-uppercase"><i class="bx bx-pencil"></i> Notes: </p>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <thead class="bg-label-secondary">
                                    <tr>
                                        <th class="w-px-150">Stage</th>
                                        <th>Notes</th>
                                        <th>When</th>
                                        <th>Who</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-top">
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option value="single">New</option>
                                                <option value="single">In Progress</option>
                                                <option value="single">Done</option>
                                                <option value="single">Invalid</option>
                                                <option value="single">On Hold</option>
                                            </select>
                                        </td>
                                        <td colspan="3">
                                            <x-input.textarea wire:model.defer="form.comments" placeholder="Enter Note" />
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-info px-1"
                                                data-bs-toggle="tooltip"
                                                data-bs-offset="0,4"
                                                data-bs-placement="right"
                                                data-bs-custom-class="tooltip-info"
                                                title="Add New Note"
                                            >
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-label-warning">New</span></td>
                                        <td>The recommended dosage is 1 mg once a day. Recur may be administered with or without meals. In general, daily use for three months or more is necessary</td>
                                        <td>{{ date('d/m/Y') }}</td>
                                        <td>Tanvir Gus</td>
                                        <td><i class="bx bx-trash text-danger"></i></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-label-danger">Invalid</span></td>
                                        <td>Recur may be administered with or without meals. In general, daily use for three months.</td>
                                        <td>{{ date('d/m/Y') }}</td>
                                        <td>Tanvir Gus</td>
                                        <td><i class="bx bx-trash text-danger"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @php
                    $images = [
                        ['example-1-1.jpg', 'example-1-2.jpg'],
                        ['example-2-1.jpg', 'example-2-2.jpg'],
                        ['example-3-1.jpg', 'example-3-2.jpg']
                    ][rand(0, 2)];
                @endphp
                <div class="col-4">
                    <div class="card ms-4 mb-3">
                        <div class="carousel rounded" data-flickity='{ "fade": true, "lazyLoad": true, "fullscreen": true, "pageDots": false }'>
                            <div class="carousel-cell h-px-200">
                                <img class="carousel-cell-image"
                                data-flickity-lazyload="{{ asset('assets/img/backgrounds/' . $images[0]) }}" alt="tulip" />
                            </div>
                            <div class="carousel-cell h-px-200">
                                <img class="carousel-cell-image"
                                data-flickity-lazyload="{{ asset('assets/img/backgrounds/' . $images[1]) }}" alt="grapes" />
                            </div>
                        </div>
                    </div>

                    <div class="card ms-4">
                        <p class=" card-title fw-bold mb-0 px-3 py-2 border-bottom">Contract Between: </p>
                        <div class="card-body p-3">
                            <div>
                                <p class="mb-0 fw-bold">Hipaa Company NFP</p>
                                <p class="mb-0">John Doe</p>
                                <p class="my-1">&</p>
                                <p class="mb-0 fw-bold">Smart-catalog Tech Ltd.</p>
                                <p class="mb-0">Tanvir Gus</p>
                            </div>

                            <hr class="my-2 mx-n3">

                            <div class="row g-2">
                                <x-input.date
                                    wire:model.defer="form.receive_date"
                                    class="col"
                                    label="Requested Date"
                                    placeholder="Enter Requested Date" />

                                <x-input.date
                                    wire:model.defer="form.reviewed_date"
                                    class="col"
                                    label="Offered Date"
                                    placeholder="Enter Offered Date" />

                                <x-input.date
                                    wire:model.defer="form.reviewed_date"
                                    class="col"
                                    label="Completed Date"
                                    placeholder="Enter Completed Date" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot:footer class="justify-content-between">
            <x-button class="btn-outline-danger ps-2" wire:loading.attr="disabled" data-bs-dismiss="modal">
                <i class="bx bx-x-circle me-1"></i> Cancel Request
            </x-button>

            <div>
                <x-button class="btn-info ps-2 me-2" wire:loading.class="loader"><i class="bx bx-up-arrow-circle me-1"></i> Save & Exit</x-button>
                <x-button class="btn-success ps-2" wire:loading.class="loader"><i class="bx bx-check-circle me-1"></i> Complete</x-button>
            </div>
        </x-slot>
    </x-modal>
</form>
