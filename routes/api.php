<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
