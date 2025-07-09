<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ChangePasswordRequest;
use App\Http\Requests\Settings\ProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AccountSettingController extends Controller
{
    /**
     * Display a settings index page.
     */
    public function index(): View
    {
        $user = auth()->user();
        return view('account-setting.index', compact('user'));
    }

    /**
     * Update Profile Information
     *
     * @param ProfileRequest $request
     * @return RedirectResponse
     */
    public function updateProfile(ProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();

        unset($data['avatar']);

        $user = auth()->user();

        // Image upload manipulation
        if ($request->hasFile('avatar')) {
            $path           = imageUploadHandler(
                $request->file('avatar'),
                'user-avatars',
                '215x215',
                $user->avatar
            );
            $data['avatar'] = $path;
        }

        // Update User
        $user->update($data);

        flash('Profile updated successfully.');

        return back();
    }

    /**
     * Update Password
     *
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        // Get the hashed password from the database
        $hashedPassword = auth()->user()->getAuthPassword();

        // Check if the new password is the same as old password
        if (Hash::check($request->password, $hashedPassword)) {
            flash('New password can not be the same as old password!', 'error');
            return back();
        }

        // Check if the current password matches with the password you provided
        if (!Hash::check($request->old_password, $hashedPassword)) {
            flash('Current password not matched, please try again!', 'error');
            return back();
        }


        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        // Logout the user
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash('Password updated successfully, please login with your new password!');

        return to_route('login');
    }
}
