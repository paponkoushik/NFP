<?php

namespace Database\Factories;

use App\Models\LegalRequest;
use App\Models\Listing;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalRequest>
 */
class LegalRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LegalRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reqForm = fake()->randomElement(['org', 'post']);
        $listingId = $reqForm == 'post' ? Listing::all()->random(1)->first()->id : null;

        return [
            'request_no' => incrReqNo(LegalRequest::count()),
            'request_from' => $reqForm,
            'listing_id' => $listingId,
            'primary_org_id' => Organisation::all()->random(1)->first()->id,
            'secondary_org_id' => Organisation::all()->random(1)->first()->id,
            'requested_user_id' => User::all()->random(1)->first()->id,
            'additional_lawyer_note' => fake()->optional($weight = 0.5)->paragraph(),
            'request_summary' => fake()->optional($weight = 0.7)->paragraph(),
            'workflow_status' => fake()->randomElement(['New', 'In Progress', 'Invalid', 'Completed']),
            'workflow_stage' => fake()->randomElement(['new', 'in-progress', 'done']),
        ];
    }
}
