<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            'Agriculture, fisheries and forestry' => [
                'Domesticated animal welfare',
                'Wildlife welfare',
                'Domestic and exotic animal rescue and rehabilitation',
                'Vegetarianism / Veganism',
                'Veterinary medicine',
            ],
            'Animal welfare' => [
                'Agriculture',
                'Fishing and aquaculture',
                'Food security',
                'Forestry'
            ],
            'Arts and culture' => [
                'Crafts',
                'Cross artforms',
                'Festivals',
                'Historical activities',
                'Museums',
            ],
            'Community development ' => [
                'Community beautification',
                'Community facilities',
                'Community organising',
                'Community service organisations',
                'Grantmaking',
                'Neighbourhood associations',
                'Philanthropy promotion',
                'Community development',
                'Place-based interventions',
                'Population change',
                'Voluntarism',
            ],
            'Economic development' => [
                'Business and industry ',
                'Employment',
                'Financial services',
                'Housing development',
                'Rural development',
                'Sustainable development',
                'Urban and town development',
            ],
            'Health' => [
                'Complementary medicine',
                'Diseases and conditions',
                'Healthcare access',
                'Healthcare administration and financing',
            ],
            'Information and communications' => [
                'Communication media',
                'Information communications technology',
                'Libraries',
                'Media access and policy',
                'News and public information',
            ],
            'Religion and faith-based spirituality' => [
                'Baha\'i',
                'Religion and faith-based spirituality',
                'Buddhism',
                'Christianity',
                'Hinduism',
                'Indigenous religions and spiritual beliefs',
                'Interfaith',
                'Islam',
                'Judaism',
                'Shintoism',
                'Sikhism',
                'Spirituality',
                'Theology',
            ],
            'Sport and recreation' => [
                'Community recreation',
                'Camps',
                'Parks',
                'Playgrounds',
                'Sport facilities',
            ],
            'Public safety' => [
                'Abuse prevention',
                'Consumer protection',
                'Corrections and penology',
                'Courts',
                'Crime prevention',
                'Disasters and emergency management',
                'Fire prevention and control',
                'Legal services',
                'Safety education',
            ],
            'Public affairs' => [
                'Democracy',
                'Leadership development',
                'National security',
                'Public administration',
                'Public policy',
                'Public utilities',
            ],
        ];

        foreach ($areas as $name => $subAreas) {
            $area = Area::create([
                'name' => $name,
                'slug' => Str::slug($name, '-') . rand(10, 99)
            ]);

            foreach($subAreas as $subName) {
                Area::create([
                    'name' => $subName,
                    'slug' => Str::slug($area->id, '-') . rand(10, 99),
                    'parent_id' => $area->id
                ]); 
            }
        }
    }
}
