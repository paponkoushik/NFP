@php 
    $titles = [
        'Collaborate with another charity that delivers services to adults with disabilities',
        'Merge with another not for profit organisation',
        'Selling a For profit osteopathic services business'
    ];
@endphp

<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
        <img class="img-fluid rounded-top" src="../../assets/img/backgrounds/example-{{ rand(1, 3) }}-{{ rand(1, 1) }}.jpg" alt="Card image cap" />
        <div class="featured-date mt-n4 ms-4 bg-white rounded w-px-50 shadow text-center p-1">
            <h5 class="mb-0 text-dark">{{ rand(10, 31) }}</h5>
            <span class="text-primary">{{ strtoupper(date('M', mt_rand(1, time()))) }}</span>
        </div>
        <div class="card-body">
            <a href="/posts/{{ $i }}/show">
                <h5 class="text-truncate">{{ $titles[rand(0, 2)] }}</h5>
            </a>
            
            <div class="d-flex gap-2">
                <span class="badge bg-label-primary">Technical</span>
                <span class="badge bg-label-primary">Account</span>
                <span class="badge bg-label-primary">Excel</span>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-3">
                <div class="card-actions">
                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                </div>
                <div class="dropup d-none d-sm-block">
                    <button class="btn p-0" type="button" id="sharedList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sharedList">
                        @if($editable)
                            <a class="dropdown-item" href="/posts/{{ $i }}/edit">Edit</a>
                        @endif
                        <a class="dropdown-item" href="/posts/{{ $i }}/show">Details</a>
                        {{-- <a class="dropdown-item hover:text-red-600" href="javascript:void(0);">Delete</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>