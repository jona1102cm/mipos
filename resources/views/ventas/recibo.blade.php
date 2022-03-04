
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> -->
        <title>Recibo de venta</title>
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
        <!-- <div style="text-align:right" id="print">
            <button onclick="javascript:window.print()" class="btn-print">Imprimir</button>
        </div> -->

        <table width="300px">
            <tr>
               
                <td colspan="2" align="center" style="font-size:10px">
                    
                  
                    <img src="{{ url('storage').'/'.setting('empresa.logo') }}" alt="loginweb" width="100px"><br>
                   
                    <b>De: {{ setting('empresa.propietario') }}</b><br>
                    <b>{{ strtoupper($sucursal->name) }}</b><br>
                    <b>{{ setting('empresa.direccion') }}<b><br>
                    <b>Cel: {{ setting('empresa.celular') }}</b><br>
                    <b>{{ setting('empresa.ciudad') }}</b>
                </td>
            </tr>
            <tr>
                <!-- consulta para saber si es factura o recibo -->
                <td colspan="2" align="center">
                    <h2>TICKET # {{ $ventas->ticket }}</h2>
                    @if($ventas->option_id==1)
                    <span class="badge">MESA</span>
                    @endif
                    @if($ventas->option_id==2)
                    <span class="badge">PARA LLEVAR</span>
                    @endif
                    @if($ventas->option_id==3)
                    <span class="badge">PEDIDO</span>
                    @endif
                    @if($ventas->option_id==4)
                    <span class="badge">A DOMICILIO</span>
                    @endif
                    <!-- <span class="badge">{{ strtoupper($ventas->option_id) }}</span> -->
                    <hr>
                </td>
            </tr>
            {{-- datos de la factura --}}

            {{-- datos de la venta --}}
            <tr>
                <td><b>Razón social</b></td>
                <td>: {{$cliente->display}}</td>
            </tr>
            <tr>
                <td><b>NIT/CI</b></td>
                <td>: {{$cliente->ci_nit}}</td>
            </tr>
            <tr>
                <td><b>Fecha</b></td>
                @php
                    setlocale(LC_TIME,"es_ES");
                @endphp
                <td>: {{ strftime("%A, %d de %B de %Y",  strtotime($ventas->created_at)) }}</td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>

            <tr>
               
                <td colspan="2">
                    <table width="100%">
                        <tr>
                           
                           <th>DETALLE</th>
                           <th align="right">IMPORTE</th>
                        </tr>
                    
                        @foreach ($detalle_ventas as $item)
                        @php
                            $miproduct = App\Producto::find($item->producto_id);
                        @endphp
                        <tr>
                            <td align="center"><b>{{ $item->cantidad }}</b></td>
                            <td align="center"><b>{{ $miproduct->name }}</b></td>
                            <td align="center"><b>{{ $item->precio }}</b></td>
                            

                        </tr>
                        @endforeach
                        <br>

                        <tr>
                            <td colspan="2" align="right"><b>SUB TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->subtotal, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><b>DESCUENTO Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->descuento, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><b>TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->total, 2, ',', '.')}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
         
            <tr>
                <td colspan="2">Son {{ $ventas->total }}</td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2"><h3>Gracias por su preferencia, vuelva pronto.</h3> </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2"><b>Atendido por : </b> {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td colspan="2"><b>Hora : {{ date('H:i:s') }}</b></td>
            </tr>

        </table>

        <div class="saltopagina"></div>

        <table width="300px">

            <tr>
                {{-- consulta para saber si es factura o recibo --}}
                <td colspan="2" align="center">
                    <h3>
                        ORDEN #{{$ventas->ticket}}<br>
                        {{date('d/m/Y H:i:s')}}<br>
                        @if($ventas->option_id==1)
                        <span class="badge">MESA</span>
                        @endif
                        @if($ventas->option_id==2)
                        <span class="badge">PARA LLEVAR</span>
                        @endif
                        @if($ventas->option_id==3)
                        <span class="badge">PEDIDO</span>s
                        @endif
                        @if($ventas->option_id==4)
                        <span class="badge">A DOMICILIO</span>
                        @endif
                    </h3><hr>
                </td>
            </tr>

            <tr>
                {{-- detalle de la venta --}}
                <td colspan="2">
                    <table width="100%">
                        <tr>
                           <th>CANTIDAD</th>
                           <th>DETALLE</th>
                           <th>PRECIO UNIT.</th>
                           <th align="right">TOTAL UNIT.</th>

                        </tr>

                        @foreach ($detalle_ventas as $item)
                            @php
                                $miproduct = App\Producto::find($item->producto_id);
                                $totalunit=($item->cantidad)*($item->precio);
                            @endphp
                            <tr>
                                <td align="center"><b>{{ $item->cantidad }}</b></td>
                                <td align="center"><b>{{ $miproduct->name }}</b></td>
                                <td align="center"><b>{{ $item->precio }}</b></td>
                                <td align="center"><b>{{ $totalunit }}</b></td>
                                

                            </tr>
                        @endforeach
                      
                        <br>
                        <tr>
                            <td colspan="3" align="right"><b>SUB TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->subtotal, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>DESCUENTO Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->descuento, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->total, 2, ',', '.')}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2"><h3>Cliente: {{$cliente->display}}.</h3> </td>
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