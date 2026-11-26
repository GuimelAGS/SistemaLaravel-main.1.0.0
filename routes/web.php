<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Rutas fijas: DEBEN ir ANTES del resource
    Route::get('/trainers/trashed', [TrainerController::class, 'trashed'])->name('trainers.trashed');
    Route::post('/trainers/empty-trash', [TrainerController::class, 'emptyTrash'])->name('trainers.emptyTrash');
    Route::get('/trainers/pdf-all', [TrainerController::class, 'downloadPdf'])->name('trainers.pdf.all');
    Route::get('/trainers/excel', [TrainerController::class, 'downloadExcel'])->name('trainers.excel');

    Route::resource('trainers', TrainerController::class);

    Route::get('/trainers/{id}/pdf', [TrainerController::class, 'downloadPdf'])
        ->whereNumber('id')->name('trainers.pdf');
    Route::delete('/trainers/{id}/force', [TrainerController::class, 'forceDestroy'])
        ->whereNumber('id')->name('trainers.force-destroy');
});