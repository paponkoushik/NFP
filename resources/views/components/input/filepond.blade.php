@props(['placeholder' => 'file'])

<div
    wire:ignore
    x-data
    x-init="() => {
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const pond = FilePond.create($refs.input);
        pond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
            labelIdle: `<div class='fw-normal font-14'><i class='bx bx-up-arrow-circle text-primary me-1 font-16'></i> Drop your {{ $placeholder }} here or <span class='filepond--label-action'>Browse</span></div>`,
            credits: false,
        });
    }"
>
    <input type="file" x-ref="input">
</div>
