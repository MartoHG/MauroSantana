<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Models\Project;

Route::get('/', function () {
    // Buscamos los proyectos ordenados por fecha (del más nuevo al más viejo)
    $projects = Project::orderBy('fecha', 'desc')->get();
    
    // Retornamos la vista 'welcome' enviándole los proyectos
    return view('welcome', compact('projects'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('projects', ProjectController::class);
});

require __DIR__.'/auth.php';