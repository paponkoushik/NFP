@props([
    'boxType' => 'basic', // basic, icon
    'title',
    'subTitle' => '',
    'for' => '',
    'icon' => null,
    'image' => null
])

@php $isBasicType = $boxType == 'basic' ? true : false; @endphp

<div class="form-check custom-option custom-option-{{ $boxType }}">
    <label class="form-check-label custom-option-content" for="{{ $for }}">

        @if($isBasicType)
            <input {{ $attributes->merge(['class' => 'form-check-input', 'type' => 'radio', 'id' => $for]) }} />

            <span class="custom-option-header">
                <span class="fw-semibold">{{ $title }}</span>
                <span class="fw-semibold">{{ $subTitle }}</span>
            </span>
        @endif

        <span class="custom-option-body">
            @if($icon) 
                <i class="{{ $icon }}"></i>
            @elseif($image)
                <img src="{{ $image }}" class="w-px-40 mb-2" alt="Picture">
            @endif

            @if(!$isBasicType)
                <span class="custom-option-title">{{ $title }}</span>
            @endif

            {{ $slot }}
        </span>

        @if(!$isBasicType)
            <input {{ $attributes->merge(['class' => 'form-check-input', 'type' => 'radio', 'id' => $for]) }} />
        @endif
    </label>
</div>

