<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Models\Auction;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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
    $data1 = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'user_info.avatar', 'categories.name as category_name', 'products.image as product_image')
            ->where('auctions.status', '=', 3)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();


        $data2 = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'user_info.avatar', 'categories.name as category_name', 'products.image as product_image')
            ->where('auctions.status', '=', 2)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        $categories = Category::all();
    return view('client.homepage.index', compact('categories', 'data1','data2'));
});



Route::prefix('client')->controller(ClientController::class)->name('client.')->group(function () {
    Route::get('productDetails/{id}', 'productDetails')->name('productDetails');
    Route::get('index', 'index')->name('index');
    Route::get('auction','auction')->name('auction');
    Route::get('aboutus', 'aboutus')->name('aboutus');
    Route::get('howwork', 'howwork')->name('howwork');
    Route::get('signup', 'signup')->name('signup');
    Route::get('login', 'login')->name('login');
    Route::get('dashboard/{id}', 'dashboard')->name('dashboard');
    Route::get('dashboard/{id}/AllProduct', 'AllProduct')->name('dashboard.AllProduct');
    Route::get('dashboard/{id}/BidAuctionList', 'BidAuctionList')->name('dashboard.BidAuctionList');
    Route::post('updateProfile/{id}', 'updateProfile')->name('updateProfile');
    Route::post('productstore', 'productstore')->name('productstore');
    Route::post('bid/{id}', 'bid')->name('bid');
    Route::post('uploadFiles', 'uploadFiles')->name('uploadFiles');
    Route::post('deleteImage', 'deleteImage')->name('deleteImage');
    Route::get('changeStatus/{id}','changeStatus')->name('changeStatus');
});







Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
    Route::post('postloginclient', [AuthController::class, 'postloginclient'])->name('postloginclient');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('logoutClient', [AuthController::class, 'logoutClient'])->name('logoutClient');
});






Route::prefix('user')->controller(UsersController::class)->middleware(['CheckLogin', 'CheckUser'])->name('user.')->group(
    function () {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('search', 'search')->name('search');
        Route::get('status', 'status')->name('status');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('profile/{id}', 'profile')->name('profile');
        Route::get('editProfile/{id}', 'editProfile')->name('editProfile');
        Route::post('updateProfile/{id}', 'updateProfile')->name('updateProfile');
        Route::post('updateProfileAvatar/{id}', 'updateProfileAvatar')->name('updateProfileAvatar');
        Route::post('changePassWord/{id}', 'changePassWord')->name('changePassWord');
        Route::get('changeStatus/{id}', 'changeStatus')->name('changeStatus');
        Route::get('changeRole/{id}', 'changeRole')->name('changeRole');
    }
);

Route::prefix('product')->controller(ProductsController::class)->middleware(['CheckLogin'])->name('product.')->group(
    function () {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('listCheck', 'listCheck')->name('listCheck');
        Route::get('search', 'search')->name('search');
        Route::post('store', 'store')->name('store');
        Route::get('changeStatus/{id}', 'changeStatus')->name('changeStatus');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('destroy/{id}', 'destroy')->name('destroy');
        Route::post('uploadFiles', 'uploadFiles')->name('uploadFiles');
        Route::post('deleteListCheck/{id}', 'deleteListCheck')->name('deleteListCheck');
        Route::post('deleteImage', 'deleteImage')->name('deleteImage');


    }
);







Route::prefix('category')->controller(CategoriesController::class)->middleware(['CheckLogin'])->name('category.')->group(
    function () {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('search', 'search')->name('search');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('changeStatus/{id}', 'changeStatus')->name('changeStatus');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
    }
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');