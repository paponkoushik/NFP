<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comms;
use App\Models\User;
use App\Models\OrgUser;
use App\Models\Organisation;

class CommunicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Comms::factory()->hasMessages(12)->count(200)->create();
//
//        Organisation::all()->each(function($org) {
//            OrgUser::create([
//                'organisation_id' => $org->id,
//                'user_id' => User::all()->random()->first()->id,
//            ]);
//        });

    }
}
