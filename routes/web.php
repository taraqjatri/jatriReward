<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeaderboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserPnrSubmissionController;
use Illuminate\Support\Facades\Route;

//Admin Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'loginView')->name('login');
    Route::post('/auth/login', 'login');
    Route::get('/auth/logout', 'logout');
});

Route::middleware('auth')->group(function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    //Admin roles permission
    Route::group(['prefix'=>'admins'],function(){
        Route::get('/', [AdminController::class,'index']);
        Route::get('/create', [AdminController::class,'create']);
        Route::post('/', [AdminController::class,'store']);
        Route::get('/{admin}/edit', [AdminController::class,'edit']);
        Route::put('/{admin}', [AdminController::class,'update']);
        Route::get('/profile', [AdminController::class,'profile']);
    });

    Route::get('/pnr-submission-history', [UserPnrSubmissionController::class, 'index']);
    Route::get('/pnr-submission-history/details/{user}', [UserPnrSubmissionController::class, 'details']);

    Route::get('/customer-leader-board', [LeaderboardController::class, 'customerLeaderBoard']);
    Route::get('/customer-leader-board/details/{user_id}', [LeaderboardController::class, 'customerHistory']);
    Route::get('/seller-leader-board', [LeaderboardController::class, 'sellerLeaderBoard']);
    Route::get('/seller-leader-board/details/{seller_id}', [LeaderboardController::class, 'sellerHistory']);
});