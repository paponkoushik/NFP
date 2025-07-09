@props(['type' => 'page'])
<!-- Logo -->
@if($type == 'vertical-menu')
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- <i class="bx bx-image-add fa-3x"></i> --}}
                <x-app-logo-img height="90px" />
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">
                {{ config('app.name') }}
            </span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
@elseif($type == 'horizontal-menu')
{{ config('app.name') }}
@else 
    <div {{ $attributes->merge(['class' => 'app-brand']) }}>
        <a href="/" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                {{-- <i class="bx bx-image-add fa-3x"></i> --}}
                <x-app-logo-img height="90px" />
            </span>
            {{-- <span class="app-brand-text demo text-body fw-bolder text-uppercase">{{ config('app.name') }}</span> --}}
        </a>
    </div>
@endif
<!-- /Logo -->