<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/',  [WebController::class, 'index'])->name('top');

Route::controller(UserController::class)->group(function () {
    Route::get('users/mypage', 'mypage')->name('mypage');
    Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
    Route::put('users/mypage', 'update')->name('mypage.update');
    Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
    Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
    Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
});

Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/restaurants/{restaurant}/reviews', [ReviewController::class, 'index'])->name('restaurants.reviews.index');
Route::get('restaurants/{restaurant}/favorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');


/* Route::resource('reservations', ReservationController::class)->middleware(['auth', 'verified']); */
Route::get('reservations/index', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/restaurants/{restaurant}/reservations/create', [ReservationController::class, 'create'])->name('restaurants.reservations.create');
Route::post('/restaurants/{restaurant}/reservations', [ReservationController::class, 'store'])->name('restaurants.reservations.store');
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::resource('restaurants', RestaurantController::class)->middleware(['auth', 'verified']);
Auth::routes(['verify' => true]);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
