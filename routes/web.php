<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PanierController;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/films/create', [ApiController::class, 'create'])->name('films.create');
    Route::post('/films', [ApiController::class, 'store'])->name('films.store');
    Route::get('/films/{film}/edit', [ApiController::class, 'edit'])->name('films.edit');
    Route::put('/films/{id}', [ApiController::class, 'update'])->name('films.update');
    Route::delete('/films/{id}', [ApiController::class, 'destroy'])->name('films.destroy');
    Route::get('/films/{film}', [ApiController::class, 'getFilmDetail'])->name('detail');
    Route::get('/films', [ApiController::class, 'getFilms'])->name('films.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/stocks', [ApiController::class, 'getStock'])->name('stocks');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/detail', function () {
    return view('detail');
})->middleware(['auth', 'verified'])->name('detail');

Route::get('/films/{filmId}', [ApiController::class, 'getFilmDetail'])->name('detail');

require __DIR__.'/auth.php';
