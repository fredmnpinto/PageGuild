<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AddressController;
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

/*
 |---------------------------------------------------
 | Rotas base
 |--------------------------------------------------- 
 */ 

Route::get('/', [HomeController::class, 'index'])->name('/');

Auth::routes(['verify' => true]);

 /*
 |---------------------------------------------------
 | Rotas de accesso a pagina inicial  
 |--------------------------------------------------- 
 */ 

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


/*
 |---------------------------------------------------
 | Rotas relativas a pesquisa de items
 |--------------------------------------------------- 
 */ 

Route::get('details/{id}', [ItemController::class, 'showDetails'])->name('showDetails');

Route::post('/search/results', [ItemController::class, 'defaultSearch']);

Route::get('/search/results/orderFilter/{searchQuery}/{author_id}/{publisher_id}/{genre_id}/{publication_year}/{order_by}/{order_direction}', [ItemController::class, 'orderFilterSearch'])->name('orderFilterSearch');

/*
 |---------------------------------------------------
 | Rotas das compras  
 |--------------------------------------------------- 
 */ 
  
Route::get('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

Route::get('/order/shopping_cart', [OrderController::class, 'shoppingCart'])->name('order.shopping_cart');

Route::post('/order/add_to_cart', [OrderController::class, 'addToCart'])->name('order.add_to_cart');

Route::post('/order/purchase', [OrderController::class, 'purchase'])->name('order.purchase');

/*
 |---------------------------------------------------
 | Rotas do perfil do usuario  
 |--------------------------------------------------- 
 */ 

Route::get('profile', [UserController::class, 'index'])->name('profile');

Route::get('profile/userInformation', [UserController::class, 'showUserInfo'])->name('userInfo');

Route::post('/profile/userInformation/update', [UserController::class, 'updateUserInfo'])->name('updateInfo');

Route::get('/profile/userAddress', [UserController::class, 'showUserAddress'])->name('userAddress');

Route::get('/profile/userAddress/desactivate{address_id}', [AddressController::class, 'desactivateAddress'])->name('desactivateAddress');

Route::get('/profile/userAddress/activate{address_id}', [AddressController::class, 'activateAddress'])->name('activateAddress');

Route::get('/profile/userAddress/delete{address_id}', [AddressController::class, 'deleteAddress'])->name('deleteAddress');

Route::post('/profile/userAddress/createAddress', [AddressController::class, 'createAddress'])->name('createAddress');

Route::get('/profile/userOrders', [UserController::class, 'showUserOrders'])->name('userOrders');


/*
 |---------------------------------------------------
 | Rota do How-To  
 |--------------------------------------------------- 
 */

 Route::get('how-to', [HomeController::class, 'howTo'])->name('how-to');


