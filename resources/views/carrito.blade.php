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
                        <th></th>
                        <th class="font-weight-bold">
                        <strong>Producto</strong>
                        </th>
                        <th class="font-weight-bold">
                            <strong>Extras</strong>
                        </th>
                        <th class="font-weight-bold">
                            <strong>Observación</strong>
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
                        <th></th>
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

    <!----------------------MODALES--------------------------->

    <div class="modal modal-primary fade" tabindex="-1" id="modal-lista_extras" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-list-add"></i> Lista de extras</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="producto_extra_id" id="producto_extra_id" hidden>
                    <table class="table table-bordered table-hover" id="table-extras">
                        <thead>
                            <tr>
                                {{-- <th>Imagen</th>
                                <th>ID</th> --}}
                                <th>Extra</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    {{-- <td style="text-align: right">
                        <input style="text-align:right" readonly min="0" type="number" name="total_extra" id="total_extra">
                    </td> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-right" onclick="calcular_total_extra()" data-dismiss="modal">Añadir</button>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
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
        });

        function pagar() {
            location.href = "{{ route('pages', 'pasarela') }}"
        }

    </script>
@endsection
