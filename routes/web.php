<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

/* Base Routes */
Route::get('/', [HomeController::class, 'index'])->name('/');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


/* Item Routes */
Route::get('details/{id}', [ItemController::class, 'showDetails'])->name('showDetails');

Route::post('/search/results', [ItemController::class, 'defaultSearch']);

Route::get('/search/results', [ItemController::class, 'defaultSearch']);

Route::get('/search/results/orderFilter/{searchQuery}/{author_id}/{publisher_id}/{genre_id}/{publication_year}/{order_by}/{order_direction}', [ItemController::class, 'orderFilterSearch']);


/* Orders Routes */
Route::get('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

Route::get('/order/shopping_cart', [OrderController::class, 'shoppingCart'])->name('order.shopping_cart');

Route::post('/order/add_to_cart', [OrderController::class, 'addToCart'])->name('order.add_to_cart');

Route::post('/order/purchase', [OrderController::class, 'purchase'])->name('order.purchase');

