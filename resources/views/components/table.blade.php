@props(['divattr' => null])
<div class="table-responsive rounded {{ $divattr }}">
    <table {{ $attributes->merge(['class' => 'table']) }}>
        <thead {{ $head->attributes->merge(['class' => '']) }}>
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody {{ $body->attributes->merge(['class' => '']) }}>
            {{ $body }}
        </tbody>
    </table>

    {{ $footer ?? '' }}
</div>