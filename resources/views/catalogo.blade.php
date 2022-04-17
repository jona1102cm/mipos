@extends('layouts.master')


@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12  col-md-8 offset-md-2 text-center">
            <h2>Catalogo Completo</h2>
            <input type="search" id="misearch" class="form-control" placeholder="ingresa un criterio de busqueda">
        </div>
        <div class="col-sm-12 col-md-8 offset-md-2">
            <table class="table table-responsive table-sm" id="miresult">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoria</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $products = App\Producto::where('ecommerce', true)->orderBy('name', 'asc')->get();
                    @endphp
                    @foreach($products as $item)
                        <tr>
                            {{-- <td>{{ $item->id }}</td> --}}
                            <td>
                                @php
                                    $miimage = $item->image ? $item->image : setting('productos.imagen_default');
                                @endphp
                                <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid">
                            </td>
                            <td>
                                {{ $item->name }} <br>
                                <small>{{ $item->description }}</small>

                            </td>
                            <td>
                                {{ $item->precio }} Bs.
                            </td>
                            <td>
                                {{ $item->categoria->name }}
                            </td>
                            <td>
                                <a href="#" onclick="addproduct('{{ $item->id }}')" class="btn btn-sm"><i class="fas fa-cart-arrow-down"></i>Agregar</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('javascript')
    <script>
        $(document).ready(function () {
            $("#mireload").attr("hidden",true);
        });

        $('#misearch').on('keypress', async function (e) {
            if(e.which === 13){
                var result = await axios("{{ setting('admin.url') }}api/search/"+this.value)
                localStorage.setItem('miproducts', JSON.stringify(result.data));
                location.href = "{{ route('pages', 'search') }}";
            }
        });
    </script>
@endsection
