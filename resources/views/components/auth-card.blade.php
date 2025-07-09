@props([
    'layout' => 'basic', // basic, cover
    'step' => 'single' // multi, single
])

@php 
    $isCoverLayout = $layout == 'cover' ? true : false; 
@endphp 

@if(!$isCoverLayout)
    <div class="container-xxl">
@endif
    <div @class([
        'authentication-wrapper' => true,
        'authentication-basic container-p-y' => !$isCoverLayout,
        'authentication-cover' => $isCoverLayout,
    ])>
        @if($isCoverLayout)
            <div class="authentication-inner row m-0">              
                <!-- /Left Text -->
                <div {{ $coverImg->attributes->class(['d-none d-lg-flex align-items-center p-5', 'col-lg-7 col-xl-8' => $step == 'single'])->merge([]) }}>
                    <div class="w-100 d-flex justify-content-center">
                        {{ $coverImg }}    
                    </div>
                </div>
                <!-- /Left Text -->
            
                <!-- Login -->
                <div @class([
                    'd-flex align-items-center authentication-bg p-sm-5' => true,
                    'col-12 col-lg-5 col-xl-4 p-4' => $step === 'single',
                    'col-lg-8 p-3' => $step === 'multi',

                ])>
                    <div @class([
                        'mx-auto', 
                        'w-px-400' => $step === 'single', 
                        'w-px-700' => $step === 'multi'
                    ])>
                        <x-application-logo class="mb-5 ms-n4" />

                        {{ $slot }}
                    </div>
                </div>
            </div>
        @else
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <a href="/">
                            <x-application-logo class="justify-content-center" />
                        </a>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        @endif
    </div>

@if(!$isCoverLayout)
    </div>
@endif
