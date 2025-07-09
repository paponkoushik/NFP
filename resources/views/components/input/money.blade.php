@props([
    'leadingAddOn' => '$',
    'trailingAddOn' => null
])

<div class="input-group input-group-merge">
    <span class="input-group-text">{!! $leadingAddOn !!}</span>

    <input {{ $attributes->merge(['class' => 'form-control']) }} aria-describedby="price-currency">

    @if($trailingAddOn)
        <span class="input-group-text">{!! $trailingAddOn !!}</span>
    @endif
</div>
