@props([
    'liClass' => '',
    'icon' => null,
    'dropdown'
])

@php 
    $hasDropdown = isset($dropdown); 
    $liClass = $liClass . (request()->url() == $attributes->get('href')) ? 'active' : ''; 
@endphp

<li class="menu-item {{ $liClass }}">
    <a  {{ $attributes->class(['menu-link', 'menu-toggle' => $hasDropdown]) }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif

        {{ $slot }}
    </a>

    @if($hasDropdown)
        <ul {{ $dropdown->attributes->class(['menu-sub']) }}>
            {{ $dropdown }}
        </ul>
    @endif
</li>