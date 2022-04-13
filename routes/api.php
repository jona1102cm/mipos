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
use App\Asiento;
use App\DetalleCaja;
use App\Sucursale;
use App\Insumo;
use App\Unidade;
use App\Option;
use App\ProductosSemiElaborado;
use App\ProductionSemi;
use App\Production;
use App\ProductionInsumo;
use App\Proveedore;
use App\DetalleProductionSemi;
use App\TypeProducto;
use App\Banipay;
use App\Compra;

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


// FRONEND
Route::post('pos/save_pedido', function (Request $request) {
    return $request;
});

Route::get('pedidos/cliente/{phone}', function ($phone) {
    $midata = Cliente::where('phone', $phone)->first();
    return $midata;
});
// --------------------------------------- VENTAS  ------------------------------------------
// --------------------------------------- VENTAS  ------------------------------------------

//Asientos
Route::get('pos/asiento/save/{midata}', function ($midata) {
    $midata2 = json_decode($midata);
    $asiento = Asiento::create([
        'caja_id' => $midata2->caja_id,
        'type' => $midata2->type,
        'monto' => $midata2->monto,
        'concepto' => $midata2->concepto,
        'editor_id' => $midata2->editor_id,
        'caja_status' => false,
        'pago'=> $midata2->pago,
    ]);
    return $asiento;
});
Route::get('pos/asientos/caja/editor/{midata}', function ($midata) {
    $midata2 = json_decode($midata);
    $asientos = Asiento::where('caja_id', $midata2->caja_id)->where('editor_id', $midata2->editor_id)->where('caja_status', false)->get();
    return $asientos;
});

//update cocina
Route::get('pos/cocina/{id}', function ($id) {
    $venta = Venta::find($id);
    $venta->status_id = 3;
    $venta->save();
    return true;
});

//open y close caja
Route::get('pos/caja/state/{state}/{id}', function ($state, $id) {
    switch ($state) {
        case 'open':
            $caja = Caja::find($id);
            $caja->estado = $state;
            $caja->save();
            break;
        case 'close':
            // $ventas = Venta::where('caja_id', $id)->where('caja_status', false)->get();
            // foreach ($ventas as $item) {
            //     $venta = Venta::find($item->id);
            //     $venta->caja_status = true;
            //     $venta->save();
            // }
            // $caja = Caja::find($id);
            // $caja->estado = $state;
            // $caja->save();
            // break;
        default:
            # code...
            break;
    }
    return  true;
});
Route::get('pos/caja/detalle/save/{midata}', function ($midata) {
    $midata2 = json_decode($midata);

    $ventas = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->get();
    foreach ($ventas as $item) {
        $venta = Venta::find($item->id);
        $venta->caja_status = true;
        $venta->save();
    }

    $asientos = Asiento::where('caja_id', $midata2->caja_id)->where('editor_id', $midata2->editor_id)->where('caja_status', false)->get();
    foreach ($asientos as $item) {
        $asiento = Asiento::find($item->id);
        $asiento->caja_status = true;
        $asiento->save();
    }

    $detalla_caja = DetalleCaja::create([
        'cantidad_ventas' => $midata2->cant_ventas,
        'importe_inicial' => $midata2->importe_inicial,
        'total_ventas' => $midata2->_total,
        'ingresos' => $midata2->ingresos,
        'egresos' => $midata2->egresos,
        'caja_id' => $midata2->caja_id,
        'editor_id' => $midata2->editor_id,
        'description' => $midata2->description,
        'venta_efectivo'=> $midata2->venta_efectivo,
		// 'venta_tarjeta'=> $midata2->venta_tarjeta,
		// 'venta_transferencia'=> $midata2->venta_transferencia,
		// 'venta_qr'=> $midata2->venta_qr,
		// 'venta_tigomoney'=> $midata2->venta_tigomoney,
        'venta_banipay'=> $midata2->venta_banipay,
		'cantidad_efectivo'=> $midata2->cantidad_efectivo,
		// 'cantidad_tarjeta'=> $midata2->cantidad_tarjeta,
		// 'cantidad_transferencia'=> $midata2->cantidad_transferencia,
		// 'cantidad_qr'=> $midata2->cantidad_qr,
		// 'cantidad_tigomoney'=> $midata2->cantidad_tigomoney,
        'cantidad_banipay'=> $midata2->cantidad_banipay,
		'efectivo_entregado'=> $midata2->efectivo_entregado,
		'cortes'=> $midata2->cortes,
        'ingreso_efectivo'=>$midata2->ingreso_efectivo,
        'ingreso_linea'=>$midata2->ingreso_linea,
        'egreso_efectivo'=>$midata2->egreso_efectivo,
        'egreso_linea'=>$midata2->egreso_linea

    ]);

    $caja = Caja::find($midata2->caja_id);
    $caja->estado = $midata2->status;
    $caja->save();

    return  $detalla_caja;
});
Route::get('pos/caja/get_total/{midata}', function ( $midata) {
    $midata2 = json_decode($midata);

    $ventas = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->get();
    $cantidad = count($ventas);
    $total = 0;
    foreach ($ventas as $item) {
        $total = $total + $item->total;
    }
    $ingresos = Asiento::where('type', 'Ingresos')->where('caja_id', $midata2->caja_id)->where('editor_id', $midata2->editor_id)->where('caja_status', false)->get();
    $ti = 0;
    foreach ($ingresos as $item) {
        $ti = $ti + $item->monto;
    }
    $egresos = Asiento::where('type', 'Egresos')->where('caja_id', $midata2->caja_id)->where('editor_id', $midata2->editor_id)->where('caja_status', false)->get();
    $te = 0;
    foreach ($egresos as $item) {
        $te = $te + $item->monto;
    }

    //desde aqui jchavez
    $venta_efectivo = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pago_id',1)->get();
    $cantidad_efectivo = count($venta_efectivo);
    $total_efectivo = 0;
    foreach ($venta_efectivo as $item) {
        $total_efectivo = $total_efectivo + $item->total;
    }

    $venta_banipay = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pago_id',2)->get();
    $cantidad_banipay = count($venta_banipay);
    $total_banipay = 0;
    foreach ($venta_banipay as $item) {
        $total_banipay = $total_banipay + $item->total;
    }

    // $venta_tarjeta = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pago_id',2)->get();
    // $cantidad_tarjeta = count($venta_tarjeta);
    // $total_tarjeta = 0;
    // foreach ($venta_tarjeta as $item) {
    //     $total_tarjeta = $total_tarjeta + $item->total;
    // }

    // $venta_transferencia = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pago_id',3)->get();
    // $cantidad_transferencia = count($venta_transferencia);
    // $total_transferencia = 0;
    // foreach ($venta_transferencia as $item) {
    //     $total_transferencia = $total_transferencia + $item->total;
    // }

    // $venta_qr = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pago_id',4)->get();
    // $cantidad_qr = count($venta_qr);
    // $total_qr = 0;
    // foreach ($venta_qr as $item) {
    //     $total_qr = $total_qr + $item->total;
    // }

    // $venta_tigomoney = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pago_id',5)->get();
    // $cantidad_tigomoney = count($venta_tigomoney);
    // $total_tigomoney = 0;
    // foreach ($venta_tigomoney as $item) {
    //     $total_tigomoney = $total_tigomoney + $item->total;
    // }

    $ie=Asiento::where('caja_id',$midata2->caja_id)->where('editor_id',$midata2->editor_id)->where('caja_status',false)->where('type',"Ingresos")->where('pago',1)->get();
    $ingreso_efectivo=0;
    foreach($ie as $item){
        $ingreso_efectivo+= $item->monto;
    }

    $il=Asiento::where('caja_id',$midata2->caja_id)->where('editor_id',$midata2->editor_id)->where('caja_status',false)->where('type',"Ingresos")->where('pago',0)->get();
    $ingreso_linea=0;
    foreach($il as $item){
        $ingreso_linea+= $item->monto;
    }

    $ee=Asiento::where('caja_id',$midata2->caja_id)->where('editor_id',$midata2->editor_id)->where('caja_status',false)->where('type',"Egresos")->where('pago',1)->get();
    $egreso_efectivo=0;
    foreach($ee as $item){
        $egreso_efectivo+= $item->monto;
    }

    $el=Asiento::where('caja_id',$midata2->caja_id)->where('editor_id',$midata2->editor_id)->where('caja_status',false)->where('type',"Egresos")->where('pago',0)->get();
    $egreso_linea=0;
    foreach($el as $item){
        $egreso_linea+= $item->monto;
    }

    //return  response()->json(array('total' => $total, 'cantidad' => $cantidad, 'ingresos' => $ti, 'egresos'=> $te, 'total_efectivo'=> $total_efectivo, 'cantidad_efectivo'=> $cantidad_efectivo,'total_tarjeta'=> $total_tarjeta,'cantidad_tarjeta'=>$cantidad_tarjeta,'total_transferencia'=> $total_transferencia,'cantidad_transferencia'=>$cantidad_transferencia, 'total_qr'=>$total_qr,'cantidad_qr'=>$cantidad_qr,'total_tigomoney'=>$total_tigomoney,'cantidad_tigomoney'=>$cantidad_tigomoney, 'ingreso_efectivo'=>$ingreso_efectivo, 'ingreso_linea'=>$ingreso_linea, 'egreso_efectivo'=>$egreso_efectivo, 'egreso_linea'=>$egreso_linea));
    return  response()->json(array('total' => $total, 'cantidad' => $cantidad, 'ingresos' => $ti, 'egresos'=> $te, 'total_efectivo'=> $total_efectivo, 'cantidad_efectivo'=> $cantidad_efectivo, 'total_banipay'=>$total_banipay, 'cantidad_banipay'=> $cantidad_banipay, 'ingreso_efectivo'=>$ingreso_efectivo, 'ingreso_linea'=>$ingreso_linea, 'egreso_efectivo'=>$egreso_efectivo, 'egreso_linea'=>$egreso_linea));

});
Route::get('pos/cajas', function(){
    return Caja::with('sucursal')->get();
});

//banipay
Route::get('pos/banipay/save/{midata}', function($midata) {
    $midata2 = json_decode($midata);
    $banipay = Banipay::create([
        'venta_id' => $midata2->externalCode,
        'paymentId' => $midata2->paymentId,
        'transactionGenerated' => $midata2->transactionGenerated,
        'urlTransaction' => '?t='.$midata2->transactionGenerated.'&p='.$midata2->paymentId
    ]);
    return $banipay;
});
Route::get('pos/banipay/get/{venta_id}', function($venta_id) {

    return Banipay::where('venta_id', $venta_id)->first();
});

//ventas
Route::get('pos/ventas/save/{midata}', function($midata) {
    $midata2 = json_decode($midata);
    $ticket = count(Venta::where('sucursal_id', $midata2->sucursal_id)->where('caja_status', false)->get());
    $venta = Venta::create([
        'cliente_id' => $midata2->cliente_id,
        'cupon_id' => $midata2->cupon_id,
        'option_id' => $midata2->option_id,
        'pago_id' => $midata2->pago_id,
        'factura' => $midata2->factura ? $midata2->factura : null,
        'credito'=> $midata2->credito,
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
        'cantidad' => $midata2->cantidad,
        'recibido' => $midata2->recibido,
        'cambio' => $midata2->cambio,
        'chofer_id'=>$midata2->chofer_id,
        'adicional'=>$midata2->adicional
    ]);
    return $venta;
});

Route::get('pos/ventas/save/detalle/{micart}', function($micart) {
    $micart2 = json_decode($micart);
    $miproducto = Producto::find($micart2->producto_id);

    if (setting('ventas.stock')) {
        $cant_a = $miproducto->stock;
        $cant_b = $micart2->cantidad;
        $cant_c = $cant_a - $cant_b;
        $miproducto->stock = $cant_c;
        $miproducto->save();
        DetalleVenta::create([
            'producto_id' => $micart2->producto_id,
            'venta_id' => $micart2->venta_id,
            'precio' => $micart2->precio,
            'cantidad' => $micart2->cantidad,
            'total' => $micart2->total,
            'foto' => $miproducto->image ? $miproducto->image : null,
            'name' => $miproducto->name,
            'description' => $micart2->description,
            'extra_name'=>$micart2->extra_name,
            'observacion'=>$micart2->observacion
        ]);

    } else {
        DetalleVenta::create([
            'producto_id' => $micart2->producto_id,
            'venta_id' => $micart2->venta_id,
            'precio' => $micart2->precio,
            'cantidad' => $micart2->cantidad,
            'total' => $micart2->total,
            'foto' => $miproducto->image ? $miproducto->image : null,
            'name' => $miproducto->name,
            'description' => $micart2->description,
            'extra_name'=>$micart2->extra_name,
            'observacion'=>$micart2->observacion
        ]);
    }

    return true;
});

//SAVE COMPRA
Route::get('pos/compras/save/{midata}', function($midata) {
    $midata2 = json_decode($midata);
    $miinsumo = Insumo::find($midata2->insumo_id);

    if (setting('ventas.stock')) {
        $cant_a = $miinsumo->stock;
        $cant_b = $midata2->cantidad;
        $cant_c = $cant_a + $cant_b;
        $miinsumo->stock = $cant_c;
        $miinsumo->save();

        $compra= Compra::create([
        'description'=>$midata2->description,
        'editor_id'=>$midata2->editor_id,
        'cantidad'=>$midata2->cantidad,
        'costo'=>$midata2->costo,
        'total'=>$midata2->total,
        'proveedor_id'=>$midata2->proveedor_id,
        'insumo_id'=>$midata2->insumo_id,
        'unidad_id'=>$midata2->unidad_id
        ]);
    }
    else{
        $compra= Compra::create([
        'description'=>$midata2->description,
        'editor_id'=>$midata2->editor_id,
        'cantidad'=>$midata2->cantidad,
        'costo'=>$midata2->costo,
        'total'=>$midata2->total,
        'proveedor_id'=>$midata2->proveedor_id,
        'insumo_id'=>$midata2->insumo_id,
        'unidad_id'=>$midata2->unidad_id
        ]);
    }
    return true;
});


// SAVE CLIENTE
Route::get('pos/savacliente/{midata}', function ($midata) {
    $cliente = json_decode($midata);
    $cliente = Cliente::create([
        'first_name' => $cliente->first_name,
        'last_name' => $cliente->last_name,
        'phone' => $cliente->phone,
        'ci_nit' => $cliente->nit,
        'display' => $cliente->display,
        'email' => $cliente->email,
        'default' => 0
    ]);
    return $cliente;
});

Route::get('pos/clientes/search/{criterio}', function ($criterio) {
    $clientes = Cliente::where('display', 'like', '%'.$criterio.'%')->get();
    return $clientes;
});

//Sucursales
Route::get('pos/sucursales', function(){
    return Sucursale::all();
});

//Deliverys
Route::get('pos/deliverys', function(){
    return Mensajero::all();
});

//Choferes
Route::get('pos/choferes', function(){
    $chofer= User::where('role_id', setting('ventas.role_id_chofer'))->get();
    return $chofer;
});
Route::get('pos/choferes/deudas/{chofer_id}/{caja_id}', function($chofer_id, $caja_id){
    $ventas= Venta::where('chofer_id', $chofer_id)->where('caja_id', $caja_id)->where('caja_status', false)->get();
    return $ventas;
});

// TODOS LOS PRODUCTOS
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
    return  Categoria::where('id', '!=', 7)->where('id','!=', 16)->orderBy('order', 'asc')->get();
});
Route::get('pos/categorias_all', function () {
    return  Categoria::orderBy('order', 'asc')->get();
});

// Productos de categoria Extra Grande y Mediana
Route::get('pos/producto/extra/{categoria_id}',function($categoria_id){
    return Producto::where('categoria_id', $categoria_id)->get();
});

//--  Tipos PRODUCTOS
Route::get('pos/typeproductos', function () {
    //return  Categoria::orderBy('order', 'asc')->get();
    return TypeProducto::all();
});

Route::get('pos/category/{id}', function ($id) {
    return  Categoria::find($id);
});

// PRODUCTS FOR CATEGORY
Route::get('pos/productos/category/{id}', function ($id) {
    return  Producto::where('categoria_id', $id)->with('categoria')->get();
});

// TODAS LAS VENTAS y By ID
Route::get('pos/ventas', function () {
    return  Venta::with('cliente')->get();
});
Route::get('pos/venta/{id}', function ($id) {
    return  Venta::find($id);
});

// TODAS LAS VENTAS POR CAJA
Route::get('pos/ventas/caja/{caja_id}/{user_id}', function ($caja_id, $user_id) {
    return  Venta::where('register_id', $user_id)->where('caja_id', $caja_id)->where('caja_status', false)->with('cliente', 'delivery','chofer', 'pasarela')->orderBy('created_at','desc')->get();
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
    return  Cliente::find($id);
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
//TODOS LOS CHOFERES
Route::get('pos/chofer', function () {
    return  User::find('role_id',8);
});

//asignacion Delivery
Route::get('pos/chofer/set/{venta_id}/{chofer_id}', function ($id, $chofer_id) {

    $venta = Venta::find($id);
    $venta->chofer_id = $chofer_id;
    $venta->save();
    return  true;
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

// UNA UNIDAD
Route::get('pos/unidades/{id}', function ($id) {
    return  Unidade::find($id);
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

    //Condición para definir si se guardará id de simple o elab
    if($miproduction2->type=="simple"){
        $insumo=$miproduction2->insumo_id;
        $elab=null;
    }

    if($miproduction2->type=="elaborado"){
        $insumo=null;
        $elab=$miproduction2->insumo_id;
    }


    $productionI= ProductionInsumo::create([
        'type_insumo'=>$miproduction2->type,
        'production_id'=>$miproduction2->production_id,
        'insumo_id' => $insumo,
        'elaborado_id'=>$elab,
        'proveedor_id'=> $miproduction2->proveedor_id,
        'precio' => $miproduction2->precio,
        'cantidad' => $miproduction2->cantidad,
        'total' => $miproduction2->total
    ]);

    //Update Stock Insumo
    if($miproduction2->type=="simple"){
    $ins= Insumo::find($miproduction2->insumo_id);
    $canta = $ins->stock;
    $cantb = $miproduction2->cantidad;
    $cantc = $canta - $cantb;
    $ins->stock = $cantc;
    $ins->save();
    }

    //Update Stock ProductosPreelaborados
    if($miproduction2->type=="elaborado"){
        $prodpre = ProductosSemiElaborado::find($miproduction2->insumo_id);
        $ca= $prodpre->stock;
        $cb= $miproduction2->cantidad;
        $cc= $ca-$cb;
        $prodpre->stock=$cc;
        $prodpre->save();
    }




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

        //Update Stock Insumo
        $miinsumo= Insumo::find($miproduction2->insumo_id);

        $cant_a = $miinsumo->stock;
        $cant_b = $miproduction2->cantidad;
        $cant_c = $cant_a - $cant_b;
        $miinsumo->stock = $cant_c;
        $miinsumo->save();



    return true;
});

//PRODUCTIOS PARA PRODUCCION
Route::get('pos/productos/production', function () {
    return  Producto::where('production', true)->get();
});


// MOVIL
// TODOS LOS PRODUCTOS
Route::get('movil/productos', function () {
    return  Producto::with('categoria')->get();
});
