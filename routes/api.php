<?php

use App\Http\Controllers\BarbieController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//rute za koje ne treba imati token
Route::post('/login', [UserController::class, 'login']);//salje podatke za logovanje, dobijamo token koji znaci da smo ulogovani
Route::post('/register', [UserController::class, 'register']);//salje podatke za registraciju
Route::get('/countries', [CountryController::class, 'index']);//vraca sve zemlje
Route::get('/barbies', [BarbieController::class, 'index']);//vraca sve barbike

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Auth
    Route::post('/logout', [UserController::class, 'logout']);//logout-ujemo se i saljemo podatke koji se korisnik odjavljuje

    // Barbies
    Route::post('/barbies', [BarbieController::class, 'store']);//za cuvanje berbike
    Route::put('/barbies/{barbie}', [BarbieController::class, 'update']);//za azuriranje barbike preko njenog id-ja
    Route::delete('/barbies/{barbie}', [BarbieController::class, 'destroy']);//za brisanje barbike

    // Favorites
    Route::post('/favorites', [FavoriteController::class, 'store']);//pravimo favorita
    Route::get('/favorites/{favorite}', [FavoriteController::class, 'show']);//prikazujemo favorita
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy']);//brisemo favorita
});
