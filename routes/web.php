<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MethodDescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CableController;
use App\Http\Controllers\PipeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(callback: function () {
    Route::get('/', [HomeController::class, 'dashboard']);

    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');
    // Contacts AJAX search
    Route::get('/contacts/search', [ContactController::class, 'search'])->name('contacts.search');

    // Cables AJAX search
    Route::get('/cables/search', [CableController::class, 'search'])->name('cables.search');
    // Pipes AJAX search
    Route::get('/pipes/search', [PipeController::class, 'search'])->name('pipes.search');

    Route::get('projects/reports/{report}/download', [ReportController::class, 'download'])
        ->name('projects.reports.download');
    Route::get('projects/reports/{report}/regenerate', [ReportController::class, 'regeneratePdf'])
        ->name('projects.reports.regenerate');

    Route::resource('projects', ProjectController::class);
    Route::resource('projects.reports', ReportController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/method-descriptions', [MethodDescriptionController::class, 'index'])->name('method-descriptions.index');
    Route::get('/method-descriptions/{methodDescription}/edit', [MethodDescriptionController::class, 'edit'])->name('method-descriptions.edit');
    Route::put('/method-descriptions/{methodDescription}', [MethodDescriptionController::class, 'update'])->name('method-descriptions.update');
});

require __DIR__.'/auth.php';
