<?php

namespace Database\Seeders;

use App\Models\Comms;
use App\Models\LegalRequest;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Organisation;
use Illuminate\Database\Seeder;

class LegalRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Organisation::factory()->count(10)->create();

        Listing::factory()->count(10)->create();

        LegalRequest::factory()->count(5)->create();

//        $comms = Comms::factory()->create();
//
//        $messages = Message::factory()
//                    ->count(1)
//                    ->for($comms)
//                    ->create();
    }
}
