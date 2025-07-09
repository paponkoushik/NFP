<?php

namespace Database\Seeders;

use App\Models\Workflow;
use Illuminate\Database\Seeder;

class WorkflowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (workflowSteps() as $key => $step) {
            if ($key == 'new' || $key == 'in-progress') {
                Workflow::create([
                    'stage_code' => $key,
                    'status_name' => $step,
                    'is_default' => true,
                    'sequence' => 1
                ]);

                if ($key == 'in-progress') {
                    Workflow::create([
                        'stage_code' => $key,
                        'status_name' => 'On Hold',
                        'is_default' => true,
                        'sequence' => 2
                    ]);
                }
            } else {
                Workflow::create([
                    'stage_code' => $key,
                    'status_name' => 'Completed',
                    'is_default' => true,
                    'sequence' => 1
                ]);

                Workflow::create([
                    'stage_code' => $key,
                    'status_name' => 'Invalid',
                    'is_default' => true,
                    'sequence' => 2
                ]);
            }
        }
    }
}
