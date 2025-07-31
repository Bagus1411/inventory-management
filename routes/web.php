<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;

Route::get('/', function () {
    return view('index',[
        'title' => 'dashboard',
        'active' => 'dashboard'
    ]);
});


Route::resource('/action/itemin', IncomingTransactionController::class);

Route::resource('/action/itemout', OutgoingTransactionController::class);

