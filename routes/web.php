<?php

use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('index',[
        'title' => 'dashboard',
        'active' => 'dashboard'
    ]);
});


Route::resource('/action/itemin', IncomingTransactionController::class);

Route::resource('/action/itemout', OutgoingTransactionController::class);




// <!-- Master -->
// items
Route::resource('/master/items', controller: ItemController::class);
// category
Route::resource('/master/category', CategoryController::class);

// <!-- In and Out -->
// Item In
// Route::resource('/inout/in', controller: IncomingTransactionController::class);
// Item Out
// Route::resource('/inout/out', OutgoingTransactionController::class);

