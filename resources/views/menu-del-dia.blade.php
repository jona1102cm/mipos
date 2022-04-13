@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">

        @php
            $catalogo = App\Catalogo::latest()->first();
            $products = App\RelCatalogoProducto::where('catalogo_id', $catalogo->id)->get();
        @endphp
        <div class="col-sm-12">
            <hr>
            <h5 class="text-center font-weight-bold dark-grey-text"><strong>Nuevos Productos</strong></h5>
            <hr>
            @foreach($products as $item)
                @php
                    $product = App\Producto::find($item->producto_id);
                    $miimage = $product->image ? $product->image : setting('productos.imagen_default');
                @endphp
                <div class="row mt-5 py-2 mb-4 hoverable align-items-center">
                    <div class="col-6">
                        <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid">
                    </div>
                    <div class="col-6">
                        <small>{{ $product->categoria->name }}</small><br>
                        <a class="pt-5"><strong>{{ $product->name }}</strong></a>
                        <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $product->precio }} Bs.</strong></h6>
                        <a href="#" onclick="addproduct('{{ $product->id }}')" class="btn btn-sm">Agregar a Carrito</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
