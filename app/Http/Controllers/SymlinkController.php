<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class SymlinkController extends Controller
{
    public function index(): bool
    {
        Artisan::call('storage:link');

        return true;
    }
}
