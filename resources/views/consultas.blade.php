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

        $('#misearch').on('keypress', async function (e) {
         if(e.which === 13){
            var misearch = await axios.get("{{ setting('admin.url') }}api/pedidos/cliente/"+this.value)
            localStorage.setItem('miuser', JSON.stringify(misearch.data));
            toastr.info(misearch.data)
         }
   });
    </script>
@endsection
