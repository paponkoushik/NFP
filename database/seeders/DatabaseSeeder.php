<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * List of tables to run database seed.
     *
     * @var array
     */
    private $tables = [
        'users',
        'categories',
        'service_areas',
        'interests',
        'areas',
        'organisations',
        'org_users',
        'workflows',
        'listings',
        'legal_requests',
        'comms',
        'messages',
        'tags',
        'collections',
        'documents',
        'locations',
    ];

    /**
     * Truncate tables data before run seed.
     *
     * @return void
     */
    private function truncateDatabase()
    {
        foreach ($this->tables as $tableName) {
            DB::table($tableName)->truncate();
        }
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $this->truncateDatabase();
        // run database seed
        $seeders = [
            LocationSeeder::class,
            AreaSeeder::class,
            CategorySeeder::class,
            ServiceAreaSeeder::class,
            //            InterestSeeder::class,
            UserSeeder::class,
            LegalRequestSeeder::class,
            WorkflowsSeeder::class,
            TagSeeder::class,
            CollectionSeeder::class,
            DocumentSeeder::class,
            CommunicationSeeder::class
        ];
        if (app()->environment('production')) {
            $seeders = [
                LocationSeeder::class,
                AreaSeeder::class,
                CategorySeeder::class,
                ServiceAreaSeeder::class,
                UserSeeder::class,
                WorkflowsSeeder::class
            ];
        }
        $this->call($seeders);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
