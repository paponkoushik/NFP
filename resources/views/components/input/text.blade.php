@props([
    'error' => false,
    'leadingAddOn' => false,
    'ngClass' => null, // ng = input group class
])

@if($leadingAddOn)
<div class="input-group input-group-merge {{ $ngClass ?? '' }}">
    <span class="input-group-text px-2">{!! $leadingAddOn !!}</span>
@endif

<input {{ $attributes->merge(['class' => 'form-control' . ($error ? ' is-invalid' : '')]) }}/>

@if($leadingAddOn)
</div>
@endif

@if ($error)
    <div class="my-1 invalid-feedback text-sm">{{ $error }}</div>
@endif
