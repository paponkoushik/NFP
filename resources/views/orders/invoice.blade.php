<x-app-layout>
    <x-slot:title>Invoice</x-slot>

        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                            <div class="mb-xl-0 mb-4">
                                <div class="d-flex svg-illustration mb-3 gap-2">
                                    <img src="{{ asset('/assets/img/logo-dark.png') }}" alt="Logo"
                                         style="height: 55px;">
                                </div>

                                <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
                                <p class="mb-1">San Diego County, CA 91905, USA</p>
                                <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
                            </div>
                            <div>
                                <h4>Invoice #{{ $invoice['order']['order_no'] }}</h4>
                                <div class="mb-2">
                                    <span class="me-1">Date Issues:</span>
                                    <span
                                        class="fw-semibold">{{ dateFormat($invoice['order']['created_at'], 'M d, Y') }} </span>
                                </div>
                                {{-- <div>
                                    <span class="me-1">Date Due:</span>
                                    <span class="fw-semibold">29/08/2020</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <hr class="my-0"/>

                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="pb-2">Invoice To:</h6>
                                <p class="mb-1">{{ $invoice['userInfo']['first_name'] }} {{ $invoice['userInfo']['last_name'] }}</p>
                                <p class="mb-1">{{$invoice['userInfo']->organisationUser->organisation->org_name  }}</p>
                                <p class="mb-1">{{ $invoice['userInfo']['address'] }}</p>
                                <p class="mb-1">{{ $invoice['userInfo']['phone'] }}</p>
                                <p class="mb-0">{{ $invoice['userInfo']['email'] }}</p>
                            </div>
                            {{-- <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <h6 class="pb-2">Bill To:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-3">Total Due:</td>
                                            <td>$399</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Bank name:</td>
                                            <td>American Bank</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Country:</td>
                                            <td>United States</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">IBAN:</td>
                                            <td>ETD95476213874685</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">SWIFT code:</td>
                                            <td>BR91905</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> --}}
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table border-top m-0">
                            <thead>
                            <tr>
                                <th>Document</th>
                                <th>Type</th>
                                <th>Tags</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @forelse($invoice['documentInfo'] as $document)

                                    <td class="text-nowrap">{{ $document['title'] }}</td>
                                    <td><span class="badge bg-label-secondary">{{ $document['file_type'] }}</span></td>
                                    <td class="text-nowrap text-primary">@foreach($document->documentTags as $tag)
                                            {{ $tag->name }}
                                        @endforeach</td>
                                    <td>${{  $document['price'] }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No documents found.</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="2" class="align-top px-4 py-5">
                                    <span>Thanks for your business</span>
                                </td>
                                <td class="text-end px-4 py-5">
                                    <p class="mb-2">Subtotal:</p>
                                    {{-- <p class="mb-2">Discount:</p>
                                    <p class="mb-2">GST:</p> --}}
                                    <p class="mb-0">Total:</p>
                                </td>
                                <td class="px-4 py-5">
                                    <p class="fw-semibold mb-2">${{ $invoice['order']['order_amount'] }}</p>
                                    {{-- <p class="fw-semibold mb-2">$48.00</p>
                                    <p class="fw-semibold mb-2">$35.00</p> --}}
                                    <p class="fw-semibold mb-0">${{ $invoice['order']['order_amount'] }}</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-semibold">Note:</span>
                                <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future cooperation. Thank You!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        {{--<button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                                data-bs-target="#sendInvoiceOffcanvas">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-3"></i>Send Invoice
                        </span>
                        </button>--}}

                    <a class="btn btn-label-secondary d-grid w-100 mb-3" href="{{route('download-invoice',['download'=>'pdf','id'=>$invoice['order']['id']])}}">Download</a>

                    <a class="btn btn-label-secondary d-grid w-100 mb-3" href="">
                        Print
                    </a>
                    {{-- <a href="javascript:void(0);" class="btn btn-label-secondary d-grid w-100 mb-3">
                        Edit Invoice
                    </a>

                    <button class="btn btn-primary d-grid w-100" data-bs-toggle="offcanvas" data-bs-target="#addPaymentOffcanvas">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-dollar bx-xs me-3"></i>Add Payment</span>
                    </button> --}}
                        {{--<a href="{{route('download-invoice',['download'=>'pdf','id'=>$invoice['order']['id']])}}"
                           class="btn btn-label-secondary d-grid w-100 mb-3">Download</a>--}}

                        {{--<button class="btn btn-primary d-grid w-100" data-bs-toggle="offcanvas"
                                data-bs-target="#addPaymentOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="bx bx-dollar bx-xs me-3"></i>Add Payment</span>
                        </button>--}}
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
</x-app-layout>
