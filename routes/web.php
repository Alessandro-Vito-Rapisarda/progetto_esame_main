

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProdottoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SpotifyController;

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', [LoginController::class, 'login_form']);
Route::post('login', [LoginController::class, 'do_login']);
Route::get('register', [LoginController::class, 'register_form']);
Route::post('register', [LoginController::class, 'do_register']);
Route::get('logout', [LoginController::class, 'logout']);


Route::get('home', [CollectionController::class, 'home']);
Route::get('prodotti', [ProdottoController::class, 'index']);


Route::get('prodotto/{id}', [ProdottoController::class, 'show']);
Route::get('prodotto/{id}/json', [ProdottoController::class, 'showJson']);
Route::get('/prodotti/search', [ProdottoController::class, 'search']);

Route::get('/shopping', [CartController::class, 'index']);
Route::post('/shopping/add', [CartController::class, 'add']);
Route::delete('/shopping/remove', [CartController::class, 'remove']);
Route::patch('/shopping/update', [CartController::class, 'update']);


Route::get('/spotify', function() {
    return view('spotify');
});

Route::get('/spotify/token', [SpotifyController::class, 'getToken']);

Route::get('/spotify-canzoni', function() {
    return view('spotify-canzoni');
});


Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'showForm']);
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'processOrder']);

Route::get('/fakestore', function() {
    return view('fakestore');
});



Route::get( '/prodotti/json',  [ProdottoController::class, 'getProdotti']);