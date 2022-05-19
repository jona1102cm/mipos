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
use App\Pensionado;
use App\ProductosSemiElaborado;
use App\ProductionSemi;
use App\Production;
use App\ProductionInsumo;
use App\Proveedore;
use App\DetalleProductionSemi;
use App\TypeProducto;
use App\Banipay;
use App\Compra;
use App\Location;
use App\Credito;
use App\Notificacione;
use App\Laboratorio;
use App\Presentacione;
use App\Marca;
use App\ComprasProducto;
use App\Dosificacione;

use Illuminate\Support\Facades\DB;
use App\Micodigo\CodigoControlV7;
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
// require_once('librerias/CodigoControlV7.php');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// TODAS LOS USER
Route::get('pos/users', function () {
    // $pricesClass = new codigo_control();
    // return $pricesClass;
    return  User::all();

});

Route::get('pos/info', function () {
    return  DB::table('settings')->where('group', 'Empresa')->get();
});


// FRONEND
Route::get('pedido/save/{midata}', function ($midata) {
    $midata2 = json_decode($midata);
    $ticket = count(Venta::where('sucursal_id', 1)->where('caja_status', false)->get());
    $newventa = Venta::create([
        'cliente_id' => $midata2->cliente_id,
        'cupon_id' => $midata2->cupon_id,
        'option_id' => $midata2->option_id,
        'pago_id' => $midata2->pago_id,
        'factura' => 'Recibo',
        'credito'=> $midata2->credito,
        'total' => $midata2->total,
        'descuento' => $midata2->descuento,
        'observacion' => $midata2->observacion,
        'register_id' => $midata2->register_id,
        'status_id' => 1,
        'caja_id' => setting('ventas.caja_aux_suc_principal'),
        'delivery_id' => $midata2->delivery_id,
        'sucursal_id' => 1,
        'subtotal' => $midata2->subtotal,
        'caja_status' => false,
        'ticket' => $ticket + 1,
        'cantidad' => 0,
        'recibido' => 0,
        'cambio' => 0,
        'chofer_id'=> setting('ventas.chofer'),
        'adicional'=> 0,
        'location' => $midata2->location,
        'pensionado_id'=> $midata2->pensionado_id,
        'status_credito'=> 0
    ]);
    return $newventa;
});

Route::get('pedido/products/save/{midata}', function($midata) {
    $midata2 = json_decode($midata);
    $miproducto = Producto::find($midata2->producto_id);
    DetalleVenta::create([
        'producto_id' => $midata2->producto_id,
        'venta_id' => $midata2->venta_id,
        'precio' => $midata2->precio,
        'cantidad' => $midata2->cantidad,
        'total' => $midata2->precio*$midata2->cantidad,
        'foto' =>  $miproducto->image ? $miproducto->image : null,
        'name' => $midata2->name,
        'description' => $midata2->description,
        'extra_name'=> $midata2->extra_name,
        'observacion'=> $midata2->observacion
    ]);
    return true;
});

Route::get('cliente/{midata}', function ($midata) {
    $midata2 = json_decode($midata);
    $cliente = Cliente::where('phone', $midata2->telefono)->first();
    if ($cliente) {
        return $cliente;
    } else {
        $newcliente = Cliente::create([
        'phone' => $midata2->telefono,
        'email' => $midata2->nombres.'.'.$midata2->apellidos.'@loginweb.dev',
        'display' => $midata2->nombres.' '.$midata2->apellidos,
        'ci_nit'=> $midata2->ci_nit,
        'first_name'=> $midata2->nombres,
        'last_name'=> $midata2->apellidos
        ]);
        return $newcliente;
    }
});

Route::get('location/{midata}', function ($midata) {
    $midata2 = json_decode($midata);
    $location = Location::where('cliente_id', $midata2->cliente_id)->where('descripcion', $midata2->direccion)->first();
    if ($location) {
        return $location;
    } else {
        $newlocation = Location::create([
            'cliente_id' => $midata2->cliente_id,
            'latitud' => $midata2->latitud,
            'longitud' => $midata2->longitud,
            'descripcion' => $midata2->direccion,
            'default' => 0
            ]);
        return $newlocation;
    }
});

Route::get('consulta/{phone}', function ($phone) {
    $cliente = Cliente::where('phone', $phone)->first();
    if ($cliente) {
        return $cliente;
    } else {
        return  response()->json(array('message' => 'Cliente NO Registrado' ));
    }
});

Route::get('pedidos/cliente/{id}', function ($id) {
    $midata = Venta::where('cliente_id', $id)->where('caja_status', false)->with('pasarela', 'estado', 'delivery', 'cupon')->orderBy('created_at', 'desc')->get();
    return $midata;
});

Route::get('pedido/detalle/{id}', function ($id) {
    $midata = DetalleVenta::where('venta_id', $id)->orderBy('created_at', 'desc')->get();
    return $midata;
});

Route::get('option/{id}', function ($id) {
    $midata = Option::find($id);
    return $midata;
});

Route::get('search/{criterio}', function ($criterio) {
    $result = Producto::where('name', 'like', '%'.$criterio.'%')->where('title', 'like', '%'.$criterio.'%')->orderBy('name', 'desc')->get();
    return $result;
});

Route::get('filtros/{categoria_id}', function ($categoria_id) {
    $result = Producto::where('categoria_id', $categoria_id )->orderBy('name', 'desc')->get();
    return $result;
});

Route::get('cupon/{codigo}', function ($codigo) {
    $result = Cupone::where('codigo', $codigo)->first();
    return $result;
});

//notificaiones
Route::get('notificaciones', function () {
    $result = Notificacione::all();
    return $result;
});
Route::get('notificacione/save/{message}', function ($message) {
    // $midata2 = json_decode($message);
    $minoti = Notificacione::create([
        'message' => $message,
    ]);
    return $minoti;
});

//banipay
Route::get('banipay/{venta_id}', function ($venta_id) {
    $result = Banipay::where('venta_id', $venta_id)->first();
    return $result;
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
        'venta_banipay'=> $midata2->venta_banipay,
		'cantidad_efectivo'=> $midata2->cantidad_efectivo,
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
    $ventas = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pensionado_id',0)->get();
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
    $venta_efectivo = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pensionado_id',0)->where('pago_id',1)->get();
    $cantidad_efectivo = count($venta_efectivo);
    $total_efectivo = 0;
    foreach ($venta_efectivo as $item) {
        $total_efectivo = $total_efectivo + $item->total;
    }

    $venta_banipay = Venta::where('caja_id', $midata2->caja_id)->where('register_id', $midata2->editor_id)->where('caja_status', false)->where('credito',"Contado")->where('pensionado_id',0)->where('pago_id',2)->get();
    $cantidad_banipay = count($venta_banipay);
    $total_banipay = 0;
    foreach ($venta_banipay as $item) {
        $total_banipay = $total_banipay + $item->total;
    }
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
        'credito'=> $midata2->credito ? $midata2->credito : null,
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
        'adicional'=>$midata2->adicional,
        'location' => 1,
        'pensionado_id'=>$midata2->pensionado_id,
        'status_credito'=>$midata2->status_credito,
        'codido_control'=>null,
        'nro_factura'=>$midata2->nro_factura
    ]);

    if($midata2->factura=="Factura"){

        $newventa=Venta::find($venta->id);

        $dosificacion=Dosificacione::where('activa',1)->first();
        $cliente= Cliente::find($midata2->cliente_id);
        $fecha=date('Ymd', strtotime($venta->created_at));
        $numero_autorizacion = $dosificacion->nro_autorizacion;
        $numero_factura = $venta->nro_factura;
        $nit_cliente =$cliente->ci_nit;
        $fecha_compra = $fecha;
        $monto_compra = round($venta->total);
        $clave = $dosificacion->llave_dosificacion;

        $coco = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);


        $venta->codigo_control=$coco;
        $venta->save();
    }

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
    // $clientes = Cliente::where('display', 'like', '%'.$criterio.'%')->where('ci_nit','like','%'.$criterio.'%')->orderBy('display', 'desc')->get();
    $clientes = Cliente::where('display', 'like', '%'.$criterio.'%')->get();

    return $clientes;
});

//Busqueda Cliente CI
Route::get('pos/clientes/search_ci/{criterio}', function ($criterio) {
    // $clientes = Cliente::where('display', 'like', '%'.$criterio.'%')->where('ci_nit','like','%'.$criterio.'%')->orderBy('display', 'desc')->get();
    $clientes = Cliente::where('ci_nit', 'like', '%'.$criterio.'%')->get();

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
    $ventas= Venta::where('chofer_id', $chofer_id)->where('caja_id', $caja_id)->where('caja_status', false)->with('cliente')->with('delivery')->with('pasarela')->get();
    return $ventas;
});

//Ventas Creditos Clientes
Route::get('pos/ventas-creditos/{cliente_id}/{sucursal_id}', function($cliente_id, $sucursal_id){
    $ventas= Venta::where('cliente_id', $cliente_id)->where('sucursal_id', $sucursal_id)->where('credito',"Credito")->with('cliente')->with('pasarela')->get();
    return $ventas;
});

//Credito por Venta
Route::get('pos/creditos/cliente/{id}', function ($id) {
    return  Credito::where('venta_id',$id)->with('cliente')->get();
});

//Cobrar Credito
Route::get('pos/cobrar-credito/{midata}', function($midata) {
    $midata2 = json_decode($midata);

    $credito = Credito::create([
        'venta_id' => $midata2->venta_id,
        'cliente_id' => $midata2->cliente_id,
        'deuda' => $midata2->deuda,
        'cuota' => $midata2->cuota,
        'restante' => $midata2->restante,
        'status'=>$midata2->status
    ]);
    return true;
});

//Pensionados por Sucursal
// Route::get('pos/pensionados/kardex/{sucursal_id}/{cliente_id}', function($sucursal_id, $cliente_id){
//     $pensionado= Pensionado::where('sucursal_id', $sucursal_id)->where('cliente_id', $cliente_id)->where('status',1)->with('cliente')->get();
//     return $pensionado;
// });
Route::get('pos/pensionados/kardex/{sucursal_id}/{cliente_id}', function($sucursal_id, $pensionado_id){
    $pensionado= Venta::where('sucursal_id', $sucursal_id)->where('pensionado_id', $pensionado_id)->with('cliente')->with('pensionado')->get();
    return $pensionado;
});

//Cliente Por Pensionado_ID
Route::get('pos/cliente/pensionado/{id}', function ($id) {
    return  Pensionado::where('id',$id)->with('cliente')->get();
});

// TODOS LOS PRODUCTOS
Route::get('pos/productos', function () {
    return  Producto::all();
});

// SEARCH PRODUCTO
Route::get('pos/producto/search/{midata}', function ($midata) {
    return  Producto::where('name', 'like', '%'.$midata.'%')->with('categoria')->get();
});

// UN PRODUCT
Route::get('pos/producto/{id}', function ($id) {
    return  Producto::where('id', $id)->with('categoria')->first();
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

//Categoria por ID
Route::get('pos/category/{id}', function ($id) {
    return  Categoria::find($id);
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

//-- Un Type producto
Route::get('pos/typeproduct/{id}', function ($id) {
    return TypeProducto::find($id);
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

// TODAS LAS VENTAS POR CAJA DE TODOS
Route::get('pos/ventas/cajas/todas/{caja_id}', function ($caja_id) {
    return  Venta::where('caja_id', $caja_id)->where('caja_status', false)->with('cliente', 'delivery','chofer', 'pasarela')->orderBy('created_at','desc')->get();
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

// TODAS LAS OPCIONES PARA BACKEND
Route::get('pos/options', function () {
    return  Option::where('view','backend')->get();
});

// TODAS LOS PAGOS PARA BACKEND
Route::get('pos/pagos', function () {
    return  Pago::where('view','backend')->get();
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

//Actualizar Status Credito en la venta
Route::get('pos/status_credito/actualizar/{venta_id}', function ($id) {

    $venta = Venta::find($id);
    $venta->status_credito = 0;
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

//PENSIONADOS ACTIVOS
Route::get('pos/pensionados', function(){
    $pensionados = Pensionado::where('status', 1)->with('cliente')->get();
    // $clientes= Cliente::find($pensionados->cliente_id);
    return $pensionados;
});

//PENSIONADO ACTIVO
Route::get('pos/pensionado/cliente/{id}', function($id){
    $pensionado = Pensionado::where('cliente_id',$id)->where('status', 1)->first();
    // $clientes= Cliente::find($pensionados->cliente_id);
    return $pensionado;
});

//ACTUALIZAR PENSIONADOS
Route::get('pos/pensionados/actualizar/{pensionado_id}', function($pensionado_id){
    $pensionado = Pensionado::find($pensionado_id);
    $pensionado->status = 0;
    $pensionado->save();
    return true;
});

// PRODUCTION
Route::get('pos/productions/save/{midataProduction}', function($midataProduction) {
    $midataProduction = json_decode($midataProduction);
    if(setting('ventas.stock')){
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
    }
    else{
        $production = Production::create([
            'producto_id' => $midataProduction->producto_id,
            'cantidad' => $midataProduction->cantidad,
            'valor' => $midataProduction->valor,
            'description' => $midataProduction->description,
            'user_id' => $midataProduction->user_id
        ]);
    }
    return $production->id;
});

Route::get('pos/productions/save/detalle/{miproduction}', function($miproduction) {
    $miproduction2 = json_decode($miproduction);
    if(setting('ventas.stock')){
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
    }
    else{
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
    }
    return true;
});


// PRODUCTION SEMI
Route::get('pos/productions/savesemi/{midataProduction}', function($midataProduction) {

    $midataProduction = json_decode($midataProduction);
    if(setting('ventas.stock')){
        $production = ProductionSemi::create([
            'producto_semi_id' => $midataProduction->producto_semi_id,
            'cantidad' => $midataProduction->cantidad,
            'valor' => $midataProduction->valor,
            'description' => $midataProduction->description,
            'user_id' => $midataProduction->user_id
        ]);
        //Update Stock Producto Semielaborado
        $mipropre= ProductosSemiElaborado::find($midataProduction->producto_semi_id);
        $a= $mipropre->stock;
        $b= $midataProduction->cantidad;
        $c= $a+$b;
        $mipropre->stock= $c;
        $mipropre->save();
    }
    else{
        $production = ProductionSemi::create([
            'producto_semi_id' => $midataProduction->producto_semi_id,
            'cantidad' => $midataProduction->cantidad,
            'valor' => $midataProduction->valor,
            'description' => $midataProduction->description,
            'user_id' => $midataProduction->user_id
        ]);
    }
    return $production->id;

});

Route::get('pos/productions/savesemi/detalle/{miproduction}', function($miproduction) {
    $miproduction2 = json_decode($miproduction);
    if(setting('ventas.stock')){
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
    }
    else{
        DetalleProductionSemi::create([
            'production_semi_id'=>$miproduction2->production_semi_id,
            'insumo_id' => $miproduction2->insumo_id,
            'proveedor_id'=> $miproduction2->proveedor_id,
            'precio' => $miproduction2->precio,
            'cantidad' => $miproduction2->cantidad,
            'total' => $miproduction2->total
        ]);
    }
    return true;
});

//Guardar Producto Comprado
Route::get('pos/addproducto/{midata}', function($midata){
    $midata2 = json_decode($midata);

    $producto=Producto::create([
        'name'=>$midata2->name,
        'categoria_id'=>$midata2->categoria_id ? $midata2->categoria_id: null,
        'description'=>$midata2->description_producto ? $midata2->description_producto:null,
        'image'=>$midata2->image ? $midata2->image: null,
        'precio'=>$midata2->precio_venta,
        'stock'=>$midata2->cantidad,
        'production'=>$midata2->production ? $midata2->production:null,
        'description_long'=>$midata2->description_long ? $midata2->description_long:null,
        'precio_compra'=>$midata2->costo,
        'images'=>$midata2->images ? $midata2->images:null,
        'vencimiento'=>$midata2->vencimiento ? $midata2->vencimiento : null,
        'mixta'=>$midata2->mixta ? $midata2->mixta :null,
        'type_producto_id'=>$midata2->type_producto_id ? $midata2->type_producto_id :null,
        'extra'=>$midata2->extra ? $midata2->extra:null,
        'extras'=>$midata2->extras ? $midata2->extras:null,
        'ecommerce'=>$midata2->ecommerce ? $midata2->ecommerce : null,
        'presentacion_id'=>$midata2->presentacion_id ? $midata2->presentacion_id:null,
        'marca_id'=>$midata2->marca_id ? $midata2->marca_id:null,
        'laboratorio_id'=>$midata2->laboratorio_id ? $midata2->laboratorio_id:null,
        //'status'=>1

    ]);

    return $producto;
});

//Guardar Compras de Productos
Route::get('pos/compras-productos/save/{midata}/{producto_id}', function($midata, $producto_id){
    $midata2= json_decode($midata);

    $compra= ComprasProducto::create([
        'title'=>$midata2->title ? $midata2->title:null ,
        'description'=>$midata2->description ? $midata2->description:null,
        'editor_id'=>$midata2->editor_id,
        'cantidad'=>$midata2->cantidad,
        'costo'=>$midata2->costo,
        'proveedor_id'=>$midata2->proveedor_id ? $midata2->proveedor_id:null ,
        'producto_id'=>$producto_id,
        'total'=>$midata2->total,
        'fecha_vencimiento'=>$midata2->vencimiento ? $midata2->vencimiento : null,
        'presentacion_id'=>$midata2->presentacion_id ? $midata2->presentacion_id:null,
        'laboratorio_id'=>$midata2->laboratorio_id ? $midata2->laboratorio_id:null,
        'marca_id'=>$midata2->marca_id ? $midata2->marca_id:null
    ]);

    return $compra;
});

//Actualizar Status Producto
Route::get('pos/producto-update/{producto_id}',function($producto_id){
    $producto= Producto::find($producto_id);
    $producto->delete();
    return true;
});

//Laboratorios para Productos
Route::get('pos/laboratorios', function () {
    return Laboratorio::all();
});

//Presentaciones para Productos
Route::get('pos/presentaciones', function () {
    return Presentacione::all();
});

//Presentaciones por ID
Route::get('pos/presentacion/{id}', function ($id) {
    return Presentacione::find($id);
});

//Marcas para Productos
Route::get('pos/marcas', function () {
    return Marca::all();
});

//PRODUCTIOS PARA PRODUCCION
Route::get('pos/productos/production', function () {
    return  Producto::where('production', true)->with('categoria')->get();
});

// MOVIL
// TODOS LOS PRODUCTOS
Route::get('movil/productos', function () {
    return  Producto::with('categoria')->get();
});

//Convertir Recibo a Factura
Route::get('pos/convertir_a_factura/{data}',function($data){
    $midata= json_decode($data);
    $dosificacion=Dosificacione::where('activa',1)->first();
    $cliente= Cliente::find($midata->cliente_id);


    $fecha=date('Ymd', strtotime($midata->fecha_compra));


    $numero_autorizacion = $dosificacion->nro_autorizacion;
    $numero_factura = $midata->numero_factura;
    $nit_cliente = $cliente->ci_nit;
    $fecha_compra = $fecha;
    $monto_compra = round($midata->monto_compra);
    $clave = $dosificacion->llave_dosificacion;
    $coco = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);

    $venta=Venta::find($midata->id);
    $venta->factura="Factura";
    $venta->nro_factura=$midata->numero_factura;
    $venta->codigo_control=$coco;
    $venta->cliente_id=$cliente->id;
    $venta->save();
});

// public function get_codigo_control(){
//     return "Hola";
// }

//Update y Get Número de Factura
Route::get('pos/nro_factura',function(){
    $dosificacion=Dosificacione::where('activa',1)->first();
    $nro_factura=($dosificacion->numero_actual)+1;
    $dosificacion->numero_actual=$nro_factura;
    $dosificacion->save();
    return $nro_factura;
});


//Update cliente
Route::get('pos/update_datos_cliente/{data}',function($data){
    $midata=json_decode($data);

    $cliente=Cliente::find($midata->id);
    $cliente->first_name=$midata->first_name;
    $cliente->last_name=$midata->last_name;
    $cliente->ci_nit=$midata->ci_nit;
    $cliente->display=$midata->first_name." ".$midata->last_name;
    $cliente->save();

    return $cliente;
});
