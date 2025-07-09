<?php

namespace app\Services;

class OrganizationPreferenceProcessService
{
    private array $groupedPreferences = [];


    /**
     * @param $preferences
     * @return $this
     */
    public function processPreferences($preferences): static
    {
        $preferences->each(function ($preference) {
            $this->processPref($preference);
        });
        return $this;
    }

    /**
     * @param $preference
     * @return void
     */
    private function processPref($preference): void
    {
        $this->groupedPreferences[$preference->category->code] = [
            'type'          => $preference->type,
            'where'         => $preference->type != 'both' ? $preference->prefValues->toArray() : null,
            'where_looking' => $preference->type == 'both' ? $preference->prefValues()->where('type', 'looking')->first()->toArray() : null,
            'where_offer'   => $preference->type == 'both' ? $preference->prefValues()->where('type', 'offer')->first()->toArray() : null,
            'summary'       => $preference->summary,
        ];

        if ($preference->type != 'both') {
            $this->groupedPreferences[$preference->category->code]['where']['location'] = $preference->prefValues->where;
            $this->groupedPreferences[$preference->category->code]['where']['states']   = $preference->prefValues->states && $preference->prefValues->states->count()
                ? $preference->prefValues->states->pluck('state')->toArray() : [];
            $this->groupedPreferences[$preference->category->code]['where']['suburbs']   = $preference->prefValues->suburbs && $preference->prefValues->suburbs->count()
                ? $preference->prefValues->suburbs->pluck('suburb')->toArray() : [];
        } else {
            $whereLooking                                                                      = $preference->prefValues()->where('type', 'looking')->first();
            $whereOffer                                                                        = $preference->prefValues()->where('type', 'offer')->first();
            $this->groupedPreferences[$preference->category->code]['where_looking']['looking'] = $whereLooking->where;
            $this->groupedPreferences[$preference->category->code]['where_looking']['states']  = $whereLooking->states && $whereLooking->states->count()
                ? $whereLooking->states->pluck('state')->toArray() : [];
            $this->groupedPreferences[$preference->category->code]['where_offer']['offer']     = $whereOffer->where;
            $this->groupedPreferences[$preference->category->code]['where_offer']['states']    = $whereOffer->states && $whereOffer->states->count()
                ? $whereOffer->states->pluck('state')->toArray() : [];
        }

    }

    public function getGroupedPreferences(): array
    {
        return $this->groupedPreferences;
    }


}
