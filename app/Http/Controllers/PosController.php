<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Venta;
use App\DetalleVenta;
use App\Option;

use App\Imports\UsersImport;
use App\Imports\ClienteImport;
use App\Imports\ProductsImport;
use App\Imports\VentaImport;

use Maatwebsite\Excel\Facades\Excel;

use App\User;
use App\Cliente;
use App\Sucursale;


use NumerosEnLetras;

class PosController extends Controller
{

    // PARA IMPRIMIR RECIBO
	public function imprimir($id){

        $ventas = Venta::find($id);
        $detalle_ventas = DetalleVenta::where('venta_id',$id)->get();
        $cliente = Cliente::find($ventas->cliente_id);
        $sucursal=Sucursale::find($ventas->sucursal_id);
        $option=Option::find($ventas->option_id);
        $literal = NumerosEnLetras::convertir($ventas->total,'Bolivianos',true);

        $vista = view('ventas.recibo', compact('ventas' ,'detalle_ventas', 'cliente','sucursal','option', 'literal'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal');
        return $pdf->stream();
    }



    public function import_users(){
        Excel::import(new UsersImport, 'users.xlsx');
        return redirect('/admin/users')->with('success', 'All good!');

    }
    public function import_clientes(){
        Excel::import(new ClienteImport, 'clientes.xlsx');
        return redirect('/admin/clientes')->with('success', 'All good!');
    }
    public function producto_detalle(){
        $vista = view('productos.detalle');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal');
        return $pdf->stream();
    }
    public function import_products(){
        Excel::import(new ProductsImport, 'products.xlsx');
        return redirect('/admin/productos')->with('success', 'All good!');
    }
    public function import_ventas(){
        Excel::import(new VentaImport, 'ventas.xlsx');
        return redirect('/admin/ventas')->with('success', 'All good!');

    }

}