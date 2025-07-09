<?php

namespace App\Http\Controllers\Individual;

use App\Models\Category;
use App\Models\Individual;
use App\Actions\Contracts\Organisation\FetchPrimaryOrgForUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationRequest;
use App\Http\Resources\OrgSettingResource;
use App\Models\Organisation;
use App\Models\ServiceArea;
use Illuminate\Http\Request;

class IndividualController extends Controller
{
    public function __construct(
        private readonly FetchPrimaryOrgForUser $query,
    ) {
    }

    public function index(Request $request)
    {
        return view('individual.settings', [
            'serviceAreas' => ServiceArea::getParentsWithChilds(),
            'interests' => Category::getParentsWithChilds(),
            'organisation' => new OrgSettingResource(
                $this->query->handle(user: $request->user())
            )
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganisationRequest $request)
    {
        try {
            return respond('Organisation settings successfully updated.');
            $request->update(
                $this->query->handle(
                    user: $request->user(),
                    relation: false
                )
            );

            return respond('Organisation settings successfully updated.');
        } catch(\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organisation $organisation)
    {
        //
    }

    public function uploadLogo(Request $request)
    {
        if (!$request->hasFile('file')) {
            return respondError('There is no file present', 400);
        }

        $request->validate([
            'file' => 'required|file|image'
        ]);

        try {
            $uploadFile = $request->file('file');
            $path = $uploadFile->store('public/logos');

            if (!$path) {
                return respondError('The file could not be saved.');
            }

            $org = $this->query->handle(user: $request->user());
            $org->logo = $uploadFile->hashName();
            $org->save();

            return response()->json(['logo' => $org->logo]);
        } catch(\Exception $e) {
            return respondError($e->getMessage());
        }
    }
}
