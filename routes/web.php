<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersAccountsController;
use App\Http\Controllers\RolesController;

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

Route::middleware(['auth', 'checkStatus', 'user.menu'])->group(function () {
    Route::get('/rolesList', [UsersAccountsController::class, 'rolesList'])->name('rolesList');
    Route::get('/enterRole/{userAccountId}', [UsersAccountsController::class, 'enterRole'])->name('enterRole');

    Route::middleware(['verify.user.account'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::resource('/usuarios', UsersController::class, ['names' => 'users'])->parameters(['usuarios' => 'user']);
        Route::resource('/roles', RolesController::class, ['names' => 'roles'])->parameters(['roles' => 'role']);
        Route::resource('/roles-usuarios', UsersAccountsController::class, ['names' => 'usersAccounts'])->parameters(['roles-usuarios' => 'userAccount']);
    });
});

Route::get('/refreshToken', function() {
    return csrf_token();
})->name('refreshToken');