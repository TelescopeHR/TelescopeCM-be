<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PhoneNumberController;

Route::middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('company', [CompanyController::class, 'index']);
        
        Route::prefix('employee')->group(function(){
            Route::get('/', [EmployeeController::class, 'index']);
            Route::post('/', [EmployeeController::class, 'store']);
            Route::get('status', [EmployeeController::class, 'status']);
            Route::get('statistics', [EmployeeController::class, 'statistics']);
            Route::get('{employee_id}', [EmployeeController::class, 'show']);
            Route::post('{employee_id}/update', [EmployeeController::class, 'update']);
        });

        Route::prefix('phone-number')->group(function(){
            Route::get('type', [PhoneNumberController::class, 'type']);
            Route::post('{user_id}/update', [PhoneNumberController::class, 'update']);
        });
    });
});