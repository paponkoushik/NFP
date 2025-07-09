<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = $request->user();
        if ($user->isOrgAdmin() || $user->isIndividual()) {
            if (!$user->organisationUser) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                throw ValidationException::withMessages(['email' => 'You have not been assigned to any organisation. Please contact your organisation admin!']);
            } else {
                session(['user_hash' => $user->organisationUser->organisation->user_hash]);
            }
        }


        return redirect()->intended($this->redirectTo($request));
    }

    public function redirectTo(LoginRequest $request)
    {
        $redirectTo = RouteServiceProvider::HOME;

        if ($request->user()->isOrgAdmin()) {
            $redirectTo = route('posts.index');

            if (!authUserOrgPreferences() || Carbon::now()->subDays(30) > auth()->user()->organisations()->first()?->set_preference_at) {
                $redirectTo = route('org.settings');
            }
        } else if ($request->user()->isIndividual()) {
            $redirectTo = route('posts.index');

            if (!authUserOrgPreferences() || Carbon::now()->subDays(30) > auth()->user()->organisations()->first()?->set_preference_at) {
                $redirectTo = route('individual.settings');
            }
        } else if ($request->user()->isLawyer()) {
            $redirectTo = route('legal-requests');
        }

        return $redirectTo;
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
