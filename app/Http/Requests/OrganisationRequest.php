<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\OrgPreference;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use function Symfony\Component\Translation\t;

class OrganisationRequest extends FormRequest
{
    /**
     * LoggedIn user primary org
     *
     * @var App\Models\Organisation
     */
    protected $organisation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
//        $this->dd();
        $rules = [
            'org_name'               => ['required', Rule::unique('organisations')->ignore($this->id)],
            'abn'                    => 'required',
            'our_preferences'        => 'required|array',
            'our_preferences.*.type' => 'required',
            //'address' => 'required'
        ];

        if ($this->has(['summary', 'details'])) {
            $rules['summary'] = 'required';
            $rules['details'] = 'required';
        }

        if ($this->has(['email', 'password'])) {
            $rules['email']    = ['required', 'string', 'email', 'unique:users'];
            $rules['password'] = ['required', 'string'];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'our_preferences.*.type'  => 'preference type',
            'our_preferences.*.where' => 'preference location',
        ];
    }

    /**
     * Update loggedIn user primary organisation
     *
     * @param Organisation $organisation
     * @return void
     */
    public function update(Organisation $organisation): void
    {
        //TODO: Just use transaction
        DB::transaction(function () use ($organisation) {
            $organisation->update($this->persist());

            $this->organisation = $organisation;

            $this->storePrimaryAddress()
                ->storeOtherLocations()
                ->storeServiceAreas()
                ->storeOurInterests()
                ->storePreferences();
        });
    }

    protected function storePrimaryAddress(): static
    {
        $this->organisation->primaryAddress()->updateOrCreate(
            ['organisation_id' => $this->organisation->id, 'is_primary' => true],
            $this->primaryAddress()
        );

        return $this;
    }

    protected function storeOtherLocations(): static
    {
        $otherLocations = $this->get('other_locations');
        // delete all other locations
        if ($otherLocations && count($otherLocations)) {
            $this->organisation->otherLocations()->delete();

            foreach ($otherLocations as $otherLocation) {

                $location = Location::query()
                    ->where('locality', $otherLocation['city'])
                    ->where('postcode', $otherLocation['postcode'])
                    ->where('state', $otherLocation['state'])
                    ->first();

                $otherLocation['location_id'] = $location?->id ? $location->id : null;

                $this->organisation->otherLocations()->create($otherLocation);
            }
        }

        return $this;
    }

    /**
     * Attach org. service areas
     *
     * @return $this
     */
    protected function storeServiceAreas(): static
    {
        $this->organisation->serviceAreas()->sync($this->service_areas);

        return $this;
    }

    protected function storeOurInterests(): static
    {
        $this->organisation->categories()->sync($this->our_interests);

        return $this;
    }

    /**
     * Attach org. preferences
     *
     * @return $this
     */
    protected function storePreferences(): static
    {
        // delete preferences from db
        $this->organisation->preferences()->delete();

        // store new
        $this->_storePreference($this->our_preferences);
//        $this->_storePreference($this->pre_offer_others, true);

        return $this;
    }

    /**
     * Store individual preferences
     * @param array $collections
     */
    protected function _storePreference(array $collections): static
    {
        $orgId    = $this->organisation->id;
        $authUser = auth()->user();
        foreach ($collections as $data) {
            if (isset($data['sub1_category']) && isset($data['sub_category'])) {
                $category = Category::where('name', $data['sub1_category'])->first();
            } elseif (!isset($data['sub_category']) && isset($data['sub1_category'])) {
                $category = Category::where('name', $data['sub1_category'])->first();
            } else {
                $category = Category::where('name', $data['category'])->first();
            }

            if (isset($data['where']['location']) || isset($data['where_offer']['offer']) || isset($data['where_looking']['looking'])) {
                $orgPref = OrgPreference::firstOrCreate(
                    [
                        'organisation_id' => $orgId,
                        'user_id'         => $authUser->id,
                        'type'            => $data['type'],
                        'category_id'     => $category->id
                    ],
                    [
                        'summary' => $data['summary'],
                    ]
                );

                $orgPref->prefValues()->delete();
                if ($data['type'] == 'both') {
                    $whereOfferPref = $orgPref->prefValues()->create([
                        'where'           => $data['where_offer']['offer'],
                        'radius'          => $data['where_offer']['radius'] ?? null,
                        'radius_location' => $data['where_offer']['radius_location'] ?? null,
                        'when'            => $data['where_offer']['when'] ?? null,
                        'date'            => $data['where_offer']['date'] ?? null,
                        'from_date'       => $data['where_offer']['from_date'] ?? null,
                        'to_date'         => $data['where_offer']['to_date'] ?? null,
                        'cost'            => $data['where_offer']['cost'] ?? null,
                        'amount'          => $data['where_offer']['amount'] ?? null,
                        'from_amount'     => $data['where_offer']['from_amount'] ?? null,
                        'to_amount'       => $data['where_offer']['to_amount'] ?? null,
                        'frequency'       => $data['where_offer']['frequency'] ?? null,
                        'lat'             => $data['where_offer']['lat'] ?? null,
                        'long'            => $data['where_offer']['long'] ?? null,
                        'location_id'     => $data['where_offer']['location_id'] ?? null,
                        'type'            => 'offer'
                    ]);
                    $whereOfferPref->states()->delete();
                    if (isset($data['where_offer']['states']) && count($data['where_offer']['states'])) {
                        foreach ($data['where_offer']['states'] as $state) {
                            $whereOfferPref->states()->create(['state' => $state]);
                        }
                    }
                    $whereOfferPref->suburbs()->delete();
                    if (isset($data['where_offer']['suburbs']) && count($data['where_offer']['suburbs'])) {
                        foreach ($data['where_offer']['suburbs'] as $suburb) {
                            $whereOfferPref->suburbs()->create(['suburb' => $suburb]);
                        }
                    }
                    $whereLookingPref = $orgPref->prefValues()->create([
                        'where'           => $data['where_looking']['looking'],
                        'radius'          => $data['where_looking']['radius'] ?? null,
                        'radius_location' => $data['where_looking']['radius_location'] ?? null,
                        'when'            => $data['where_looking']['when'] ?? null,
                        'date'            => $data['where_looking']['date'] ?? null,
                        'from_date'       => $data['where_looking']['from_date'] ?? null,
                        'to_date'         => $data['where_looking']['to_date'] ?? null,
                        'cost'            => $data['where_looking']['cost'] ?? null,
                        'amount'          => $data['where_looking']['amount'] ?? null,
                        'from_amount'     => $data['where_looking']['from_amount'] ?? null,
                        'to_amount'       => $data['where_looking']['to_amount'] ?? null,
                        'frequency'       => $data['where_looking']['frequency'] ?? null,
                        'lat'             => $data['where_looking']['lat'] ?? null,
                        'long'            => $data['where_looking']['long'] ?? null,
                        'location_id'     => $data['where_looking']['location_id'] ?? null,
                        'type'            => 'looking'
                    ]);
                    $whereLookingPref->states()->delete();
                    if (isset($data['where_looking']['states']) && count($data['where_looking']['states'])) {
                        foreach ($data['where_looking']['states'] as $state) {
                            $whereLookingPref->states()->create(['state' => $state]);
                        }
                    }
                    $whereLookingPref->suburbs()->delete();
                    if (isset($data['where_looking']['suburbs']) && count($data['where_looking']['suburbs'])) {
                        foreach ($data['where_looking']['suburbs'] as $suburb) {
                            $whereLookingPref->suburbs()->create(['suburb' => $suburb]);
                        }
                    }
                } else {
                    $wherePref = $orgPref->prefValues()->create([
                        'where'           => $data['where']['location'],
                        'radius'          => $data['where']['radius'] ?? null,
                        'radius_location' => $data['where']['radius_location'] ?? null,
                        'when'            => $data['where']['when'] ?? null,
                        'date'            => $data['where']['date'] ?? null,
                        'from_date'       => $data['where']['from_date'] ?? null,
                        'to_date'         => $data['where']['to_date'] ?? null,
                        'cost'            => $data['where']['cost'] ?? null,
                        'amount'          => $data['where']['amount'] ?? null,
                        'from_amount'     => $data['where']['from_amount'] ?? null,
                        'to_amount'       => $data['where']['to_amount'] ?? null,
                        'frequency'       => $data['where']['frequency'] ?? null,
                        'lat'             => $data['where']['lat'] ?? null,
                        'long'            => $data['where']['long'] ?? null,
                        'location_id'     => $data['where']['location_id'] ?? null,
                        'type'            => $data['type']
                    ]);

                    $wherePref->states()->delete();
                    if (isset($data['where']['states']) && count($data['where']['states'])) {
                        foreach ($data['where']['states'] as $state) {
                            $wherePref->states()->create(['state' => $state]);
                        }
                    }
                    $wherePref->suburbs()->delete();
                    if (isset($data['where']['suburbs']) && count($data['where']['suburbs'])) {
                        foreach ($data['where']['suburbs'] as $suburb) {
                            $wherePref->suburbs()->create(['suburb' => $suburb]);
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Structure request data
     *
     * @return array
     */
    protected function persist(): array
    {
        $imagePath = str_replace('/storage/', '', $this->logo);
        $imagePath = ltrim($imagePath, '/');
        return [
            'logo'              => $this->logo ? $imagePath : null,
            'org_name'          => $this->org_name,
            'abn'               => $this->abn,
            'acn'               => $this->acn,
            'website'           => $this->website,
            'summary'           => $this->summary,
            'details'           => $this->details,
            'email_preference'  => $this->email_preference,
            // TODO: we should not write logic in these class
            'set_preference_at' => now(),
        ];
    }

    protected function primaryAddress(): array
    {
        $location = Location::query()
            ->where('locality', $this->city)
            ->where('postcode', $this->postcode)
            ->where('state', $this->state)->first();

        return [
            'address'     => $this->address,
            'city'        => $this->city,
            'state'       => $this->state,
            'postcode'    => $this->postcode,
            'is_primary'  => true,
            'location_id' => $location?->id ? $location->id : null
        ];
    }
}
