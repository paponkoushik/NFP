<div class="card-datatable table-responsive pt-0 pb-0">
    <div class="dataTables_wrapper dt-bootstrap5 no-footer">
        {{ $slot }}

        <table {{ $attributes->merge(['class' => 'datatables-basic table border-top dataTable no-footer dtr-column']) }}>
            <thead {{ $head->attributes }}>
                <tr>
                    {{ $head }}
                </tr>
            </thead>
    
            <tbody {{ $body->attributes->class(['divide-y divide-cool-gray-200']) }}>
                {{ $body }}
            </tbody>
        </table>
        
        {{ $footer ?? '' }}
    </div>
</div>