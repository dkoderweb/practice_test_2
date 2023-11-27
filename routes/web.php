<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\Admin\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// User routes
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
  

// admin routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    Route::get('/admin/home', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('dependent-dropdown', [DropdownController::class, 'index']);
    Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);
    Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);
    Route::get('/admin/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::resource('users', UserController::class);

});


