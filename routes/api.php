<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StripesController;
use App\Http\Controllers\LoginController;


Route::apiResource('/users', UsersController::class);
Route::apiResource('/carts', CartsController::class);
Route::apiResource('/likes', LikesController::class);
Route::apiResource('categories', CategoriesController::class);
// 一部管理者権限の人だけ使えるメソッドあり
Route::get('categories/{category}/products', [ProductsController::class, 'index']);
Route::get('categories/{category}/products/{product}', [ProductsController::class, 'show']);
Route::post('categories/{category}/products', [ProductsController::class, 'store'])->middleware('admin');
Route::put('categories/{category}/products/{product}', [ProductsController::class, 'update'])->middleware('admin');
Route::delete('categories/{category}/products/{product}', [ProductsController::class, 'destroy'])->middleware('admin');

// 決済システムのためのセッション作成
Route::post('/stripes', [StripesController::class, 'createSession']);
Route::delete('/carts', [CartsController::class, 'delete']);
Route::delete('/likes', [LikesController::class, 'delete']);

// 通常ログイン
Route::post('/login', [LoginController::class, 'login']);
// 管理者ログイン
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->middleware('admin');
// 全商品取得
Route::get('/products', [ProductsController::class, 'getAll']);