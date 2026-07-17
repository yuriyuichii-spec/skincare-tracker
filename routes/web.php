<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', \App\Http\Controllers\ProductController::class);

    Route::get('/routine/today', [\App\Http\Controllers\RoutineController::class, 'today'])->name('routine.today');
    Route::post('/routine/toggle', [\App\Http\Controllers\RoutineController::class, 'toggle'])->name('routine.toggle');
    Route::get('/routine/calendar', [\App\Http\Controllers\RoutineController::class, 'calendar'])->name('routine.calendar');
});

require __DIR__.'/auth.php';