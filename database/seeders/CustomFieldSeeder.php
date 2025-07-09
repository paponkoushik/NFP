<?php

namespace Database\Seeders;

use App\Models\CustomField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('org_interest_cf_values')->truncate();
        DB::table('interest_cf_mappings')->truncate();
        DB::table('custom_fields')->truncate();

        $fields = [
            ['name' => 'offer_type', 'type' => 'radio'],
            ['name' => 'where', 'type' => 'text'],
            ['name' => 'where_looking', 'type' => 'text'],
            ['name' => 'where_offer', 'type' => 'text'],
            ['name' => 'from_date', 'type' => 'date'],
            ['name' => 'to_date', 'type' => 'date'],
            ['name' => 'resources', 'type' => 'text'],
            ['name' => 'is_resources', 'type' => 'bool', 'def_value' => 0],
            ['name' => 'ongoing', 'type' => 'bool', 'def_value' => 0],
            ['name' => 'is_fixed_amt', 'type' => 'bool', 'def_value' => 0],
            ['name' => 'is_fixed_amt2', 'type' => 'bool', 'def_value' => 0],
        ];

        CustomField::create()
    }
}
