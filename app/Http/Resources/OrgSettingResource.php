<?php

namespace App\Http\Resources;

use App\Services\OrganizationCategoryProcessService;
use App\Services\OrganizationPreferenceProcessService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrgSettingResource extends JsonResource
{
    // public $relationships = [
    //     'transactions' => TransactionResource::class,
    // ];
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categoryProcessService = (new OrganizationCategoryProcessService())->processCategories($this->whenLoaded('categories'));
        $orgPrefProcessService  = (new OrganizationPreferenceProcessService())->processPreferences($this->whenLoaded('preferences'));
        return [
            'id'                                => $this->id,
            'org_name'                          => $this->org_name,
            'abn'                               => $this->abn,
            'acn'                               => $this->acn,
            'website'                           => $this->website,
            'address'                           => $this->primaryAddress->address,
            'city'                              => $this->primaryAddress->city,
            'state'                             => $this->primaryAddress->state,
            'postcode'                          => $this->primaryAddress->postcode,
            'logo'                              => $this->logo,
            'summary'                           => $this->summary,
            'details'                           => $this->details,
            'email_preference'                  => $this->email_preference,
            'client_type'                       => $this->client_type,
            'defaultStep'                       => (int)$this->default_step,
            //'main_service_areas' => $this->whenLoaded('serviceAreas', fn() => $this->serviceAreas->pluck('parent_id')->filter()->all()),
            'service_areas'                     => $this->whenLoaded('serviceAreas', fn() => $this->serviceAreas->pluck('pivot.service_area_id')),
            'groupedServiceAreas'               => $this->whenLoaded('serviceAreas', fn() => $this->serviceAreas->groupBy('parent_id')->map(fn($groupArea) => $groupArea->pluck('name'))),
            'our_interests'                     => $this->whenLoaded('categories', fn() => $this->categories->pluck('pivot.category_id')),
            'groupedOurInterests'               => $categoryProcessService->getGroupedCategories(),
            'groupedCategoryExcludeFields'      => $categoryProcessService->getGroupedCategoryExcludeFields(),
            'groupedCategoryExcludeFieldValues' => $categoryProcessService->getGroupedCategoryExcludeFieldValues(),
            'groupedCategoryCustomLabels'       => $categoryProcessService->getGroupedCustomLabels(),
            // map and change key name by category code
            'other_locations'                   => $this->whenLoaded('otherLocations', fn() => $this->otherLocations->map(fn($location) => $location->only('address', 'city', 'state', 'postcode'))),
            'our_preferences'                   => $orgPrefProcessService->getGroupedPreferences(),
        ];
    }


}
