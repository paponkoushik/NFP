@props([
    'label',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'helpText' => false,
    'leadingAddOn' => false,
    'ngClass' => null, // ng = input group class
    'tooltip' => null
])

@php 
    $wireModelName = $attributes->whereStartsWith('wire:model')->first(); 
@endphp

<div class="{{ $attributes->get('class') }}">
    <label for="{{ $wireModelName }}" class="form-label">
        {{ $label }}
        
        @if($tooltip)
            <x-tooltip content="{{ $tooltip }}" />
        @endif
    </label>

    @if($leadingAddOn)
        <div class="input-group input-group-merge {{ $ngClass ?? '' }}">
            <span class="input-group-text">{{ $leadingAddOn }}</span>
    @endif

    <input 
        {{ $attributes->whereStartsWith('wire:model') }}
        type="{{ $type }}"
        id="{{ $wireModelName }}"
        class="form-control @error($wireModelName) is-invalid @enderror"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
    />

    @if($leadingAddOn)
        </div>
    @endif

    @error ($wireModelName)
        <div class="my-1 invalid-feedback text-sm">{{ $message }}</div>
    @enderror

    @if ($helpText)
        <div class="form-text">{{ $helpText }}</div>
    @endif
</div>
