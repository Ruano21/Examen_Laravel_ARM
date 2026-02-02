<?php

use App\Http\Controllers\ProductARMController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductARMController::class);
