@extends('layouts.master')

@section('content')
    <br>
    <div class="container-fluid">
      <section class="section mb-2 mt-5">
        {{-- <div class="card card-ecommerce"> --}}
          {{-- <div class="card-body"> --}}
            <div class="table-responsive">
              <table class="table product-table" id="micart">
                <thead class="mdb-color lighten-5">
                    <tr>
                        <th>Imagen</th>
                        <th class="font-weight-bold">
                        <strong>Producto</strong>
                        </th>
                        <th class="font-weight-bold">
                            <strong>Precio</strong>
                        </th>
                        <th class="font-weight-bold">
                            <strong>Cantidad</strong>
                        </th>
                        <th class="font-weight-bold">
                            <strong>STotal</strong>
                        </th>
                        <th>Elimnar</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          {{-- </div> --}}
        {{-- </div> --}}
      </section>
    </div>
@endsection

@section('javascript')
    <script>
       $('document').ready(function () {
            var micart = JSON.parse(localStorage.getItem('micart'));
            if (micart.length == 0) {
                toastr.error('Carrito Vacio')
            } else {
                milist()
            }

            if (localStorage.getItem('micart')) {
                mitotal()
            } else {
                localStorage.setItem('micart', JSON.stringify([]));
                mitotal()
            }

        });

        function mitotal() {
            var micart = JSON.parse(localStorage.getItem('micart'))
                var mitotal = 0
                for (let index = 0; index < micart.length; index++) {
                    mitotal += micart[index].cant
                }
            $('#micount').html(mitotal)
        }

        function milist() {
            var milist = JSON.parse(localStorage.getItem('micart'))
            var mitotal = 0
            for (let index = 0; index < milist.length; index++) {
                var stotal = milist[index].precio * milist[index].cant
                $("#micart").append("<tr id="+milist[index].id+"><td><img class='img-responsive' src='{{ setting('admin.url') }}storage/"+milist[index].image+"'></td><td><strong>"+milist[index].name+"</strong></td><td>"+milist[index].precio+"</td><td>"+milist[index].cant+"</td><td>"+stotal+"</td><td><button type='button' class='btn btn-sm btn-primary' data-toggle='tooltip' data-placement='top' title='Remove item'>X</button></td></tr>")
                mitotal += stotal
            }
            $("#micart").append("<tr><td colspan='3'></td><td><h4 class='mt-2'><strong>Total</strong></h4></td><td><strong>"+mitotal+"</strong></td><td><a type='button' href='#' onclick='pagar()' class='btn btn-md btn-primary btn-rounded'>Pagar<i class='fas fa-angle-right right'></i></td></tr>")
        }

        function pagar() {
            location.href = "{{ route('pages', 'pasarela') }}"
        }

    </script>
@endsection
