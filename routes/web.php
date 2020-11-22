<?php

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





Auth::routes([
    'reset'     => false,
    'confirm'   => false,
]);

Route::get('locale/{locale}', 'MainController@changeLocale')->name('locale');
Route::get('currency/{currencyCode}', 'MainController@changeCurrency')->name('currency');

    Route::get('logout','Auth\LoginController@logout')->name('get-logout');



Route::middleware(['set_locale'])->group(function () {
        Route::middleware(['auth'])->group(function (){

            //Обычные пользователи
            Route::group(['prefix'=>'person', 'namespace'=>'Person', 'as'=>'person.'], function (){

                Route::get('/orders', 'OrdersController@index')->name('order.index');
                Route::get('/orders/{orders}', 'OrdersController@show')->name('orders.show');
            });

            //Админка
            Route::group(['namespace' => 'Admin', 'prefix'=>'admin'], function () {
                Route::group(['middleware' => 'is_admin',], function (){

                    Route::get('/orders', 'OrdersController@index')->name('home');
                    Route::get('/orders/{orders}', 'OrdersController@show')->name('orders.show');
                    Route::get('/orders/execute/{orders}', 'OrdersController@executeOrder')->name('orders.execute');

                    Route::resource('products', 'ProductController');
                    Route::resource('categories', 'CategoryController');
                });
            });


    });



//Корзина
    Route::post('/basket/add/{product}','BasketController@basketAdd')->name('basket-add');
    Route::group(['middleware' => 'basket_not_empty', 'prefix'=>'basket' ], function () {

        Route::get('/','BasketController@basket')->name('basket');
        Route::get('/place','BasketController@basketOrderForm')->name('basket-place');
        Route::post('/place','BasketController@basketConfirm')->name('basket-confirm');
        Route::post('/remove/{product}','BasketController@basketRemove')->name('basket-remove');
    });


//Главная страница
    Route::get('/','MainController@index')->name('index');
    Route::get('/categories','MainController@categories')->name('categories');
    Route::get('/{category}','MainController@category')->name('category');
    Route::post('subscription/{product}','MainController@subscribe')->name('subscription');
    Route::get('/{category}/{product}','MainController@product')->name('product');

});



