@extends('layouts.master')

@section('css')
    <style>
        table {
    table-layout:fixed;
}
table td {
    width: 900px;
    overflow: hidden;
    text-overflow: ellipsis;
}
    </style>

@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="row pt-4">
            <div class="col-lg-12">
                <section class="section pt-1">
                    <div class="row">

                      <!-- Grid column -->
                      <div class="col-lg-8 col-md-12 mb-3 pb-lg-2">

                        <!-- Image -->
                        <div class="view zoom  z-depth-1">

                          <img src="https://mdbootstrap.com/img/Photos/Others/product2.jpg" class="img-fluid" alt="sample image">

                          <div class="mask rgba-white-light">

                            <div class="dark-grey-text d-flex align-items-center pt-3 pl-4">

                              <div>

                                <a><span class="badge badge-danger">{{ setting('site.title') }}</span></a>

                                <h2 class="card-title font-weight-bold pt-2"><strong>{{ setting('site.title') }}</strong></h2>

                                <p class="">{{ setting('site.description') }}</p>

                                <a href="{{ route('pages', 'catalogo') }}" class="btn btn-danger btn-sm btn-rounded clearfix d-none d-md-inline-block">Catalgo</a>

                              </div>

                            </div>

                          </div>

                        </div>
                        <!-- Image -->

                      </div>
                      <!-- Grid column -->


                    </div>
                </section>

                {{-- <section>
                    <div class="row">
                        @php
                            $product1 = App\Producto::where('ecommerce', 'new_products')->with('categoria')->get();
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-12">
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
                        <div class="col-lg-4 col-md-6 col-sm-12">
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
                        <div class="col-lg-4 col-md-6 col-sm-12">
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
                </section> --}}

                <section class="mb-5">
                    @php
                        $categorias = App\Categoria::orderBy('order', 'asc')->get();
                    @endphp
                    @foreach($categorias as $key)
                        @php
                            $products = App\Producto::where('ecommerce', true)->where('categoria_id', $key->id)->orderBy('name', 'asc')->with('categoria')->get();
                        @endphp
                        <h2>{{ $key->name }}</h2>
                        <table class="table table-responsive">
                            <tr>
                                @foreach($products as $item)

                                    <td>
                                        @php
                                            $miimage = $item->image ? $item->image : setting('productos.imagen_default');
                                        @endphp
                                            <div class="card">
                                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid"/>
                                                <a href="#!">
                                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                                </a>
                                                </div>
                                                <div class="card-body">
                                                <h6 class="h6-responsive font-weight-bold dark-grey-text">{{ $item->name }}</h6>
                                                <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $item->precio }} Bs.</strong></h6>
                                                <p class="card-text">{{ $item->description }}</p>
                                                <a href="#!"  onclick="addproduct('{{ $item->id }}')" class="btn btn-sm"><i class="fas fa-cart-arrow-down"></i>Agrego</a>
                                                </div>
                                            </div>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
@endsection
