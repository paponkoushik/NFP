<?php

namespace Database\Seeders;

use App\Imports\LocationImport;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0'); // disable foreign key constraints
        Location::truncate();
        Excel::import(new LocationImport, database_path('australian_postcodes.csv'));
        DB::statement('SET FOREIGN_KEY_CHECKS=1'); // enable foreign key constraints

        $this->command->info('Location table seeded successfully.');
    }
}
