<?php


use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\IsoController;
use Illuminate\Support\Facades\Auth;

// Route::get('/login', function() {
//     return Livewire::mount(LoginController::class);
// })->name('login');

// Publicly accessible routes

Route::get('/', function() {
    return redirect()->route('admin.dashboard');
});

Route::get('/login', [AdminController::class, 'login'])->name('login')->middleware('guest'); // Only for unauthenticated users
Route::get('/register', [AdminController::class, 'register'])->name('register')->middleware('auth'); // Only authenticated users

// Protected routes (Only accessible by authenticated users)
Route::group(["prefix" => "admin", "middleware" => "auth"], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


    Route::group(['prefix' => 'iso'], function() {
        Route::get('', [AdminController::class, 'iso'])->name('admin.iso.daftar');
        Route::get('/komponen/{id}/{role_id}', [IsoController::class, 'komponen'])->name('admin.iso.komponen');
        Route::get('/divisi/{id}', [IsoController::class, 'divisi'])->name('admin.iso.divisi');
        Route::get('/dokumen/{berkasId}/{komponenId}/{role_id}', [IsoController::class, 'kelolaKomponen'])->name('admin.iso.komponen.kelola');
    });
    // ISO routes
    Route::post('/logout', function () {
        Auth::logout();  // Log the user out
        return redirect('/login');  // Redirect to the login page after logout
    })->name('admin.logout');
});
