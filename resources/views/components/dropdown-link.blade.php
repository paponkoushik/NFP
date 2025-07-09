@props([
    'href' => 'javascript:void(0);',
    'icon' => null,
    'divider' => null,
    'modal' => null
])

@if($divider)
    <div class="dropdown-divider"></div>
@endif

<a {{ $attributes->merge(['class' => "dropdown-item"]) }} href="{{ $href }}" @if($modal) data-bs-toggle="modal" data-bs-target="#{{ is_string($modal) ? $modal : 'modal'  }}" @endif>
    @if($icon)
        <i class="{{ $icon }} me-2"></i>
    @endif

    {{ $slot }}
</a>