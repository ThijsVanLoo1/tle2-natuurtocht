<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\NatuurDexController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NatuurDexController::class, 'index'])
    ->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/quiz/{id}', [\App\Http\Controllers\QuizController::class, 'showQuiz'])
    ->name('quiz')
    ->middleware(['auth', 'verified']);

//change up the route name
Route::post('/cards/shiny/{id}', [CardController::class, 'makeCardShiny'])
    ->name('cards.makeShiny')
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/natuur-dex', [NatuurDexController::class, 'index'])
        ->name('natuur-dex.index')
        ->middleware('auth');
    Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');

    Route::post('/cards/{card}/upload-photo', [PhotoController::class, 'store'])->name('cards.upload');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // Add this line to handle GET /admin/cards
    Route::get('/cards', [AdminController::class, 'index'])->name('admin.cards.index');
    Route::get('/cards/create', [AdminController::class, 'create'])->name('admin.cards.create');
    Route::post('/cards', [AdminController::class, 'store'])->name('admin.cards.store');
    Route::get('/cards/{card}/edit', [AdminController::class, 'edit'])->name('admin.cards.edit');
    Route::put('/cards/{card}', [AdminController::class, 'update'])->name('admin.cards.update');
    Route::delete('/cards/{card}', [AdminController::class, 'destroy'])->name('admin.cards.destroy');
});

Route::get('/test-layout', function () {
    return view('test-layout');
});

require __DIR__ . '/auth.php';
