<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Payment\DisbursementController;
use App\Http\Controllers\Payment\PaymentController;
use App\Models\Payment\AppointmentPayment;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);

Route::post('decrypt', [UserController::class, 'decrypt']);
Route::post('apiLogin', [UserController::class, 'apiLogin']);
Route::post('getNotification', [UserController::class, 'getNotification']);
Route::post('/pending-payment', [PaymentController::class, 'pendingAppointment']);
Route::post('/paid-payment', [PaymentController::class, 'paidAppointment']);

Route::group(['as' => 'txnId-details.', 'prefix' => 'txnId-details'], function() {
    Route::post('/{merchantId}', [PaymentController::class, 'getAppointmentByMerchantId']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('test', [UserController::class, 'test']);
    Route::get('uid/{id}', [UserController::class, 'getUID']);
    Route::post('/disbursement', [DisbursementController::class, 'disbursement'])->name('disbursement');
});




