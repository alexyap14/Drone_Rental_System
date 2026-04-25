<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page (yours)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact page (yours, overrides the closure version)
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Authentication routes (yours)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Friend's product routes (no auth needed)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Admin CRUD routes for products
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
Route::get('/profile/setup-form', [ProfileController::class, 'showSetupForm'])->name('profile.setup.form');
Route::post('/profile/setup-form', [ProfileController::class, 'postSetup'])->name('profile.setup.post');

Route::middleware('auth')->group(function () {
    // Short profile route for header navigation
    Route::get('/profile', function () {
        return redirect()->route('profile.show', ['user' => Auth::user()]);
    })->name('profile');
    // Your profile routes (edit must come before {user})
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Your purchase history
    Route::get('/purchase-history', [PurchaseHistoryController::class, 'index'])->name('purchase.history');

    // Friend's cart and checkout
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/card', function () {
        return view('checkout.card');
    })->name('checkout.card');

    Route::get('/checkout/tng', function () {
        return view('checkout.tng');
    })->name('checkout.tng');

    Route::get('/checkout/done', [CheckoutController::class, 'done'])->name('checkout.done');

});

//Something doesn't make any sense
Route::get('/easteregg/gugugaga', function () {
    return view('easteregg.gugugaga');
});
Route::get('/easteregg/senpai', function () {
    return view('easteregg.senpai');
});


Route::view('/tos', 'privacy_term_of_service.tos')->name('tos');
Route::view('/privacy', 'privacy_term_of_service.privacy')->name('privacy');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

