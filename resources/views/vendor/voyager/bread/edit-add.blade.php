@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

    @switch($dataType->getTranslatedAttribute('slug'))
        @case('cocinas')

            @break
        @case('ventas')
            @php
                $miuser = TCG\Voyager\Models\User::find(Auth::user()->id);
                $micajas = App\Caja::all();
            @endphp

            @section('page_header')
            <br>
                {{-- <div class="row"> --}}
                    <div class="col-sm-2">
                        <h4 class="">
                            <i class="{{ $dataType->icon }}"></i>
                            {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
                        </h4>
                    </div>
                    <div class="col-sm-6">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-danger" data-toggle="modal" onclick="get_total()" data-target="#cerrar_caja">Cerrar</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#venta_caja" onclick="venta_caja()">Ventas</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_cliente">Cliente</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_asientos" onclick="cargar_asientos()">Asientos</button>
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_venta" onclick="get_cambio()">Vender</button> --}}
                                <button type="button" class="btn btn-primary"  onclick="saveventas()">Vender</button>

                            </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="info_caja"></div>
                    </div>
                {{-- </div> --}}
            @stop
            @break

        @case('chatbots')
            @php
                $miuser = TCG\Voyager\Models\User::find(Auth::user()->id);
                $micajas = App\Caja::all();
            @endphp
            @section('page_header')
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <strong style="font-size: 30px;">
                            <i class="{{ $dataType->icon }}"></i>
                            CHATBOT
                        </strong>
                    </div>
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4">
                    </div>

                </div>
            @stop
            @break

        @case('productions')
            @section('page_header')
                <br>
                <div class="row">
                    <div class="col-sm-8">
                        <strong style="font-size: 30px;">
                            <i class="{{ $dataType->icon }}"></i>
                            {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
                        </strong>
                    </div>

                    <div class="col-sm-4">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_prod">Guardar</button>
                            </div>
                    </div>

                </div>
            @stop
            @break


        @default
            @section('page_header')
                <h1 class="page-title">
                    <i class="{{ $dataType->icon }}"></i>
                    {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
                </h1>
                @include('voyager::multilingual.language-selector')
            @stop
    @endswitch



@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif
                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                        @switch($dataType->getTranslatedAttribute('slug'))
                            @case('cocinas')


                                @break
                            @case('ventas')
                                @php
                                    $miuser = TCG\Voyager\Models\User::find(Auth::user()->id);
                                    $micajas = App\Caja::all();
                                    $categorias = App\Categoria::where('id', '!=', 7 )->where('id', '!=', 16 )->orderBy('order', 'asc')->get();
                                @endphp

                                    <div class="form-group col-md-8">

                                        <div>
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach($categorias as $item)
                                                    <li role="presentation"><a href="#{{ $item->id }}" aria-controls="home" role="tab" data-toggle="tab">{{ $item->name}}</a></li>

                                                @endforeach
                                                <li role="presentation"><a href="#vacio" aria-controls="home" role="tab" data-toggle="tab">Vacio</a></li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach($categorias as $item)
                                                    <div role="tabpanel" class="tab-pane" id="{{ $item->id }}">
                                                        @php
                                                            $products = App\Producto::where('categoria_id', $item->id )->get();
                                                        @endphp
                                                         <div class="row">
                                                            @foreach($products as $item)
                                                                <div class="col-xs-3">
                                                                    <a href="#" onclick="addproduct('{{$item->id}}')" class="thumbnail">
                                                                        @php
                                                                        $miimage =$item->image ? $item->image :  setting('productos.imagen_default') ;
                                                                        @endphp
                                                                        <img src="{{setting('admin.url')}}storage/{{ $miimage }}">
                                                                    </a>
                                                                    <small>{{ $item->name }}</small>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                @endforeach
                                                <div role="tabpanel" class="tab-pane" id="vacio">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="search-input">
                                            <div class="input-group col-sm-6">
                                                <select class="form-control js-example-basic-single" id="category"></select>
                                            </div>
                                            <div class="input-group col-sm-6">
                                                <select class="form-control js-example-basic-single" id="s"></select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="mixtos" hidden>
                                            <select class="form-control js-example-basic-single" id="mixta1" style="width: 250px"></select>
                                            <select class="form-control js-example-basic-single" id="mixta2" style="width: 250px"></select>
                                            <a href="#" onclick="addmixta()" class="btn btn-sm btn-primary">Agregar</a>
                                        </div>
                                        <table class="table table-striped table-inverse table-responsive" id="micart">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Producto</th>
                                                    <th>Observación</th>
                                                    <th>Extra</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                    <th>Opciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group col-md-4 text-center">
                                        <form class="form-horizontal" role="form">
                                            <label class="radio-inline"> <input type="radio" name="season" id="" value="imprimir" checked> Imprimir </label>
                                            <label class="radio-inline"> <input type="radio" name="season" id="" value="seguir"> Seguir </label>
                                        </form>
                                    </div>
                                    <div class="form-group col-md-4">

                                        <div class="form-group col-md-12">
                                            <strong>Cliente</strong>
                                            <select class="form-control js-example-basic-single" id="micliente"> </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <strong>Pasarela</strong>
                                            <select class="form-control js-example-basic-single" id="mipagos"> </select>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <strong>Tipo</strong>
                                            <select class="form-control js-example-basic-single" id="venta_type"> </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <strong>Pensionado</strong>
                                            <select class="form-control js-example-basic-single" id="mipensionado"> </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <strong>Cupon</strong>
                                            <select class="form-control js-example-basic-single" id="micupon"> </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <strong>Delivery</strong>
                                            <select class="form-control js-example-basic-single" id="midelivery"> </select>
                                        </div>

                                        @foreach($dataTypeRows as $row)
                                            <!-- GET THE DISPLAY OPTIONS -->
                                            @php
                                                $display_options = $row->details->display ?? NULL;
                                                if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                    $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                                }
                                            @endphp

                                            @if (isset($row->details->legend) && isset($row->details->legend->text))
                                                <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                            @endif

                                            <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                                {{ $row->slugify }}
                                                <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                                @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                @if (isset($row->details->view))
                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                                @elseif ($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship', ['options' => $row->details])
                                                @else
                                                    {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                @endif

                                                @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                    {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                                @endforeach
                                                @if ($errors->has($row->field))
                                                    @foreach ($errors->get($row->field) as $error)
                                                        <span class="help-block">{{ $error }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>
                                @break

                            @case('productions')
                                <div class="form-group col-md-8">
                                    <label for="">Lista de Ingrediente</label>
                                    <div id="search-input">
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="proveedorelab"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="unidades"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="insumos"></select>
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single" id="prod_semi"></select>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-inverse table-responsive" id="miproduction">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>ID</th>
                                                <th>Insumo</th>
                                                <th>Proveedor</th>
                                                <th>Costo</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                    </table>

                                </div>

                                <div class="form-group col-md-4">

                                    <div class="form-group col-sm-12">
                                        <label>Producto</label>
                                        <select class="form-control js-example-basic-single" id="new_producto_id"></select>
                                    </div>
                                    @foreach($dataTypeRows as $row)
                                        <!-- GET THE DISPLAY OPTIONS -->
                                        @php
                                            $display_options = $row->details->display ?? NULL;
                                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                            }
                                        @endphp
                                        @if (isset($row->details->legend) && isset($row->details->legend->text))
                                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                        @endif

                                        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                @break

                            @case('production-semis')
                                <div class="form-group col-md-8">


                                    <div id="search-input">

                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single"  id="proveedorsemi"></select>
                                        </div>

                                    </div>

                                    <div id="search-input">
                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single" id="unidadessemi"></select>
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single" id="insumossemi"></select>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-inverse table-responsive" id="miprodsemi">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>#</th>
                                                <th>Ítem</th>
                                                <th>Proveedor</th>
                                                <th>Costo</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                    </table>
                                </div>

                                <div class="form-group col-md-4">
                                    @foreach($dataTypeRows as $row)
                                        <!-- GET THE DISPLAY OPTIONS -->
                                        @php
                                            $display_options = $row->details->display ?? NULL;
                                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                            }
                                        @endphp
                                        @if (isset($row->details->legend) && isset($row->details->legend->text))
                                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                        @endif

                                        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                @break

                            @case('imports')
                                <div class="form-group col-sm-6">
                                    <h3>Elije una Opcion</h3>
                                    <p>La importacion se realizara con la opcion que elejiste y luego de enviar.</p>
                                    <hr>
                                    <h5>MODULO VENTAS</h5>
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Clientes
                                        </label> -->
                                        <a href="{{ route('import.clientes') }}" class="btn btn-primary">Clientes</a>
                                        <br>
                                    <!-- </div> -->
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Productos
                                        </label> -->
                                        <a href="{{ route('import.products') }}" class="btn btn-primary btn-sm">Productos</a>
                                        <br>
                                    <!-- </div> -->
                                    <!-- <div class="form-check"> -->
                                        <a href="{{ route('import.ventas') }}" class="btn btn-primary btn-sm">Ventas</a>
                                    <!-- </div> -->
                                    <hr>
                                    <h5>MODULO PRODUCCION</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" disabled>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Insumos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Proveedores
                                        </label>
                                    </div>
                                </div>

                            @break
                            @case('compras')

                                {{-- <div class="form-group col-md-6">
                                    <div id="search-input">

                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="proveedores_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="unidades_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="insumos_compras"> </select>
                                        </div>


                                    </div>

                                </div> --}}

                                <div class="form-group col-md-12">

                                    <div id="search-input">

                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="proveedores_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="unidades_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="insumos_compras"> </select>
                                        </div>


                                    </div>


                                    @foreach($dataTypeRows as $row)
                                        <!-- GET THE DISPLAY OPTIONS -->
                                        @php
                                            $display_options = $row->details->display ?? NULL;
                                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                            }
                                        @endphp
                                        @if (isset($row->details->legend) && isset($row->details->legend->text))
                                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                        @endif

                                        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            @break

                            @case('productos')
                                <div class="form-group col-md-6">
                                    <strong>Categoria</strong>
                                    <select class="form-control js-example-basic-single" name="micategory" id="micategory"></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong>Tipo Producto</strong>
                                    <select class="form-control js-example-basic-single" name="type_producto" id="type_producto"></select>
                                </div>
                                @foreach($dataTypeRows as $row)
                                    <!-- GET THE DISPLAY OPTIONS -->
                                    @php
                                        $display_options = $row->details->display ?? NULL;
                                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                        }
                                    @endphp
                                    @if (isset($row->details->legend) && isset($row->details->legend->text))
                                        <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                    @endif

                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                        @if(isset($row->details->mitoolstip))
                                            <i class="voyager-info-circled" data-toggle="tooltip" rel="tooltip" title="{{ $row->details->mitoolstip }}"></i>
                                        @endif
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if (isset($row->details->view))
                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                        @elseif ($row->type == 'relationship')
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif

                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                                @break
                            @case('chatbots')
                                <div class="form-group col-sm-5">
                                    <h4 class="title">Cliente</h4>
                                    <select id="customer" class="form-control">
                                        <option> Elije una opcion</option>
                                    </select>
                                    <h4 class="title">Producto</h4>
                                    <select id="product" class="form-control">
                                        <option value="0" > Elije una opcion</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-7">
                                    <h4 class="title">CHAT - <small>Copia y Pega los Emojis!</small>
                                        <br />
                                        <a class="btn btn-sm btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Smileys
                                        </a>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">Gestures</button>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">People</button>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4">Clothing</button>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample5">Objects</button>

                                    </h4>
                                    <div class="collapse multi-collapse" id="collapseExample">
                                        😀 😃 😄 😁 😆 😅 😂 🤣 🥲 ☺️ 😊 😇 🙂 🙃 😉 😌 😍 🥰 😘 😗 😙 😚 😋 😛 😝 😜 🤪 🤨 🧐 🤓 😎 🥸 🤩 🥳 😏 😒 😞 😔 😟 😕 🙁 ☹️ 😣 😖 😫 😩 🥺 😢 😭 😤 😠 😡 🤬 🤯 😳 🥵 🥶 😱 😨 😰 😥 😓 🤗 🤔 🤭 🤫 🤥 😶 😐 😑 😬 🙄 😯 😦 😧 😮 😲 🥱 😴 🤤 😪 😵 🤐 🥴 🤢 🤮 🤧 😷 🤒 🤕 🤑 🤠 😈 👿 👹 👺 🤡 💩 👻 💀 ☠️ 👽 👾 🤖 🎃 😺 😸 😹 😻 😼 😽 🙀 😿 😾
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample2">
                                        👋 🤚 🖐 ✋ 🖖 👌 🤌 🤏 ✌️ 🤞 🤟 🤘 🤙 👈 👉 👆 🖕 👇 ☝️ 👍 👎 ✊ 👊 🤛 🤜 👏 🙌 👐 🤲 🤝 🙏 ✍️ 💅 🤳 💪 🦾 🦵 🦿 🦶 👣 👂 🦻 👃 🫀 🫁 🧠 🦷 🦴 👀 👁 👅 👄 💋 🩸
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample3">
                                        👶 👧 🧒 👦 👩 🧑 👨 👩‍🦱 🧑‍🦱 👨‍🦱 👩‍🦰 🧑‍🦰 👨‍🦰 👱‍♀️ 👱 👱‍♂️ 👩‍🦳 🧑‍🦳 👨‍🦳 👩‍🦲 🧑‍🦲 👨‍🦲 🧔 👵 🧓 👴 👲 👳‍♀️ 👳 👳‍♂️ 🧕 👮‍♀️ 👮 👮‍♂️ 👷‍♀️ 👷 👷‍♂️ 💂‍♀️ 💂 💂‍♂️ 🕵️‍♀️ 🕵️ 🕵️‍♂️ 👩‍⚕️ 🧑‍⚕️ 👨‍⚕️ 👩‍🌾 🧑‍🌾 👨‍🌾 👩‍🍳 🧑‍🍳 👨‍🍳 👩‍🎓 🧑‍🎓 👨‍🎓 👩‍🎤 🧑‍🎤 👨‍🎤 👩‍🏫 🧑‍🏫 👨‍🏫 👩‍🏭 🧑‍🏭 👨‍🏭 👩‍💻 🧑‍💻 👨‍💻 👩‍💼 🧑‍💼 👨‍💼 👩‍🔧 🧑‍🔧 👨‍🔧 👩‍🔬 🧑‍🔬 👨‍🔬 👩‍🎨 🧑‍🎨 👨‍🎨 👩‍🚒 🧑‍🚒 👨‍🚒 👩‍✈️ 🧑‍✈️ 👨‍✈️ 👩‍🚀 🧑‍🚀 👨‍🚀 👩‍⚖️ 🧑‍⚖️ 👨‍⚖️ 👰‍♀️ 👰 👰‍♂️ 🤵‍♀️ 🤵 🤵‍♂️ 👸 🤴 🥷 🦸‍♀️ 🦸 🦸‍♂️ 🦹‍♀️ 🦹 🦹‍♂️ 🤶 🧑‍🎄 🎅 🧙‍♀️ 🧙 🧙‍♂️ 🧝‍♀️ 🧝 🧝‍♂️ 🧛‍♀️ 🧛 🧛‍♂️ 🧟‍♀️ 🧟 🧟‍♂️ 🧞‍♀️ 🧞 🧞‍♂️ 🧜‍♀️ 🧜 🧜‍♂️ 🧚‍♀️ 🧚 🧚‍♂️ 👼 🤰 🤱 👩‍🍼 🧑‍🍼 👨‍🍼 🙇‍♀️ 🙇 🙇‍♂️ 💁‍♀️ 💁 💁‍♂️ 🙅‍♀️ 🙅 🙅‍♂️ 🙆‍♀️ 🙆 🙆‍♂️ 🙋‍♀️ 🙋 🙋‍♂️ 🧏‍♀️ 🧏 🧏‍♂️ 🤦‍♀️ 🤦 🤦‍♂️ 🤷‍♀️ 🤷 🤷‍♂️ 🙎‍♀️ 🙎 🙎‍♂️ 🙍‍♀️ 🙍 🙍‍♂️ 💇‍♀️ 💇 💇‍♂️ 💆‍♀️ 💆 💆‍♂️ 🧖‍♀️ 🧖 🧖‍♂️ 💅 🤳 💃 🕺 👯‍♀️ 👯 👯‍♂️ 🕴 👩‍🦽 🧑‍🦽 👨‍🦽 👩‍🦼 🧑‍🦼 👨‍🦼 🚶‍♀️ 🚶 🚶‍♂️ 👩‍🦯 🧑‍🦯 👨‍🦯 🧎‍♀️ 🧎 🧎‍♂️ 🏃‍♀️ 🏃 🏃‍♂️ 🧍‍♀️ 🧍 🧍‍♂️ 👭 🧑‍🤝‍🧑 👬 👫 👩‍❤️‍👩 💑 👨‍❤️‍👨 👩‍❤️‍👨 👩‍❤️‍💋‍👩 💏 👨‍❤️‍💋‍👨 👩‍❤️‍💋‍👨 👪 👨‍👩‍👦 👨‍👩‍👧 👨‍👩‍👧‍👦 👨‍👩‍👦‍👦 👨‍👩‍👧‍👧 👨‍👨‍👦 👨‍👨‍👧 👨‍👨‍👧‍👦 👨‍👨‍👦‍👦 👨‍👨‍👧‍👧 👩‍👩‍👦 👩‍👩‍👧 👩‍👩‍👧‍👦 👩‍👩‍👦‍👦 👩‍👩‍👧‍👧 👨‍👦 👨‍👦‍👦 👨‍👧 👨‍👧‍👦 👨‍👧‍👧 👩‍👦 👩‍👦‍👦 👩‍👧 👩‍👧‍👦 👩‍👧‍👧 🗣 👤 👥 🫂
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample4">
                                        🧳 🌂 ☂️ 🧵 🪡 🪢 🧶 👓 🕶 🥽 🥼 🦺 👔 👕 👖 🧣 🧤 🧥 🧦 👗 👘 🥻 🩴 🩱 🩲 🩳 👙 👚 👛 👜 👝 🎒 👞 👟 🥾 🥿 👠 👡 🩰 👢 👑 👒 🎩 🎓 🧢 ⛑ 🪖 💄 💍 💼
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample5">
                                        ⌚️ 📱 📲 💻 ⌨️ 🖥 🖨 🖱 🖲 🕹 🗜 💽 💾 💿 📀 📼 📷 📸 📹 🎥 📽 🎞 📞 ☎️ 📟 📠 📺 📻 🎙 🎚 🎛 🧭 ⏱ ⏲ ⏰ 🕰 ⌛️ ⏳ 📡 🔋 🔌 💡 🔦 🕯 🪔 🧯 🛢 💸 💵 💴 💶 💷 🪙 💰 💳 💎 ⚖️ 🪜 🧰 🪛 🔧 🔨 ⚒ 🛠 ⛏ 🪚 🔩 ⚙️ 🪤 🧱 ⛓ 🧲 🔫 💣 🧨 🪓 🔪 🗡 ⚔️ 🛡 🚬 ⚰️ 🪦 ⚱️ 🏺 🔮 📿 🧿 💈 ⚗️ 🔭 🔬 🕳 🩹 🩺 💊 💉 🩸 🧬 🦠 🧫 🧪 🌡 🧹 🪠 🧺 🧻 🚽 🚰 🚿 🛁 🛀 🧼 🪥 🪒 🧽 🪣 🧴 🛎 🔑 🗝 🚪 🪑 🛋 🛏 🛌 🧸 🪆 🖼 🪞 🪟 🛍 🛒 🎁 🎈 🎏 🎀 🪄 🪅 🎊 🎉 🎎 🏮 🎐 🧧 ✉️ 📩 📨 📧 💌 📥 📤 📦 🏷 🪧 📪 📫 📬 📭 📮 📯 📜 📃 📄 📑 🧾 📊 📈 📉 🗒 🗓 📆 📅 🗑 📇 🗃 🗳 🗄 📋 📁 📂 🗂 🗞 📰 📓 📔 📒 📕 📗 📘 📙 📚 📖 🔖 🧷 🔗 📎 🖇 📐 📏 🧮 📌 📍 ✂️ 🖊 🖋 ✒️ 🖌 🖍 📝 ✏️ 🔍 🔎 🔏 🔐 🔒 🔓
                                    </div>
                                    <textarea class="form-control" name="" id="message" rows="8"></textarea>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="option1" name="gender" value="option1" checked>
                                        <span class="form-check-label"> Texto </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="option2" name="gender" value="option2">
                                        <span class="form-check-label"> Imagen </span>
                                    </label>
                                    <br>
                                    <a href="#" onclick="send()" class="btn btn-sm btn-primary">Enviar</a>
                                </div>
                                @break
                            @default
                                @foreach($dataTypeRows as $row)
                                    <!-- GET THE DISPLAY OPTIONS -->
                                    @php
                                        $display_options = $row->details->display ?? NULL;
                                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                        }
                                    @endphp
                                    @if (isset($row->details->legend) && isset($row->details->legend->text))
                                        <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                    @endif

                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if (isset($row->details->view))
                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                        @elseif ($row->type == 'relationship')
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif

                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach

                        @endswitch

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @switch($dataType->getTranslatedAttribute('slug'))
                                @case('cocinas')

                                @break
                                @case('ventas')

                                @break

                                @case('imports')

                                @break
                                @case('chatbots')

                                @break
                                @case('productions')
                                    <!-- <a class="btn btn-primary" href="#" onclick="saveproductions()">Guardar</a> -->
                                    @break

                                @case('production-semis')
                                    <a class="btn btn-primary" href="#" onclick="saveproductionssemi()">Guardar</a>
                                    @break

                                @default
                                    @section('submit-buttons')
                                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                    @stop
                                    @yield('submit-buttons')
                            @endswitch
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- -------------------MODALES----------------------- -->
    <!-- -------------------MODALES----------------------- -->
    @switch($dataType->getTranslatedAttribute('slug'))
        @case('ventas')

            <div class="modal fade modal-primary" id="micaja">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="voyager-info"></i> Abrir Caja</h4>
                        </div>
                        <div class="modal-body">

                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Estado</th>

                                        <th>Sucursal</th>
                                        <th>Cajeros</th>
                                        <th>Importe</th>

                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($micajas as $caja)
                                        @php
                                            $tienda = App\Sucursale::find($caja->sucursal_id);
                                            $cajeros =  App\CajaUser::where('caja_id' ,$caja->id)->get();
                                            $mipermiso = false;
                                            foreach ($cajeros as $value) {
                                                if ($value->user_id == Auth::user()->id) {
                                                    $mipermiso = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if( $mipermiso )
                                            <tr>
                                                <td>
                                                    # {{ $caja->id }}
                                                    <br>
                                                    {{ $caja->title }}
                                                </td>
                                                <td>{{ $caja->estado }}</td>

                                                <td>
                                                    {{ $tienda->name }}
                                                    <br>
                                                    {{ $caja->sucursal_id }}
                                                </td>
                                                <td>
                                                    @foreach ($cajeros as $item)
                                                        @php
                                                            $miuser = TCG\Voyager\Models\User::find($item->user_id);
                                                        @endphp
                                                        {{ $miuser->name }} <br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" value="0" name="" id="importe_{{$caja->id }}">
                                                </td>
                                                <td> <button onclick="abrir_caja('{{ $caja->id }}', '{{ $caja->title }}', '{{ $tienda->name }}', '{{ $caja->sucursal_id }}' )" class="btn btn-sm btn-success"> Abrir </button> </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <a href="/admin/ventas" type="button" class="btn btn-default">{{ __('voyager::generic.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-primary" id="venta_caja">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                        <h4>Ventas de la Caja</h4>
                        </div>
                        <div class="modal-body">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#miventas" aria-controls="miventas" role="tab" data-toggle="tab">Mis Ventas</a></li>
                                <li role="presentation"><a href="#deliverys" aria-controls="deliverys" role="tab" data-toggle="tab">Deliverys</a></li>

                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="miventas">

                                    <table class="table table-striped table-inverse table-responsive" id="productos_caja">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>ID</th>
                                                <th>Pasarela</th>
                                                <th>Cliente</th>
                                                <th>Delivery</th>
                                                <th>Chofer</th>
                                                <th>Tipo</th>
                                                <th>Ticket</th>
                                                <th>Total</th>
                                                <th>Control</th>
                                                <th>Creado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="deliverys">
                                    <input id="venta_id" type="hidden" class="form-control" hidden>
                                    <select id="mideliverys" class="form-control"></select>
                                    <a href="#" class="btn btn-sm btn-primary" onclick="save_set_chofer()">Asignar</a>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-primary" id="cerrar_caja">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                        <h4>¿Estás seguro de cerrar?</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-responsive" hidden>
                            <thead>
                                <tr>
                                    <th>INGRESOS</th>
                                    <th>EGRESOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Total Ventas Bs.
                                        <br>
                                        <input type="number" class="form-control" id="total_ventas" value="0" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        Importe Inicial Bs.
                                        <br>
                                        <input type="number" class="form-control" id="importe_inicial" value="0" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        Asientos - Ingresos Bs.
                                        <br>
                                        <input type="number" class="form-control" id="ingresos" value="0" readonly>
                                    </td>
                                    <td>
                                        Asientos - Egresos Bs.<br>
                                        <input type="number" class="form-control" id="egresos" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Venta en Efectivo
                                        <input type="number" class="form-control" id="venta_efectivo" value="0" readonly>
                                    </td>
                                    {{-- <td>
                                        Venta con Tarjeta
                                        <input type="number" class="form-control" id="venta_tarjeta" value="0" readonly>
                                    </td>
                                    <td>
                                        Venta por Transferencia
                                        <input type="number" class="form-control" id="venta_transferencia" value="0" readonly>
                                    </td> --}}
                                </tr>
                                <tr>
                                    {{-- <td>
                                        Venta por QR
                                        <input type="number" class="form-control" id="venta_qr" value="0" readonly>
                                    </td>
                                    <td>
                                        Venta por TigoMoney
                                        <input type="number" class="form-control" id="venta_tigomoney" value="0" readonly>
                                    </td> --}}
                                    <td>
                                        Cantidad en Efectivo
                                        <input type="number" class="form-control" id="cantidad_efectivo" value="0" readonly>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td>
                                        Cantidad por Tarjeta
                                        <input type="number" class="form-control" id="cantidad_tarjeta" value="0" readonly>
                                    </td>
                                    <td>
                                        Cantidad por Transferencia
                                        <input type="number" class="form-control" id="cantidad_transferencia" value="0" readonly>
                                    </td>
                                    <td>
                                        Cantidad por QR
                                        <input type="number" class="form-control" id="cantidad_qr" value="0" readonly>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td>
                                        Venta Efectivo
                                        <input type="number" class="form-control" id="ingreso_efectivo" value="0" readonly>
                                    </td>
                                    <td>
                                        Venta En Linea
                                        <input type="number" class="form-control" id="ingreso_linea" value="0" readonly>
                                    </td>
                                    <td>
                                        Egreso Efectivo
                                        <input type="number" class="form-control" id="egreso_efectivo" value="0" readonly>
                                    </td>
                                    <td>
                                        Egreso En Linea
                                        <input type="number" class="form-control" id="egreso_linea" value="0" readonly>
                                    </td>


                                </tr>

                                <tr>
                                    <td>
                                        Venta con BaniPay
                                        <input type="number" class="form-control" id="venta_banipay" value="0" readonly>
                                    </td>
                                    <td>
                                        Cantidad por BaniPay
                                        <input type="number" class="form-control" id="cantidad_banipay" value="0" readonly>
                                    </td>

                                </tr>

                                <tr>
                                    {{-- <td>
                                        Cantidad por TigoMoney
                                        <input type="number" class="form-control" id="cantidad_tigomoney" value="0" readonly>
                                    </td> --}}

                                    <td>
                                        <label for="">Total Caja Bs.</label>
                                        <input type="number" class="form-control col-6" id="_total" value="0" readonly>
                                    </td>
                                    <td>
                                        CORTES
                                        <input type="text" class="form-control" id="cortes" readonly>
                                    </td>
                                        <td>

                                                <label for="">Cantidad de Ventas</label>
                                                <input type="number" class="form-control" id="cant_ventas" value="0" readonly>

                                        </td>
                                </tr>

                            </tbody>
                            </table>


                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Corte</th>
                                        <th>Cantidad</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody id="lista_cortes"></tbody>
                            </table>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Observaciones</label>
                                    <textarea name="" id="description" class="form-control"></textarea>
                                </div>
                                <div class="col-sm-6">
                                    Monto Entregado
                                    <input type="number" class="form-control" id="efectivo_entregado" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="" onclick="cerrar_caja()">SI</button>
                        </div>
                    </div>
                </div>
            </div>



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
                                        <th>Imagen</th>
                                        <th>ID</th>
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

            <div class="modal fade modal-primary" id="modal_cliente">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="voyager-info"></i> Nuevo Cliente</h4>
                        </div>
                        <div class="modal-body">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Nuevo</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Buscar</a></li>

                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <div class="form-group col-sm-6">
                                        <label for="">Nombres</label>
                                        <input class="form-control" type="text" placeholder="Nombres" id="first_name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Apellidos</label>
                                        <input class="form-control" type="text" placeholder="Apellidos" id="last_name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Telefono</label>
                                        <input class="form-control" type="text" placeholder="Telefono" id="phone" value="0">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">NIT</label>
                                            <input class="form-control" type="text" placeholder="Carnet o NIT" id="nit" value="0">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Display</label>
                                        <input class="form-control" type="text" placeholder="Display" id="display">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Correo</label>
                                        <input class="form-control" type="text" placeholder="Email" id="email">
                                    </div>
                                    <div class="form-group col-sm-6">

                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="savecliente()" >Agregar</button>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <input type="text" class="form-control" placeholder="Criterio de Busquedas.." id="cliente_busqueda">
                                    <br>
                                    <table class="table" id="cliente_list">
                                        <thead>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>CI - NIT</th>
                                            <th>Opciones</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-primary" id="modal_save_venta">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-primary" id="modal_asientos">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4>Ingresos & Egresos</h4>
                        </div>
                        <div class="modal-body">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">Registrar</a></li>
                                <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab">Historial</a></li>

                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home1">
                                    <div class="form-group col-sm-4">
                                            <label for="">Tipo</label>
                                        <select class="form-control" name="" id="type">
                                            <option value="Egresos" selected>Egresos</option>
                                            <option value="Ingresos">Ingresos</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4"><br>
                                        <label class="radio-inline"> <input type="radio" name="pago" id="pago" value="0" checked> Bany Pay </label> <br>
                                        <label class="radio-inline"> <input type="radio" name="pago" id="pago" value="1"> En Efectivo </label>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Monto</label>
                                        <input type="number" class="form-control" id="monto" value="0">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="">Concepto</label>
                                        <textarea class="form-control" name="" id="concepto"></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">

                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button type="button" class="btn btn-primary" onclick="save_asiento()">Enviar</button>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile1">

                                    <table class="table" id="asiento_list">
                                        <thead>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Pago</th>
                                            <th>Monto</th>
                                            <th>Concepto</th>
                                            <th>Creado</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>

            @break

        @case('productions')
            <div class="modal fade modal-primary" id="modal_save_prod">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                        </div>

                        <div class="modal-body">
                            <h4>¿Estás seguro que quieres guardar ?</h4>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                            <button type="button" class="btn btn-primary" onclick="saveproductions()">SI</button>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @default
            <div class="modal fade modal-danger" id="confirm_delete_modal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                        </div>

                        <div class="modal-body">
                            <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                        </div>
                    </div>
                </div>
            </div>

    @endswitch



@stop


<!-- -------------------CARGADO DE JS----------------------- -->
<!-- -------------------CARGADO DE JS----------------------- -->

@switch($dataType->getTranslatedAttribute('slug'))
    @case('cocinas')
        @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
        <script src="{{url('js/ventas.js')}}"></script>
            <script>
                const socket = io('https://socket.loginweb.dev')
                const socket_ventas = "{{ setting('notificaciones.socket') }}";
                const socket_cocina = "{{ setting('notificaciones.socket_cocina') }}";
                // socket.on(socket_ventas, (msg) =>{
                //     toastr.success('La Cocina Libero el Pedido: '+msg);
                // })
            </script>
        @stop
    @break

    @case('ventas')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
            <script>
                const socket = io('https://socket.loginweb.dev')
                const name_socket = "{{ setting('notificaciones.socket') }}";
                const socket_cocina = "{{ setting('notificaciones.socket_cocina') }}";
                socket.on(socket_cocina, (msg) =>{
                    toastr.success('La Cocina Libero el Pedido: '+msg);
                })

                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    $('input[name="register_id"]').val('{{ Auth::user()->id }}');
                    $('input[name="chofer_id"]').val("{{setting('ventas.chofer')}}");


                    if (localStorage.getItem('micaja')) {
                        var micaja = JSON.parse(localStorage.getItem('micaja'));
                        $("input[name='caja_id']").val(micaja.caja_id);
                        $('input[name="sucursal_id"]').val(micaja.sucursal_id);
                        $("#info_caja").html("<h4>"+micaja.title+" - "+micaja.sucursal+" - "+micaja.importe+" Bs. - <a href='#' onclick='reset()'>Reset</a></h4>");
                    }else{
                        $("#micaja").modal();
                    }

                    // TODOS LOS CATEGORIAS
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/categorias",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#category').append($('<option>', {
                    //             value: 0,
                    //             text: 'Elige una Categoria'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             const element = response[index];
                    //             $('#category').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //         }
                    //     }
                    // });

                    Categorias();

                    // get Deliverys
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/deliverys",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         for (let index = 0; index < response.length; index++) {
                    //             if (response[index].id == 1) {
                    //                 $('#midelivery').append($('<option>', {
                    //                 selected: true,
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //             $("input[name='delivery_id']").val(response[index].id);
                    //             } else {
                    //                 $('#midelivery').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //             }
                    //         }
                    //     }
                    // });
                    Deliverys();

                    //get cliente default
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/cliente/default/get",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $("input[name='cliente_id']").val(response.id);
                    //         $('#micliente').append($('<option>', {
                    //                 value: response.id,
                    //                 text: response.display+' - '+response.ci_nit
                    //             }));
                    //     }
                    // });
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/clientes",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         for (let index = 0; index < response.length; index++) {
                    //             if(response[index].default==0){
                    //                 $('#micliente').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].display+' - '+response[index].ci_nit
                    //              }));
                    //             }
                    //         }
                    //     }
                    // });

                    ClienteDefault();
                    Cliente();

                    // get cup[ones]
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/cupones",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         for (let index = 0; index < response.length; index++) {
                    //             if (response[index].id == 1) {
                    //                 $('#micupon').append($('<option>', {
                    //                 selected: true,
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             $("input[name='cupon_id']").val(response[index].id);
                    //             } else {
                    //                 $('#micupon').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             }
                    //         }
                    //     }
                    // });
                    Cupones();

                    // get pasarela
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/pagos",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         for (let index = 0; index < response.length; index++) {
                    //             if (response[index].id == 1) {
                    //                 $('#mipagos').append($('<option>', {
                    //                 selected: true,
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             $("input[name='pago_id']").val(response[index].id);
                    //             } else {
                    //                 $('#mipagos').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             }
                    //         }
                    //     }
                    // });

                    Pasarelas();

                    // get estados
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/estados",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         for (let index = 0; index < response.length; index++) {
                    //             if (response[index].id == 1) {
                    //                 $('#miestado').append($('<option>', {
                    //                 selected: true,
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             $("input[name='status_id']").val(response[index].id);
                    //             } else {
                    //                 $('#miestado').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             }
                    //         }
                    //     }
                    // });

                    Estados();

                    // venta_type
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/options",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         for (let index = 0; index < response.length; index++) {
                    //             if (response[index].id == 1) {
                    //                 $('#venta_type').append($('<option>', {
                    //                 selected: true,
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             $("input[name='option_id']").val(response[index].id);
                    //             } else {
                    //                 $('#venta_type').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //             }
                    //         }
                    //     }
                    // });

                    Opciones();
                    //PensionadoDefault();
                    Pensionados();

                    //-----------------------
                    if (localStorage.getItem('micart')) {
                        micart();

                    } else {
                        localStorage.setItem('micart', JSON.stringify([]));
                    }
                });

                async function Categorias() {

                    var table = await axios.get("{{ setting('admin.url') }}api/pos/categorias");

                    $('#category').append($('<option>', {
                        value: 0,
                        text: 'Elige una Categoria'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#category').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }
                async function Deliverys(){
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/deliverys");

                    for (let index = 0; index < table.data.length; index++) {
                        if (table.data[index].id == 1) {
                            $('#midelivery').append($('<option>', {
                            selected: true,
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                        $("input[name='delivery_id']").val(table.data[index].id);
                        } else {
                            $('#midelivery').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                        }
                    }
                }

                async function Cupones(){

                    var table= await axios.get("{{ setting('admin.url') }}api/pos/cupones");

                    for (let index = 0; index < table.data.length; index++) {
                        if (table.data[index].id == 1) {
                            $('#micupon').append($('<option>', {
                            selected: true,
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        $("input[name='cupon_id']").val(table.data[index].id);
                        } else {
                            $('#micupon').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        }
                    }
                }

                async function Pasarelas() {
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/pagos");

                    for (let index = 0; index < table.data.length; index++) {
                        if (table.data[index].id == 1) {
                            $('#mipagos').append($('<option>', {
                            selected: true,
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        $("input[name='pago_id']").val(table.data[index].id);
                        } else {
                            $('#mipagos').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        }
                    }

                }

                async function Estados() {
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/estados");

                    for (let index = 0; index < table.data.length; index++) {
                        if (table.data[index].id == 1) {
                            $('#miestado').append($('<option>', {
                            selected: true,
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        $("input[name='status_id']").val(table.data[index].id);
                        } else {
                            $('#miestado').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        }
                    }
                }

                async function Opciones() {
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/options");

                    for (let index = 0; index < table.data.length; index++) {
                        if (table.data[index].id == 1) {
                            $('#venta_type').append($('<option>', {
                            selected: true,
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        $("input[name='option_id']").val(table.data[index].id);
                        } else {
                            $('#venta_type').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                        }
                    }
                }
                async function PensionadoDefault(){
                    $('#mipensionado').append($('<option>', {
                        value: 0,
                        text: 'Elige un Pensionado'
                    }));
                    $('input[name="pensionado_id"]').val(0);

                }

                async function Pensionados(){
                    var table= await axios.get("{{setting('admin.url')}}api/pos/pensionados");
                    $('#mipensionado').append($('<option>', {
                        value: 0,
                        text: 'Elige un Pensionado'
                    }));

                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#mipensionado').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].id+' - '+table.data[index].cliente.display+' - '+table.data[index].cliente.phone
                        }));
                    }

                }

                // $('#venta_type').on('change', function() {
                //     if($('#venta_type').text()=='Pensionado'){
                //         Pensionados();
                //     }
                // });
                $('#mipensionado').on('change', function() {
                    if($('#mipensionado').val()==0){
                        $('#micliente').find('option').remove().end();
                        ClienteDefault();
                        Cliente();
                    }
                    else{
                        ClientePorPensionado($('#mipensionado').val());

                        // var cliente=$('#mipensionado option:selected').val();
                        // var cltext=$('#mipensionado option:selected').text();

                        // $('#micliente').find('option').remove().end();

                        // $('#micliente').append($('<option>', {
                        //     value: cliente,
                        //     text: cltext
                        // }));
                        // $("input[name='cliente_id']").val(cliente);
                    }
                });

                $('#mipensionado').on('change', function() {

                    $('input[name="pensionado_id"]').val(this.value);
                    toastr.success('Cambio de Pensionado');
                });

                async function ClientePorPensionado(id){
                    var table = await axios.get("{{setting('admin.url')}}api/pos/cliente/pensionado/"+id);
                    //console.log(table.data);
                    $('#micliente').find('option').remove().end();
                    for (let index = 0; index < table.data.length; index++) {

                        $('#micliente').append($('<option>', {
                            value: table.data[index].cliente_id,
                            text: table.data[index].cliente.display
                        }));
                        $("input[name='cliente_id']").val($('#micliente').val());
                    }
                }

                async function Cliente(){
                    var tabla= await axios.get("{{ setting('admin.url') }}api/pos/clientes");

                    for (let index = 0; index < tabla.data.length; index++) {
                        if(tabla.data[index].default==0){
                            $('#micliente').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].display+' - '+tabla.data[index].ci_nit
                            }));
                        }
                    }

                }
                async function ClienteDefault(){

                    var tabla= await axios("{{ setting('admin.url') }}api/pos/cliente/default/get");

                    $("input[name='cliente_id']").val(tabla.data.id);
                    $('#micliente').append($('<option>', {
                        value: tabla.data.id,
                        text: tabla.data.display+' - '+tabla.data.ci_nit
                    }));
                }


                // Extras
                async function addextra(extras , producto_id) {
                    $("#table-extras tbody tr").remove();
                    $("#producto_extra_id").val(producto_id);
                    var mitable="";
                    var extrasp=  await axios.get("{{ setting('admin.url') }}api/pos/producto/extra/"+extras);
                    //console.log(extrasp.data);
                    for(let index=0; index < extrasp.data.length; index++){
                        mitable = mitable + "<tr><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+extrasp.data[index].image+"></td><td>"+extrasp.data[index].id+"</td><td><input class='form-control extra-name' readonly value='"+extrasp.data[index].name+"'></td><td><input class='form-control extra-precio' readonly  value='"+extrasp.data[index].precio+" Bs."+"'></td><td><input class='form-control extra-cantidad' style='width:100px' type='number' min='0' value='0'  id='extra_"+extrasp.data[index].id+"'></td></tr>";
                    }
                    $('#table-extras').append(mitable);
                }

                async function updatecantextra( name_extra, precio_extra, producto_id){
                    var miprice = $("#precio_"+producto_id).val()
                    var nuevoprecio = parseFloat(precio_extra)+ parseFloat(miprice);
                    var nuevototal = parseFloat(nuevoprecio).toFixed(2)*parseFloat($("#cant_"+producto_id).val());
                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == producto_id) {
                                var miprice = milist[index].precio_inicial;
                                var nuevoprecio = parseFloat(precio_extra)+ parseFloat(miprice);
                                var nuevototal = parseFloat(nuevoprecio).toFixed(2)*parseFloat($("#cant_"+producto_id).val());

                                var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': nuevoprecio ,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant, 'total':nuevototal, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name': name_extra, 'observacion':milist[index].observacion};
                                newlist.push(temp);
                        }
                        else{
                                var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio , 'precio_inicial': milist[index].precio_inicial ,'cant': milist[index].cant, 'total': milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                                newlist.push(temp);
                        }
                    }
                    localStorage.setItem('micart', JSON.stringify(newlist));
                    micart();
                }

                async function calcular_total_extra(){
                    var cantidad=[];
                    var name=[];
                    var precio=[];
                    var subtotal=0;
                    var index_cantidad=0;
                    var index_name_aux=0;
                    var index_precio_aux=0;
                    var index_cantidad_aux=0;
                    var precio_extras=0;
                    var nombre_extras="";

                   $('.extra-cantidad').each(function(){
                       if($(this).val()>0){
                            cantidad[index_cantidad_aux]=parseFloat($(this).val());
                            index_cantidad_aux+=1;
                            var index_name=0;
                            $('.extra-name').each(function(){
                                if(index_name==index_cantidad){
                                    name[index_name_aux]=$(this).val();
                                    index_name_aux+=1;
                                }
                                index_name+=1;
                            });

                            var index_precio=0;
                            $('.extra-precio').each(function(){
                                if(index_precio==index_cantidad){
                                    precio[index_precio_aux]=parseFloat($(this).val());
                                    index_precio_aux+=1;
                                }
                                index_precio+=1;
                            });

                       }
                       index_cantidad+=1;
                   });

                   for(let index=0;index<precio.length;index++){
                    nombre_extras+=name[index]+' ';
                    precio_extras+=parseFloat(cantidad[index])*parseFloat(precio[index]);
                   }
                   console.log(cantidad);
                   console.log(precio);
                   console.log(name);
                   console.log(nombre_extras);
                   console.log(precio_extras);
                   var producto_id=$("#producto_extra_id").val();
                   var name_extra=nombre_extras;
                   var precio_extra=precio_extras;
                   updatecantextra(name_extra, precio_extra, producto_id);
                }

                //Agregar Observacion al Carrito
                async function updateobservacion(id){
                    var observacion= $("#observacion_"+id).val()
                    console.log(id)
                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {
                                var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio ,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant, 'total':milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name': milist[index].extra_name, 'observacion':observacion};
                                newlist.push(temp);
                        }
                        else{
                                var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio , 'cant': milist[index].cant, 'total': milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                                newlist.push(temp);
                        }
                    }
                    localStorage.setItem('micart', JSON.stringify(newlist));
                    micart();
                }

                //reset session
                function reset() {
                    localStorage.removeItem('micaja');
                    localStorage.setItem('micart', JSON.stringify([]));
                    location.reload();
                }

                //Asignacion de Cortes
                let cortes = new Array('0.5', '1', '2', '5', '10', '20', '50', '100', '200');
                cortes.map(function(value){
                $('#lista_cortes').append(`<tr>
                                <td><h4><img src="{{url('billetes/${value}.jpg')}}" alt="${value} Bs." width="80px"> ${value} Bs. </h4></td>
                                <td><input type="number" min="0" step="1" style="width:100px" data-value="${value}" class="form-control input-corte" value="0" required></td>
                                <td><label id="label-${value.replace('.', '')}">0.00 Bs.</label><input type="hidden" class="input-subtotal" id="input-${value.replace('.', '')}"></td>
                            </tr>`)
                });

                $('.input-corte').keyup(function(){
                    let corte = $(this).data('value');
                    let cantidad = $(this).val() ? $(this).val() : 0;
                    calcular_subtottal(corte, cantidad);
                });
                $('.input-corte').change(function(){
                    let corte = $(this).data('value');
                    let cantidad = $(this).val() ? $(this).val() : 0;
                    calcular_subtottal(corte, cantidad);
                });

                function calcular_subtottal(corte, cantidad){
                    let total = (parseFloat(corte)*parseFloat(cantidad)).toFixed(2);
                    $('#label-'+corte.toString().replace('.', '')).text(total+' Bs.');
                    $('#input-'+corte.toString().replace('.', '')).val(total);
                    let total_corte = 0;
                    $(".input-subtotal").each(function(){
                        total_corte += $(this).val() ? parseFloat($(this).val()) : 0;
                    });
                    $('#efectivo_entregado').val(total_corte);

                    var cortes = JSON.stringify({corte: '0.5', cantidad: 10, valor: 5});
                    // $('#cortes').val(cortes);
                }

                //get totales
                function get_total() {
                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    var editor_id = '{{ Auth::user()->id; }}';
                    var midata = JSON.stringify({caja_id: micaja.caja_id, editor_id: editor_id});
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/caja/get_total/"+midata,
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            $('#cant_ventas').val(response.cantidad);
                            $('#total_ventas').val(response.total);
                            $('#importe_inicial').val(micaja.importe);
                            $('#ingresos').val(response.ingresos);
                            $('#egresos').val(response.egresos);
                            $('#venta_efectivo').val(response.total_efectivo);
                            // $('#venta_tarjeta').val(response.total_tarjeta);                            $('#venta_efectivo').val(response.total_efectivo);

                            // $('#venta_transferencia').val(response.total_transferencia);
                            // $('#venta_qr').val(response.total_qr);
                            // $('#venta_tigomoney').val(response.total_tigomoney);
                            $('#venta_banipay').val(response.total_banipay);
                            $('#cantidad_efectivo').val(response.cantidad_efectivo);
                            // $('#cantidad_tarjeta').val(response.cantidad_tarjeta);
                            // $('#cantidad_transferencia').val(response.cantidad_transferencia);
                            // $('#cantidad_qr').val(response.cantidad_qr);
                            // $('#cantidad_tigomoney').val(response.cantidad_tigomoney);
                            $('#cantidad_banipay').val(response.cantidad_banipay);
                            $('#ingreso_efectivo').val(response.ingreso_efectivo);
                            $('#ingreso_linea').val(response.ingreso_linea);
                            $('#egreso_efectivo').val(response.egreso_efectivo);
                            $('#egreso_linea').val(response.egreso_linea);
                            var total = (response.total + parseFloat(micaja.importe) + response.ingresos) - response.egresos;
                            $('#_total').val(total);
                        }
                    });
                }


                // cargar asientos
                function cargar_asientos() {
                    $("#asiento_list tbody tr").remove();
                    var mitable = "";
                    var editor = '{{ Auth::user()->id; }}';
                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    var midata = JSON.stringify({caja_id: micaja.caja_id, editor_id: editor});
                    var urli = "{{ setting('admin.url') }}api/pos/asientos/caja/editor/"+midata;
                    // console.log(urli);

                    $.ajax({
                        url: urli,
                        dataType: "json",
                        success: function (response) {
                            if (response.length == 0 ) {
                                toastr.error('Sin Resultados.');
                            } else {
                                for (let index = 0; index < response.length; index++) {

                                    if (response[index].pago == 0) {
                                        var pagotext="En Linea";
                                    }
                                    if (response[index].pago == 1){
                                        var pagotext="En Efectivo";
                                    }

                                    mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].type+"</td><td>"+pagotext+"</td><td>"+response[index].monto+"</td><td>"+response[index].concepto+"</td><td>"+response[index].created_at+"</td></tr>";
                                }
                                $('#asiento_list').append(mitable);
                            }
                        }
                    });
                }

                //SAVE ASIENTOS
                function save_asiento() {
                    if ($("input[name='pago']:checked").val() == '0') {
                        var pagotext="En Linea";
                    }
                    if ($("input[name='pago']:checked").val() == '1'){
                        var pagotext="En Efectivo";
                    }
                    var pago=$("input[name='pago']:checked").val();
                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    var concepto = $('#concepto').val();
                    var monto = $('#monto').val();
                    var type = $('#type option:selected').val();
                    var caja_id = micaja.caja_id;
                    var editor_id = '{{ Auth::user()->id }}';
                    var midata = JSON.stringify({caja_id: caja_id, type: type, monto: monto, editor_id: editor_id, concepto: concepto, pago:pago});
                    console.log(midata);
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/asiento/save/"+midata,
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            toastr.success('Asiento registrado como: '+response.type);
                            $('#modal_asientos').modal('hide');
                        }
                    });
                }

                // GET CAMBIO
                $("input[name='recibido']").keyup(function (e) {
                    e.preventDefault();
                    var cambio = $("input[name='recibido']").val() - $("input[name='total']").val();
                    $("input[name='cambio']").val(cambio);
                });

                 // CAMBIO TPV
                function get_cambio() {
                    var micart = JSON.parse(localStorage.getItem('micart'));
                    if (micart.length == 0 ) {
                        toastr.error('Tu Carrito esta Vacio');
                        // $('#modal_save_venta').modal('hide');
                    } else {
                       $("input[name='recibido']").val(0);
                       $("input[name='cambio']").val(0);
                        var total = 0;
                        for (let index = 0; index < micart.length; index++) {
                        total = total + micart[index].total;
                    }
                    }
                }

                //ADD MIXTA
                async function addmixta() {
                    var id = $('#s').val();
                    var mixta1 = $('#mixta1').val();
                    var mixta2 = $('#mixta2').val();

                    var cant_actual1 = 0;
                    var cant_actual2 = 0;
                    var cant_i1=false;
                    var cant_i2=false;
                    var prod1= "";
                    var prod2= "";

                    var inventario = false;

                    if("{{setting('ventas.stock')}}"){
                        inventario = true;

                        var miresponse1 = await axios.get("{{ setting('admin.url') }}api/pos/producto/"+mixta1);

                        prod1=miresponse1.data.name;
                        cant_actual1 = miresponse1.data.stock;
                        if(cant_actual1>1){
                            cant_i1=true;
                        }
                        else{
                            cant_i1=false;
                        }
                    }

                    if("{{setting('ventas.stock')}}"){
                        var miresponse2 = await axios.get("{{ setting('admin.url') }}api/pos/producto/"+mixta2);
                        prod2=miresponse2.data.name;
                        cant_actual2 = miresponse2.data.stock;
                        if(cant_actual2>1){
                            cant_i2=true;
                        }
                        else{
                            cant_i2=false;
                        }
                    }
                    if(inventario){
                        if(cant_i1){
                            if(cant_i2){
                                var micart = JSON.parse(localStorage.getItem('micart'));
                                var description = $('#mixta1 :selected').text() + ' - ' + $('#mixta2 :selected').text();
                                $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/producto/"+id,
                                dataType: "json",
                                success: function (response) {
                                    $('#mixtos').attr("hidden", true);
                                    $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+response.image+"></td><td>"+response.name+"<br>"+description+"</td><td><input class='form-control' type='text' id='observacion_"+response.id+"'></td><td><a href='#' class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras' onclick='addextra("+response.extras+", "+response.id+")'><i class='voyager-plus'></i></a></td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' onchange='updateprice("+response.id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                    var temp = {'id': response.id, 'image': response.image, 'name': response.name, 'precio': response.precio, 'precio_inicial':response.precio , 'cant': 1, 'total': response.precio, 'description': description, 'extra': response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':'' };
                                    micart.push(temp);
                                    localStorage.setItem('micart', JSON.stringify(micart));
                                    mitotal();
                                    toastr.success(response.name+" - REGISTRADO");
                                    }
                                });
                            }else{
                                toastr.error("No existe en Stock: "+prod2);
                            }
                        }else{
                            toastr.error("No existe en Stock: "+prod1);
                        }
                    }
                    else{

                        var micart = JSON.parse(localStorage.getItem('micart'));
                        var description = $('#mixta1 :selected').text() + ' - ' + $('#mixta2 :selected').text();
                        $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/producto/"+id,
                        dataType: "json",
                        success: function (response) {

                            var miimage =response.image ? response.image : "{{ setting('productos.imagen_default') }}";

                            $('#mixtos').attr("hidden", true);
                            $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+response.image+"></td><td>"+response.name+"<br>"+description+"</td><td><input class='form-control' type='text' id='observacion_"+response.id+"'></td><td><a href='#' class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras'onclick='addextra("+response.extras+", "+response.id+")'><i class='voyager-plus'></i></a></td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' onchange='updateprice("+response.id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                            var temp = {'id': response.id, 'image': miimage, 'name': response.name, 'precio': response.precio, 'precio_inicial':response.precio, 'cant': 1, 'total': response.precio, 'description': description, 'extra': response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':''};
                            micart.push(temp);
                            localStorage.setItem('micart', JSON.stringify(micart));

                            mitotal();
                            toastr.success(response.name+" - REGISTRADO");

                            }
                        });

                    }
                }

                //Busquedas de Clientes
                $('#cliente_busqueda').keyup(function (e) {
                    e.preventDefault();
                    if (e.keyCode == 13) {
                        $("#cliente_list tbody tr").remove();
                        var mitable = "";
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/clientes/search/"+this.value,
                            dataType: "json",
                            success: function (response) {
                                if (response.length == 0 ) {
                                    toastr.error('Sin Resultados.');
                                } else {
                                    toastr.success('Clintes Encontrados');
                                    for (let index = 0; index < response.length; index++) {
                                        mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].display+"</td><td>"+response[index].ci_nit+"</td><td><a class='btn btn-sm btn-success' href='#' onclick='cliente_get("+response[index].id+")'>Elegir</a></td></tr>";
                                    }
                                    $('#cliente_list').append(mitable);
                                }
                            }
                        });
                    }
                });

                // cliente_get
                function cliente_get(id) {
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/cliente/"+id,
                        dataType: "json",
                        success: function (response) {
                            $("input[name='cliente_id']").val(id);
                            $('#micliente').val(id);
                            $('#micliente').text(response.display + ' - ' + response.ci_nit);
                            $('#modal_cliente').modal('hide');
                        }
                    });
                }

                // ADD DISPLAY
                $('#first_name').keyup(function (e) {
                    e.preventDefault();
                    $('#display').val(this.value+' '+$('#last_name').val());
                    $('#email').val(this.value+'.'+$('#last_name').val()+'@loginweb.dev');
                });

                $('#last_name').keyup(function (e) {
                    e.preventDefault();
                    $('#display').val($('#first_name').val()+' '+this.value);
                    $('#email').val($('#first_name').val()+'.'+this.value+'@loginweb.dev');
                });

                function cerrar_caja() {

                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    var total_ventas = $('#total_ventas').val();
                    var importe_inicial = $('#importe_inicial').val();
                    var ingresos = $('#ingresos').val();
                    var egresos = $('#egresos').val();
                    var description = $('#description').val();
                    var _total = $('#_total').val();
                    var cant_ventas = $('#cant_ventas').val();
                    var venta_efectivo = $('#venta_efectivo').val();
                    // var venta_tarjeta = $('#venta_tarjeta').val();
                    // var venta_transferencia = $('#venta_transferencia').val();
                    // var venta_qr = $('#venta_qr').val();
                    // var venta_tigomoney = $('#venta_tigomoney').val();
                    var venta_banipay = $('#venta_banipay').val();
                    var cantidad_efectivo = $('#cantidad_efectivo').val();
                    // var cantidad_tarjeta = $('#cantidad_tarjeta').val();
                    // var cantidad_transferencia = $('#cantidad_transferencia').val();
                    // var cantidad_qr = $('#cantidad_qr').val();
                    // var cantidad_tigomoney = $('#cantidad_tigomoney').val();
                    var cantidad_banipay = $('#cantidad_banipay').val();
                    var efectivo_entregado = $('#efectivo_entregado').val();
                    var cortes = $('#cortes').val();
                    var ingreso_efectivo=$('#ingreso_efectivo').val();
                    var ingreso_linea=$('#ingreso_linea').val();
                    var egreso_efectivo=$('#egreso_efectivo').val();
                    var egreso_linea=$('#egreso_linea').val();
                    var editor_id = '{{ Auth::user()->id }}';
                    var caja_id = micaja.caja_id;
                    var status = 'close';
                    var midata = JSON.stringify({caja_id: caja_id, editor_id: editor_id, cant_ventas: cant_ventas, _total: _total, description: description, egresos: egresos, ingresos: ingresos, importe_inicial: importe_inicial, total_ventas: total_ventas, status: status, venta_efectivo: venta_efectivo, cantidad_efectivo: cantidad_efectivo, venta_banipay:venta_banipay, cantidad_banipay:cantidad_banipay , efectivo_entregado: efectivo_entregado, cortes: cortes, ingreso_efectivo: ingreso_efectivo, ingreso_linea: ingreso_linea, egreso_efectivo: egreso_efectivo, egreso_linea: egreso_linea});
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/caja/detalle/save/"+midata,
                        success: function (response){

                            localStorage.removeItem('micaja');
                            window.open( "{{ setting('admin.url') }}admin/detalle_cajas/imprimir/"+response.id, "Recibo", "width=500,height=700");
                            location.href = '/admin/profile';
                        }
                    });
                }

                async function venta_caja() {
                    $('#productos_caja tbody').empty();
                    var user_id = '{{ Auth::user()->id }}';
                    var misventas = await axios("{{ setting('admin.url') }}api/pos/ventas/caja/"+$("input[name='caja_id']").val()+'/'+user_id);

                    for (let index = 0; index < misventas.data.length; index++) {
                        var banipay = await axios("{{ setting('admin.url') }}api/pos/banipay/get/"+misventas.data[index].id);
                        var milink = "{{ setting('banipay.url_base') }}"+banipay.data.urlTransaction
                        // console.log()
                        if(misventas.data[index].pasarela.id==2){

                            if(misventas.data[index].option_id==3){
                            $("#productos_caja").append("<tr><td>"+misventas.data[index].id+"</td><td>"+misventas.data[index].pasarela.title+"</td><td>"+misventas.data[index].cliente.display+"</td><td>"+misventas.data[index].delivery.name+"</td><td>"+misventas.data[index].chofer.name+"</td><td>"+misventas.data[index].factura+"</td><td>"+misventas.data[index].ticket+"</td><td>"+misventas.data[index].total+"</td><td>"+misventas.data[index].caja_status+"</td><td>"+misventas.data[index].published+"</td><td><a href='#deliverys' aria-controls='deliverys' role='tab' data-toggle='tab' class='btn btn-sm btn-primary' onclick='set_chofer("+misventas.data[index].id+")'>Chofer</a></td></tr>");
                            }
                            else{
                                $("#productos_caja").append("<tr><td>"+misventas.data[index].id+"</td><td>"+misventas.data[index].pasarela.title+"<br><a href='"+milink+"' target='_blank'>Link de Pago</a></td><td>"+misventas.data[index].cliente.display+"</td><td>"+misventas.data[index].delivery.name+"</td><td>"+misventas.data[index].chofer.name+"</td><td>"+misventas.data[index].factura+"</td><td>"+misventas.data[index].ticket+"</td><td>"+misventas.data[index].total+"</td><td>"+misventas.data[index].caja_status+"</td><td>"+misventas.data[index].published+"</td><td></td></tr>");
                            }

                        }
                        else{

                            if(misventas.data[index].option_id==3){
                                $("#productos_caja").append("<tr><td>"+misventas.data[index].id+"</td><td>"+misventas.data[index].pasarela.title+"</td><td>"+misventas.data[index].cliente.display+"</td><td>"+misventas.data[index].delivery.name+"</td><td>"+misventas.data[index].chofer.name+"</td><td>"+misventas.data[index].factura+"</td><td>"+misventas.data[index].ticket+"</td><td>"+misventas.data[index].total+"</td><td>"+misventas.data[index].caja_status+"</td><td>"+misventas.data[index].published+"</td><td><a href='#deliverys' aria-controls='deliverys' role='tab' data-toggle='tab' class='btn btn-sm btn-primary' onclick='set_chofer("+misventas.data[index].id+")'>Chofer</a></td></tr>");
                            }
                            else{
                                $("#productos_caja").append("<tr><td>"+misventas.data[index].id+"</td><td>"+misventas.data[index].pasarela.title+"</td><td>"+misventas.data[index].cliente.display+"</td><td>"+misventas.data[index].delivery.name+"</td><td>"+misventas.data[index].chofer.name+"</td><td>"+misventas.data[index].factura+"</td><td>"+misventas.data[index].ticket+"</td><td>"+misventas.data[index].total+"</td><td>"+misventas.data[index].caja_status+"</td><td>"+misventas.data[index].published+"</td><td></td></tr>");
                            }
                        }
                    }
                }

                async function set_chofer(id){
                    $('#mideliverys').find('option').remove().end();
                    var mideliverys = await axios("{{ setting('admin.url') }}api/pos/users");
                    $('#mideliverys').append($('<option>', {
                        value: null,
                        text: 'Elige un Chofer'
                    }));
                    for (let index = 0; index < mideliverys.data.length; index++) {
                        if(mideliverys.data[index].role_id=="{{setting('ventas.role_id_chofer')}}"){
                            $('#mideliverys').append($('<option>', {
                                value: mideliverys.data[index].id,
                                text: mideliverys.data[index].name
                            }));
                        }
                    }
                    $('#venta_id').val(id);
                }

                async function save_set_chofer() {
                    var chofer_id =  $('#mideliverys').val();
                    var venta_id =  $('#venta_id').val();
                    var save = await axios("{{ setting('admin.url') }}api/pos/chofer/set/"+venta_id+"/"+chofer_id);
                    toastr.success('Chofer Asignado');
                    $('#venta_caja').modal('hide');
                }

                function abrir_caja(id, title, sucursal, sucursal_id) {
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/caja/state/open/"+id,
                        success: function (response){
                            localStorage.setItem('micaja', JSON.stringify({caja_id: id, open: 'open', user_id: '{{ Auth::user()->id  }}', title: title, sucursal: sucursal, importe: $('#importe_'+id).val(), sucursal_id: sucursal_id } ));
                            $("input[name='caja_id']").val(id);
                            var micaja = JSON.parse(localStorage.getItem('micaja'));
                            $("input[name='caja_id']").val(micaja.caja_id);
                            $("input[name='sucursal_id']").val(micaja.sucursal_id);

                            $("#info_caja").html("<h4>"+micaja.title+" - "+micaja.sucursal+" - "+micaja.importe+" Bs. - <a href='#' onclick='reset()'>Reset</a></h4>");
                            toastr.success('Caja Abierta Correctamente.');
                            $('#micaja').modal('hide');

                        }
                    });
                }

                // cliente
                 $('#micliente').on('change', function() {
                    $('input[name="cliente_id"]').val(this.value);
                    toastr.success('Cambio de Cliente');
                });

                $('#midelivery').on('change', function() {
                    $("input[name='delivery_id']").val(this.value);
                    toastr.success('Cambio de Delivery');
                });

                $('#mipagos').on('change', function() {
                    $("input[name='pago_id']").val(this.value);
                    toastr.success('Cambio de Pasarela');
                });

                $('#micupon').on('change', function() {
                    $("input[name='cupon_id']").val(this.value);
                });

                $('#venta_type').on('change', function() {
                    $("input[name='option_id']").val(this.value);
                    toastr.success('Cambio Tipo');
                });

                //save cliente
                function savecliente() {
                    var first = $('#first_name').val();
                    var last = $('#last_name').val();
                    var phone = $('#phone').val();
                    var nit = $('#nit').val();
                    var display = $('#display').val();
                    var email = $('#email').val();
                    var midata = JSON.stringify({first_name: first, last_name: last, phone: phone, nit: nit, display: display, email: email});
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/savacliente/"+midata,
                        success: function (response){
                            toastr.success('Cliente Creado');
                            $('#micliente').append($('<option>', {
                                value: response.id,
                                text: response.display,
                                selected: true
                            }));
                            $("input[name='cliente_id']").val(response.id);
                            $('#modal_cliente').modal('hide');
                        }
                    });
                }

                $('#micupon').on('change', function() {
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/cupon/"+this.value,
                        dataType: "json",
                        success: function (response) {
                            toastr.success('Cupon Asignado');
                            $("input[name='descuento']").val(response.valor);
                            mitotal();
                        }
                    });
                });

                $('#miestado').on('change', function() {
                    $("input[name='status_id']").val(this.value);
                    mitotal();
                });

                async function saveventas() {
                    var micart = JSON.parse(localStorage.getItem('micart'));
                    if (micart.length == 0 ) {
                        toastr.error('Tu Carrito esta Vacio');
                    }
                    else{
                        var cliente_id = $("input[name='cliente_id']").val();
                        var cupon_id = $("input[name='cupon_id']").val();
                        var pago_id = $("input[name='pago_id']").val();
                        var status_id = $("input[name='status_id']").val();
                        var option_id = $("input[name='option_id']").val();
                        var factura = $("input[name='factura']:checked").val();
                        var credito = $("input[name='credito']:checked").val();
                        var total = $("input[name='total']").val();
                        var descuento = $("input[name='descuento']").val();
                        var observacion = $("input[name='observacion']").val();
                        var register_id = $("input[name='register_id']").val();
                        var caja_id = $("input[name='caja_id']").val();
                        var delivery_id = $("input[name='delivery_id']").val();
                        var sucursal_id = $("input[name='sucursal_id']").val();
                        var subtotal = $("input[name='subtotal']").val();
                        var recibido = $("input[name='recibido']").val();
                        var cambio = $("input[name='cambio']").val();
                        var chofer_id=$("input[name='chofer_id']").val();
                        var adicional=$("input[name='adicional']").val();
                        var pensionado_id=$("input[name='pensionado_id']").val();
                        var micart = JSON.parse(localStorage.getItem('micart'));
                        var midata = JSON.stringify({'cliente_id': cliente_id, 'cupon_id': cupon_id, 'option_id': option_id, 'pago_id': pago_id, 'factura': factura, 'credito': credito ,'total': total, 'descuento': descuento, 'observacion': observacion, 'register_id': register_id, 'status_id': status_id, 'caja_id': caja_id, 'delivery_id': delivery_id, 'sucursal_id': sucursal_id, subtotal: subtotal, 'cantidad': micart.length, 'recibido': recibido, 'cambio': cambio, chofer_id : chofer_id, adicional:adicional, 'pensionado_id':pensionado_id });

                        // console.log($('#mipagos').val())
                        switch ($('#mipagos').val()) {
                            case '1':
                                var venta = await axios.get("{{ setting('admin.url') }}api/pos/ventas/save/"+midata)
                                    // console.log(venta.data)
                                for (let index = 0; index < micart.length; index++) {
                                    var midata2 = JSON.stringify({'producto_id': micart[index].id, 'venta_id': venta.data.id, 'precio': micart[index].precio, 'cantidad': micart[index].cant, 'total': micart[index].total, 'name':micart[index].name, 'foto':micart[index].foto, 'description': micart[index].description, 'extra_name':micart[index].extra_name, 'observacion':micart[index].observacion});
                                    var venta_detalle = axios.get("{{ setting('admin.url') }}api/pos/ventas/save/detalle/"+midata2)
                                    $("#micart tr#"+micart[index].id).remove();
                                    mitotal();
                                }
                                break;
                            case '2':
                                var venta = await axios.get("{{ setting('admin.url') }}api/pos/ventas/save/"+midata)
                                for (let index = 0; index < micart.length; index++) {
                                    var midata2 = JSON.stringify({'producto_id': micart[index].id, 'venta_id': venta.data.id, 'precio': micart[index].precio, 'cantidad': micart[index].cant, 'total': micart[index].total, 'name':micart[index].name, 'foto':micart[index].foto, 'description': micart[index].description, 'extra_name':micart[index].extra_name, 'observacion':micart[index].observacion});
                                    var venta_detalle = await axios.get("{{ setting('admin.url') }}api/pos/ventas/save/detalle/"+midata2)
                                    $("#micart tr#"+micart[index].id).remove();
                                    mitotal();
                                }
                                // BANIPAY
                                var micart2 = []
                                for (let index = 0; index < micart.length; index++) {
                                    micart2.push({"concept": micart[index].name, "quantity": micart[index].cant, "unitPrice": micart[index].precio})
                                }
                                var miconfig = {"affiliateCode": "{{ setting('banipay.affiliatecode') }}",
                                    "notificationUrl": "{{ setting('banipay.notificacion') }}",
                                    "withInvoice": false,
                                    "externalCode": venta.data.id,
                                    "paymentDescription": "Pago por la compra en {{ setting('admin.title') }}",
                                    "details": micart2,
                                    "postalCode": "{{ setting('banipay.moneda') }}"
                                    }
                                var banipay = await axios.post('https://banipay.me:8443/api/payments/transaction', miconfig)
                                var midata3 = JSON.stringify({paymentId: banipay.data.paymentId, transactionGenerated: banipay.data.transactionGenerated, externalCode: banipay.data.externalCode})
                                console.log(banipay.data)
                                await axios.get("{{ setting('admin.url') }}api/pos/banipay/save/"+midata3)
                                break;
                            default:
                                console.log('default')
                                break;
                        }

                        if ($("input[name='season']:checked").val() == 'imprimir') {
                            $("input[name='descuento']").val(0)
                            localStorage.setItem('micart', JSON.stringify([]));
                            window.open( "{{ setting('admin.url') }}admin/ventas/imprimir/"+venta.data.id, "Recibo", "width=500,height=700");
                        }else{
                            localStorage.setItem('micart', JSON.stringify([]));
                            toastr.success('Venta Realizada');
                        }
                    }
                }

                $('#category').on('change', function() {
                    if (+this.value == 0) {
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/productos/",
                            dataType: "json",
                            success: function (response) {
                                $('#s').find('option').remove().end();
                                $('#s').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Producto'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    $('#s').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].abreviatura+'-'+response[index].name+'-'+response[index].precio+'-'+response[index].stock
                                    }));
                                }
                            }
                        });
                        toastr.success('Todos los Productos');
                    } else {
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/productos/category/"+this.value,
                            dataType: "json",
                            success: function (response) {
                                $('#s').find('option').remove().end();
                                $('#s').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Producto'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#s').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].categoria.abreviatura+'-'+response[index].name+'-'+response[index].precio+'-'+response[index].stock
                                    }));
                                }
                            }
                        });
                    }

                });

                function mitotal() {

                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var cant = milist.length;
                    var des = $("input[name='descuento']").val();
                    var total = 0;
                    var adicional=parseFloat($("input[name='adicional']").val());
                    for (let index = 0; index < milist.length; index++) {
                        total = total + milist[index].total;
                    }

                    $("input[name='subtotal']").val(parseFloat(total).toFixed(2));
                    $("input[name='total']").val(parseFloat(total+adicional-des).toFixed(2));
                    $("input[name='cantidad']").val(cant);
                }

                $('#s').on('change', function() {
                    addproduct(this.value);
                });

                $("input[name='adicional']").on('change', function() {
                    mitotal();
                });
                $("input[name='adicional']").keyup(function(){
                    mitotal();
                });

                function addproduct(id) {
                    var total = 0;
                    var micart = JSON.parse(localStorage.getItem('micart'));
                    $("#micart tr#0").remove();
                    var mirep = false;
                    for (let index = 0; index < micart.length; index++) {
                        if(micart[index].id == id){
                            mirep = true;
                            break;
                        }
                    }
                    if(mirep){
                        toastr.error("Producto ya Registrado");
                    }else{
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/producto/"+id,
                            dataType: "json",
                            success: function (response) {
                                var miimage =response.image ? response.image : "{{ setting('productos.imagen_default') }}"
                                var producto_aux=response;
                                if('{{setting('ventas.stock')}}'){
                                    if (response.mixta == 1 ) {
                                        $('#mixtos').attr("hidden",false);
                                        var micategory = $('#category').val();
                                        $.ajax({
                                            url: "{{ setting('admin.url') }}api/pos/producto/mixto/0/"+micategory,
                                            dataType: "json",
                                            success: function (response) {
                                                $('#mixta1').append($('<option>', {
                                                    value: null,
                                                    text: 'Elige un Mitad'
                                                }));
                                                for (let index = 0; index < response.length; index++) {
                                                    $('#mixta1').append($('<option>', {
                                                        value: response[index].id,
                                                        text: response[index].name
                                                    }));
                                                }
                                                $('#mixta2').append($('<option>', {
                                                    value: null,
                                                    text: 'Elige un Mitad'
                                                }));
                                                for (let index = 0; index < response.length; index++) {
                                                    $('#mixta2').append($('<option>', {
                                                        value: response[index].id,
                                                         //text: response[index].name + ' '+ response[index].precio + ' Bs.'
                                                         text: response[index].name
                                                    }));
                                                }
                                            }
                                        });
                                    } else {
                                        $('#mixtos').attr("hidden",true);
                                        if(response.stock >= 1){
                                            if(response.stock <= '{{setting('ventas.minimo_stock')}}')
                                            {
                                                toastr.error("Solo quedan: "+response.stock+" "+response.name +" ");
                                            }
                                            var description=null;
                                            if(response.extra){
                                                $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+miimage+"></td><td>"+response.name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+response.id+")' id='observacion_"+response.id+"'></td><td><a href='#' class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras' onclick='addextra("+response.extras+", "+response.id+")'><i class='voyager-plus'></i></a></td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' onchange='updateprice("+response.id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' min='1' max='"+response.stock+"' id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                            }
                                            else{
                                                $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+miimage+"></td><td>"+response.name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+response.id+")' id='observacion_"+response.id+"'></td><td></td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' onchange='updateprice("+response.id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' min='1' max='"+response.stock+"' id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                            }
                                            var temp = {'id': response.id, 'image': miimage, 'name': response.name, 'precio': response.precio, 'precio_inicial':response.precio, 'cant': 1, 'total': response.precio, 'description': '', 'extra':response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':''};
                                            micart.push(temp);
                                            localStorage.setItem('micart', JSON.stringify(micart));
                                            mitotal();
                                            toastr.success(response.name+" - REGISTRADO");

                                        }
                                        else{
                                            toastr.error("No existe el producto: "+response.name +" en Stock");
                                        }
                                    }
                                } else {
                                    if (response.mixta == 1 ) {
                                        $('#mixtos').attr("hidden",false);
                                        var micategory = $('#category').val();
                                        $.ajax({
                                            url: "{{ setting('admin.url') }}api/pos/producto/mixto/0/"+micategory,
                                            dataType: "json",
                                            success: function (response) {
                                                $('#mixta1').append($('<option>', {
                                                    value: null,
                                                    text: 'Elige un Mitad'
                                                }));
                                                for (let index = 0; index < response.length; index++) {
                                                    $('#mixta1').append($('<option>', {
                                                        value: response[index].id,
                                                         //text: response[index].name + ' '+ response[index].precio + ' Bs.'
                                                         text: response[index].name
                                                    }));
                                                }
                                                $('#mixta2').append($('<option>', {
                                                    value: null,
                                                    text: 'Elige un Mitad'
                                                }));
                                                for (let index = 0; index < response.length; index++) {
                                                    $('#mixta2').append($('<option>', {
                                                        value: response[index].id,
                                                         //text: response[index].name + ' '+ response[index].precio + ' Bs.'
                                                         text: response[index].name
                                                    }));
                                                }
                                            }
                                        });
                                    } else {
                                        $('#mixtos').attr("hidden",true);
                                        var description=null;
                                        if(response.extra){
                                            $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+miimage+"></td><td>"+response.name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+response.id+")' id='observacion_"+response.id+"'></td><td><a href='#' class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras' onclick='addextra("+response.extras+","+response.id+")'><i class='voyager-plus'></i></a></td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' onchange='updateprice("+response.id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' min='1'  id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                                        }else{
                                            $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+miimage+"></td><td>"+response.name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+response.id+")' id='observacion_"+response.id+"'></td><td></td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' onchange='updateprice("+response.id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' min='1'  id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                        }
                                        var temp = {'id': response.id, 'image': miimage, 'name': response.name, 'precio': response.precio, 'precio_inicial':response.precio, 'cant': 1, 'total': response.precio, 'description': '', 'extra':response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':''};
                                        micart.push(temp);
                                        localStorage.setItem('micart', JSON.stringify(micart));
                                        mitotal();
                                        toastr.success(response.name+" - REGISTRADO");
                                    }
                                }
                            }
                        });
                    }
                }

                function midelete(id) {
                    $("#micart tr#"+id).remove();

                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {
                            toastr.info(milist[index].name+" - ELIMINADO");
                        } else {
                            var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'precio_inicial':milist[index].precio_inicial, 'cant': milist[index].cant, 'total': milist[index].total, 'description': milist[index].description, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion };
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('micart', JSON.stringify(newlist));
                    mitotal();

                }

                async function updatecant(id) {

                    //  GET GESTION INVENTARIO
                    var cant_actual = 0;
                    var inventario = false;
                    if('{{setting('ventas.stock')}}'){
                        var response = await axios("{{ setting('admin.url') }}api/pos/producto/"+id);
                        cant_actual = response.data.stock;
                        inventario = true;
                    }
                    var total = parseFloat($("#precio_"+id).val()).toFixed(2) * parseInt($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {
                            if(inventario){
                                if (milist[index].cant > cant_actual ) {
                                    toastr.error('Cantidad Excedida')
                                } else {
                                    var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': parseFloat($("#precio_"+id).val()).toFixed(2), 'precio_inicial':parseFloat($("#precio_"+id).val()).toFixed(2) , 'cant': parseInt($("#cant_"+id).val()), 'total': total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                                    newlist.push(temp);
                                }
                            }else{
                                var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description ,'precio': parseFloat($("#precio_"+id).val()).toFixed(2), 'precio_inicial':parseFloat($("#precio_"+id).val()).toFixed(2) , 'cant': parseInt($("#cant_"+id).val()), 'total': total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                                newlist.push(temp);
                            }
                        }else{
                            var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description ,'precio': milist[index].precio, 'precio_inicial':milist[index].precio_inicial , 'cant': milist[index].cant, 'total': milist[index].total,  'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('micart', JSON.stringify(newlist));
                    mitotal();
                }

                async function updateprice(id) {


                    updatecant(id);
                    // var milist = JSON.parse(localStorage.getItem('micart'));
                    // var newlist = [];
                    // for (let index = 0; index < milist.length; index++) {
                    //     if (milist[index].id == id) {

                    //         var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description ,'precio': parseInt($("#precio_"+id).val()), 'cant': milist[index].cant, 'total': milist[index].precio * milist[index].cant};
                    //         newlist.push(temp);

                    //     }else{
                    //         var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio, 'cant': milist[index].cant, 'total': milist[index].precio, 'total':  milist[index].total};
                    //         newlist.push(temp);
                    //     }
                    // }


                    // localStorage.setItem('micart', JSON.stringify(newlist));
                    // var milist = JSON.parse(localStorage.getItem('micart'));
                    // var total = parseFloat(milist[id].precio).toFixed(2) * parseInt(milist[id].cant);
                    // $("#total_"+id).val(parseFloat(total).toFixed(2));
                    //mitotal();
                }


                function micart(){
                    $("#micart tbody tr").remove();
                    var milist = JSON.parse(localStorage.getItem('micart'));
                        if(milist.length == 0){
                            $("#micart").append("<tr id=0><td colspan='4'> <img class='img-responsive img-sm' src={{ setting('admin.url') }}storage/231-2317260_an-empty-shopping-cart-viewed-from-the-side.png></td></tr>");
                        }else{
                            for (let index = 0; index < milist.length; index++) {
                                if(milist[index].extra){
                                    $("#micart").append("<tr id="+milist[index].id+"><td>"+milist[index].id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+milist[index].image+"></td><td>"+milist[index].name+"<br>"+milist[index].description+"<br>"+milist[index].extra_name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+milist[index].id+")' value='"+milist[index].observacion+"' id='observacion_"+milist[index].id+"'></td><td><a href='#' class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras' onclick='addextra("+milist[index].extras+", "+milist[index].id+")'><i class='voyager-plus'></i></a></td><td><input class='form-control' type='number' value='"+milist[index].precio+"' id='precio_"+milist[index].id+"' onchange='updateprice("+milist[index].id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+milist[index].id+")' value='"+milist[index].cant+"' id='cant_"+milist[index].id+"'></td><td><input class='form-control' type='number' value='"+milist[index].total+"' id='total_"+milist[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+milist[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                }
                                else{
                                     $("#micart").append("<tr id="+milist[index].id+"><td>"+milist[index].id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+milist[index].image+"></td><td>"+milist[index].name+"<br>"+milist[index].description+"<br>"+milist[index].extra_name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+milist[index].id+")' value='"+milist[index].observacion+"' id='observacion_"+milist[index].id+"'></td><td></td><td><input class='form-control' type='number' value='"+milist[index].precio+"' id='precio_"+milist[index].id+"' onchange='updateprice("+milist[index].id+")'></td><td><input class='form-control' type='number' onclick='updatecant("+milist[index].id+")' value='"+milist[index].cant+"' id='cant_"+milist[index].id+"'></td><td><input class='form-control' type='number' value='"+milist[index].total+"' id='total_"+milist[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+milist[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                }
                            }
                            mitotal();
                        }
                }
            </script>
        @stop
    @break
    @case('productions')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>

                //  AL CARGAR LA VISTA
                $('document').ready(async function () {

                    $('.js-example-basic-single').select2();
                    $('input[name="user_id"]').val('{{ Auth::user()->id }}');

                    // PRODUCTOS PRE ELABORADO
                    InsumosSemi();
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/productosemi",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#prod_semi').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Pre Elaborado'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             $('#prod_semi').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //         }
                    //     }
                    // });

                    // PRODUCTOS PARA PRODUCCION
                    ProductosProduction();
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/productos/production",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#new_producto_id').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Producto'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             $('#new_producto_id').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //         }
                    //     }
                    // });

                    // CARGADO DE SESSION INSUMOS
                    if (localStorage.getItem('miproduction')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miproduction'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miproduction").append("<tr id="+milistProduction[index].cod+"><td>"+milistProduction[index].cod+"</td><td>"+milistProduction[index].type+"</td><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' min='1' onclick='updatemiproduction("+milistProduction[index].id+")' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' min='1' onclick='updatemiproduction("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+milistProduction[index].cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            mitotal2();
                        }
                    } else {
                        localStorage.setItem('miproduction', JSON.stringify([]));
                    }

                    //Crear variable miprodsemi
                    if (localStorage.getItem('miprodsemi')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miprodsemi'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miprodsemi").append("<tr id="+milistProduction[index].id+"><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproductionsemi("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+milistProduction[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            mitotal3();
                        }
                    } else {
                        localStorage.setItem('miprodsemi', JSON.stringify([]));
                    }

                    // TODOS LOS INSUMOS


                    insumos();

                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/insumos",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#insumos').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Insumo'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             const element = response[index];
                    //             $('#insumos').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //         }
                    //     }
                    // });

                    //-------------------
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/unidades",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#unidades').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige una Unidad'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             const element = response[index];
                    //             $('#unidades').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].title
                    //             }));
                    //         }
                    //     }
                    // });


                    // TODOS LOS INSUMOS SEMI

                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/insumos",
                            dataType: "json",
                            success: function (response) {
                                $('#insumossemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Insumo'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#insumossemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                            }
                        });

                    Unidades();

                    //--------------------------------
                    // $.ajax({
                    //         url: "{{ setting('admin.url') }}api/pos/unidades",
                    //         dataType: "json",
                    //         success: function (response) {
                    //             $('#unidadessemi').append($('<option>', {
                    //                 value: null,
                    //                 text: 'Elige una Unidad'
                    //             }));
                    //             for (let index = 0; index < response.length; index++) {
                    //                 const element = response[index];
                    //                 $('#unidadessemi').append($('<option>', {
                    //                     value: response[index].id,
                    //                     text: response[index].title
                    //                 }));
                    //             }
                    //         }
                    //     });

                    //PROVEDORES
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/proveedores",
                        dataType: "json",
                        success: function (response) {
                            // $('#proveedorelab').append($('<option>', {
                            //     value: null,
                            //     text: 'Elige un Proveedor'
                            // }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#proveedorelab').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });

                    //--------------
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/proveedores",
                            dataType: "json",
                            success: function (response) {
                                $('#proveedorsemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Proveedor'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#proveedorsemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                            }
                        });

                });

                async function InsumosSemi(){
                    var table = await axios.get("{{ setting('admin.url') }}api/pos/productosemi");

                    $('#prod_semi').append($('<option>', {
                        value: null,
                        text: 'Elige un Pre Elaborado'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#prod_semi').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }

                }

                async function ProductosProduction(){
                    var table = await axios.get("{{ setting('admin.url') }}api/pos/productos/production");

                     $('#new_producto_id').append($('<option>', {
                        value: null,
                        text: 'Elige un Producto'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#new_producto_id').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                // async function unidad_name(id){
                //        var table= await axios("{{ setting('admin.url') }}api/pos/unidades/"+id);
                //        var unidad= table.data.name
                //        var prueba=1;
                //        console.log(prueba);
                //        return prueba;
                //     }

                async function insumos(){

                    var insumo=await axios("{{ setting('admin.url') }}api/pos/insumos");
                    //var unidad= await axios("{{ setting('admin.url') }}api/pos/unidades/"+id);

                    $('#insumos').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < insumo.data.length; index++) {
                        const element = insumo.data[index];
                        $('#insumos').append($('<option>', {
                            value: insumo.data[index].id,
                            //text: unidad_name(insumo.data[index].unidad_id) + ' de '+ insumo.data[index].name
                            //console.log(unidad_name(insumo.data[index].unidad_id));
                            text:insumo.data[index].name
                        }));
                    }

                }

                // ADD INSUMO PRE ELEBORADO
                $('#prod_semi').on('change', function() {

                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var mirep = false;
                    var thisvalue = this.options[this.selectedIndex].text;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].name == thisvalue){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {
                        toastr.warning(thisvalue+ 'Elaborado Repetido');
                    }else{
                        // var idpro = $('#proveedorelab').val();
                        // var miprotext = $('#proveedorelab option:selected').text();
                        AgregarInsumoPre(this.value);
                        // $.ajax({
                        //     url: "{{ setting('admin.url') }}api/pos/productopreid/"+this.value,
                        //     dataType: "json",
                        //     success: function (jchavez) {
                        //         var cod = Math.floor(Math.random() * 999) + 800;

                        //         $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>elaborado</td><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        //         var temp = {'cod': cod, 'type': 'elaborado', 'idpro' :idpro,'id': jchavez.id, 'name': jchavez.name, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                        //         miproduction.push(temp);
                        //         localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        //         mitotal2();
                        //         toastr.success('Agreado Insumo: '+jchavez.name);
                        //     }
                        // });
                    }
                });
                async function AgregarInsumoPre(id){
                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));

                    var idpro = $('#proveedorelab').val();
                    var miprotext = $('#proveedorelab option:selected').text();

                    var jchavez= await axios.get("{{ setting('admin.url') }}api/pos/productopreid/"+id);
                    var cod = Math.floor(Math.random() * 999) + 800;

                    if('{{setting('ventas.stock')}}'){
                        if(jchavez.data.stock>=1){

                        $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>elaborado</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' max='"+jchavez.data.stock+"' onclick='updatemiproduction("+jchavez.data.id+")' value='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        var temp = {'cod': cod, 'type': 'elaborado', 'idpro' :idpro,'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                        miproduction.push(temp);
                        localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        mitotal2();
                        toastr.success('Agreado Insumo: '+jchavez.data.name);
                        }
                        else{
                            toastr.error("No existe el producto: "+jchavez.data.name +" en Stock");
                        }
                    }
                    else{
                        $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>elaborado</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.data.id+")' value='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        var temp = {'cod': cod, 'type': 'elaborado', 'idpro' :idpro,'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                        miproduction.push(temp);
                        localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        mitotal2();
                        toastr.success('Agreado Insumo: '+jchavez.data.name);
                    }
                }

                $('#new_producto_id').on('change', function() {
                    $("input[name='producto_id']").val(this.value);
                    toastr.success('Producto Establecido');
                });

                function mitotal2() {
                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var total = 0
                    for (let index = 0; index < miproduction.length; index++) {
                        total = total + miproduction[index].total;
                    }
                    $("input[name='valor']").val(parseFloat(total).toFixed(2));
                }
                function mitotal3() {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var total = 0
                    for (let index = 0; index < miproduction.length; index++) {
                        total = total + miproduction[index].total;
                    }
                    $("input[name='valor']").val(parseFloat(total).toFixed(2));
                }

                async function Unidades(){
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/unidades");

                    $('#unidades').append($('<option>', {
                        value: null,
                        text: 'Elige una Unidad'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#unidades').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                    }

                }

                $('#unidades').on('change', function() {
                    InsumosPorUnidad(this.value);
                    // $.ajax({
                    //     type: "get",
                    //     url: "{{ setting('admin.url') }}api/pos/insumo/unidad/"+this.value,
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#insumos').find('option').remove().end();
                    //         $('#insumos').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Insumo'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             const element = response[index];
                    //             $('#insumos').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //         }
                    //     }
                    // });
                });

                async function InsumosPorUnidad(id){

                    var table= await axios.get("{{ setting('admin.url') }}api/pos/insumo/unidad/"+id);
                    $('#insumos').find('option').remove().end();
                    $('#insumos').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#insumos').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                $('#unidadessemi').on('change', function() {
                    InsumosPorUnidadSemi(this.value);
                    // $.ajax({
                    //     type: "get",
                    //     url: "{{ setting('admin.url') }}api/pos/insumo/unidad/"+this.value,
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#insumossemi').find('option').remove().end();
                    //         $('#insumossemi').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Insumo'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {
                    //             const element = response[index];
                    //             $('#insumossemi').append($('<option>', {
                    //                 value: response[index].id,
                    //                 text: response[index].name
                    //             }));
                    //         }
                    //     }
                    // });
                });

                async function InsumosPorUnidadSemi(id){
                    var table = await axios.get("{{ setting('admin.url') }}api/pos/insumo/unidad/"+id);
                    $('#insumossemi').find('option').remove().end();
                    $('#insumossemi').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#insumossemi').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }

                }

                // ADD INSUMO SIMPLE
                $('#insumos').on('change', function() {

                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var mirep = false;
                    var thisvalue = this.options[this.selectedIndex].text;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].name == thisvalue){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {
                        toastr.warning('Insumo Repetido');
                    }else{
                        // var idpro = $('#proveedorelab').val();
                        // var miprotext = $('#proveedorelab option:selected').text();
                        AgregarInsumoSimple(this.value);
                        // $.ajax({
                        //     url: "{{ setting('admin.url') }}api/pos/insumos/"+this.value,
                        //     dataType: "json",
                        //     success: function (jchavez) {
                        //         var cod = Math.floor(Math.random() * 999) + 800;

                        //         $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>simple</td><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.id+")' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.id+")' value='1' min='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");



                        //         var temp = {'cod': cod, 'type': 'simple', 'idpro' :idpro, 'id': jchavez.id, 'name': jchavez.name, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                        //         miproduction.push(temp);
                        //         localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        //         mitotal2();
                        //         toastr.success('Agreado Insumo: '+thisvalue);
                        //     }
                        // });
                    }
                });

                async function AgregarInsumoSimple(id){
                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));

                    var idpro = $('#proveedorelab').val();
                    var miprotext = $('#proveedorelab option:selected').text();

                    var jchavez= await axios.get("{{ setting('admin.url') }}api/pos/insumos/"+id);
                    var cod = Math.floor(Math.random() * 999) + 800;

                    if('{{setting('ventas.stock')}}'){
                        if(jchavez.data.stock>=1){

                            $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>simple</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproduction("+jchavez.data.id+")' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' max='"+jchavez.data.stock+"' type='number' onclick='updatemiproduction("+jchavez.data.id+")' value='1' min='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' min='0' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                            var temp = {'cod': cod, 'type': 'simple', 'idpro' :idpro, 'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                            miproduction.push(temp);
                            localStorage.setItem('miproduction', JSON.stringify(miproduction));
                            mitotal2();
                            toastr.success('Agregado Insumo: '+jchavez.data.name);
                        }
                        else{
                            toastr.error("No existe el producto: "+jchavez.data.name +" en Stock");

                        }
                    }
                    else{
                        $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>simple</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproduction("+jchavez.data.id+")' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.data.id+")' value='1' min='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' min='0' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        var temp = {'cod': cod, 'type': 'simple', 'idpro' :idpro, 'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                        miproduction.push(temp);
                        localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        mitotal2();
                        toastr.success('Agregado Insumo: '+jchavez.data.name);
                    }
                }

                $('#insumossemi').on('change', function() {
                    addinsumosemi(this.value);
                });

                function addinsumosemi(id) {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var mirep = false;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].id == id){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {

                    }else{
                        // var mipro = $('#proveedorsemi').val();
                        // var miprotext = $('#proveedorsemi option:selected').text();
                        AgregarInsumoSimpleSemi(id);
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/insumos/"+id,
                    //     dataType: "json",
                    //     success: function (jchavez) {


                    //         $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.id+")' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproductionsemi("+jchavez.id+")' value='1' min='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");


                    //         var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                    //         miproduction.push(temp);
                    //         localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                    //         mitotal3();
                    //         }
                    //     });
                    }
                }

                async function AgregarInsumoSimpleSemi(id){

                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));

                    var mipro = $('#proveedorsemi').val();
                    var miprotext = $('#proveedorsemi option:selected').text();

                    var jchavez= await axios.get("{{ setting('admin.url') }}api/pos/insumos/"+id);

                    $("#miprodsemi").append("<tr id="+jchavez.data.id+"><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' min='0' type='number' onclick='updatemiproductionsemi("+jchavez.data.id+")' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' min='1' onclick='updatemiproductionsemi("+jchavez.data.id+")' value='1' min='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' type='number' min='0' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.data.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");


                    var temp = {'id': jchavez.data.id, 'name': jchavez.data.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                    miproduction.push(temp);
                    localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                    mitotal3();
                }

                // DELETE FROM PRODUCTION
                function mideleteInsumo(id) {
                    // console.log(id);

                    $("#miproduction tr#"+id).remove();
                    var milist = JSON.parse(localStorage.getItem('miproduction'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].cod == id) {
                            toastr.success(milist[index].name+' eliminado');
                        } else {
                            var temp = {'cod': milist[index].cod, 'type': milist[index].type, 'idpro' :milist[index].idpro, 'id': milist[index].id, 'name': milist[index].name, 'proveedor_text': milist[index].proveedor_text, 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miproduction', JSON.stringify(newlist));
                    mitotal2();
                }

                function mideleteInsumosemi(id) {
                    $("#miprodsemi tr#"+id).remove();
                    var milist = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {

                        } else {
                            var temp = {'id': milist[index].id, 'name': milist[index].name,'proveedor':milist[index].proveedor, 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                function updatemiproduction(id) {

                    var total = parseFloat($("#costo_"+id).val()).toFixed(2) * parseFloat($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var newlist = [];
                    for (let index = 0; index < miproduction.length; index++) {
                        if (miproduction[index].id == id) {
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name, 'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miproduction', JSON.stringify(newlist));
                    mitotal2();

                }

                function updatemiproductionsemi(id) {

                    var total = parseFloat($("#costo_"+id).val()).toFixed(2) * parseFloat($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < miproduction.length; index++) {
                        if (miproduction[index].id == id) {
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                //SAVE PRODUCCION
                function saveproductions() {

                    var producto_id = $("input[name='producto_id']").val();
                    var cantidad = $("input[name='cantidad']").val();
                    var valor = $("input[name='valor']").val();
                    var description = $("textarea[name='description']").val();
                    var user_id = $("input[name='user_id']").val();

                    var midata = JSON.stringify({'producto_id': producto_id, 'cantidad': cantidad, 'valor': valor, 'description': description, 'user_id': user_id });
                    var urli = "{{ setting('admin.url') }}api/pos/productions/save/"+midata;
                    //var urli=0;
                    $.ajax({
                        url: urli,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                            for (let index = 0; index < miproduction.length; index++) {
                                console.log(miproduction[index].type);
                                var midata = JSON.stringify({'type': miproduction[index].type, 'production_id': response, 'insumo_id': miproduction[index].id, 'proveedor_id': miproduction[index].idpro, 'precio': miproduction[index].costo, 'cantidad': miproduction[index].cant, 'total': miproduction[index].total});
                                var urli = "{{ setting('admin.url') }}api/pos/productions/save/detalle/"+midata;
                                $.ajax({
                                    url: urli,
                                    success: function () {
                                        $("#miproduction tr#"+ miproduction[index].cod).remove();
                                        mitotal2();
                                    }
                                });

                            }
                            localStorage.setItem('miproduction', JSON.stringify([]));
                            // location.reload();
                            $('#modal_save_prod').modal('hide');

                        }
                    });

                    toastr.success('Producion Registrada');
                }

                function saveproductionssemi() {

                    var producto_semi_id = $("select[name='producto_semi_id']").val();
                    var cantidad = $("input[name='cantidad']").val();
                    var valor = $("input[name='valor']").val();
                    var description = $("textarea[name='description']").val();
                    var user_id = $("input[name='user_id']").val();

                    var midata = JSON.stringify({'producto_semi_id': producto_semi_id, 'cantidad': cantidad, 'valor': valor, 'description': description, 'user_id': user_id });
                    // console.log(midata)
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/productions/savesemi/"+midata,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));

                            for (let index = 0; index < miproduction.length; index++) {

                                var midata = JSON.stringify({'production_semi_id': response, 'insumo_id': miproduction[index].id, 'proveedor_id': miproduction[index].proveedor, 'precio': miproduction[index].costo, 'cantidad': miproduction[index].cant, 'total': miproduction[index].total});

                                $.ajax({
                                    url: "{{ setting('admin.url') }}api/pos/productions/savesemi/detalle/"+midata,
                                    success: function () {

                                    }
                                });
                            }
                            localStorage.setItem('miprodsemi', JSON.stringify([]));
                            location.href='{{ setting('admin.url') }}admin/production-semis';
                        }
                    });


                }
            </script>
        @stop
    @break
    @case('production-semis')
        @section('javascript')
            <script>
                // LOAD VIEW
                $('document').ready(function () {

                    $('.js-example-basic-single').select2();
                    $('input[name="user_id"]').val('{{ Auth::user()->id }}');


                    //Crear variable miprodsemi
                    if (localStorage.getItem('miprodsemi')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miprodsemi'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miprodsemi").append("<tr id="+milistProduction[index].id+"><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' min='0' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' min='1' onclick='updatemiproductionsemi("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' min='0' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+milistProduction[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            mitotal3();
                        }
                    } else {
                        localStorage.setItem('miprodsemi', JSON.stringify([]));
                    }


                    // TODOS LOS INSUMOS SEMI
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/insumos",
                            dataType: "json",
                            success: function (response) {
                                $('#insumossemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Insumo'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#insumossemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                            }
                        });

                    //--------------------------------
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/unidades",
                            dataType: "json",
                            success: function (response) {
                                $('#unidadessemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige una Unidad'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#unidadessemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].title
                                    }));
                                }
                            }
                        });

                    //--------------
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/proveedores",
                            dataType: "json",
                            success: function (response) {
                                $('#proveedorsemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Proveedor'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#proveedorsemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                            }
                        });

                });


                // FUNCIONES

                $('#unidadessemi').on('change', function() {
                    $.ajax({
                        type: "get",
                        url: "{{ setting('admin.url') }}api/pos/insumo/unidad/"+this.value,
                        dataType: "json",
                        success: function (response) {
                            $('#insumossemi').find('option').remove().end();
                            $('#insumossemi').append($('<option>', {
                                value: null,
                                text: 'Elige un Insumo'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#insumossemi').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });
                });

                function mitotal3() {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var total = 0
                    for (let index = 0; index < miproduction.length; index++) {
                        total = total + miproduction[index].total;
                    }
                    $("input[name='valor']").val(parseFloat(total).toFixed(2));
                }


                //Agregar

                $('#insumossemi').on('change', function() {
                    addinsumosemi(this.value);
                });

                function addinsumosemi(id) {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var mirep = false;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].id == id){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {

                    }else{
                        var mipro = $('#proveedorsemi').val();
                        var miprotext = $('#proveedorsemi option:selected').text();
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/insumos/"+id,
                        dataType: "json",
                        success: function (jchavez) {



                            if('{{setting('ventas.stock')}}'){
                                if(jchavez.stock>=1){
                                    $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproductionsemi("+jchavez.id+")' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' min='1' max='"+jchavez.stock+"' onclick='updatemiproductionsemi("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' min='0' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                                    var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                                    miproduction.push(temp);
                                    localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                                    mitotal3();
                                }
                                else{
                                    toastr.error("No existe el producto: "+jchavez.name +" en Stock");
                                }
                            }
                            else{
                                $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproductionsemi("+jchavez.id+")' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' min='1'  onclick='updatemiproductionsemi("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' min='0' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                                var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                                miproduction.push(temp);
                                localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                                mitotal3();
                            }


                            }
                        });
                    }
                }

                //Eliminar
                function mideleteInsumosemi(id) {
                    $("#miprodsemi tr#"+id).remove();
                    var milist = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {

                        } else {
                            var temp = {'id': milist[index].id, 'name': milist[index].name,'proveedor':milist[index].proveedor,'proveedor_text':milist[index].proveedor_text , 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                //Actualizar
                function updatemiproductionsemi(id) {

                    var total = parseFloat($("#costo_"+id).val()).toFixed(2) * parseFloat($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < miproduction.length; index++) {
                        if (miproduction[index].id == id) {
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'proveedor_text':milist[index].proveedor_text, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'proveedor_text':milist[index].proveedor_text,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                //Guardar
                function saveproductionssemi() {

                    var producto_semi_id = $("select[name='producto_semi_id']").val();
                    var cantidad = $("input[name='cantidad']").val();
                    var valor = $("input[name='valor']").val();
                    var description = $("textarea[name='description']").val();
                    var user_id = $("input[name='user_id']").val();

                    var midata = JSON.stringify({'producto_semi_id': producto_semi_id, 'cantidad': cantidad, 'valor': valor, 'description': description, 'user_id': user_id });
                    // console.log(midata)
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/productions/savesemi/"+midata,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));

                            for (let index = 0; index < miproduction.length; index++) {

                                var midata = JSON.stringify({'production_semi_id': response, 'insumo_id': miproduction[index].id, 'proveedor_id': miproduction[index].proveedor, 'precio': miproduction[index].costo, 'cantidad': miproduction[index].cant, 'total': miproduction[index].total});

                                $.ajax({
                                    url: "{{ setting('admin.url') }}api/pos/productions/savesemi/detalle/"+midata,
                                    success: function () {

                                    }
                                });
                            }
                            localStorage.setItem('miprodsemi', JSON.stringify([]));
                            location.href='{{ setting('admin.url') }}admin/production-semis';
                        }
                    });
                }

            </script>
        @stop
    @break
    @case('productos')
        @section('javascript')
        <script>

            $('document').ready(function () {
                    $('.js-example-basic-single').select2();

                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/categorias_all",
                        dataType: "json",
                        success: function (response) {
                            $('#micategory').append($('<option>', {
                                value: null,
                                text: 'Elige una Categoria'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#micategory').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });

                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/typeproductos",
                        dataType: "json",
                        success: function (response) {
                            $('#type_producto').append($('<option>', {
                                value: null,
                                text: 'Elige un Tipo de Producto'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#type_producto').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });


            });

            $('#micategory').on('change', function() {

                var category = $('#micategory').val();
                $('input[name="categoria_id"]').val(category);

            });


            $('#type_producto').on('change', function() {

                var type_producto_id = $('#type_producto').val();
                $('input[name="type_producto_id"]').val(type_producto_id);

            });

            var params = {};
            var $file;

            function deleteHandler(tag, isMulti) {
              return function() {
                $file = $(this).siblings(tag);

                params = {
                    slug:   '{{ $dataType->slug }}',
                    filename:  $file.data('file-name'),
                    id:     $file.data('id'),
                    field:  $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
              };
            }

            $('document').ready(function () {
                $('.toggleswitch').bootstrapToggle();

                //Init datepicker for date fields if data-datepicker attribute defined
                //or if browser does not handle date inputs
                $('.form-group input[type=date]').each(function (idx, elt) {
                    if (elt.hasAttribute('data-datepicker')) {
                        elt.type = 'text';
                        $(elt).datetimepicker($(elt).data('datepicker'));
                    } else if (elt.type != 'date') {
                        elt.type = 'text';
                        $(elt).datetimepicker({
                            format: 'L',
                            extraFormats: [ 'YYYY-MM-DD' ]
                        }).datetimepicker($(elt).data('datepicker'));
                    }
                });

                @if ($isModelTranslatable)
                    $('.side-body').multilingual({"editing": true});
                @endif

                $('.side-body input[data-slug-origin]').each(function(i, el) {
                    $(el).slugify();
                });

                $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
                $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
                $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
                $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

                $('#confirm_delete').on('click', function(){
                    $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                        if ( response
                            && response.data
                            && response.data.status
                            && response.data.status == 200 ) {

                            toastr.success(response.data.message);
                            $file.parent().fadeOut(300, function() { $(this).remove(); })
                        } else {
                            toastr.error("Error removing file.");
                        }
                    });

                    $('#confirm_delete_modal').modal('hide');
                });
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        @stop
    @break
    @case('compras')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    $('input[name="editor_id"]').val('{{ Auth::user()->id }}');
                    Proveedores_Compras();
                    Unidades_Compras();



                });

                async function Proveedores_Compras(){

                    var tabla= await axios("{{setting('admin.url')}}api/pos/proveedores");

                    $('#proveedores_compras').append($('<option>', {
                        value: null,
                        text: 'Elige un Proveedor'
                    }));
                    for (let index = 0; index < tabla.data.length; index++) {
                        const element = tabla.data[index];
                        $('#proveedores_compras').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].name
                        }));
                    }
                }

                async function Unidades_Compras(){

                    var tabla= await axios("{{setting('admin.url')}}api/pos/unidades");

                    $('#unidades_compras').append($('<option>', {
                        value: null,
                        text: 'Elige una Unidad'
                    }));
                    for (let index = 0; index < tabla.data.length; index++) {
                        const element = tabla.data[index];
                        $('#unidades_compras').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].title
                        }));
                    }

                }

                async function InsumosPorUnidadesCompras(id){
                    var tabla= await axios("{{setting('admin.url')}}api/pos/insumo/unidad/"+id);

                    $('#insumos_compras').find('option').remove().end();
                    $('#insumos_compras').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < tabla.data.length; index++) {
                        const element = tabla.data[index];
                        $('#insumos_compras').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].name
                        }));
                    }

                }

                $('#proveedores_compras').on('change',function() {

                    $('input[name="proveedor_id"]').val($('#proveedores_compras').val());

                });


                $('#unidades_compras').on('change', function() {
                    InsumosPorUnidadesCompras(this.value);

                    $('input[name="unidad_id"]').val($('#unidades_compras').val());
                });

                $('#insumos_compras').on('change',function() {

                    $('input[name="insumo_id"]').val($('#insumos_compras').val());

                });



            </script>

        @stop
    @break

    @default

        @section('javascript')
            <script>
                var params = {};
                var $file;

                function deleteHandler(tag, isMulti) {
                return function() {
                    $file = $(this).siblings(tag);

                    params = {
                        slug:   '{{ $dataType->slug }}',
                        filename:  $file.data('file-name'),
                        id:     $file.data('id'),
                        field:  $file.parent().data('field-name'),
                        multi: isMulti,
                        _token: '{{ csrf_token() }}'
                    }

                    $('.confirm_delete_name').text(params.filename);
                    $('#confirm_delete_modal').modal('show');
                };
                }

                $('document').ready(function () {
                    $('.toggleswitch').bootstrapToggle();

                    //Init datepicker for date fields if data-datepicker attribute defined
                    //or if browser does not handle date inputs
                    $('.form-group input[type=date]').each(function (idx, elt) {
                        if (elt.hasAttribute('data-datepicker')) {
                            elt.type = 'text';
                            $(elt).datetimepicker($(elt).data('datepicker'));
                        } else if (elt.type != 'date') {
                            elt.type = 'text';
                            $(elt).datetimepicker({
                                format: 'L',
                                extraFormats: [ 'YYYY-MM-DD' ]
                            }).datetimepicker($(elt).data('datepicker'));
                        }
                    });

                    @if ($isModelTranslatable)
                        $('.side-body').multilingual({"editing": true});
                    @endif

                    $('.side-body input[data-slug-origin]').each(function(i, el) {
                        $(el).slugify();
                    });

                    $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
                    $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
                    $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
                    $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

                    $('#confirm_delete').on('click', function(){
                        $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                            if ( response
                                && response.data
                                && response.data.status
                                && response.data.status == 200 ) {

                                toastr.success(response.data.message);
                                $file.parent().fadeOut(300, function() { $(this).remove(); })
                            } else {
                                toastr.error("Error removing file.");
                            }
                        });

                        $('#confirm_delete_modal').modal('hide');
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
        @stop

@endswitch
