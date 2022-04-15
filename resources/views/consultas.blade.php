@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">

        <div class="col-sm-12 form-group">
            <label for="">Ingresa tu telefono</label>
            <input type="number" id="misearch" class="form-control" placeholder="whatsapp">
            <label><div id="micliente"></div></label>
        </div>
        <div class="col-sm-12 form-group">
            <table class="table table-responsive" id="mipedidos">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        {{-- <th>Ticket</th> --}}
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Pasarela</th>
                        <th>Delivery</th>
                        <th>Cupon</th>
                        {{-- <th>Mensaje</th> --}}
                        <th>Total</th>
                        {{-- <th>Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            cargar_user(miuser.phone)
        });

        async function cargar_user(phone) {
            var miuser = await axios.get("{{ setting('admin.url') }}api/consulta/"+phone)
            if (miuser.data.message) {
                toastr.error(miuser.data.message)
            } else {
                localStorage.setItem('miuser', JSON.stringify(miuser.data));
                $("#micliente").html(miuser.data.display);
                $("#misearch").val(miuser.data.phone);
                var pedidos = await axios.get("{{ setting('admin.url') }}api/pedidos/cliente/"+miuser.data.id)
                $("#mipedidos tbody tr").remove();
                for (let index = 0; index < pedidos.data.length; index++) {
                    $("#mipedidos").append("<tr><td>Codigo:"+pedidos.data[index].id+"<br>Ticket:"+pedidos.data[index].ticket+"</td><td>"+pedidos.data[index].published+"</td><td>"+pedidos.data[index].estado.title+"</td><td>"+pedidos.data[index].pasarela.title+"</td><td>"+pedidos.data[index].delivery.name+"</td><td>"+pedidos.data[index].cupon.title+"</td><td>"+pedidos.data[index].total+" Bs.</td></tr>")
                }
                toastr.success('Cliente Encontrado')
            }
        }

        $('#misearch').on('keypress', async function (e) {
            if(e.which === 13){
                cargar_user(this.value)
            }
        });
    </script>
@endsection
