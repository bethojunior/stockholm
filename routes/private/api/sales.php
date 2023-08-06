<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sales\SalesController;


Route::resource('sales',SalesController::class);
