<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SetupController extends Controller
{
    public function __invoke(): View
    {
         return view('setup.index');
    }
}
