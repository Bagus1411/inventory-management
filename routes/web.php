<?php

use App\Http\Controllers\CustomerController;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalesInvoicesController;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;

Route::get('/', function () {
    return view('auth.login',[
        'title' => 'kingkungkingkang',
        'active' => 'dashboard'
    ]);
})->middleware('guest');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('index',[
            'title' => 'dashboard',
            'active' => 'dashboard'
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/user', UserController::class);

    Route::resource('/customer', CustomerController::class);

    Route::resource('/sales', SalesInvoicesController::class);

    Route::resource('/action/itemin', IncomingTransactionController::class);

    Route::resource('/action/itemout', OutgoingTransactionController::class);

    // <!-- Master -->
    // items
    Route::resource('/master/items', controller: ItemController::class);
    // category
    Route::resource('/master/category', CategoryController::class);
});



// Route Breeze
require __DIR__.'/auth.php';
