<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\UserAccountsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes(['register' => true, 'reset' => false, 'confirm' => false, 'verify' => false]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user.menu'])->group(function () {
    Route::get('/profilesList', [UserAccountsController::class, 'profilesList'])->name('profilesList');
    Route::get('/enterProfile/{user_account_id}', [UserAccountsController::class, 'enterProfile'])->name('enterProfile');

    Route::middleware(['user.account'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

        Route::resource('/profiles', ProfilesController::class);
    });
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [App\Http\Controllers\HomeController::class, 'users'])->name('users.index');