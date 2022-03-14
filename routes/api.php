<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use TCG\Voyager\Models\User;

use App\Caja;
use App\Mensajero;
use App\Producto;
use App\Categoria;
use App\Venta;
use App\DetalleVenta;
use App\Cupone;
use App\Pago;
use App\Estado;
use App\Cliente;


use App\Insumo;
use App\Unidade;
use App\Option;
use App\ProductosSemiElaborado;
use App\ProductionSemi;
use App\Production;
use App\ProductionInsumo;
use App\Proveedore;
use App\DetalleProductionSemi;


use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// TODAS LOS USER
Route::get('pos/users', function () {
    return  User::all();
});





Route::get('pos/info', function () {
    return  DB::table('settings')->where('group', 'Empresa')->get();
});


// --------------------------------------- VENTAS  ------------------------------------------
// --------------------------------------- VENTAS  ------------------------------------------

//open y close caja
Route::get('pos/caja/state/{state}/{id}', function ($state, $id) {

    switch ($state) {
        case 'open':
            $caja = Caja::find($id);
            $caja->estado = $state;
            $caja->save();
            break;
        case 'close':
            $ventas = Venta::where('caja_id', $id)->where('caja_status', false)->get();
            foreach ($ventas as $item) {
                $venta = Venta::find($item->id);
                $venta->caja_status = true;
                $venta->save();
            }
            $caja = Caja::find($id);
            $caja->estado = $state;
            $caja->save();
            break;
        default:
            # code...
            break;
    }
   
    return  true;
});
Route::get('pos/caja/total/{id}', function ( $id) {

    $ventas = Venta::where('caja_id', $id)->where('caja_status', false)->get();
    $cantidad = count($ventas);
    $total = 0;
    foreach ($ventas as $item) {
        $total = $total + $item->total;
    }
    return  response()->json(array('total' => $total, 'cantidad' => $cantidad));
});

Route::get('pos/ventas/save/{midata}', function($midata) {
    $midata2 = json_decode($midata);
    $ticket = count(Venta::where('caja_id', $midata2->caja_id)->where('caja_status', false)->get());
    $venta = Venta::create([
        'cliente_id' => $midata2->cliente_id,
        'cupon_id' => $midata2->cupon_id,
        'option_id' => $midata2->option_id,
        'pago_id' => $midata2->pago_id,
        'factura' => $midata2->factura ? $midata2->factura : null,
        'total' => $midata2->total,
        'descuento' => $midata2->descuento,
        'observacion' => $midata2->observacion,
        'register_id' => $midata2->register_id,
        'status_id' => $midata2->status_id,
        'caja_id' => $midata2->caja_id,
        'delivery_id' => $midata2->delivery_id,
        'sucursal_id' => $midata2->sucursal_id,
        'subtotal' => $midata2->subtotal,
        'caja_status' => false,
        'ticket' => $ticket + 1,
        'cantidad' => $midata2->cantidad
    ]);
    return $venta;
});

Route::get('pos/ventas/save/detalle/{micart}', function($micart) {
    // return $micart;
    $micart2 = json_decode($micart);
    $miproducto = Producto::find($micart2->producto_id);
    DetalleVenta::create([
        'producto_id' => $micart2->producto_id,
        'venta_id' => $micart2->venta_id,
        'precio' => $micart2->precio,
        'cantidad' => $micart2->cantidad,
        'total' => $micart2->total,
        'foto' => $miproducto->image ? $miproducto->image : null,
        'name' => $miproducto->name,
        'description' => $micart2->description ? $micart2->description : null
    ]);
    return true;
});

//--  SAVE CLIENTE
Route::get('pos/savacliente/{midata}', function ($midata) {
    $cliente = json_decode($midata);
    $cliente = Cliente::create([
        'first_name' => $cliente->first_name,
        'last_name' => $cliente->last_name,
        'phone' => $cliente->phone,
        'ci_nit' => $cliente->nit,
        'display' => $cliente->display,
        'email' => $cliente->email,
        'default' => 1
    ]);
    return $cliente;
});

//--  TODOS LOS PRODUCTOS
Route::get('pos/productos', function () {
    return  Producto::all();
});

// UN PRODUCT
Route::get('pos/producto/{id}', function ($id) {
    return  Producto::find($id);
});

// UN PRODUCT MIXTAS
Route::get('pos/producto/mixto/{id}/{category}', function ($id, $category) {
    return  Producto::where('mixta', $id)->where('categoria_id', $category)->get();
});

//--  TODAS LAS CATEGORY PRODUCTOS
Route::get('pos/categorias', function () {
    return  Categoria::all();
});

Route::get('pos/category/{id}', function ($id) {
    return  Categoria::find($id);
});

// PRODUCTS FOR CATEGORY
Route::get('pos/productos/category/{id}', function ($id) {
    return  Producto::where('categoria_id', $id)->get();
});

// TODAS LAS VENTAS y By ID
Route::get('pos/ventas', function () {
    return  Venta::all();
});
Route::get('pos/venta/{id}', function ($id) {
    return  Venta::find($id);
});

// TODAS LAS VENTAS POR CAJA
Route::get('pos/ventas/caja/{caja_id}', function ($caja_id) {
    return  Venta::where('caja_id', $caja_id)->where('caja_status', false)->get();
});

// VENTA POR ID
Route::get('pos/ventas/{id}', function ($id) {
    return  Venta::where('id',$id)->get();
});

// TODAS LOS CLIENTES
Route::get('pos/clientes', function () {
    return Cliente::all();
});
Route::get('pos/cliente/{id}', function ($id) {
    return  Cliente::where('id', $id)->get();
});
Route::get('pos/cliente/default/get', function () {
    return  Cliente::where('default', 1)->orderBy('created_at', 'desc')->first();
    // return true;
});


// UN VENTAS POR CLINTE
Route::get('pos/ventas/cliente/{cliente_id}', function ($cliente_id) {
    return  Venta::where('cliente_id', $cliente_id)->get();
});

// UN VENTAS POR CAJERO
Route::get('pos/ventas/cajauser/{register_id}', function ($register_id) {
    return  Venta::where('register_id', $register_id)->get();
});

//TODOS LOS CAJEROS
Route::get('pos/cajeros', function () {
    return  User::all();
});

//TODOS LOS CUPONES
Route::get('pos/cupones', function () {
    return  Cupone::all();
});

//TODOS LOS CUPON ID
Route::get('pos/cupon/{id}', function ($id) {
    return  Cupone::find($id);
});

// TODAS LAS OPCIONES
Route::get('pos/options', function () {
    return  Option::all();
});

// TODAS LOS PAGOS
Route::get('pos/pagos', function () {
    return  Pago::all();
});

// TODAS LOS STADOS
Route::get('pos/estados', function () {
    return  Estado::all();
});

// TODAS LOS DELIVERYS
Route::get('pos/deliverys', function () {
    return  Mensajero::all();
});





//TODO ESTO ES PARA PRODUCCIÓN BY JONATHAN--------------------------------------
//--  TODOS LOS INSUMOS
Route::get('pos/insumos', function () {
    return  Insumo::all();
});

// UN INSUMO
Route::get('pos/insumos/{id}', function ($id) {
    return  Insumo::find($id);
});

//--  TODAS LAS UNIDADES INSUMOS
Route::get('pos/unidades', function () {
    return  Unidade::all();
});

// INSUMOS FOR UNIDAD
Route::get('pos/insumo/unidad/{id}', function ($id) {

    return  Insumo::where('unidad_id', $id)->get();
});
//TODOS LOS PRODS_PREEL
Route::get('pos/productosemi', function () {
    return  ProductosSemiElaborado::all();
});
//UN PROD_PREEL
Route::get('pos/productopreid/{id}', function ($id) {
    return ProductosSemiElaborado::find($id);
});

//TODOS LOS PROVEEDORES
Route::get('pos/proveedores', function () {
    return  Proveedore::all();
});
//UN PROVEEDOR
Route::get('pos/proveedores/{id}', function ($id) {
    return Proveedore::find($id);
});

// PRODUCTION  
Route::get('pos/productions/save/{midataProduction}', function($midataProduction) {
    
    $midataProduction = json_decode($midataProduction);

    $production = Production::create([
        'producto_id' => $midataProduction->producto_id,
        'cantidad' => $midataProduction->cantidad,
        'valor' => $midataProduction->valor,
        'description' => $midataProduction->description,
        'user_id' => $midataProduction->user_id
    ]);

    //Actualizando el STOCK DEL Producto
    $update = Producto::find($midataProduction->producto_id);
    $actual = $update->stock;
    $update->stock = $actual + $midataProduction->cantidad;
    $update->save();

    return $production->id;
});

Route::get('pos/productions/save/detalle/{miproduction}', function($miproduction) {
    $miproduction2 = json_decode($miproduction);
    ProductionInsumo::create([
        'type_insumo'=>$miproduction2->type,
        'production_id'=>$miproduction2->production_id,
        'insumo_id' => $miproduction2->insumo_id,
        'proveedor_id'=> $miproduction2->proveedor_id,
        'precio' => $miproduction2->precio,
        'cantidad' => $miproduction2->cantidad,
        'total' => $miproduction2->total
    ]);
    return true;
});


// PRODUCTION SEMI 
Route::get('pos/productions/savesemi/{midataProduction}', function($midataProduction) {
    
    $midataProduction = json_decode($midataProduction);

    $production = ProductionSemi::create([
        'producto_semi_id' => $midataProduction->producto_semi_id,
        'cantidad' => $midataProduction->cantidad,
        'valor' => $midataProduction->valor,
        'description' => $midataProduction->description,
        'user_id' => $midataProduction->user_id
    ]);
    return $production->id;
});

Route::get('pos/productions/savesemi/detalle/{miproduction}', function($miproduction) {
    $miproduction2 = json_decode($miproduction);
    DetalleProductionSemi::create([
        'production_semi_id'=>$miproduction2->production_semi_id,
        'insumo_id' => $miproduction2->insumo_id,
        'proveedor_id'=> $miproduction2->proveedor_id,
        'precio' => $miproduction2->precio,
        'cantidad' => $miproduction2->cantidad,
        'total' => $miproduction2->total
    ]);
    return true;
});

//PRODUCTIOS PARA PRODUCCION
Route::get('pos/productos/production', function () {
    return  Producto::where('production', true)->get();
});