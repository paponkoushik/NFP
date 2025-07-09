<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'email'             => 'superadmin@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'super-admin',
                'phone'             => '+880 1829 648572',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'NFP',
                'last_name'         => 'Admin',
                'email'             => 'tanvir.gaus+nfp@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'nfp-admin',
                'phone'             => '+880 1829 648572',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Client',
                'last_name'         => 'Admin',
                'email'             => 'tanvir.gaus+client@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'client-admin',
                'phone'             => '+880 1829 648572',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Org',
                'last_name'         => 'Admin',
                'email'             => 'tanvir.gaus+org@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'org-admin',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Org',
                'last_name'         => 'Admin',
                'email'             => 'koushik@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'org-admin',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Org',
                'last_name'         => 'Admin',
                'email'             => 'papon@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'org-admin',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Individual',
                'last_name'         => 'Admin',
                'email'             => 'papon1@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'individual',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Legal',
                'last_name'         => 'Admin',
                'email'             => 'tanvir.gaus+legal@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'legal-admin',
                'phone'             => '+880 1829 648572',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Vera',
                'last_name'         => 'Visevic',
                'email'             => 'vera@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'legal-admin',
                'phone'             => '+6141234567',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Lawyer',
                'last_name'         => 'Panel',
                'email'             => 'tanvir.gaus+lawyer@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'lawyer',
                'phone'             => '+880 1829 648572',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Alex',
                'last_name'         => 'Billy',
                'email'             => 'tanvir.gaus+lawyer1@gmail.com',
                'password'          => Hash::make('p@ssword'),
                'role'              => 'lawyer',
                'phone'             => '+880 1829 648572',
                'is_accept_terms'   => true,
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        ];

        if (app()->environment('production')) {
            $users = [
                [
                    'first_name'        => 'Super',
                    'last_name'         => 'Admin',
                    'email'             => 'superadmin@gmail.com',
                    'password'          => Hash::make('p@ssword'),
                    'role'              => 'super-admin',
                    'phone'             => '+880 1829 648572',
                    'is_accept_terms'   => true,
                    'status'            => 'active',
                    'email_verified_at' => now(),
                ]
            ];
        }

        foreach ($users as $user) {
            $user = User::create($user);
            if ($user->role == 'org-admin' || $user->role == 'individual') {
                $org = Organisation::create([
                    'org_name'      => 'Dummy Organisation:' . rand(100, 999),
                    'user_hash'     =>  md5(uniqid()),
                    'slug'          => 'dummy-organisation:' . rand(100, 999),
                    'abn'           => rand(1000, 9999),
                    'alias'         => 'Anonymous ' . rand(1000, 9999),
                    'logo'          => null,
                    //                    'client_type' => 'nfp',
                    'client_type'   => $user->role == 'individual' ? 'individual' : 'nfp',
                    //                    'logo' => '/assets/img/photos/b' . rand(4, 7) . ".jpg",
                    // 'address' => 'Melbourne, Australia',
                    'contact_email' => $user->email,
                    'contact_phone' => $user->phone,
                    'summary'       => 'Melbourne is the coastal capital of the southeastern Australian state of Victoria. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. ',
                    'details'       => 'a performing arts complex – and the National Gallery of Victoria, with Australian and indigenous art.'
                ]);

                $user->organisations()->attach($org->id, ['role' => $user->role]);

                $org->serviceAreas()->attach([16, 18, 30]);

                //$org->areas()->attach([1, 5, 8]);

                $org->locations()->create([
                    'location_id'=> 1,
                    'city'       => 'ANU',
                    'state'      => 'ACT',
                    'postcode'   => '0200',
                    'locality'   => 'ANU',
                    'lat'        => '-35.2777',
                    'long'       => '149.119',
                    'sa4'        => '701',
                    'sa4_name'   => 'Darwin',
                    'lga_region' => 'Darwin Waterfront Precinct',
                    'lga_code'   => '71000',
                    'is_primary' => true
                ]);

                /*$org->preferences()->createMany([
                    ['user_id' => $user->id, 'slug' => 'office-space-to-share', 'title' => preferencesList()['office-space-to-share']],
                    ['user_id' => $user->id, 'slug' => 'office-space-to-rent', 'title' => preferencesList()['office-space-to-rent']],
                ]);*/
            }
        }

        // User::factory(100)->create();
    }
}
