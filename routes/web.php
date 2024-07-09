<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ApartmentSponsorshipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\BraintreeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::resource('apartment_sponsorship', ApartmentSponsorshipController::class);
    Route::post('/braintree/checkout', [BraintreeController::class, 'checkout'])->name('braintree.checkout');
    Route::get('/braintree/token', [BraintreeController::class, 'token'])->name('braintree.token');
    Route::get('/admin/payment/{id}', [BraintreeController::class, 'confirmPayment'])->name('payment');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::fallback(function () {
    return redirect()->route('admin.dashboard');
});