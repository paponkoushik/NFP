<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\OrgLocation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'org_name'   => ['sometimes', 'required', 'string', 'max:255'],
            'abn'        => ['sometimes', 'required', 'string', 'max:255'],
            'address'    => ['required', 'string', 'max:255'],
            'state'      => ['required', 'string', 'max:255'],
            'city'       => ['required', 'string', 'max:255'],
            'postcode'   => ['required', 'string', 'max:255'],
        ]);
        //try {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'role'       => $request->client_type === "individual" ? "individual" : "org-admin",
                'password'   => Hash::make($request->password),
                'status'     => 'active',
            ]);


            //event(new Registered($user));

            $org = Organisation::create([
                'org_name'      => $request->org_name,
                'user_hash'     => $request->client_type === "individual" || "org-admin" ? md5(uniqid()) : null,
                'abn'           => $request->abn,
                'alias'         => Organisation::generateAliasName(),
                'client_type'   => $request->client_type,
                'logo'          => null,
                //'address' => $request->address,
                'contact_email' => $user->email,
                'contact_phone' => $user->phone,
                'details'       => $request->details,
                'created_by'    => $user->id,
                'status'        => 'active',
            ]);

            $orgLoc = OrgLocation::create([
                'organisation_id' => $org->id,
                'city'            => $request->city,
                'state'           => $request->state,
                'postcode'        => $request->postcode,
                'address'         => $request->address,
                'is_primary'      => 1,
            ]);

            $user->organisations()->attach($org->id, ['role' => $user->role]);

            return $user;
        });
        // } catch(\Exception $e) {
        //     return respondError('Failed to register. Please try again!');
        // }

        Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
        return respond('Congratulations! Your Account is Ready!', 201);
    }
}
