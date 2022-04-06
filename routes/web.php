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

Route::get('venta/{id}', 'App\Http\Controllers\PosController@venta_public')->name('venta.public');

Route::get('/encola/{id}', function ($id) {
    $monitor = App\Monitore::find($id);
    // return $monitor;
    return view('encola')->with('monitor', $monitor);
})->name('monitor');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();


    Route::get('ventas/imprimir/{id}', 'App\Http\Controllers\PosController@imprimir')->name('venta.imprimir');

    Route::get('detalle_cajas/imprimir/{id}', 'App\Http\Controllers\PosController@cierre_caja')->name('cajas.cierre_caja');

    Route::get('catalogos/enviar/{id}', function($id){
        $catalogo = App\Catalogo::find($id);
        $productos = App\RelCatalogoProducto::where('catalogo_id', $id)->get();
        return redirect("https://api.whatsapp.com/send?&text= MENU DE DIA: %0A".$catalogo->title.'%0A'.$productos);
    })->name('catalogo.enviar');
    
    Route::get('import/users', 'App\Http\Controllers\PosController@import_users')->name('import.users');
    Route::get('import/clientes', 'App\Http\Controllers\PosController@import_clientes')->name('import.clientes');
    // Route::get('producto/detalle', 'App\Http\Controllers\PosController@producto_detalle')->name('producto.detalle');
    Route::get('import/products', 'App\Http\Controllers\PosController@import_products')->name('import.products');
    Route::get('import/ventas', 'App\Http\Controllers\PosController@import_ventas')->name('import.ventas');


    
});

\PWA::routes();
