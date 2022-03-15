
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tickets</title>
    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background: url("{{ url('storage/'.setting('admin.encola')) }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow-y:hidden
            /* margin: 0;
            padding: 0; */
        }
        .title{
            font-size: 50px;
            color: white;
            margin-top: 20px
        }
        .footer{
            position:fixed;
            bottom:0px;
            left:0px;
            background-color:rgba(0, 0, 0, 0.6);
            width: 100%
        }
        .footer-content{
            margin: 10px 20px;
            color: white
        }
        iframe{
            background-color: white
        }
        table th td{
        color:white;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <div class="col-md-12" id="data" style="margin-top:20px;overflow-y:hidden"></div>
                    @php
                        $ventas = App\Venta::where('status_id', 1 )->orderby('id', 'desc')->get();
                    @endphp       
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover">
                            <thead style="color: white; height: 30px;">
                                <tr>
                                    <th>#</th>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                </tr>
                            </thead>
                            <tbody style="color: white;">
                                @foreach ($ventas as $item)
                                    <tr>
                                        <td>
                                            ID# {{ $item->id }}
                                            <br>
                                            Ticket: {{ $item->ticket }}
                                        </td>
                                        <td>
                                            @php
                                                $detalle = App\DetalleVenta::where('venta_id', $item->id )->get();
                                            @endphp
                                            @foreach($detalle as $d)
                                                @php
                                                    $producto = App\Producto::find( $d->producto_id );
                                                @endphp
                                                Producto: {{ $producto->name }} Cant: {{ $d->cantidad }} <br>
                                                Detalle: {{ $d->description }}
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $cliente = App\Cliente::find($item->cliente_id );
                                            @endphp
                                            {{ $cliente->display }}
                                        </td>                                        
                                    </tr>
                                @endforeach                                                   
                            </tbody>                       
                        </table>
                    </div>
            </div>
            <div class="col-sm-4">               
                <h1 class="title">{{ setting('empresa.title') }} <img src="{{ url('storage').'/'.setting('empresa.logo') }}" width="100px" alt=""></h1>
                <audio id="audio">
                    <source type="audio/mp3" src="iphone-notificacion.mp3">
                </audio>
            </div>
        </div>
        <div class="footer">
            <div class="footer-content">
                Powered By <b>Loginweb</b>
            </div>
        </div>
    </div>
 

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
    <script>
        document.getElementById("audio").play();
        const socket = io('https://socket.loginweb.dev')
        socket.on('chat', (msg) =>{
            location.reload();
        })
    </script>

</body>
</html>