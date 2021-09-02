<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersAccountsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\DevicesController;

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

Route::get('/', [HomeController::class, 'index'])->middleware('guest')->name('home');

Route::middleware(['auth', 'checkStatus', 'user.menu'])->group(function () {
    Route::get('/rolesList', [UsersAccountsController::class, 'rolesList'])
    ->name('rolesList');
    
    Route::get('/enterRole/{userAccountId}', [UsersAccountsController::class, 'enterRole'])
    ->name('enterRole');

    Route::middleware(['verify.user.account'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');
        
        Route::resource('/usuarios', UsersController::class, ['names' => 'users'])
        ->parameters(['usuarios' => 'user']);
        
        Route::resource('/roles', RolesController::class, ['names' => 'roles'])
        ->parameters(['roles' => 'role']);
        
        Route::resource('/roles-usuarios', UsersAccountsController::class, ['names' => 'usersAccounts'])
        ->parameters(['roles-usuarios' => 'userAccount']);
        
        Route::resource('/sucursales', BranchesController::class, ['names' => 'branches'])
        ->parameters(['sucursales' => 'branch']);

        Route::resource('/configuracion', ConfigurationsController::class, ['names' => 'configurations'])
        ->parameters(['configuracion' => 'configuration']);

        Route::post('/configuracion/{configuration}', [ConfigurationsController::class, 'update'])->name('configurations.update');

        Route::resource('/clientes', ClientsController::class, ['names' => 'clients'])
        ->parameters(['clientes' => 'client']);

        Route::resource('/categorias', CategoriesController::class, ['names' => 'categories'])
        ->parameters(['categorias' => 'category']);

        Route::resource('/marcas', BrandsController::class, ['names' => 'brands'])
        ->parameters(['marcas' => 'brand']);

        Route::resource('/modelos', ModelsController::class, ['names' => 'models'])
        ->parameters(['modelos' => 'model']);

        Route::resource('/equipos', DevicesController::class, ['names' => 'devices'])
        ->parameters(['equipos' => 'device']);
    });
});

Route::get('/refreshToken', function() {
    return csrf_token();
})->name('refreshToken');