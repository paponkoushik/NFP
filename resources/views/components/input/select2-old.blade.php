@props(['placeholder' => '', 'data' => []])

<div
    wire:ignore
    x-ref="rootSelect"
    x-data="{
        multiple: @js($attributes->get('multiple')),
        model: @entangle($attributes->wire('model')),
        data: @js($data),
        filteredData() {
            return this.data.map(item => {
                return {id: item.id, text: item.name}
            })
        },
        initSelect2() {            
            return $(this.$refs.select)
                .not('.select2-hidden-accessible')
                .select2({
                    dropdownParent: $(this.$refs.rootSelect),
                    data: this.filteredData()
                }) 
        },
        destroySelect2() {
            $(this.$refs.select).select2('destroy');
        }
    }"
    x-init="
        select2 = initSelect2();
        select2.on('select2:select', (event) => {
            console.log('called', event)
            model = multiple ? Array.from(event.target.options).filter(option => option.selected).map(option => option.value) : event.target.value;
        });
        select2.on('select2:unselect', (event) => {
            model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
        });
        $watch('model', (value, oldValue) => {      
            setTimeout(() => {
                destroySelect2();
                console.log(select2)


            }, 1200);
            select2.val(value).trigger('change');
        });
        $watch('data', (value, oldValue) => {      
            console.log('called', value)
        });
    "
{{-- 
    destroySelect2();
    select2 = initSelect2();
    select2.val(value).trigger('change');
--}}
    class="select2-container-wrapper position-relative"
>
    <select 
        x-ref="select" 
        data-placeholder="{{ $placeholder }}" 
        {{ $attributes->merge(['class' => 'select2 form-select']) }}
    >
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
</div>