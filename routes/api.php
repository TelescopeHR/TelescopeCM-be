<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::post('logout', [AuthController::class, 'logout']);

        Route::prefix('employee')->group(function(){
            Route::get('/', [EmployeeController::class, 'index']);
        });
    });
});