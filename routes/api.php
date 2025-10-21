<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeScheduleController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\VisitController;

Route::middleware('api')->group(function () {
    //welcome
    Route::get('/', function(){
        return response()->json(['message' => 'welcome']);
    });

    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('company', [CompanyController::class, 'index']);
        
        Route::prefix('employee')->group(function(){
            Route::get('/', [EmployeeController::class, 'index']);
            Route::post('/', [EmployeeController::class, 'store']);
            Route::get('status', [EmployeeController::class, 'status']);
            Route::get('statistics', [EmployeeController::class, 'statistics']);
            Route::get('{employee}', [EmployeeController::class, 'show']);
            Route::post('{employee}/update', [EmployeeController::class, 'update']);
            Route::post('{employee}/delete', [EmployeeController::class, 'delete']);

            Route::prefix('schedule')->group(function(){
                Route::post('/', [EmployeeScheduleController::class, 'create']);
                Route::get('details/{schedule}', [EmployeeScheduleController::class, 'detail']);
                Route::get('visits/{schedule}', [EmployeeScheduleController::class, 'visits']);
                Route::get('types', [EmployeeScheduleController::class, 'getTypes']);
                Route::post('update/{schedule}', [EmployeeScheduleController::class, 'update']);
                Route::post('delete/{schedule}', [EmployeeScheduleController::class, 'delete']);
                Route::get('{employee}', [EmployeeScheduleController::class, 'index']);
            });

            Route::prefix('visit')->group(function(){
                Route::get('types', [VisitController::class, 'types']);
                Route::post('create', [VisitController::class, 'create']);
            });
        });

        Route::prefix('client')->group(function(){
            Route::get('/', [ClientController::class, 'index']);
        });

        Route::prefix('phone-number')->group(function(){
            Route::get('type', [PhoneNumberController::class, 'type']);
            Route::post('{user}/update', [PhoneNumberController::class, 'update']);
        });
    });
});