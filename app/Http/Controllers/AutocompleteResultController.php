<?php

namespace App\Http\Controllers;

use App\Http\Resources\AutocompleteResultResource;
use App\Models\User;
use Illuminate\Http\Request;

class AutocompleteResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $users = User::query();

        return AutocompleteResultResource::collection(
            $request->autocomplete == false ?
            $users->whereRole($request->role)->select('id', 'first_name', 'last_name', 'email', 'avatar')->get() :
            $users->autocompleteResult($request->search, $request->role)
        );
    }
}
