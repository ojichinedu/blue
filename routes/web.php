<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

// Shipment (public)
Route::get('/send', [ShipmentController::class, 'create'])->name('shipment.create');
Route::post('/send', [ShipmentController::class, 'store'])->name('shipment.store');
Route::get('/track', [ShipmentController::class, 'track'])->name('track');
Route::get('/track/{trackingNumber}', [ShipmentController::class, 'trackResult'])->name('track.result');

// API endpoint for live position data
Route::get('/api/shipment/{trackingNumber}/position', [ShipmentController::class, 'getPosition'])->name('api.shipment.position');

// Customer Dashboard (auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/shipment/{id}', [DashboardController::class, 'show'])->name('dashboard.shipment');
});

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Dashboard
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/shipments', [AdminDashboardController::class, 'shipments'])->name('shipments');
    Route::get('/shipments/create', [AdminDashboardController::class, 'createShipment'])->name('shipment.create');
    Route::post('/shipments', [AdminDashboardController::class, 'storeShipment'])->name('shipment.store');
    Route::get('/shipments/{id}', [AdminDashboardController::class, 'showShipment'])->name('shipment.show');
    Route::get('/shipments/{id}/edit', [AdminDashboardController::class, 'editShipment'])->name('shipment.edit');
    Route::put('/shipments/{id}/edit', [AdminDashboardController::class, 'updateShipmentDetails'])->name('shipment.updateDetails');
    Route::put('/shipments/{id}', [AdminDashboardController::class, 'updateShipment'])->name('shipment.update');
    Route::delete('/shipments/{id}', [AdminDashboardController::class, 'destroyShipment'])->name('shipment.destroy');
    Route::post('/shipments/{id}/update', [AdminDashboardController::class, 'addUpdate'])->name('shipment.addUpdate');
});

require __DIR__.'/auth.php';

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return 'Cache cleared successfully!';
});
