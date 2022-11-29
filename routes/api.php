<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('opendesa_api/login', [UserController::class, 'login']);
Route::post('opendesa_api/create-user', [UserController::class, 'create_user']);
Route::post('opendesa_api/logout', [UserController::class, 'logout']);
Route::put('opendesa_api/change-role', [UserController::class, 'change_role']);

Route::get('opendesa_api/user-information/{username}', [UserController::class, 'user_information']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
