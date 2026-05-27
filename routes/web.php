<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', [DashboardController::class, 'index']);
Route::resource('categories', CategoryController::class);
Route::resource('transactions', TransactionController::class);