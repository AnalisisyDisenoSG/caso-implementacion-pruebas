<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/carreras', [App\Http\Controllers\CarreraController::class, 'store']);
