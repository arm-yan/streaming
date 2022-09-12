<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [StreamController::class, 'list'])->name('home');
Route::get('/stream/{id}', [StreamController::class, 'single'])->name('stream');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [StreamController::class, 'dashboard'])->name('dashboard');
    Route::post('/update', [StreamController::class, 'update'])->name('stream.update');
    Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [UserController::class, 'login'])->name('user.login');
    Route::get('/register', [UserController::class, 'register'])->name('user.register');

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});
