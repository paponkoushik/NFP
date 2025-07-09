<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city' => fake()->city(),
            'state' => fake()->streetName(),
            'postcode' => fake()->postcode(),
            'address' => fake()->streetAddress(),
            'country' => fake()->country(),
            'lat' => fake()->latitude($min = -90, $max = 90),
            'lang' => fake()->longitude($min = -180, $max = 180),
        ];
    }
}
