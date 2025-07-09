<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\Organisation;
use Illuminate\Contracts\View\View;

class MyAdsController extends Controller
{
    public function __invoke(): View
    {
        return view('posts.my-posts.index');
    }

    public function index(Organisation $orgid): View
    {
        $userId = $orgid->users()->first()->id;

        return view('posts.org-posts.index', compact('userId'));
    }
}
