<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth_user_api')->get('/', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::middleware(['auth_user_api'])->group(function () {
        Route::controller(App\Http\Controllers\v1\PNRController::class)->group(function () {
            Route::get('/point-history', 'pointHistory');
            Route::post('/submit-pnr', 'store');
        });
        Route::controller(App\Http\Controllers\v1\LeaderboardController::class)->group(function () {
            Route::get('/leaderboard', 'Leaderboard');
        });
    });
});
