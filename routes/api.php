<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/agents/{broker}', function (\App\Models\Broker $broker) {
    return $broker->agents()->get()->map(function ($item, $key) {
        return collect($item)->except(['created_at', 'updated_at', 'email_verified_at'])->toArray();
    });
});
Route::middleware('auth:api')->put('/agent/{agent_id}/assign/{broker_id}', function (Request $request) {
    return $request->agent();
});
Route::post('login', ['uses' => '\App\Http\Controllers\AuthController@authenticate'])->name('auth.login');
Route::post('logout', ['uses' => [AuthController::class, 'logout']]);
