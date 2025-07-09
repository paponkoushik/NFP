@props(['value', 'data' => null, 'error' => null])

@if($data)
    <div class="col mb-3">
        <label {{ $attributes->merge(['class' => 'd-flex justify-content-between form-label']) }}>
            <span>{{ $value }}</span>
            <a href="{{ $data['href'] }}" class="btn btn-label-facebook btn-xs px-1" target="_blank">
                {!! $data['label'] !!}
            </a>
        </label>

        {{ $slot }}

        @if ($error)
            <div class="my-1 invalid-feedback d-block text-sm">{{ $error }}</div>
        @endif
    </div>
@else
    <label {{ $attributes->merge(['class' => 'form-label']) }}>
        {{ $value ?? $slot }}
    </label>
@endif
