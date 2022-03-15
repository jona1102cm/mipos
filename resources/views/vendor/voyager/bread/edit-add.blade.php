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
                <div class="row">
                    <div class="col-sm-4">
                        <strong style="font-size: 30px;">
                            <i class="{{ $dataType->icon }}"></i>
                            {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
                        </strong>
                    </div>
                    <div class="col-sm-4">
                            <div id="info_caja"></div>
                    </div>
                    <div class="col-sm-4">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-danger" data-toggle="modal" onclick="get_total()" data-target="#cerrar_caja">Cerrar</button>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal_cliente">Cliente</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_venta" onclick="get_cambio()">Guardar</button>                                
                            </div>                        
                    </div>
                    
                </div>
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
                                @endphp
                            
                                    <div class="form-group col-md-8">
                                        <strong>Carrito</strong>
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

                                    <div class="form-group col-md-4">
                                         {{-- <div class="form-group col-md-12">
                                            <strong>Opciones</strong>
                                            <br>
                                            <form class="form-horizontal" role="form">
                                                <label class="radio-inline"> <input type="radio" name="season" id="" value="imprimir" checked> Imprimir </label>
                                                <label class="radio-inline"> <input type="radio" name="season" id="" value="seguir"> Seguir </label>
                                            </form>
                                        </div> --}}
                                        <div class="form-group col-md-12">
                                            <strong>Cliente</strong>
                                            <input type="text" id="micliente" class="form-control">
                                            <input type="hidden" id="phone_client" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <strong>Pasarela</strong>
                                            <select class="form-control js-example-basic-single" id="mipagos"> </select>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <strong>Tipo</strong>
                                            <select class="form-control js-example-basic-single" id="venta_type"> </select>
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
                                        <!-- <div class="input-group col-md-4">
                                            <select class="form-control" id="unidades"> </select>
                                        </div> -->
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
                                            <select class="form-control" id="proveedorsemi"></select>
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

                            @case('productos')
                                <div class="form-group col-md-6">
                                    <strong>Categoria</strong>
                                    <select class="form-control js-example-basic-single" name="micategory" id="micategory"></select>
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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                        <h4>Ventas de la Caja</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-inverse table-responsive" id="productos_caja">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Tipo</th>
                                        <th>Orden</th>
                                        <th>Creado</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-primary" id="cerrar_caja">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                        <h4>¿Estás seguro que deseas cerra?</h4>
                        </div>
                        <div class="modal-body">
                            {{-- <h4>¿Estás seguro que deseas cerra?</h4> --}}
                            <table class="table">
                                <tr>
                                    <td>Cant. Ventas:</td><td><div id="cant_ventas"></div></td>
                                </tr>
                                <tr>
                                    <td>Total Ventas:</td><td><div id="total_ventas"></div></td>
                                </tr>
                                <tr>
                                    <td>Importe Inicial:</td><td><div id="importe_inicial"></div></td>
                                </tr>
                                <tr>
                                    <td>Total Caja:</td><td><div id="_total"></div></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="" onclick="cerrar_caja()">SI</button>
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
                            <div>
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
                                  </div>
                                  <div role="tabpanel" class="tab-pane" id="profile">
                                        <input type="text" class="form-control" placeholder="Criterio de Busquedas.." id="cliente_busqueda">
                                        <br>
                                        <table class="table" id="cliente_list">
                                            <thead>
                                                <th>#</th>
                                                <th>Cliente</th>
                                                <th>Opciones</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                  </div>
                                </div>                              
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="savecliente()" >Enviar</button>
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
                        <div class="modal-body">
                            <div class="form-group text-center">                               
                                <form class="form-horizontal" role="form">
                                    <label class="radio-inline"> <input type="radio" name="season" id="" value="imprimir" checked> Imprimir </label>
                                    <label class="radio-inline"> <input type="radio" name="season" id="" value="seguir"> Seguir </label>
                                </form>
                            </div>
                            <table class="table">                                                               
                                    <tr>
                                        <td>Importe: </td>
                                        <td>
                                            <input type="number" class="form-control" id="recibido">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Venta: </td>
                                        <td>
                                            <input type="number" class="form-control" id="venta_total" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cambio: </td>
                                        <td>
                                            <input type="number" class="form-control" id="cambio" readonly>
                                        </td>
                                    </tr>                               
                            </table>
                        </div>
        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                            <button type="button" class="btn btn-primary" onclick="saveventas()">SI</button>
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
            <script>
                socket.on('chat', (msg) =>{
                    console.log(msg);
                })
            </script>
        @stop
        @break
        
    @case('ventas')
        @section('javascript')
            <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
            <script>
                const socket = io('https://socket.loginweb.dev')
                socket.on('chat', (msg) =>{
                    toastr.success('La Cocina Libero el Pedido: '+msg);
                })

                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    $('input[name="register_id"]').val('{{ Auth::user()->id }}');
                    
                    if (localStorage.getItem('micaja')) {
                        var micaja = JSON.parse(localStorage.getItem('micaja'));
                        $("input[name='caja_id']").val(micaja.caja_id);
                        $('input[name="sucursal_id"]').val(micaja.sucursal_id);
                        $("#info_caja").html('<h4>'+micaja.title+" - "+micaja.sucursal+" - "+micaja.importe+' Bs.</h4>');
                    }else{
                        $("#micaja").modal();
                    }

                    // MIXTA 1 y 2 
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/producto/mixto/0",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#mixta1').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Mitad'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {

                    //             $.ajax({
                    //                 url: "{{ setting('admin.url') }}api/pos/category/"+response[index].categoria_id,
                    //                 dataType: "json",
                    //                 success: function (midata) {
                    //                     $('#mixta1').append($('<option>', {
                    //                         value: response[index].id,
                    //                         text: midata.abreviatura + ' - ' + response[index].name + ' - ' + response[index].precio+' Bs.'
                    //                     }));
                    //                 }
                    //             });

                    //         }
                    //     }
                    // });
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/producto/mixto/0",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#mixta2').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige una Mitad'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {

                    //             $.ajax({
                    //                 url: "{{ setting('admin.url') }}api/pos/category/"+response[index].categoria_id,
                    //                 dataType: "json",
                    //                 success: function (midata) {
                    //                     $('#mixta2').append($('<option>', {
                    //                         value: response[index].id,
                    //                         text: midata.abreviatura + ' - ' + response[index].name + ' - ' + response[index].precio+' Bs.'
                    //                     }));
                    //                 }
                    //             });

                    //         }
                    //     }
                    // });

                    // TODOS LOS CATEGORIAS 
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/categorias",
                        dataType: "json",
                        success: function (response) {
                            $('#category').append($('<option>', {
                                value: null,
                                text: 'Elige una Categoria'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#category').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });
                
                    // TODOS LOS PRODUCTOS 
                    // $.ajax({
                    //     url: "{{ setting('admin.url') }}api/pos/productos",
                    //     dataType: "json",
                    //     success: function (response) {
                    //         $('#s').append($('<option>', {
                    //             value: null,
                    //             text: 'Elige un Producto'
                    //         }));
                    //         for (let index = 0; index < response.length; index++) {

                    //             $.ajax({
                    //                 url: "{{ setting('admin.url') }}api/pos/category/"+response[index].categoria_id,
                    //                 dataType: "json",
                    //                 success: function (midata) {
                    //                     $('#s').append($('<option>', {
                    //                         value: response[index].id,
                    //                         text: midata.abreviatura + ' - ' + response[index].name + ' - ' + response[index].precio+' Bs.'
                    //                     }));
                    //                 }
                    //             });

                    //         }
                    //     }
                    // });

                    // get Deliverys
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/deliverys",
                        dataType: "json",
                        success: function (response) {
                            for (let index = 0; index < response.length; index++) {
                                if (response[index].id == 1) {
                                    $('#midelivery').append($('<option>', {
                                    selected: true,
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                                $("input[name='delivery_id']").val(response[index].id);
                                } else {
                                    $('#midelivery').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                                }
                            }
                        }
                    });

                    // get cliente default
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/cliente/default/get",
                        dataType: "json",
                        success: function (response) {
                            $("input[name='cliente_id']").val(response.id);
                            $('#micliente').val(response.display+' - '+response.phone)
                            $('#phone_client').val(response.phone)
                        }
                    });

                    // get cup[ones]
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/cupones",
                        dataType: "json",
                        success: function (response) {
                            for (let index = 0; index < response.length; index++) {
                                if (response[index].id == 1) {
                                    $('#micupon').append($('<option>', {
                                    selected: true,
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                $("input[name='cupon_id']").val(response[index].id);
                                } else {
                                    $('#micupon').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                }
                            }
                        }
                    });

                    // get pasarela-----------------------------
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/pagos",
                        dataType: "json",
                        success: function (response) {
                            for (let index = 0; index < response.length; index++) {
                                if (response[index].id == 1) {
                                    $('#mipagos').append($('<option>', {
                                    selected: true,
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                $("input[name='pago_id']").val(response[index].id);
                                } else {
                                    $('#mipagos').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                }
                            }
                        }
                    });

                    // get estados-----------------------------
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/estados",
                        dataType: "json",
                        success: function (response) {
                            for (let index = 0; index < response.length; index++) {
                                if (response[index].id == 1) {
                                    $('#miestado').append($('<option>', {
                                    selected: true,
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                $("input[name='status_id']").val(response[index].id);
                                } else {
                                    $('#miestado').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                }
                            }
                        }
                    });

                    // venta_type
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/options",
                        dataType: "json",
                        success: function (response) {
                            for (let index = 0; index < response.length; index++) {
                                if (response[index].id == 1) {
                                    $('#venta_type').append($('<option>', {
                                    selected: true,
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                $("input[name='option_id']").val(response[index].id);
                                } else {
                                    $('#venta_type').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].title
                                }));
                                }
                            }
                        }
                    });

                    //-----------------------
                    if (localStorage.getItem('micart')) {
                        var milist = JSON.parse(localStorage.getItem('micart'));
                        // console.log(milist.length);
                        if(milist.length == 0){
                            $("#micart").append("<tr id=0><td colspan='4'> <img class='img-responsive img-sm' src={{ setting('admin.url') }}storage/231-2317260_an-empty-shopping-cart-viewed-from-the-side.png></td></tr>");
                        }else{
                            for (let index = 0; index < milist.length; index++) {

                                $("#micart").append("<tr id="+milist[index].id+"><td>"+milist[index].id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+milist[index].image+"></td><td>"+milist[index].name+"<br>"+milist[index].description+"</td><td><input class='form-control' type='number' value='"+milist[index].precio+"' id='precio_"+milist[index].id+"' readonly></td><td><input class='form-control' type='number' onclick='updatecant("+milist[index].id+")' value='"+milist[index].cant+"' id='cant_"+milist[index].id+"'></td><td><input class='form-control' type='number' value='"+milist[index].total+"' id='total_"+milist[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+milist[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            }
                            mitotal();
                        }

                    } else {
                        localStorage.setItem('micart', JSON.stringify([]));
                    }
                });

                // GET CAMBIO 
                $('#recibido').keyup(function (e) { 
                    e.preventDefault();
                    var cambio = $('#recibido').val() - $('#venta_total').val();
                    $('#cambio').val(cambio);
                });
                function get_cambio() {
                    $('#recibido').val(0);
                    $('#cambio').val(0);
                    var micart = JSON.parse(localStorage.getItem('micart'));
                    var total = 0;
                    for (let index = 0; index < micart.length; index++) {
                      total = total + micart[index].total;
                    }
                    $('#venta_total').val(total);
                }

                //ADD MIXTA 
                function addmixta() {
                    var id = $('#s').val();
                    var mixta1 = $('#mixta1').val(); 
                    var mixta2 = $('#mixta2').val();
                    // console.log({product: product, mixta1: mixta1, mixta2: mixta2});
                    var micart = JSON.parse(localStorage.getItem('micart'));
                    var description = $('#mixta1 :selected').text() + ' - ' + $('#mixta2 :selected').text();
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/producto/"+id,
                        dataType: "json",
                        success: function (response) {

                            $('#mixtos').attr("hidden", true);
                            $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+response.image+"></td><td>"+response.name+"<br>"+description+"</td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' readonly></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                            
                            var temp = {'id': response.id, 'image': response.image, 'name': response.name, 'precio': response.precio, 'cant': 1, 'total': response.precio, 'description': description};
                            micart.push(temp);
                            localStorage.setItem('micart', JSON.stringify(micart));

                            mitotal();
                            toastr.success(response.name+" - REGISTRADO");

                        }
                    });

                }

                //get totales
                function get_total() {
                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/caja/total/"+micaja.caja_id,
                        dataType: "json",
                        success: function (response) {
                            $('#cant_ventas').html('<h3>'+response.cantidad+'</h3>');
                            $('#total_ventas').html('<h3>'+response.total+' Bs.</h3>');
                            $('#importe_inicial').html('<h3>'+micaja.importe+' Bs.</h3>');
                            var total = response.total + parseFloat(micaja.importe);
                            $('#_total').html('<h3>'+total +' Bs.</h3>');
                        }
                    });
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
                                    toastr.success('Sin Resultados.');
                                } else {
                                    for (let index = 0; index < response.length; index++) {                                    
                                        mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].display+"</td><td><a class='btn btn-sm btn-success' href='#' onclick='cliente_get()'>Elegir</a></td></tr>";
                                    }
                                    $('#cliente_list').append(mitable);
                                }
                            }
                        });
                    }
                });

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
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/caja/state/close/"+micaja.caja_id,
                        success: function (response){
                            localStorage.removeItem('micaja');
                            location.href = '/admin/profile';
                        }
                    });
                }

                function venta_caja() {
                    $('#venta_caja').modal();
                    $('#productos_caja tbody').empty();

                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/ventas/caja/"+$("input[name='caja_id']").val(),
                        dataType: "json",
                        success: function (response) {
                            for (let index = 0; index < response.length; index++) {
                                
                                if (response[index].register_id == '{{ Auth::user()->id }}') {
                                    $("#productos_caja").append("<tr><td>"+response[index].id+"</td><td>"+response[index].factura+"</td><td>"+response[index].option_id+"</td><td>"+response[index].created_at+"</td><td>"+response[index].total+"</td><td>"+response[index].caja_status+"</td></tr>");
                                } else {
                                    
                                }

                                
                            }
                        }
                    });
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
                            
                            $("#info_caja").html('<h4>'+micaja.title+" - "+micaja.sucursal+" - "+micaja.importe+' Bs.</h4>');
                            toastr.success('Caja Abierta Correctamente.');
                            $('#micaja').modal('hide');

                        }
                    });
                }
        
                $('#midelivery').on('change', function() {
                    $("input[name='delivery_id']").val(this.value);
                });

                $('#mipagos').on('change', function() {
                    $("input[name='pago_id']").val(this.value);
                });

                $('#micupon').on('change', function() {
                    $("input[name='cupon_id']").val(this.value);
                });

                $('#venta_type').on('change', function() {
                    $("input[name='option_id']").val(this.value);
                });

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
                            toastr.success('Cliente Creado..');
                            $('#micliente').val(response.display+' - '+response.phone);
                            $('#phone_client').val(response.phone);
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

                function saveventas() {

                    var cliente_id = $("input[name='cliente_id']").val();
                    var cupon_id = $("input[name='cupon_id']").val();
                    var pago_id = $("input[name='pago_id']").val();
                    var status_id = $("input[name='status_id']").val();
                    var option_id = $("input[name='option_id']").val();
                    var factura = $("input[name='factura']:checked").val();
                    var total = $("input[name='total']").val();
                    var descuento = $("input[name='descuento']").val();
                    var observacion = $("input[name='observacion']").val();
                    var register_id = $("input[name='register_id']").val();
                    var caja_id = $("input[name='caja_id']").val();
                    var delivery_id = $("input[name='delivery_id']").val();
                    var sucursal_id = $("input[name='sucursal_id']").val();
                    var subtotal = $("input[name='subtotal']").val();
                    var recibido = $("#recibido").val();
                    var cambio = $("#cambio").val();
                    var micart = JSON.parse(localStorage.getItem('micart'));

                    var midata = JSON.stringify({'cliente_id': cliente_id, 'cupon_id': cupon_id, 'option_id': option_id, 'pago_id': pago_id, 'factura': factura, 'total': total, 'descuento': descuento, 'observacion': observacion, 'register_id': register_id, 'status_id': status_id, 'caja_id': caja_id, 'delivery_id': delivery_id, 'sucursal_id': sucursal_id, subtotal: subtotal, 'cantidad': micart.length, 'recibido': recibido, 'cambio': cambio });

                    $('#modal_save_venta').modal('hide');
                    
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/ventas/save/"+midata,
                        success: function (response) {
                            
                            // enviando detalle de venta
                            var micart = JSON.parse(localStorage.getItem('micart'));
                            for (let index = 0; index < micart.length; index++) {
                                var midata = JSON.stringify({'producto_id': micart[index].id, 'venta_id': response.id, 'precio': micart[index].precio, 'cantidad': micart[index].cant, 'total': micart[index].total, 'description': micart[index].description});
                                var urli = "{{ setting('admin.url') }}api/pos/ventas/save/detalle/"+midata;
                                $.ajax({
                                    url: urli,
                                    success: function (midata) {
                                    if ((response.cantidad - 1) == index) {
                                        

                                        if ($("input[name='season']:checked").val() == 'imprimir') {
                                            $("input[name='descuento']").val(0)
                                            localStorage.setItem('micart', JSON.stringify([]));
                                            location.href = "{{ setting('admin.url') }}admin/ventas/imprimir/"+response.id;
                                        }else{       
                                            localStorage.setItem('micart', JSON.stringify([]));                                 
                                            toastr.success('Venta Realizada');
                                        }
                                    }
                                    $("#micart tr#"+micart[index].id).remove();
                                    mitotal(); 
                                    }
                                });
                            }
                            
                            // enviado notification 
                            
                            socket.emit('chat', 'VENTA REALIZADA: '+response.id)

                            // var phone = $('#phone_client').val();
                            // $.ajax({
                            //     url: "{{ setting('admin.chatbot') }}?type=pedido&phone="+phone+"&message="+response,
                            //     success: function () {
                                  
                                   
                            //     }
                            // });

                        }
                    });
                }

                $('#category').on('change', function() {
                    $.ajax({
                        type: "get",
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
                                    text: response[index].name + ' '+ response[index].precio + ' Bs.'
                                }));
                            }
                        }
                    });
                });

                function mitotal() {
                    
                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var cant = milist.length;
                    var des = $("input[name='descuento']").val();
                    var total = 0
                    for (let index = 0; index < milist.length; index++) {
                        total = total + milist[index].total;
                    }
                    
                    $("input[name='subtotal']").val(parseFloat(total).toFixed(2));
                    $("input[name='total']").val(parseFloat(total-des).toFixed(2));
                    $("input[name='cantidad']").val(cant);
                }

                $('#s').on('change', function() {
                    addproduct(this.value); 
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
                        toastr.warning("Producto ya Registrado");
                    }else{
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/producto/"+id,
                            dataType: "json",
                            success: function (response) {

                                if (response.mixta == 1 ) {
                                    $('#mixtos').attr("hidden",false);
                                    var micategory = $('#category').val();
                                    // console.log(micategory);
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
                                                    text: response[index].name + ' '+ response[index].precio + ' Bs.'
                                                }));                                                        
                                            }

                                            $('#mixta2').append($('<option>', {
                                                value: null,
                                                text: 'Elige un Mitad'
                                            }));
                                            for (let index = 0; index < response.length; index++) {                                         
                                                $('#mixta2').append($('<option>', {
                                                    value: response[index].id,
                                                    text: response[index].name+ ' '+ response[index].precio + ' Bs.'
                                                }));                                                        
                                            }

                                        }
                                    });
                                } else {
                                    $('#mixtos').attr("hidden",true);
                               
                                    $("#micart").append("<tr id="+response.id+"><td>"+response.id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+response.image+"></td><td>"+response.name+"</td><td><input class='form-control' type='number' value='"+response.precio+"' id='precio_"+response.id+"' readonly></td><td><input class='form-control' type='number' onclick='updatecant("+response.id+")' value='1' id='cant_"+response.id+"'></td><td><input class='form-control' type='number' value='"+response.precio+"' id='total_"+response.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='midelete("+response.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                    
                                    var temp = {'id': response.id, 'image': response.image, 'name': response.name, 'precio': response.precio, 'cant': 1, 'total': response.precio, 'description': null};
                                    micart.push(temp);
                                    localStorage.setItem('micart', JSON.stringify(micart));

                                    mitotal();
                                    toastr.success(response.name+" - REGISTRADO");
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
                            var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('micart', JSON.stringify(newlist));
                    mitotal();
                    
                }

                function updatecant(id) {
                    var total = parseFloat($("#precio_"+id).val()).toFixed(2) * parseInt($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var milist = JSON.parse(localStorage.getItem('micart'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {
                            var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'cant': parseInt($("#cant_"+id).val()), 'total': milist[index].precio * parseInt($("#cant_"+id).val())};
                            newlist.push(temp);
                        }else{
                            var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'cant': milist[index].cant, 'total': milist[index].precio, 'total':  milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('micart', JSON.stringify(newlist));
                    mitotal();
                }

            </script>
        @stop
    @break
    @case('productions')
        @section('javascript')
            <script>

                //  AL CARGAR LA VISTA
                $('document').ready(function () {

                    $('.js-example-basic-single').select2();
                    $('input[name="user_id"]').val('{{ Auth::user()->id }}');
                    
                    // PRODUCTOS PRE ELABORADO
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/productosemi",
                        dataType: "json",
                        success: function (response) {
                            $('#prod_semi').append($('<option>', {
                                value: null,
                                text: 'Elige un Pre Elaborado'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                $('#prod_semi').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });

                    // PRODUCTOS PARA PRODUCCION
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/productos/production",
                        dataType: "json",
                        success: function (response) {
                            $('#new_producto_id').append($('<option>', {
                                value: null,
                                text: 'Elige un Producto'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                $('#new_producto_id').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });

                    // CARGADO DE SESSION INSUMOS
                    if (localStorage.getItem('miproduction')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miproduction'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miproduction").append("<tr id="+milistProduction[index].cod+"><td>"+milistProduction[index].cod+"</td><td>"+milistProduction[index].type+"</td><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+milistProduction[index].cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
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
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/insumos",
                        dataType: "json",
                        success: function (response) {
                            $('#insumos').append($('<option>', {
                                value: null,
                                text: 'Elige un Insumo'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#insumos').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });

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
                        var idpro = $('#proveedorelab').val();
                        var miprotext = $('#proveedorelab option:selected').text();
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/productopreid/"+this.value,
                            dataType: "json",
                            success: function (jchavez) {
                                var cod = Math.floor(Math.random() * 999) + 800;

                                $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>elaborado</td><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                                                    
                                var temp = {'cod': cod, 'type': 'elaborado', 'idpro' :idpro,'id': jchavez.id, 'name': jchavez.name, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                                miproduction.push(temp);
                                localStorage.setItem('miproduction', JSON.stringify(miproduction));
                                mitotal2();
                                toastr.success('Agreado Insumo: '+jchavez.name);
                            }
                        });
                    }
                });

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

                $('#unidades').on('change', function() {
                    $.ajax({
                        type: "get",
                        url: "{{ setting('admin.url') }}api/pos/insumo/unidad/"+this.value,
                        dataType: "json",
                        success: function (response) {
                            $('#insumos').find('option').remove().end();
                            $('#insumos').append($('<option>', {
                                value: null,
                                text: 'Elige un Insumo'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#insumos').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });
                });

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
                        var idpro = $('#proveedorelab').val();
                        var miprotext = $('#proveedorelab option:selected').text();
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/insumos/"+this.value,
                            dataType: "json",
                            success: function (jchavez) {
                                var cod = Math.floor(Math.random() * 999) + 800;

                                $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>simple</td><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                    

                                
                                var temp = {'cod': cod, 'type': 'simple', 'idpro' :idpro, 'id': jchavez.id, 'name': jchavez.name, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                                miproduction.push(temp);
                                localStorage.setItem('miproduction', JSON.stringify(miproduction));
                                mitotal2();
                                toastr.success('Agreado Insumo: '+thisvalue);
                            }
                        });
                    }
                });

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


                            $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproductionsemi("+jchavez.id+")' value='0' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                

                            var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                            miproduction.push(temp);
                            localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                            mitotal3();
                            }
                        });
                    }
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
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name, 'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
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
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
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
                    $.ajax({
                        url: urli,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                            for (let index = 0; index < miproduction.length; index++) {

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

                            $("#miprodsemi").append("<tr id="+milistProduction[index].id+"><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproductionsemi("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+milistProduction[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
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


                            $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproductionsemi("+jchavez.id+")' value='0' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                                

                            var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                            miproduction.push(temp);
                            localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                            mitotal3();
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
                            var temp = {'id': milist[index].id, 'name': milist[index].name,'proveedor':milist[index].proveedor, 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
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
                        var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                        newlist.push(temp);
                    }else{
                        var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
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


                $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/categorias",
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




            });

            $('#micategory').on('change', function() {

                var category = $('#micategory').val();
                $('input[name="categoria_id"]').val(category);

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


