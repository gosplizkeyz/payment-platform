<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pay', function() {
    return view('pay');
});

Route::post('/pay', [PaymentController::class, 'pay']);
