<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Unique validation rules
 */
Route::post('/validate/{table}/unique', function (Request $request, $table) {
    $validator = Validator::make($request->all(), [
        "{$request->key}" => ["unique:{$table},{$request->key}"]
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => $validator->errors()->first($request->field)
        ], 422);
    }

    return response()->json([
        'isValidate' => true
    ], 200);
});
