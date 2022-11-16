<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\UsersController;
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

Route::group( ['middleware'=> ['auth:sanctum'] ,'controller'=> UsersController::class], function(){
    Route::get('/user', 'getCurrentUser');
    Route::get('/users', 'getUsers');
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//testing
Route::post('/error', [AuthController::class , 'error']);

Route::post('/login', [AuthController::class , 'login']);
Route::post('/register', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->middleware('auth:sanctum');


Route::get('/authorize/{provider}/redirect', [GoogleController::class ,'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class ,'handleProviderCallback']);

