<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\PosController;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/admin/profile');
});

Route::get('/encola', function () {
    return view('encola');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();


    Route::get('ventas/imprimir/{id}', 'App\Http\Controllers\PosController@imprimir')->name('venta.imprimir');



    
    Route::get('import/users', 'App\Http\Controllers\PosController@import_users')->name('import.users');
    Route::get('import/clientes', 'App\Http\Controllers\PosController@import_clientes')->name('import.clientes');
    // Route::get('producto/detalle', 'App\Http\Controllers\PosController@producto_detalle')->name('producto.detalle');
    Route::get('import/products', 'App\Http\Controllers\PosController@import_products')->name('import.products');
    Route::get('import/ventas', 'App\Http\Controllers\PosController@import_ventas')->name('import.ventas');
    
});

\PWA::routes();
