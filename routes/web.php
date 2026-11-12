<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FakeStoreController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdineController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProdottoController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Autenticazione (solo per chi non e' loggato)
Route::middleware('guest.user')->group(function () {
    Route::get('login', [LoginController::class, 'login_form']);
    Route::post('login', [LoginController::class, 'do_login']);
    Route::get('register', [LoginController::class, 'register_form']);
    Route::post('register', [LoginController::class, 'do_register']);
});

// Catalogo (pubblico)
Route::get('prodotti', [ProdottoController::class, 'index']);
Route::get('prodotto/{id}', [ProdottoController::class, 'show'])->whereNumber('id');

// Area riservata
Route::middleware('logged')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('home', [CollectionController::class, 'home']);

    Route::get('shopping', [CartController::class, 'index']);
    Route::post('shopping/add', [CartController::class, 'add']);
    Route::patch('shopping/update', [CartController::class, 'update']);
    Route::delete('shopping/remove', [CartController::class, 'remove']);

    Route::get('checkout', [CheckoutController::class, 'showForm']);
    Route::post('checkout', [CheckoutController::class, 'processOrder']);
    Route::get('ordine/{id}', [OrdineController::class, 'show'])->whereNumber('id');

    Route::get('spotify', [PageController::class, 'spotifyAlbum']);
    Route::get('spotify-canzoni', [PageController::class, 'spotifySongs']);
    Route::get('spotify/token', [SpotifyController::class, 'getToken']);
    Route::get('fakestore', [PageController::class, 'fakestore']);
    Route::get('fakestore/products', [FakeStoreController::class, 'products']);
});
