<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Rooms routes
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/check', [RoomController::class, 'check'])->name('rooms.check');
    
    // Bookings routes
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/status', [BookingController::class, 'status'])->name('bookings.status');
    
    // Profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
});

//require __DIR__.'/auth.php';