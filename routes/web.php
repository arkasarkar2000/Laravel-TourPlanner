<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripController;

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
    return view('signup');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/signup-form', [UserController::class, 'signup']);
Route::post('/login-form', [UserController::class, 'login']);


Route::get('/home', function () {
    return view('home');
});

Route::get('/logout-user', [UserController::class, 'logout']);
Route::post('/add-user',[UserController::class,'create']);
Route::post('/add-role',[UserController::class,'create_role']);
Route::get('/users',[UserController::class,'listing']);
Route::get('/home',[UserController::class,'role_listing']);


Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');


Route::post('/add-trip', [TripController::class, 'create_trip']);
Route::get('/home', [TripController::class, 'list_trip'])->name('trip.index');
Route::get('/trip/{id}/edit', [TripController::class, 'edit'])->name('trip.edit');
Route::put('/trip/{id}', [TripController::class, 'update'])->name('trip.update');
Route::get('/trip/delete/{id}', [TripController::class, 'destroy'])->name('trip.destroy');
Route::get('/trips_export',[TripController::class, 'get_trips_data'])->name('trips.export');
