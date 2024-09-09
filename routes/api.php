<?php

use App\Http\Controllers\API\DonorDarahController;
use App\Http\Controllers\API\HubungiKamiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/profile', [UserController::class, 'fetch']);
    Route::post('user/profile/update', [UserController::class, 'updateProfile']);
    Route::post('user/photo/update', [UserController::class, 'updatePhoto']);

    Route::get('donorDarah', [DonorDarahController::class, 'fetch']);
    Route::get('hubungiKami', [HubungiKamiController::class, 'fetch']);
});

Route::post('login', [UserController::class, 'login']);
Route::post('registerRelawan', [UserController::class, 'registerRelawan']);
Route::post('registerPasien', [UserController::class, 'registerPasien']);
