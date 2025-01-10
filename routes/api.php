<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DocumentStatusController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;

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


Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function ($router) {
    Route::post('register', [UserController::class, 'create'])->name('api.auth.register');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'users'

], function ($router) {
    Route::get('/', [UserController::class, 'index'])->name('api.users');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('api.users.update');
    Route::post('/delete/{id}', [UserController::class, 'destroy'])->name('api.users.delete');
});

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'brands'
], function ($router) {
    Route::get('/', [BrandController::class, 'index'])->name('api.brands');
});


Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'tables'
], function ($router) {
    Route::post('/import/{table}', [TableController::class, 'import'])->name('api.tables.import');
});


Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'products'
], function ($router) {
    Route::get('/', [NomenclatureController::class, 'index'])->name('api.products');
});


Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'basket'
], function ($router) {
    Route::get('/', [BasketController::class, 'index'])->name('api.basket');
    Route::post('/add', [BasketController::class, 'add'])->name('api.basket.add');
    Route::post('/delete', [BasketController::class, 'delete'])->name('api.basket.delete');
    Route::post('/clear', [BasketController::class, 'clear'])->name('api.basket.clear');
});

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'orders'
], function ($router) {
    Route::get('/', [OrderController::class, 'index'])->name('api.orders');
    Route::post('/submit', [OrderController::class, 'store'])->name('api.orders.store');
    Route::post('/update/{id}', [OrderController::class, 'update'])->name('api.orders.update');
});

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'statuses'
], function ($router) {
    Route::get('/', [DocumentStatusController::class, 'index'])->name('api.statuses');
});
