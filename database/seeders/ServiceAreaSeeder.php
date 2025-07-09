<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\ServiceArea;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            'Disability',
            'Youth Services',
            'Family Violence',
            'Agriculture',
            'Arts and Culture',
            'Community development',
            'Economic development',
            'Education',
            'Environment Preservation',
            'Health',
            'Human rights',
            'Human Services',
            'Information & Communication', 'Other'
        ];

        $subAreas = [
            'Basic and emergency aid',
            'Family services',
            'Human services information',
            'Job services',
            'Personal services',
            'Environment Preservation',
            'Health',
            'Human rghts',
            'Human Services',
            'Shelter and residential care', 'Other'
        ];

        foreach ($areas as $area) {
            $area = ServiceArea::create([
                'name' => $area,
                'code' => Str::slug($area, '-') . rand(10, 99)
            ]);

            // create sub-areas
            for ($i = 0; $i <= rand(0, 9); $i++) {
                $subArea = $subAreas[rand(0, 9)];
                ServiceArea::create([
                    'parent_id' => $area->id,
                    'name' => $subArea,
                    'code' => $area->id . '-' . Str::slug($subArea, '-') . rand(100, 999)
                ]);
            }
        }
    }
}
