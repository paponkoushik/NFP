@props([
    'title' => ''
])

<div {{ $attributes->merge(['class' => 'card-header px-3 pb-2']) }}>
    @if($title)
        <div class="head-label">
            <h5 class="card-title mb-0">{{ $title }}</h5>
        </div>   
    @else 
        <h4  {{ $heading->attributes->merge(['class' => 'fw-bold mb-0']) }}>
            {{ $heading }}
            {{-- <span class="text-muted fw-light">{{ $heading }}</span> Lists --}}
        </h4>
    @endif
    
    <div class="float-right">
        {{ $slot }}
    </div>
</div>