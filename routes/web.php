<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(callback: function () {
    // Contacts AJAX search
    Route::get('/contacts/search', [ContactController::class, 'search'])->name('contacts.search');

    // Cables AJAX search
    Route::get('/cables/search', [CableController::class, 'search'])->name('cables.search');

    Route::get('projects/reports/{report}/download', [ReportController::class, 'download'])
        ->name('projects.reports.download');
    Route::get('projects/reports/{report}/regenerate', [ReportController::class, 'regeneratePdf'])
        ->name('projects.reports.regenerate');

    Route::resource('projects', ProjectController::class);
    Route::resource('projects.reports', ReportController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
