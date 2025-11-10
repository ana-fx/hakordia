<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [RegistrationController::class, 'index'])->name('home');

Route::get('/event-details', function () {
    return view('event-details');
})->name('event.details');

// Registration Routes (tanpa auth)
Route::get('/register-event', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/register-event', [RegistrationController::class, 'store'])->name('registration.store');

// Public Checkout Route (tanpa auth)
Route::get('/register/{unique_id}', [CheckoutController::class, 'showPublic'])->name('checkout.public');
Route::post('/register/{unique_id}/upload-payment', [CheckoutController::class, 'uploadPaymentProofPublic'])->name('checkout.upload-payment');

// Auth Routes
Route::middleware(['auth'])->group(function () {
    // User Routes
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Payment Routes
    Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
    Route::get('/payment/{payment}/status', [PaymentController::class, 'status'])->name('payment.status');
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/registrations/{id}', [AdminController::class, 'show'])->name('show');
    Route::get('/export', [AdminController::class, 'export'])->name('export');
    Route::patch('/checkouts/{id}/update-status', [AdminController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/order/{order_number}/detail', [AdminController::class, 'orderDetail'])->name('orderDetail');
    Route::get('/order/{order_number}/edit', [AdminController::class, 'editOrder'])->name('editOrder');
    Route::post('/order/{order_number}/edit', [AdminController::class, 'updateOrder'])->name('updateOrder');
    Route::delete('/order/{order_number}', [AdminController::class, 'deleteOrder'])->name('deleteOrder');
});

// Admin auth routes
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Fallback route for 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
