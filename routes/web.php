<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Rutas de Presentación (Públicas)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('presentation.index');
})->name('home');

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogo/{product}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/nosotros', function () {
    return view('presentation.nosotros');
})->name('about');

Route::get('/ubicaciones', [StoreController::class, 'index'])->name('stores.index');
Route::post('/ubicaciones/sugerir', [StoreController::class, 'suggestLocation'])->name('stores.suggest');

Route::get('/contacto', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/recuperar-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/recuperar-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/nueva-password/{token?}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/nueva-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/verificar-correo', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/confirmacion', [VerificationController::class, 'confirmation'])->name('auth.confirmation');

/*
|--------------------------------------------------------------------------
| Rutas del Panel / Funcionalidad (Autenticadas)
|--------------------------------------------------------------------------
*/
Route::middleware('web')->group(function () {
    Route::get('/dashboard', [PanelController::class, 'index'])->name('dashboard');

    // Catálogo en panel
    Route::get('/panel/catalogo', [CatalogController::class, 'panelIndex'])->name('panel.catalog');

    // Carrito
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/carrito/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Favoritos
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favoritos/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Pedidos
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Perfil
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::match(['post', 'put'], '/perfil', [ProfileController::class, 'update'])->name('profile.update');

    // Configuración
    Route::get('/configuracion', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/configuracion', [SettingsController::class, 'update'])->name('settings.update');
});
