@props(['href' => 'javascript:;', 'active' => false, 'icon' => null, 'modal' => null])

<a {{ $attributes }} href="{{ $href }}" @if($modal) data-bs-toggle="modal" data-bs-target="#{{ is_string($modal) ? $modal : 'modal'  }}" @endif>
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif

    {{ $slot }}
</a>
