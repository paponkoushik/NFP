@props(['icon' => null, 'modal' => null, 'disabled' => null])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn']) }} @if($modal) data-bs-toggle="modal" data-bs-target="#{{ is_string($modal) ? $modal : 'modal'  }}" @endif @if($disabled) disabled @endif>
    @if($icon)
        <i class="{{ $icon }}"></i> 
    @endif

    {{ $slot }}
</button>
