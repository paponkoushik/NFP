@props(['icon' => 'fa fa-info-circle text-info', 'content' => '', 'label' => '', 'alignment' => 'bottom'])

<span {{ $attributes }}
    data-bs-toggle="tooltip" 
    data-bs-offset="0,4" 
    data-bs-placement="{{ $alignment }}"
    data-bs-html="true" 
    title="{!! $content !!}"
>
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    
    {{ $label }}
</span>