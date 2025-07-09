<?php

namespace App\Http\Controllers\Organisations;

use App\Actions\Contracts\Organisation\FetchPrimaryOrgForUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationRequest;
use App\Http\Resources\OrgSettingResource;
use App\Models\Category;
use App\Models\ServiceArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Services\NfpAdminService;

class OrgSettingsController extends Controller
{
    public function __construct(
        private readonly FetchPrimaryOrgForUser $query,
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('organisations.settings', [
            'serviceAreas' => ServiceArea::getParentsWithChilds(),
            'interests'    => Category::getParentsWithChilds(),
            'organisation' => new OrgSettingResource(
                $this->query->handle(user: $request->user())
            )
        ]);
    }

    public function nfpDashboard(Request $request)
    {
        return (new NfpAdminService())->dashboard($request->category, $request->fromDate, $request->toDate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrganisationRequest $request
     * @return JsonResponse
     */
    public function store(OrganisationRequest $request)
    {
        try {
//            return respond('Organisation settings successfully updated.');
            $request->update(
                $this->query->handle(
                    user: $request->user(),
                    relation: false
                )
            );

            return respond('Organisation settings successfully updated.');
        } catch (\Exception $e) {
            return respondError(FAIL);
        }
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
            $uploadDir  = authUserOrgId() . '/logos';
            $path       = imageUploadHandler($uploadFile, $uploadDir);


            if (!$path) {
                return respondError('The file could not be saved.');
            }

            $org = $this->query->handle(user: $request->user());
            $org->update(['logo' => $path]);

            return response()->json(['logo' => '/storage/' . $org->logo]);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }
}
