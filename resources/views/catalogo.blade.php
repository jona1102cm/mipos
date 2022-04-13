
@extends('layouts.master')

@section('css')
@endsection

@section('content')
    <div class="container-fluid mt-2 pt-2">
        <div class="row pt-4">
            <div class="col-lg-12">
                <section class="mb-5">
                    <div class="row">
                        <div class="col-sm-12 pt-5">
                            <div class="input-group">
                                <input type="search" class="form-control rounded" placeholder="Buscar Producto" aria-label="Search" aria-describedby="search-addon" />
                            </div>
                        </div>
                        @php
                            $product1 = App\Producto::where('ecommerce', 'new_products')->with('categoria')->get();
                        @endphp
                        <div class="col-lg-4 col-md-12 col-12 ">
                            <hr>
                            <h5 class="text-center font-weight-bold dark-grey-text"><strong>Nuevos Productos</strong></h5>
                            <hr>
                            @foreach($product1 as $item)
                                <div class="row mt-5 py-2 mb-4 hoverable align-items-center">
                                <div class="col-6">
                                    @php
                                        $miimage = $item->image ? $item->image : setting('productos.imagen_default');
                                    @endphp
                                    <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid">
                                </div>
                                <div class="col-6">
                                    <small>{{ $item->categoria->name }}</small><br>
                                    <a class="pt-5"><strong>{{ $item->name }}</strong></a>
                                    <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $item->precio }} Bs.</strong></h6>
                                    <a href="#" onclick="addproduct('{{ $item->id }}')" class="btn btn-sm">Agregar a Carrito</a>
                                </div>
                                </div>
                            @endforeach
                        </div>
                            @php
                            $product2 = App\Producto::where('ecommerce', 'top_sellers')->get();
                            @endphp
                        <div class="col-lg-4 col-md-12 col-12">
                            <hr>
                            <h5 class="text-center font-weight-bold dark-grey-text"><strong>Los Mas Vendidos</strong></h5>
                            <hr>
                            @foreach($product2 as $item)
                                <div class="row mt-5 py-2 mb-4 hoverable align-items-center">
                                <div class="col-6">
                                    @php
                                    $miimage = $item->image ? $item->image : setting('productos.imagen_default');
                                    @endphp
                                    <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid">
                                </div>
                                <div class="col-6">
                                    <a class="pt-5"><strong>{{ $item->name }}</strong></a>
                                    <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $item->precio }} Bs.</strong></h6>
                                    <a href="#" onclick="addproduct('{{ $item->id }}')" class="btn btn-sm">Agregar a Carrito</a>
                                </div>
                                </div>
                            @endforeach
                        </div>
                            @php
                            $product3 = App\Producto::where('ecommerce', 'random_products')->get();
                            @endphp
                        <div class="col-lg-4 col-md-12 col-12">
                            <hr>
                            <h5 class="text-center font-weight-bold dark-grey-text"><strong>Todos los Productos</strong></h5>
                            <hr>
                            @foreach($product3 as $item)
                                <div class="row mt-5 py-2 mb-4 hoverable align-items-center">
                                <div class="col-6">
                                    @php
                                    $miimage = $item->image ? $item->image : setting('productos.imagen_default');
                                    @endphp
                                    <img src="{{ setting('admin.url') }}storage/{{ $miimage }}"
                                        class="img-fluid">
                                </div>
                                <div class="col-6">
                                    <a class="pt-5"><strong>{{ $item->name }}</strong></a>
                                    <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $item->precio }} Bs.</strong></h6>
                                    <a href="#" onclick="addproduct('{{ $item->id }}')" class="btn btn-sm">Agregar a Carrito</a>
                                </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop


@section('javascript')

    <script>
        $('document').ready(function () {

        });

    </script>
@endsection
