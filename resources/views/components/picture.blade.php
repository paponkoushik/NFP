@props(['src', 'class' => 'rounded-circle'])

<div class="avatar-wrapper">
    <div class="avatar me-2">
        <img class="{{ $class }}" src="{{ $src ? $src : '/img/no-image.png' }}" alt="Picture" />
    </div>
</div>