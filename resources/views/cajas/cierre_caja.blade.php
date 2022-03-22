
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> --}}
        <title>Reporte Cierre Caja</title>
        <style>
            .btn-print{
                background-color: #fa2a00;
                color:white;
                border: 1px solid #fa2a00;
                padding: 5px 8px;
                border-radius:5px
            }
            @media print {
                #print{
                    display: none;
                }
            }
            body{
                font-size: 11px;
                font-family: 'Noto Sans', sans-serif;
                /* border: 1px solid black;
                border-radius: 1px; */
                padding: 5px 10px;
                margin: 0px
            }

			@media all {
			   div.saltopagina{
			      display: none;
			   }
			}

			@media print{
			   div.saltopagina{
			      display:block;
			      page-break-before:always;
			   }
			}
            .badge{
                padding:2px 20px;
                background-color:black;
                color:white;
                font-size: 12px;
                font-weight:bold;
            }
		</style>
    </head>
    <body>
        {{-- <div style="text-align:right" id="print">
            <button onclick="javascript:window.print()" class="btn-print">Imprimir</button>
        </div> --}}

        @php
            $ingreso_efectivo=0;
            $ingreso_linea=0;
            $egreso_efectivo=0;
            $egreso_linea=0;
        @endphp
        @foreach($asiento as $item)
            @if($item->pago==true && $item->type=="Ingresos")
                @php
                    $ingreso_efectivo+=$item->monto;
                @endphp
            @endif
            @if($item->pago==false && $item->type=="Ingresos")
                @php
                    $ingreso_linea+=$item->monto;
                @endphp
            @endif
            @if($item->pago==true && $item->type=="Egresos")
                @php
                    $egreso_efectivo+=$item->monto;
                @endphp
            @endif
            @if($item->pago==false && $item->type=="Egresos")
                @php
                    $egreso_linea+=$item->monto;
                @endphp
            @endif
        @endforeach
     

        <table width="300px">
            
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            
                                <th align="center" style="font-size:18px">CIERRE CAJA # {{ $detalle_caja->id }}</th>
                           
                        </tr>
                        <tr>
                            <th></th>
                            <th align="center">{{$caja->title}} - {{$sucursal->name}}</th>
                            <th></th>
                        </tr> <br>
                        <tr>
                            <td>
                                Nº Venta Inicial: {{$detalle_caja->venta_inicio}}
                            </td>
                            <td>
                                Nº Venta Final: {{$detalle_caja->venta_final}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Fecha Apertura</b></td>
                            <td>: {{$detalle_caja->created_at}}</td>
                        </tr>
                        <tr>
                            <td><b>Fecha Cierre</b></td>
                            <td>: {{$detalle_caja->fecha_cierre}}</td>
                        </tr>

                    </table>
                </td>
            </tr>
        
            
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th></th>
                            <th align="center" style="font-size:15px">INGRESOS</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Cantidad</th>
                            <th>Detalle</th>
                            <th></th>
                            <th align="right">Total</th><br>

                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_efectivo}}</th>
                            <th>Ventas en Efectivo</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_efectivo}}</th>
                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_tarjeta}}</th>
                            <th>Ventas con Tarjeta</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_tarjeta}}</th>
                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_transferencia}}</th>
                            <th>Ventas por Transferencia</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_transferencia}}</th>
                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_qr}}</th>
                            <th>Ventas por QR</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_qr}}</th>
                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_tigomoney}}</th>
                            <th>Ventas por TigoMoney</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_tigomoney}}</th>
                        </tr><br><br>
                        <tr>
                            <td colspan="3" align="right"><b>TOTAL EFECTIVO Bs.</b></td>
                            <td align="right"><b>{{$detalle_caja->venta_efectivo}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>INGRESOS EFECTIVO Bs.</b></td>
                            <td align="right"><b>{{$ingreso_efectivo}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>INGRESOS EN LÍNEA Bs.</b></td>
                            <td align="right"><b>{{$ingreso_linea}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b></b></td>
                            <td align="right"><b><hr></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>TOTAL INGRESOS Bs.</b></td>
                            <td align="right"><b>{{$detalle_caja->venta_efectivo+$ingreso_efectivo+$ingreso_linea}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th></th>
                            <th align="center" style="font-size:15px">EGRESOS</th>
                            <th></th>
                        </tr>
                        
                        <tr>
                            <th></th>
                            <th>
                                EGRESOS EN EFECTIVO: 
                            </th>
                            <th> {{$egreso_efectivo}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>
                                EGRESO EN LÍNEA
                            </th>
                            <th>{{$egreso_linea}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th><hr></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>TOTAL EGRESOS</th>
                            <th>{{$detalle_caja->egresos}}</th>
                        </tr>
                    </table>

                </td>

            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th style="font-size:15px" align="left">DETALLE EFECTIVO</th>
                        </tr><br>
                        <tr>
                            <th>VENTAS EN EFECTIVO</th>
                            <th>{{$detalle_caja->venta_efectivo}}</th>
                        </tr>
                        <tr>
                            <th>INGRESOS EN EFECTIVO</th>
                            <th>{{$ingreso_efectivo}}</th>
                        </tr>
                        <tr>
                            <th>EGRESOS EN EFECTIVO</th>
                            <th>{{$egreso_efectivo}}</th>
                        </tr><br>
                        <tr>
                            <th>TOTAL ENTREGADO</th>
                            <th>{{$detalle_caja->efectivo_entregado}}</th>
                        </tr>
                        <tr>
                            <th>TOTAL EN SISTEMA</th>
                            <th>{{$detalle_caja->venta_efectivo+$ingreso_efectivo-$egreso_efectivo}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><hr></th>
                        </tr>
                        <tr>
                            <th>DIFERENCIA</th>
                            <th>{{$detalle_caja->efectivo_entregado-($detalle_caja->venta_efectivo+$ingreso_efectivo-$egreso_efectivo)}}</th>
                        </tr>

                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th style="font-size:15px" align="left">DETALLE EN LÍNEA</th>
                        </tr><br>
                        <tr>
                            <th>VENTAS CON TARJETA</th>
                            <th>{{$detalle_caja->venta_tarjeta}}</th>
                        </tr>
                        <tr>
                            <th>VENTAS POR TRANSFERENCIA</th>
                            <th>{{$detalle_caja->venta_transferencia}}</th>
                        </tr>
                        <tr>
                            <th>VENTAS POR QR</th>
                            <th>{{$detalle_caja->venta_qr}}</th>
                        </tr>
                        <tr>
                            <th>VENTAS POR TIGOMONEY</th>
                            <th>{{$detalle_caja->venta_tigomoney}}</th>
                        </tr>
                        <tr>
                            <th>INGRESOS EN LÍNEA</th>
                            <th>{{$ingreso_linea}}</th>
                        </tr>
                        <tr>
                            <th>EGRESOS EN LÍNEA</th>
                            <th>{{$egreso_linea}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><hr></th>
                        </tr>
                        <tr>
                            <th>TOTAL EN LÍNEA</th>
                            <th>{{$detalle_caja->venta_tarjeta+$detalle_caja->venta_transferencia+$detalle_caja->venta_qr+$detalle_caja->venta_tigomoney+$ingreso_linea-$egreso_linea}}</th>
                        </tr>

                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th>
                                {{setting('empresa.mensaje_caja')}}
                            </th>
                        </tr>

                    </table>

                </td>
            </tr>

            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th>CANTIDAD</th>
                            <th>DETALLE</th>
                            <th>PRECIO UNIT.</th>
                            <th align="right">TOTAL UNIT.</th>
 
                         </tr>
 
                        
                             <tr>
                                 <td align="center"><b></b></td>
                                 <td align="center"><b></b></td>
                                 <td align="center"><b></b></td>
                                 <td align="center"><b></b></td>
                                 
 
                             </tr>
                        
                        <br>
                        <tr>
                            <td colspan="3" align="right"><b>SUB TOTAL Bs.</b></td>
                            <td align="right"><b></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>DESCUENTO Bs.</b></td>
                            <td align="right"><b></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>TOTAL Bs.</b></td>
                            <td align="right"><b></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td colspan="2"><hr></td>
            </tr> <br>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
           
            <tr>
                <td colspan="2"><b>Hora : {{ date('H:i:s') }}</b></td>
            </tr>
        </table>
        
        <script>
            window.print();
            setTimeout(function(){
                window.close();
            }, 10000);
        </script>
    </body>
</html>