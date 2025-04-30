<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PinjemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminRuanganController;
use App\Http\Controllers\Admin\AdminPeminjamanController;
use App\Http\Controllers\Admin\AdminLaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    // Register Routes
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    // Password Reset Routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    // Basic routes
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-foto', [ProfileController::class, 'updateFoto'])->name('profile.updateFoto');
    Route::get('/helpdesk', function () { return view('helpdesk.helpdesk'); })->name('helpdesk');
    Route::get('/helpdesk/tutor1', function () { return view('helpdesk.tutor1'); })->name('helpdesk.tutor1');
    Route::get('/helpdesk/tutor2', function () { return view('helpdesk.tutor2'); })->name('helpdesk.tutor2');
    Route::get('/helpdesk/tutor3', function () { return view('helpdesk.tutor3'); })->name('helpdesk.tutor3');
    // Ruangan routes
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/check', [RuanganController::class, 'check'])->name('ruangan.check');
    Route::get('/ruangan/{kode_ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');
    Route::get('/ruangan/schedule/{roomId}', [RuanganController::class, 'getRoomSchedule'])->name('ruangan.schedule');    
    Route::get('/ruangan/schedule-gedung/{gedung}', [RuanganController::class, 'getGedungSchedule']);
    // Peminjaman routes
    Route::get('/pinjem/buat-pinjem', [PinjemController::class, 'create'])->name('pinjem.create');
    Route::post('/pinjem', [PinjemController::class, 'store'])->name('pinjem.store');
    Route::get('/pinjem/status-pinjem', [PinjemController::class, 'status'])->name('pinjem.status');
    Route::delete('/pinjem/{id}', [PinjemController::class, 'destroy'])->name('pinjem.destroy');
    Route::put('/pinjem/{id}', [PinjamController::class, 'update'])->name('pinjem.update');
    Route::get('/pinjem/schedule/{roomId}', [PinjemController::class, 'getRoomSchedule'])->name('pinjem.schedule');
    Route::delete('/notifikasi/{id}', [ProfileController::class, 'destroy'])->name('notifikasi.destroy');
    Route::get('/pinjem/{id}/bukti', [\App\Http\Controllers\PinjemController::class, 'buktiPDF'])->name('pinjem.bukti');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('ruangan', AdminRuanganController::class);
    Route::resource('peminjaman', AdminPeminjamanController::class);
    Route::get('laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/export', [AdminLaporanController::class, 'export'])->name('laporan.export');
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-excel', [AdminLaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-pdf', [AdminLaporanController::class, 'exportPDF'])->name('laporan.pdf');
    Route::post('/peminjaman/{id}/cancel', [AdminPeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
    Route::get('/helpdesk', function() {return view('admin.helpdesk');})->name('helpdesk');
});

