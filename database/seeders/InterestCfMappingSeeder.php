<?php

namespace Database\Seeders;

use App\Models\CustomField;
use App\Models\Interest;
use App\Models\InterestCfMapping;
use Illuminate\Database\Seeder;

class InterestCfMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interests = Interest::whereNull('parent_id')->get();

        $customFields = [
            [
                'name' => 'Field-01',
                'type' => 'text',
            ],
            [
                'name' => 'Field-02',
                'type' => 'select',
                'values' => [
                    ['option1' => 'Option 1'],
                    ['option2' => 'Option 2'],
                    ['option3' => 'Option 3'],
                ]
            ],
            [
                'name' => 'Field-03',
                'type' => 'date',
            ],
            [   
                'name' => 'Field-04',
                'type' => 'date',
            ],
        ];

        foreach($customFields as $cf) {
            $store = CustomField::create($cf);

            foreach($interests as $int) {
                InterestCfMapping::create([
                    'interest_id' => $int->id,
                    'custom_field_id' => $store->id,
                    'slug' => $int->slug,
                ]);
            }
        }
    }
}
