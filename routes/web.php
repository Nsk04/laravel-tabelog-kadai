<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\CheckSubscription;
use App\Http\Middleware\NotSubscription;
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

// トップページ
Route::get('/', [WebController::class, 'index'])->name('top');

// メール認証
Auth::routes(['verify' => true]);

// メール認証後のリダイレクト設定
Route::get('/home', function () {
    return redirect()->route('top');
})->name('home');

// レストラン関連（非認証）
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

// 検索機能
Route::get('/search', [SearchController::class, 'search'])->name('search');

// 認証が必要
Route::middleware(['auth', 'verified'])->group(function () {
    // レストラン
    Route::resource('restaurants', RestaurantController::class)->except(['index', 'show']);

    // ユーザーのマイページ
    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
    });

    // 未加入ユーザー
    Route::group(['middleware' => [NotSubscription::class]], function () {
        Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
        Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    });

    // サブスクリプション加入
    Route::group(['middleware' => [CheckSubscription::class]], function () {
        // レビュー関連
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/restaurants/{restaurant}/reviews', [ReviewController::class, 'index'])->name('restaurants.reviews.index');

        // お気に入り関連
        Route::post('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite');

        // 予約関連
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/restaurants/{restaurant}/reservations/create', [ReservationController::class, 'create'])->name('restaurants.reservations.create');
        Route::post('/restaurants/reservations/store', [ReservationController::class, 'store'])->name('restaurants.reservations.store');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::get('/reservations/complete', [ReservationController::class, 'complete'])->name('reservations.complete');

        // サブスクリプション管理
        Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
        /* Route::get('/subscription/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit'); */
        Route::get('/subscription', [SubscriptionController::class, 'show'])->name('subscription.show');
        Route::post('/subscription/update', [SubscriptionController::class, 'update'])->name('subscription.update');
        Route::get('/subscription/complete', [SubscriptionController::class, 'complete'])->name('subscription.complete');
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* 
    Route::middleware(['notsubscribed'])->group(function () {
        Route::get('subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
        Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    });

    Route::middleware(['subscribed'])->group(function () {
        Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::post('restaurants/{restaurant}/favorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite');
        Route::get('/restaurants/{restaurant}/reviews', [ReviewController::class, 'index'])->name('restaurants.reviews.index');
        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/restaurants/{restaurant}/reservations/create', [ReservationController::class, 'create'])->name('restaurants.reservations.create');
        Route::post('/restaurants/reservations/store', [ReservationController::class, 'store'])->name('restaurants.reservations.store');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::get('reservations/complete', [ReservationController::class, 'complete'])->name('reservations.complete');
        Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
        Route::post('/subscription/store', [SubscriptionController::class, 'store'])->name('subscription.store');
        Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
        Route::get('/subscription/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
        Route::post('/subscription/update', [SubscriptionController::class, 'update'])->name('subscription.update');
        Route::get('/subscription/complete', [SubscriptionController::class, 'complete'])->name('subscription.complete');
    });
});
 */