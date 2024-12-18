<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\SearchController;
use App\Models\Company;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('restaurants', RestaurantController::class)->except(['index', 'show']);
});

Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::controller(UserController::class)->group(function () {
    Route::get('users/mypage', 'mypage')->name('mypage');
    Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
    Route::put('users/mypage', 'update')->name('mypage.update');
    Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
    Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
    Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
    Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
});


Route::middleware(['auth', 'verified', 'subscribed'])->group(function () {
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::post('restaurants/{restaurant}/favorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite');

    Route::get('/restaurants/{restaurant}/reviews', [ReviewController::class, 'index'])->name('restaurants.reviews.index');


/* Route::get('restaurants/{restaurant}/favorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite'); */

/* Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show'); */

/* Route::middleware(['auth', 'verified', 'subscribed'])->group(function () { */
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/restaurants/{restaurant}/reservations/create', [ReservationController::class, 'create'])->name('restaurants.reservations.create');
    Route::post('/restaurants/reservations/store', [ReservationController::class, 'store'])->name('restaurants.reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('reservations/complete', [ReservationController::class, 'complete'])->name('reservations.complete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants/{restaurant}/reservations/create', [ReservationController::class, 'create'])->name('restaurants.reservations.create');
    Route::post('/restaurants/reservations/store', [ReservationController::class, 'store'])->name('restaurants.reservations.store');
});

// サブスクリプション関連のルート
Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
Route::post('/subscription/store', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
Route::get('/subscription/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
Route::post('/subscription/update', [SubscriptionController::class, 'update'])->name('subscription.update');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true, 'register' => true]);