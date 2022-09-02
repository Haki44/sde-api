<?php

use App\Http\Controllers\AdventureController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\LevelController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->get('dashbboard', [AuthController::class, 'dashbboard']);

Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::post('sendContact', [ContactController::class, 'send_contact']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('getRole', [AuthController::class, 'getRole']);
    Route::get('getAuthUser', [AuthController::class, 'getAuthUser']);

    // Boat
    Route::post('registerBoatBooking', [BoatController::class, 'register_booking']);

    // Adventure
    Route::post('registerAdventureBooking', [AdventureController::class, 'register_booking']);
});

Route::middleware(['auth', 'can:admin'])->group(function () {
});

Route::apiResource('boat', BoatController::class);
Route::apiResource('adventure', AdventureController::class);
Route::apiResource('picture', PictureController::class);
Route::apiResource('period', PeriodController::class);
Route::apiResource('event', EventController::class);
Route::apiResource('level', LevelController::class);

