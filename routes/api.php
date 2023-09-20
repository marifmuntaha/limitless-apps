<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CashflowController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Setting\WhatsappController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgot']);
Route::post('/auth/reset-password', [AuthController::class, 'reset'])->name('password.reset');
Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::get('/auth/user-info', [AuthController::class, 'user']);
    Route::get('/auth/notification', [AuthController::class, 'notification']);
    Route::post('/invoice/send-notification/{invoice}', [InvoiceController::class, 'sendNotification']);
    Route::apiResource('/account',AccountController::class);
    Route::apiResource('/cashflow', CashflowController::class);
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/invoice', InvoiceController::class);
    Route::apiResource('/member', MemberController::class);
    Route::apiResource('/order', OrderController::class);
    Route::apiResource('/payment', PaymentController::class);
    Route::apiResource('/product', ProductController::class);
    Route::apiResource('/user', UserController::class);
    Route::group(['prefix' => 'setting'], function (){
        Route::post('/whatsapp/init', [WhatsappController::class, 'init']);
        Route::post('/whatsapp/qr64', [WhatsappController::class, 'qr64']);
        Route::post('/whatsapp/info', [WhatsappController::class, 'info']);
        Route::post('/whatsapp/delete', [WhatsappController::class, 'delete']);
        Route::post('/whatsapp/send/{key}', [WhatsappController::class, 'send']);
    });
});
