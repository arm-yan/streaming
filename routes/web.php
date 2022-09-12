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

//Main Page with the list of streams
Route::get('/', [StreamController::class, 'list'])->name('home');

//The Stream Page with all the details
Route::get('/stream/{id}', [StreamController::class, 'single'])->name('stream');

//Authorized users allowed only
Route::group(['middleware' => ['auth']], function () {
    //Users stream dashboard
    Route::get('/dashboard', [StreamController::class, 'dashboard'])->name('dashboard');
    //Handles stream details update
    Route::post('/update', [StreamController::class, 'update'])->name('stream.update');
    //Handles user logout
    Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

//Guests allowed only
Route::group(['middleware' => ['guest']], function () {
    //The login page
    Route::get('/login', [UserController::class, 'login'])->name('user.login');
    //The registration page
    Route::get('/register', [UserController::class, 'register'])->name('user.register');
    //Handles user login
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    //Handles user registration
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});
