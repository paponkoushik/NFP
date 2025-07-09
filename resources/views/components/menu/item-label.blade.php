@props(['label'])

<li {{ $attributes->class(['menu-header small text-uppercase']) }}>
    <span class="menu-header-text">{!! $label !!}</span>
</li>