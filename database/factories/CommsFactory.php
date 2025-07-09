<?php

namespace Database\Factories;

use App\Models\Comms;
use App\Models\Listing;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comms>
 */
class CommsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comms::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $number = fake()->numberBetween(1, 2);

        return [
            'listing_id' => ($number % 2 == 0) ? Listing::limit(5)->get()->random(1)->first()->id : null,
            'to_org_id' => Organisation::limit(3)->get()->random(1)->first()->id,
            'from_org_id' => Organisation::skip(3)->take(3)->get()->random(1)->first()->id,
            'is_offered' => fake()->numberBetween(0, 1),
//            'is_anonymous' => fake()->numberBetween(0, 1),
        ];
    }
}
