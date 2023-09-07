<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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
    Route::resource('/invoice', InvoiceController::class)->except(['create', 'edit']);
    Route::resource('/member', MemberController::class)->except(['create', 'edit']);
    Route::resource('/order', OrderController::class)->except(['create', 'edit']);
    Route::resource('/payment', PaymentController::class)->except(['create', 'edit']);
    Route::resource('/product', ProductController::class)->except(['create', 'edit']);
    Route::resource('/user', UserController::class)->except(['create', 'edit']);
    Route::get('/testing', function (Request $request){
        return response([
            'result' => Http::asForm()
                ->post('http://localhost:3333/message/text?key=limitless-apps', [
                    'id' => '6282229366506',
                    'message' => 'Testing Whatsapp'
                ])->json()
        ]);
    });
});
