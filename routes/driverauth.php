<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;

// Route::resource([DriverController::class]);
Route::prefix('driver')->group(function () {
    Route::group(['middleware' => 'CheckRole'], function () {
        Route::get('/', [LoginController::class, 'checkDashboard']);

    });
});
