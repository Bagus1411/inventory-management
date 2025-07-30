<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index',[
        'title' => 'dashboard',
        'active' => 'dashboard'
    ]);
});


Route::get('/viewaction/create', function () {
    return view('viewaction.create', [
        'title' => 'create',
        'active' => 'create'
    ]);
});
Route::get('/viewaction/edit', function () {
    return view('viewaction.edit', [
        'title' => 'edit',
        'active' => 'edit'
    ]);
});