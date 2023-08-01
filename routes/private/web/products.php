<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ProductsController;


Route::resource('products',ProductsController::class);
