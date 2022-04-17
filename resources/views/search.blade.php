@extends('layouts.master')


@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h2>Resultado de Busqueda</h2>
        </div>
        <div class="col-sm-12">
            <table class="table table-responsive" id="miresult">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>Image</th>
                        <th>Titulo</th>
                        <th>Precio</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('javascript')
    <script>
        $(document).ready(function () {
            cargar_search()
        });

        async function cargar_search() {
            var miproducts = JSON.parse(localStorage.getItem('miproducts'))
            $("#miresult tbody tr").remove();
            for (let index = 0; index < miproducts.length; index++) {
                $("#miresult").append("<tr><td><img class='img-responsive img-thumbnail' src='{{ setting('admin.url') }}storage/"+miproducts[index].image+"'></td><td>"+miproducts[index].name+"</td><td>"+miproducts[index].precio+" Bs.</td><td><a class='btn btn-sm btn-dark' onclick='addproduct("+miproducts[index].id+")'><i class='fas fa-cart-arrow-down'>Agregar</a></td></tr>")
            }
        }
    </script>
@endsection
