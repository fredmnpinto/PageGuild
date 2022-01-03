<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index'])->name('/');

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::get('details/{id}', [ItemController::class, 'showDetails']);

Route::post('/search/results', [ItemController::class, 'defaultSearch']);

Route::get('/search/results', [ItemController::class, 'defaultSearch']);

Route::get('/search/results/orderFilter/{searchQuery}/{author_id}/{publisher_id}/{genre_id}/{publication_year}/{order_by}/{order_direction}', [ItemController::class, 'orderFilterSearch']);

Route::get('profile', [UserController::class, 'index'])->name('profile');

Route::get('profile/userInformation', [UserController::class, 'showUserInfo'])->name('userInfo');

Route::post('/profile/userInformation/update', [UserController::class, 'updateUserInfo'])->name('updateInfo');
