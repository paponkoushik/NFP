<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function __invoke()
    {
        return view('company.settings');
    }
}
