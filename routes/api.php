<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Mail\NewPasswordMailController;



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

Route::post('/upload/image', function(){
    return response()->json('success');
});
// TESTING
Route::post('/error', [AuthController::class , 'error']);

// AUTHENTICATION
Route::post('/login', [AuthController::class , 'login']);
Route::post('/register', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->middleware('auth:sanctum');
// RESET PASSWORD
Route::post('/request-password-reset', [NewPasswordMailController::class, 'sendEmailForPasswordReset']);
Route::post('/validate-credentials', [NewPasswordMailController::class, 'validateCredentials']);
Route::post('/set-password', [NewPasswordMailController::class, 'setNewPassword']);
// GOOGLE SIGN IN
Route::get('/authorize/{provider}/redirect', [GoogleController::class ,'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class ,'handleProviderCallback']);

// MANAGE SCHOOL

Route::resource('schools', SchoolController::class);


