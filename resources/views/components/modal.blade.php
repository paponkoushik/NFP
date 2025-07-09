@props([
    'title' => '',
    'id' => null,
    'maxWidth' => null, // .modal-{sm|lg|xl}
    'position' => null, // .modal-{dialog-centered|fullscreen}
    'backdrop' => 'static',
    'formAction' => null
])

@php 
    $bsModal = empty($id) ? false : true; 
    $modalPosition = ['centered' => 'modal-dialog-centered', 'fullscreen' => 'modal-fullscreen'][$position] ?? '';
@endphp

<!-- Modal -->
<div wire:ignore.self 
    {{ $attributes->class(['modal', 'fade' => $bsModal, 'animate__animated animate__zoomIn d-block show' => !$bsModal]) }} 
    @if($bsModal) id="{{ $id }}" @endif
    data-bs-backdrop="{{ $backdrop }}" 
    tabindex="-1" 
    aria-hidden="true"
>
    <div 
        @class([
            'modal-dialog',
            "modal-{$maxWidth}" => $maxWidth ? true : false,
            "{$modalPosition}" => $modalPosition ? true : false,
        ]) role="document"
    >
        @if($formAction)
            <v-form @submit="{{ $formAction }}">
        @endif

        <div class="modal-content">
            <div class="modal-header">
                @if($title)
                    <h5 class="modal-title">{{ $title }}</h5>
                @endif

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div {{ $body->attributes->merge(['class' => 'modal-body py-2']) }}>
                {{ $body }}
            </div>

            <div {{ $footer->attributes->merge(['class' => 'modal-footer pb-3']) }}>
                {{ $footer ?? '' }}
            </div>
        </div>

        @if($formAction)
            </v-form>
        @endif   
    </div>     
</div>
