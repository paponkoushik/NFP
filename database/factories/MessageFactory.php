<?php

namespace Database\Factories;

use App\Models\Comms;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'comms_id' => Comms::all()->random(1)->first()->id,
            'user_id' => User::all()->random(1)->first()->id,
            'comment' => fake()->paragraph(),
        ];
    }
}
