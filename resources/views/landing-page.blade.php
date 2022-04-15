@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row pt-4">
            <div class="col-lg-12">
                <section>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 mb-2 mb-md-2 pb-lg-2">
                            <div class="view zoom z-depth-1">
                                <img src="https://mdbootstrap.com/img/Photos/Others/product1.jpg" class="img-fluid" alt="sample image">
                                <div class="mask rgba-white-light">
                                <div class="dark-grey-text d-flex align-items-center pt-4 ml-lg-3 pl-lg-3 pl-md-5">
                                    <div>
                                        <a><span class="badge badge-danger">Mi Tienda</span></a>
                                        <h2 class="card-title font-weight-bold pt-2"><strong>{{ setting('site.title') }}</strong></h2>
                                        <p class="hidden show-ud-up">{{ setting('site.description') }}</p>
                                        <a class="btn btn-danger btn-sm btn-rounded clearfix d-none d-md-inline-block"></i> Ver Catalogo</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="view zoom z-depth-1 photo">
                                <img src="https://mdbootstrap.com/img/Photos/Others/product3.jpg" class="img-fluid" alt="sample image">
                                <div class="mask rgba-stylish-strong">
                                <div class="white-text center-element text-center w-75">
                                    <div class="">
                                    <a><span class="badge badge-info">Mi Tienda</span></a>
                                    <h2 class="card-title font-weight-bold pt-2"><strong>{{ setting('site.title') }}</strong></h2>
                                    <p class="">{{ setting('site.description') }}</p>
                                    <a class="btn btn-info btn-sm btn-rounded"></i> Ver Catalogo</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- Grid column -->
                        <div class="col-12">

                            <!-- Image -->
                            <div class="view  z-depth-1">
                            <img src="https://mdbootstrap.com/img/Photos/Others/ecommerce6.jpg" class="img-fluid"
                                alt="sample image">

                            <div class="mask rgba-stylish-slight">

                                <div class="dark-grey-text text-right pt-lg-5 pt-md-1 mr-5 pr-md-4 pr-0">

                                <div>

                                    <a>

                                    <span class="badge badge-primary">SALE</span>

                                    </a>

                                    <h2 class="card-title font-weight-bold pt-md-3 pt-1">

                                    <strong>Sale 20% off on every smartphone!

                                    </strong>

                                    </h2>

                                    <p class="pb-lg-3 pb-md-1 clearfix d-none d-md-block">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit. </p>

                                    <a class="btn mr-0 btn-primary btn-rounded clearfix d-none d-md-inline-block">Read more</a>

                                </div>

                                </div>

                            </div>

                            </div>
                            <!-- Image -->

                        </div>
                        <!-- Grid column -->

                    </div>
                </section>

                <section>
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
                </section>

            </div>
        </div>
    </div>
@endsection
