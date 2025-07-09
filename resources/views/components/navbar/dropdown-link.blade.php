@props(['icon'])

<li>
    <a {{ $attributes->merge(['class' => 'dropdown-item']) }}>
        @isset($icon)
            <i class="{{ $icon }}"></i>
        @endisset

        {{ $slot }}
    </a>
</li>