<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Non-authenticated Routes
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Authenticated Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user/all', [UserController::class, 'all']);

    // Product Routes
    Route::get('/product/all', [ProductController::class, 'all']);
    Route::get('/product/{slug}', [ProductController::class, 'ProductProfile']);
    Route::post('/product/save', [ProductController::class, 'save']);
    Route::post('/product/update', [ProductController::class, 'update']);
    Route::get('/product/delete/{id}', [ProductController::class, 'delete']);

    // Category Routes
    Route::get('/category/all', [CategoryController::class, 'all']);
    Route::get('/category/{slug}', [CategoryController::class, 'CategoryProfile']);
    Route::post('/category/save', [CategoryController::class, 'save']);
    Route::post('/category/update', [CategoryController::class, 'update']);
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete']);

});
