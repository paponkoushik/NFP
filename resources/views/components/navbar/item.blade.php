@props([
    'liClass' => '',
    'icon',
    'dropdown'
])

@php $hasDropdown = isset($dropdown); @endphp

<li @class([
    'nav-item me-2 me-xl-0',
    'dropdown' => $hasDropdown,
    $liClass
])>
    <a {{ $attributes->class(['nav-link hide-arrow', 'dropdown-toggle' => $hasDropdown])->merge([]) }} @if($hasDropdown) data-bs-toggle="dropdown" @endif>
        @isset($icon)
            <i class="{{ $icon }}"></i>
        @endisset

        {{ $slot }}
    </a>

    @if($hasDropdown)
        <ul {{ $dropdown->attributes->class(['dropdown-menu dropdown-menu-end']) }}>
            {{ $dropdown }}
        </ul>
    @endif
</li>