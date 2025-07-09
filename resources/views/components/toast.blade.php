@props([
    'message' => '',
    'type' => 'success'
])

@php
    $show = empty($message) ? false : true;

    $icons = [
        'success' => 'check',
        'warning' => 'error',
        'danger' => 'error-circle',
        'default' => 'bell',
    ];

    $alertTypes = [
        'success' => 'SUCCESS',
        'warning' => 'WARNING',
        'info' => 'INFO',
        'danger' => 'ERROR',
        'error' => 'ERROR'
    ];
@endphp

<div 
    x-data="{ 
        show: @js($show), 
        message: @js($message), 
        type: @js($type), 
        icons: @js($icons), 
        alertTypes: @js($alertTypes), 
        timerId: null,
        closed() { this.show = false, this.clearTimerId() },
        setAutoHideTimer() {  this.clearTimerId(), this.timerId = setTimeout(() => { this.show = false }, 5000) },
        clearTimerId() { this.timerId ? clearTimeout(this.timerId) : null }
    }"
    x-on:notify.window="show = true; message = $event.detail.title; type = $event.detail.type; setAutoHideTimer();"
    x-init="setAutoHideTimer()"
    x-show="show"
    x-bind:class="`bs-toast toast toast-ex animate__animated my-2 animate__shakeX fade show bg-${type}`"
    role="alert" 
    style="display: none;"
    x-transition:leave.duration.500ms
>
    <div class="toast-header">
        <i x-bind:class="`bx bx-${icons[type]} me-2`"></i>
        <div class="me-auto fw-semibold" x-text="alertTypes[type]">!</div>
        
        <button type="button" class="btn-close" x-on:click="closed()"  aria-label="Close"></button>
    </div>
    <div class="toast-body" x-text="message"></div>
</div>