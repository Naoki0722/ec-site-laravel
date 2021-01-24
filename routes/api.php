<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;


Route::apiResource('/users', UsersController::class);
Route::apiResource('/carts', CartsController::class);
Route::apiResource('/likes', LikesController::class);
Route::apiResource('categories', CategoriesController::class);
Route::apiResource('categories.products', ProductsController::class);

// リクエストに応じ、カテゴリーに該当する商品だけを取得するクエリのメモ
Route::get('/products', [ProductsController::class, 'showProduct']);

// 決済システムのためのセッション作成
Route::get('/stripes', [StripesController::class, 'createSession']);