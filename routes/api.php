<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BoongkingFoodController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HistoryPointController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReviewManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseInvoiceController;

// Route mặc định
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Nhóm route cho ADMIN
Route::prefix('admin')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/create', [CustomerController::class, 'store']);
        Route::get('/{id}', [CustomerController::class, 'show']);
        Route::put('/{id}', [CustomerController::class, 'update']);
        Route::delete('/{id}', [CustomerController::class, 'delete']);
    });

    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::post('/create', [BookingController::class, 'store']);
        Route::get('/{id}', [BookingController::class, 'update']);
        Route::put('/{id}', [BookingController::class, 'update']);
        Route::delete('/{id}', [BookingController::class, 'delete']);
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::post('/create', [InvoiceController::class, 'store']);
        Route::get('/{id}', [InvoiceController::class, 'show']);
        Route::put('/{id}', [InvoiceController::class, 'update']);
        Route::delete('/{id}', [InvoiceController::class, 'delete']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/create', [CategoryController::class, 'store']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('history-points')->group(function () {
        Route::get('/', [HistoryPointController::class, 'index']);
        Route::post('/create', [HistoryPointController::class, 'store']);
        Route::get('/{id}', [HistoryPointController::class, 'show']);
        Route::put('/{id}', [HistoryPointController::class, 'update']);
        Route::delete('/{id}', [HistoryPointController::class, 'destroy']);
    });

    Route::prefix('ranks')->group(function () {
        Route::get('/', [RankController::class, 'index']);
        Route::post('/create', [RankController::class, 'store']);
        Route::get('/{id}', [RankController::class, 'show']);
        Route::put('/{id}', [RankController::class, 'update']);
        Route::delete('/{id}', [RankController::class, 'destroy']);
    });

    Route::prefix('ingredients')->group(function () {
        Route::get('/', [IngredientController::class, 'getData']);
        Route::get('/{id}', [IngredientController::class, 'getById']);
        Route::post('/', [IngredientController::class, 'store']);
        Route::put('/{id}', [IngredientController::class, 'update']);
        Route::delete('/{id}', [IngredientController::class, 'destroy']);
    });

    Route::prefix('warehouses')->group(function () {
        Route::get('/', [WarehouseController::class, 'getData']);
        Route::post('/', [WarehouseController::class, 'store']);
        Route::put('/{id}', [WarehouseController::class, 'update']);
        Route::delete('/{id}', [WarehouseController::class, 'destroy']);
    });

    Route::prefix('warehouse-invoices')->group(function () {
        Route::get('/', [WarehouseInvoiceController::class, 'getData']);
        Route::post('/', [WarehouseInvoiceController::class, 'store']);
        Route::put('/{id}', [WarehouseInvoiceController::class, 'update']);
        Route::delete('/{id}', [WarehouseInvoiceController::class, 'destroy']);
        Route::get('/search', [WarehouseInvoiceController::class, 'search']);
    });

    Route::prefix('review-management')->group(function () {
        Route::get('/', [ReviewManagementController::class, 'getData']);
        Route::post('/', [ReviewManagementController::class, 'store']);
        Route::put('/{id}', [ReviewManagementController::class, 'update']);
        Route::delete('/{id}', [ReviewManagementController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'getData']);
        Route::get('/{id}', [UserController::class, 'getById']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    Route::prefix('booking-food')->group(function () {
        Route::get('/', [BoongkingFoodController::class, 'index']);
        Route::post('/', [BoongkingFoodController::class, 'store']);
        Route::get('/{id}', [BoongkingFoodController::class, 'show']);
        Route::put('/{id}', [BoongkingFoodController::class, 'update']);
        Route::delete('/{id}', [BoongkingFoodController::class, 'destroy']);
    });
});

// Nhóm route cho CLIENT
Route::prefix('client')->group(function () {
    Route::prefix('rates')->group(function () {
        Route::get('/', [RateController::class, 'getData']);
        Route::post('/', [RateController::class, 'store']);
        Route::put('/{id}', [RateController::class, 'update']);
        Route::delete('/{id}', [RateController::class, 'destroy']);
    });
});
