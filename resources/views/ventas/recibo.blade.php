
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
        <title>Recibo de venta</title>


    </head>
    <body style="font-size: 20px; margin: 0px; padding: 5px 10px;">
        {{-- <div style="text-align:right" id="print">
            <button onclick="javascript:window.print()" class="btn-print">Imprimir</button>
        </div> --}}
        <table>
            <tr>
                <td colspan="2" align="center">
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
                     <span class="badge">{{ strtoupper($option->title) }}</span>
                    <hr>
                </td>
            </tr>
            <tr>
                <td><b>Razón social</b></td>
                <td>: <strong>{{$cliente->display}}</strong></td>
            </tr>
            <tr>
                <td><b>NIT/CI</b></td>
                <td>:<b> {{$cliente->ci_nit}}</b></td>
            </tr>
            <tr>
                <td><b>Fecha</b></td>
                @php
                    setlocale(LC_TIME,"es_ES");
                @endphp
                <td>: <strong>{{ strftime("%A, %d de %B de %Y",  strtotime($ventas->created_at)) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td><strong>DETALLE</strong></td>
                            <td><strong>EXTRAS</strong></td>
                            <td><strong>OBSERVAC</strong></td>
                            <td><strong>PRECIO UNIT.</strong></td>
                            <td><strong>TOTAL UNIT.</strong></td>
                         </tr>
                         @foreach ($detalle_ventas as $item)
                             @php
                                 $miproduct = App\Producto::find($item->producto_id);
                                 $totalunit=($item->cantidad)*($item->precio);
                             @endphp
                             <tr>
                                 <td><b>{{ $item->cantidad }} {{ $miproduct->name }} {{$item->description}}</b></td>
                                 <td><b>{{$item->extra_name}}</b></td>
                                 <td><b>{{ $item->observacion }}</b></td>
                                 <td><b>{{ $item->precio }}</b></td>
                                 <td><b>{{ $totalunit }}</b></td>
                             </tr>
                         @endforeach
                         <tr>
                             <td colspan="6">
                                 <hr>
                             </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>SUB TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->subtotal, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>ADICIONAL Bs.</b></td>
                            <td align="right"><b>{{number_format($ventas->adicional, 2, ',', '.')}}</b></td>
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
                <td colspan="2">Son: {{ $literal }}</td>
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
        <div class="saltopagina" style="display:block; page-break-before:always;"></div>
        @if(setting('ventas.cocina'))
            <table>
                <tr>
                    <td colspan="2" align="center">
                        <h3>
                            ORDEN #{{$ventas->ticket}}<br>
                            {{date('d/m/Y H:i:s')}}<br>
                            <span class="badge">{{ strtoupper($option->title) }}</span>
                        </h3><hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td><strong>DETALLE</strong></td>
                                <td><strong>EXTRAS</strong></td>
                                <td><strong>OBSERVAC</strong></td>
                                <td><strong>PRECIO UNIT.</strong></td>
                                <td><strong>TOTAL UNIT.</strong></td>
                            </tr>
                            @foreach ($detalle_ventas as $item)
                                @php
                                    $miproduct = App\Producto::find($item->producto_id);
                                    $totalunit=($item->cantidad)*($item->precio);
                                @endphp
                                <tr>
                                    <td><b>{{ $item->cantidad }} {{ $miproduct->name }} {{$item->description}}</b></td>
                                    <td><b>{{$item->extra_name}}</b></td>
                                    <td><b>{{ $item->observacion }}</b></td>
                                    <td><b>{{ $item->precio }}</b></td>
                                    <td><b>{{ $totalunit }}</b></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" align="right"><b>SUB TOTAL Bs.</b></td>
                                <td align="right"><b>{{number_format($ventas->subtotal, 2, ',', '.')}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right"><b>ADICIONAL Bs.</b></td>
                                <td align="right"><b>{{number_format($ventas->adicional, 2, ',', '.')}}</b></td>
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
        @endif
        <script type="text/javascript">
            try {
                this.print();
            }
            catch(e) {
                window.onload = window.print;
            }
        </script>
    </body>
</html>
