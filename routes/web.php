<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('home');

// Authentication routes
Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Public donation routes
    Route::get('/new-donation', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Donor routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':donor'])->group(function () {
        Route::get('/donor/dashboard', [DonationController::class, 'dashboard'])->name('donor.dashboard');
        Route::get('/donor/donations', [DonationController::class, 'index'])->name('donor.donations.index');
        Route::get('/donor/donations/{donation}', [DonationController::class, 'show'])->name('donor.donations.show');
    });

    // Volunteer routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':volunteer'])->group(function () {
        Route::get('/volunteer/dashboard', [VolunteerController::class, 'dashboard'])->name('volunteer.dashboard');
        Route::post('/volunteer/donations/{donation}/reserve', [VolunteerController::class, 'reserveDonation'])->name('volunteer.donations.reserve');
        Route::post('/volunteer/donations/{donation}/complete', [VolunteerController::class, 'completeDonation'])->name('volunteer.donations.complete');
    });

    // Admin routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/donations', [AdminController::class, 'donations'])->name('admin.donations');
        Route::get('/admin/volunteers', [AdminController::class, 'volunteers'])->name('admin.volunteers');
        Route::get('/admin/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
        Route::post('/admin/donations/{donation}/assign', [AdminController::class, 'assignDonation'])->name('admin.donations.assign');
    });
}); 