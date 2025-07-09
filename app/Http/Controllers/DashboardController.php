<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Services\LegalAdminService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Workflow;

class DashboardController extends Controller
{
    protected $legalAdminService;

    public function __construct(LegalAdminService $legalAdminService)
    {
        $this->legalAdminService = $legalAdminService;
    }

    public function index(): View|RedirectResponse
    {
        if(auth()->user()->role == UserRoles::LegalAdmin->value){

            return view('dashboard', [
                'statuses' => Workflow::select('id', 'status_name')->get(),
                'can' => [
                    'edit' => !request()->user()->isOrgAdmin(),
                ]
            ]);
        } elseif(auth()->user()->role == UserRoles::OrgAdmin->value) {
            return to_route('posts.index');
        }

        elseif(auth()->user()->role == UserRoles::NfpAdmin->value) {
            return view('dashboard', [
                'statuses' => Workflow::select('id', 'status_name')->get(),
                'can' => [
                    'edit' => !request()->user()->isOrgAdmin(),
                ]
            ]);
        }
        return view('dashboard');
    }

    public function LegalAdmin(): JsonResponse
    {
        $dashboardData = $this->legalAdminService->dashboard();

        return response()->json($dashboardData);
    }


}
