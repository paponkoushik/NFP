<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\Category;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Listing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'organisation_id' => Organisation::all()->random(1)->first()->id,
            'category_id' => Category::whereNotNull('parent_id')->get()->random(1)->first()->id,
            'title' => fake()->sentence(5),
            'slug' => fake()->unique()->sentence(),
            'type' => fake()->randomElement(['looking', 'offer']),
            'description' => fake()->realTextBetween($minNbChars = 1600, $maxNbChars = 2500, $indexSize = 2),
            'city' => fake()->city(),
            'state' => fake()->randomElement(['ACT', 'QLD', 'NT', 'NSW', 'SA', 'VIC', 'TAS', 'WA']),
            'postcode' => fake()->postcode(),
            'address' => fake()->address(),
            'created_at' => fake()->date(),
        ];
    }
}
