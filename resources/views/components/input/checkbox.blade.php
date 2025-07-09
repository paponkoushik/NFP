@props([
    'label',
    'for' => ''
])

<div class="form-check {{ $attributes->get('class') }}">
    <input {{ $attributes->whereDoesntStartWith('class')->merge(['type' => 'checkbox']) }}
        id="{{ $for }}"
        class="form-check-input"
    />
    <label class="form-check-label" for="{{ $for }}">
        {{ $label }}
    </label>
</div>
