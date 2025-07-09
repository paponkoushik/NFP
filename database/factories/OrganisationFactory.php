<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrganisationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organisation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'user_id' => User::factory(),
            // 'user_type' => function (array $attributes) {
            //     return User::find($attributes['user_id'])->type;
            // },
            'org_name' => fake()->name() . '-' . fake()->unique()->randomDigit(),
            'slug' => fake()->unique()->sentence(),
            'contact_email' => fake()->email(),
            'logo' => '/assets/img/photos/b' . rand(4, 7) . ".jpg",
            'summary' => fake()->text(350),
            'alias' => 'Anonymous ' . rand(1000, 9999),
        ];
    }
}
