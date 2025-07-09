@props([
    'placeholder' => null,
    'trailingAddOn' => null,
])

<select {{ $attributes->merge(['class' => 'form-select' . ($trailingAddOn ? ' rounded-r-none' : '')]) }}>
  @if ($placeholder)
      <option value="">{{ $placeholder }}</option>
  @endif

  {{ $slot }}
</select>

@if ($trailingAddOn)
  {{ $trailingAddOn }}
@endif
