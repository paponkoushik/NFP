<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interests = [
            [
                "name" => 'Collaboration',
                "subCategory" => [
                    'Tender', 
                    'Projects', 
                    'Social Enterprise'
                    ]
            ],
            [
                "name" => 'Sponsorship',
                "subCategory" => [
                    'For project', 
                    'For an Event',
                    'On going'
                    ]
            ],
            [
                "name" => 'Potential Merger',
                "subCategory" => []
            ],
            [
                "name" => 'Resources',
                "subCategory" => [
                    'Premises', 
                    'Vehicles', 
                    'Volunteers', 
                    'Back office services', 
                    'Professional Services',
                    'Equipment'
                ]
            ],
        ];

        foreach ($interests as $key => $data) {
            $parent = Interest::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'sequence' => $key + 1
            ]);

            foreach($data['subCategory'] as $k => $subName) {
                Interest::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'parent_id' => $parent->id,
                    'sequence' => $k + 1
                ]); 
            }
        }
    }
}
