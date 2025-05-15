<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingFoodController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryFoodController;
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
use App\Http\Controllers\CartController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\InvoiceFoodController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleFoodController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TypeController;
use App\Models\Rate;
use App\Http\Controllers\GeminiChatController;
use App\Http\Controllers\MessageController;
use App\Models\Message;

Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::post('/register', [CustomerController::class, 'register']);
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/create', [CustomerController::class, 'store']);
        Route::get('/{id}', [CustomerController::class, 'show']);
        Route::put('/update/{id}', [CustomerController::class, 'update']);
        Route::delete('/{id}', [CustomerController::class, 'delete']);
    });

    Route::prefix('bookings')->group(function () {
        Route::get('/check-timeout', [BookingController::class, 'autoUpdateStatus']); // Đặt trước
        Route::get('/', [BookingController::class, 'index']);
        Route::get('/{id}', [BookingController::class, 'show']);
        Route::put('/{id}', [BookingController::class, 'update']);
        Route::delete('/{id}', [BookingController::class, 'delete']);
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::post('/create', [InvoiceController::class, 'store']);
        Route::get('/{id}', [InvoiceController::class, 'show']);
        Route::put('/{id}', [InvoiceController::class, 'update']);
        Route::delete('/{id}', [InvoiceController::class, 'delete']);
        Route::post('/{id}/pay-transfer', [InvoiceController::class, 'payByTransfer']);
        Route::post('/payos/callback', [InvoiceController::class, 'handlePayOSCallback']);
        Route::post('/payment/callback', [InvoiceController::class, 'handlePaymentResult']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/create', [CategoryController::class, 'store']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('category-foods')->group(function () {
        Route::get('/', [CategoryFoodController::class, 'getData']);
        Route::post('/create', [CategoryFoodController::class, 'store']);
        Route::get('/{id}', [CategoryFoodController::class, 'findById']);
        Route::put('/{id}', [CategoryFoodController::class, 'update']);
        Route::delete('/{id}', [CategoryFoodController::class, 'destroy']);
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
        Route::post('/create', [IngredientController::class, 'store']);
        Route::get('/show/{id}', [IngredientController::class, 'getById']);
        Route::put('/update/{id}', [IngredientController::class, 'update']);
        Route::delete('/delete/{id}', [IngredientController::class, 'destroy']);
    });

    Route::prefix('warehouses')->group(function () {
        Route::get('/', [WarehouseController::class, 'getData']);
        Route::post('/create', [WarehouseController::class, 'store']);
        Route::get('/show/{id}', [WarehouseController::class, 'show']);
        Route::put('/update/{id}', [WarehouseController::class, 'update']);
        Route::delete('/delete/{id}', [WarehouseController::class, 'destroy']);
    });

    Route::prefix('rates')->group(function () {
        Route::get('/', [RateController::class, 'getData']);
        Route::post('/create', [RateController::class, 'store']);
        Route::get('/show/{id}', [RateController::class, 'show']);
        Route::put('/update/{id}', [RateController::class, 'update']);
        Route::delete('/delete/{id}', [RateController::class, 'destroy']);
    });

    Route::prefix('warehouse-invoices')->group(function () {
        Route::get('/', [WarehouseInvoiceController::class, 'getData']);
        Route::post('/create', [WarehouseInvoiceController::class, 'store']);
        Route::get('/show/{id}', [WarehouseInvoiceController::class, 'show']);
        Route::put('/update/{id}', [WarehouseInvoiceController::class, 'update']);
        Route::delete('/delete/{id}', [WarehouseInvoiceController::class, 'destroy']);
        Route::get('/search', [WarehouseInvoiceController::class, 'search']);
    });

    Route::prefix('review-management')->group(function () {
        Route::get('/', [ReviewManagementController::class, 'getData']);
        Route::post('/create', [ReviewManagementController::class, 'store']);
        Route::get('/show/{id}', [ReviewManagementController::class, 'show']);
        Route::put('/update/{id}', [ReviewManagementController::class, 'update']);
        Route::delete('/delete/{id}', [ReviewManagementController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'getData']);
        Route::post('/create', [UserController::class, 'store']);
        Route::get('/show/{id}', [UserController::class, 'getById']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);

        Route::post('/login', [UserController::class, 'login']);
        Route::post('/check-login', [UserController::class, 'checkLogin']);
        Route::post('/logout', [UserController::class, 'logout']);

        Route::get('/profile', [UserController::class, 'getUserInfo']);
        Route::put('/profile-update/{id}', [UserController::class, 'updateUserInfo']);
        Route::put('/change-password', [UserController::class, 'changePasswordProfile'])->middleware('checkUser');
    });

    Route::prefix('booking-food')->group(function () {
        Route::get('/', [BookingFoodController::class, 'index']);
        Route::post('/', [BookingFoodController::class, 'store']);
        Route::get('/{id}', [BookingFoodController::class, 'show']);
        Route::put('/{id}', [BookingFoodController::class, 'update']);
        Route::delete('/{id}', [BookingFoodController::class, 'destroy']);
    });
    Route::prefix('carts')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/create', [CartController::class, 'store']);
        Route::get('/{id}', [CartController::class, 'show']);
        Route::put('/{id}', [CartController::class, 'update']);
        Route::delete('/{id}', [CartController::class, 'destroy']);
    });

    Route::prefix('foods')->group(function () {
        Route::get('/', [FoodController::class, 'index']);
        Route::post('/create', [FoodController::class, 'store']);
        Route::get('/{id}', [FoodController::class, 'show']);
        Route::put('/{id}', [FoodController::class, 'update']);
        Route::delete('/{id}', [FoodController::class, 'destroy']);
    });

    Route::prefix('sales')->group(function () {
        Route::get('/', [SaleController::class, 'index']);
        Route::post('/create', [SaleController::class, 'store']);
        Route::get('/{id}', [SaleController::class, 'show']);
        Route::put('/{id}', [SaleController::class, 'update']);
        Route::delete('/{id}', [SaleController::class, 'destroy']);
    });

    Route::prefix('sale_foods')->group(function () {
        Route::get('/', [SaleFoodController::class, 'index']);
        Route::post('/create', [SaleFoodController::class, 'store']);
        Route::get('/{id}', [SaleFoodController::class, 'show']);
        Route::put('/{id}', [SaleFoodController::class, 'update']);
        Route::delete('/{id}', [SaleFoodController::class, 'destroy']);
    });

    Route::prefix('types')->group(function () {
        Route::get('/', [TypeController::class, 'index']);
        Route::post('/create', [TypeController::class, 'store']);
        Route::get('/{id}', [TypeController::class, 'show']);
        Route::put('/{id}', [TypeController::class, 'update']);
        Route::delete('/{id}', [TypeController::class, 'destroy']);
    });

    Route::prefix('tables')->group(function () {
        Route::get('/', [TableController::class, 'index']);
        Route::post('/create', [TableController::class, 'store']);
        Route::get('/{id}', [TableController::class, 'show']);
        Route::put('/{id}', [TableController::class, 'update']);
        Route::delete('/{id}', [TableController::class, 'destroy']);
    });

    Route::prefix('invoice-food')->group(function () {
        Route::get('/', [InvoiceFoodController::class, 'index']);
        Route::post('/', [InvoiceFoodController::class, 'store']);
        Route::get('/{id}', [InvoiceFoodController::class, 'show']);
        Route::put('/{id}', [InvoiceFoodController::class, 'update']);
        Route::delete('/{id}', [InvoiceFoodController::class, 'destroy']);
    });
});

Route::prefix('client')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('login', [AuthController::class, 'loginWithOtp']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->prefix('/')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::prefix('invoice-food')->group(function () {
            Route::get('/', [InvoiceFoodController::class, 'index']);
        });

        Route::prefix('bookings')->group(function () {
            Route::post('/create', [BookingController::class, 'createBooking']);
        });

        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerController::class, 'index']);
            Route::post('/create', [CustomerController::class, 'store']);
            Route::get('/{id}', [CustomerController::class, 'show']);
            Route::put('/update/{id}', [CustomerController::class, 'update']);
            Route::delete('/{id}', [CustomerController::class, 'delete']);
        });

        Route::prefix('carts')->group(function () {
            Route::get('/', [CartController::class, 'index']);
            Route::post('/create', [CartController::class, 'store']);
            Route::get('/{id}', [CartController::class, 'show']);
            Route::put('/{id}', [CartController::class, 'update']);
            Route::delete('/{id}', [CartController::class, 'destroy']);
        });

        Route::prefix('booking-food')->group(function () {
            Route::post('/', [BookingFoodController::class, 'store']);
        });

        Route::prefix('sales')->group(function () {
            Route::get('/', [SaleController::class, 'index']);
        });

        Route::prefix('rates')->group(function () {
            Route::get('/', [RateController::class, 'getData']);
            Route::post('/create', [RateController::class, 'store']);
            Route::get('/show/{id}', [RateController::class, 'show']);
            Route::put('/update/{id}', [RateController::class, 'update']);
            Route::delete('/delete/{id}', [RateController::class, 'destroy']);
        });

        Route::prefix('invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index']);
        });

        Route::prefix('ranks')->group(function () {
            Route::get('/', [RankController::class, 'index']);
        });

        Route::prefix('history-points')->group(function () {
            Route::get('/', [HistoryPointController::class, 'index']);
            Route::delete('/{id}', [HistoryPointController::class, 'destroy']);
        });
    });

    Route::prefix('types')->group(function () {
        Route::get('/', [TypeController::class, 'index']);
    });

    Route::prefix('foods')->group(function () {
        Route::get('/', [FoodController::class, 'index']);
    });

    Route::prefix('tables')->group(function () {
        Route::get('/', [TableController::class, 'index']);
    });

    Route::prefix('category-foods')->group(function () {
        Route::get('/', [CategoryFoodController::class, 'getData']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
    });
});

Route::prefix('chat')->group(function () {
    Route::post('/send', [GeminiChatController::class, 'send']);
});

Route::prefix('chat')->middleware('auth:sanctum')->group(function () {
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
    Route::post('/reply-message', [MessageController::class, 'replyMessage']);
    Route::get('/get-messages/{customerId}/{staffId}', [MessageController::class, 'getMessages']);
});
