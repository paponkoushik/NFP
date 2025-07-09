@props([
    'icon' => null, 
    'href', 
    'label'
])

<li {{ $attributes->class(['menu-item', 'active' => request()->url() == $href]) }}>
    <a  href="{{ $href }}" class="menu-link">
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif

        <div data-i18n="{{ $label }}">{{ $label }}</div>
    </a>
</li>