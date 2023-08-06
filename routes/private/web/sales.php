<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sales\SalesController;


Route::get('sales/me', [SalesController::class, 'salesByUser']);
Route::resource('sales',SalesController::class);
