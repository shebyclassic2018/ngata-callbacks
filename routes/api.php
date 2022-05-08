<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Payment\AppointmentPayment;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Callback\AirtelController;
use App\Http\Controllers\Callback\VodacomController;
use App\Http\Controllers\Callback\CellulantController;

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

Route::post('cellulant-callback', [CellulantController::class, 'CallbackReceiver'])->name('cellulant');
Route::post('vodacom-callback', [VodacomController::class, 'CallbackReceiver'])->name('vodacom');
Route::post('airtel-callback', [AirtelController::class, 'CallbackReceiver'])->name('airtel');





