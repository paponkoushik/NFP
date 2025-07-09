@props([
    'group' => null, 
    'hover' => false, 
    'label' => '', 
    'icon' => 'bx bx-dots-vertical-rounded',
    'clickable' => null, // inside, outside, false
])

<div @class([
    'd-inline-block float-end' => !$group,
    'btn-group' => $group,
])>
    <button {{ $attributes->class(['btn dropdown-toggle', 'btn-icon hide-arrow' => !$group])->merge(['type' => 'button']) }} 
        data-bs-toggle="dropdown" 
        @if($hover) data-trigger="hover" @endif

        @if($clickable)
            data-bs-auto-close="{{ $clickable }}" 
            aria-expanded="false"
        @endif
    >
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif 
        
        {!! $label !!}
    </button>

    <div @class([
        'dropdown-menu' => true,
        'dropdown-menu-end m-0' => !$group
    ])>
        {{ $slot }}
    </div>
</div>
