@props([
    'label' => null,
    'for' => null,
    'error' => false,
    'helpText' => false,
    'inline' => false, // contain array of class list for label & div [0 => label class, 1 => div class]
    'paddingless' => false,
    'borderless' => false,
    'leadingAddOn' => null,
    'trailingAddOn' => null
])

@php 
    $labelFor = $for ?? strtolower(removeSpace($label, '-'));
@endphp

<div {{ $attributes }}>
    @if($inline)
        <label for="{{ $labelFor }}" class="{{ $inline[0] ?? 'col-md-2' }} col-form-label">{{ $label }}</label>

        <div class="{{ $inline[1] ?? 'col-md-10'}}">
            {{ $slot }}

            @if ($error)
                <div class="my-1 invalid-feedback d-block text-sm">{{ $error }}</div>
            @endif

            @if ($helpText)
                <div class="form-text">{{ $helpText }}</div>
            @endif
        </div>
    @else
        @if($label)
            <label for="{{ $labelFor }}" class="form-label fw-bold">
                {{ $label }}
            </label>
        @endif

        @if($leadingAddOn || $trailingAddOn)
            @php $addOnAttributes = $leadingAddOn ?? $trailingAddOn; @endphp
            
            <div {{ $addOnAttributes->attributes->merge(['class' => 'input-group input-group-merge']) }}>
        @endif

        @isset($leadingAddOn)
            <span class="input-group-text px-2">{{ $leadingAddOn }}</span>
        @endisset
        
        {{ $slot }}

        @isset($trailingAddOn)
            <span {{ $trailingAddOn->attributes->merge(['class' => 'input-group-text']) }}>{{ $trailingAddOn }}</span>
        @endisset

        @if($leadingAddOn || $trailingAddOn)
            </div>
        @endif

        @if ($error)
            <div class="my-1 invalid-feedback d-block text-sm">{{ $error }}</div>
        @endif

        @if ($helpText)
            <div class="form-text">{{ $helpText }}</div>
        @endif
    @endif
</div>
