<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Mail\NewPasswordController;
use App\Http\Controllers\Mail\NewPasswordMailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

 Route::get('/show-reset-password-email', [NewPasswordMailController::class, 'showPage']);
 Route::get('/social', [NewPasswordMailController::class, 'hasProvider']);


Route::get('/{any}' , function(){
    return view('index');
})->where('any', '.*');


