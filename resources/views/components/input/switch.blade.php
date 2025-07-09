@props(['label'])

<label class="switch {{ $attributes->get('class') }}">
    <input {{ $attributes->whereDoesntStartWith('class') }} type="checkbox" class="switch-input" />
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="bx bx-check"></i>
        </span>
        <span class="switch-off">
            <i class="bx bx-x"></i>
        </span>
    </span>
    <span class="switch-label">{{ $label ?? '' }}</span>
</label>
