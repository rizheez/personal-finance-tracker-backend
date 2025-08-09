<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\DashboardController;
use App\Http\Controllers\API\V1\TransactionController;


Route::prefix('v1')->group(function () {
    Route::get('hello', function () {
        return response()->json(['message' => 'Hello, World!']);
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum');
    });


    Route::apiResource('categories', CategoryController::class)
        ->middleware('auth:sanctum');
    Route::apiResource('transactions', TransactionController::class)
        ->middleware('auth:sanctum');

    Route::prefix('dashboard')->group(function () {
        Route::get('summary', [DashboardController::class, 'summary'])->middleware('auth:sanctum');
        Route::get('monthly-summary', [DashboardController::class, 'getMonthlySummary'])->middleware('auth:sanctum');
        Route::get('recent-transactions', [DashboardController::class, 'recentTransactions'])->middleware('auth:sanctum');
        Route::get('category-breakdown', [DashboardController::class, 'categoryBreakdown'])->middleware('auth:sanctum');
    });
});
