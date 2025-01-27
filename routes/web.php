<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;


Route::group(["prefix" => "admin"], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/iso', [AdminController::class, 'iso'])->name('admin.iso.daftar');
});