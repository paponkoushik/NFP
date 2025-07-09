<x-app-layout>
    <div class="row mt-2">
        <x-slot:title>Workflows</x-slot>

        <div class="col-12">
            <div class="card">
                <x-card-header title="Workflows of Non-profit" class="pt-3 mb-2" />
            
                <workflows :steps="@js(workflowSteps())"></workflows>
            </div>
        </div>
    </div> 
</x-app-layout>