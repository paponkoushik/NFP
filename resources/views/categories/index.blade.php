<x-app-layout>
    <div class="row">
        <x-slot:title>Categories</x-slot>

            <category-index :exclude-fields="@js($excludeFields)"
                            :exclude-field-values="@js($excludeFieldValues)">
            </category-index>
    </div>
</x-app-layout>
