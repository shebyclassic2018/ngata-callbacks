<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Home\homeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('login');

Route::get('/register', function () {
    return view('pages.register');
})->name('register');

Route::get('/home', function () {
    return view('pages.home');
})->name('home');

Route::get('/server-db', function () {
    $records = DB::connection('mysql')
            ->table('users')
            ->get()
            ->toArray();

    dd($records);
});

Route::post('/create', [UserController::class, 'createClients'])->name('create');
Route::post('/authenticate', [UserController::class, 'login'])->name('authenticate');
Route::get('/au', [UserController::class, 'authorized_token'])->name('authorized_token');
Route::post('/login', [UserController::class, 'loginClient'])->name('loginClient');
Route::middleware(['auth'])->group(function () {
    Route::get('/user-keys', [homeController::class, 'userKeys'])->name('userKeys');
    Route::get('/api-admin', [homeController::class, 'admin'])->name('admin-page');
    Route::post('/grant', [homeController::class, 'grantPermission'])->name('grant-permission');
    Route::post('/revoke', [homeController::class, 'revokePermission'])->name('revoke-permission');
    Route::get('/api-documentation', [homeController::class, 'APIDocumentation'])->name('documentation');
    Route::get('/download', [homeController::class, 'download'])->name('download');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});
