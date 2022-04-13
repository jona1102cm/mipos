@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">

        <div class="col-sm-12 form-group">
            <label for="">Ingres tu #Telefono</label>
            <input type="number" id="misearch" class="form-control" placeholder="whatsapp">
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Productos</th>
                        <th>Acciones</th>
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
           $('document').ready(function () {
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
        $('#misearch').on('keypress', async function (e) {
         if(e.which === 13){
            var misearch = await axios.get("{{ setting('admin.url') }}api/pedidos/cliente/"+this.value)
            localStorage.setItem('miuser', JSON.stringify(misearch.data));
            toastr.info(misearch.data)
         }
   });
    </script>
@endsection
