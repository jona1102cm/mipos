@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

<!-- ---------------------HEADER-------------------  -->
<!-- ---------------------HEADER-------------------  -->
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @switch($dataType->getTranslatedAttribute('slug'))
            @case('cocinas')

                @break
            @case('productos')
                <a href="{{ url('admin/categorias') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-tag"></i> <span>Categorias</span>
                </a>
                <a href="{{ url('admin/ventas') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Volver</span>
                </a>
                @break
            @case('clientes')
                <a href="{{ url('admin/ventas') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Volver</span>
                </a>
                @break
            @case('categorias')
                <a href="{{ url('admin/productos') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Volver</span>
                </a>
                @break
            @case('mensajeros')
                    <a href="{{ url('admin/ventas') }}" class="btn btn-default btn-add-new" title="">
                        <i class="voyager-helm"></i> <span>Volver</span>
                    </a>
                @break
            @case('ventas')
                <a href="{{ url('admin/productos') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Productos</span>
                </a>
                <a href="{{ url('admin/cajas') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Cajas</span>
                </a>
                @break
            @case('insumos')
                <a href="{{ url('admin/unidades') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-milestone"></i> <span>Unidades</span>
                </a>
                <a href="{{ url('admin/productions') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Producciones</span>
                </a>
                <a href="{{ url('admin/proveedores') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-people"></i> <span>Proveedores</span>
                </a>
                @break
            @case('productions')
                <a href="{{ url('admin/productos-semi-elaborados') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Pre Elaborados</span>
                </a>
                    <a href="{{ url('admin/proveedores') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-people"></i> <span>Proveedores</span>
                </a>
                <a href="{{ url('admin/insumos') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Insumos</span>
                </a>
                @break
            @case('production-semis')
                <a href="{{ url('admin/productos-semi-elaborados') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Volver</span>
                </a>
                @break
            @case('detalle-ventas')
                <a href="{{ url('admin/ventas') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Volver</span>
                </a>
                @break
            @case('production-insumos')
                <a href="{{ url('admin/productions') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Volver</span>
                </a>
                @break
            @case('detalle-production-semis')
            <a href="{{ url('admin/production-semis') }}" class="btn btn-default btn-add-new" title="">
                <i class="voyager-puzzle"></i> <span>Productos Semielaborados</span>
            </a>
                @break
            @case('unidades')
                <a href="{{ url('admin/insumos') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Volver</span>
                </a>
                @break
            @case('proveedores')
                <a href="{{ url('admin/productions') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Volver</span>
                </a>
                @break
            @case('productos-semi-elaborados')
                <a href="{{ url('admin/production-semis/create') }}" class="btn btn-primary btn-add-new" title="">
                    <i class="voyager-plus"></i> <span>Producir</span>
                </a>
                <a href="{{ url('admin/production-semis') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-plus"></i> <span>Historial</span>
                </a>
                <a href="{{ url('admin/productions') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Volver</span>
                </a>
                @break
            @case('cajas')
                <a href="{{ url('admin/sucursales') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Sucursales</span>
                </a>
                @break
            @case('sucursales')
                <a href="{{ url('admin/cajas') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Volver</span>
                </a>
                @break
            @case('compras')
                <a href="{{ url('admin/proveedores') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-helm"></i> <span>Proveedores</span>
                </a>
                <a href="{{ url('admin/unidades') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-milestone"></i> <span>Unidades</span>
                </a>
                <a href="{{ url('admin/insumos') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Insumos</span>
                </a>
                {{-- <h1>EN DESARROLLO</h1> --}}
                @break
            @default
            @foreach($actions as $action)
                @if (method_exists($action, 'massAction'))
                    @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
                @endif
            @endforeach
            @include('voyager::multilingual.language-selector')
        @endswitch
    </div>
@stop



<!-- ---------------------BOBY-------------------  -->
<!-- ---------------------BODY-------------------  -->
@section('content')

    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            @switch($dataType->getTranslatedAttribute('slug'))
                                @case('production-insumos')
                                    {{-- @php
                                        $detalle = App\ProductionInsumo::find($_GET['s']);
                                    @endphp
                                    <pre> <code>{{ $detalle }}</code></pre> --}}
                                @break
                                @case('cocinas')

                                @break
                                @case('ventas')
                                    <form method="get" class="form-search">
                                        <div id="search-input">
                                            <div class="col-4">
                                                <select id="search_key" name="key" style="width: 250px" class="js-example-basic-single">
                                                        <option value=""> ---- Elige un Filtro ----</option>
                                                        <option value="caja_id"> Cajas </option>
                                                        <option value="cliente_id"> Cliente </option>
                                                        <option value="sucursal_id"> Sucursal </option>
                                                        <option value="delivery_id"> Delivery</option>
                                                        <option value="chofer_id"> Chofer </option>
                                                        <option value="register_id"> Editor </option>
                                                        <option value="chofer_deudas"> Chofer Deudas </option>
                                                        <option value="pensionado_kardex"> Kardex Pensionados </option>
                                                        <option value="credito">Cobro Créditos</option>

                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select id="filter" name="filter">
                                                        <option value="equals"> = </option>
                                                </select>
                                                <select class="js-example-basic-single" id="s" name="s" onchange="this.form.submit()" style="width: 350px"></select>
                                            </div>
                                        </div>
                                    </form>
                                @break

                                @case('productions')

                                    <!-- <form method="get" class="form-search"> -->
                                        <div id="search-input">
                                            <div class="col-6">
                                                <select id="search_key" name="key" style="width: 200px">
                                                        <option value=""> ---- Elige un Filtro ----</option>
                                                        <option value="production_id"> Producción </option>

                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select id="filter" name="filter"  readonly>
                                                        <option value="equals"> = </option>
                                                </select>
                                                <select id="s" name="s" style="width: 500px" onchange="this.form.submit()">
                                                </select>
                                            </div>
                                        </div>
                                    <!-- </form>  -->
                                @break

                                @case('detalle-ventas')
                                @break

                                @case('detalle-cajas')
                                @break



                                @case('productos')
                                    <form method="get" class="form-search">
                                        <div id="search-input">
                                            <div class="col-4">
                                                <select id="search_key" name="key" style="width: 200px" class="js-example-basic-single">
                                                        <option value=""> ---- Elige un Filtro ----</option>
                                                        <option value="name"> NOMBRE </option>
                                                        <option value="categoria_id"> CATEGORIA </option>
                                                        <option value="capital_productos">CAPITAL PRODUCTOS</option>

                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select id="filter" name="filter">
                                                        <option value="equals"> = </option>
                                                </select>
                                                <select class="js-example-basic-single" id="s" name="s" onchange="this.form.submit()" style="width: 350px"></select>
                                            </div>
                                        </div>

                                    </form>
                                @break

                                @case('compras')
                                    <form method="get" class="form-search">
                                        <div id="search-input">
                                            <div class="col-4">
                                                <select id="search_key" name="key" style="width: 250px" class="js-example-basic-single">
                                                        <option value=""> ---- Elige un Filtro ----</option>
                                                        <option value="proveedor_id"> Proveedor </option>
                                                        <option value="insumo_id"> Insumo </option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select id="filter" name="filter">
                                                        <option value="equals"> = </option>
                                                </select>
                                                <select class="js-example-basic-single" id="s" name="s" onchange="this.form.submit()" style="width: 350px"></select>
                                            </div>
                                        </div>
                                    </form>
                                @break
                                @default
                                    <form method="get" class="form-search">
                                        <div id="search-input">
                                            <div class="col-2">
                                                <select id="search_key" name="key">
                                                    @foreach($searchNames as $key => $name)
                                                        <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <select id="filter" name="filter">
                                                    <option value="contains" @if($search->filter == "contains") selected @endif>contains</option>
                                                    <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                                                </select>
                                            </div>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info btn-lg" type="submit">
                                                        <i class="voyager-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        @if (Request::has('sort_order') && Request::has('order_by'))
                                            <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                            <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                        @endif
                                    </form>
                            @endswitch
                        @endif

                        @switch($dataType->getTranslatedAttribute('slug'))
                            @case('cocinas')
                                    @php
                                        $ventas = App\Venta::where('status_id', 1 )->orderby('id', 'desc')->get();
                                    @endphp
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Pedido</th>
                                                        <th>Cliente</th>
                                                        <th>Creado</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ventas as $item)
                                                        <tr>
                                                            <td>
                                                                ID# {{ $item->id }}
                                                                <br>
                                                                Ticket: {{ $item->ticket }}
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $detalle = App\DetalleVenta::where('venta_id', $item->id )->get();
                                                                @endphp
                                                                @foreach($detalle as $d)
                                                                    @php
                                                                        $producto = App\Producto::find( $d->producto_id );
                                                                    @endphp
                                                                    {{ $producto->id.' - '.$producto->name }} <br>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $cliente = App\Cliente::find($item->cliente_id );
                                                                @endphp
                                                                {{ $cliente->display }} <br>
                                                                {{ $cliente->phone }}
                                                            </td>
                                                            <td>
                                                                {{ $item->created_at }}
                                                            </td>
                                                            <td>
                                                                {{-- <a href="#" onclick="confirmar({{ $item->id }})" class="btn btn-success">Confirmar</a> --}}
                                                                <a href="#" onclick="cocina({{ $item->id }})" class="btn btn-primary">Realizado</a>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </tbody>
                                        </table>
                                    </div>
                            @break
                            @case('ventas')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                @if($data->register_id == Auth::user()->id )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('pago_id')
                                                                                @php
                                                                                    $pago = App\Pago::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $pago ? $pago->title : null }}</span>
                                                                                @break

                                                                            @case('status_id')
                                                                                @php
                                                                                    $estado = App\Estado::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $estado->title }}</span>
                                                                                @break

                                                                            @case('cliente_id')
                                                                                @php
                                                                                    $cliente = App\Cliente::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $cliente ? $cliente->display : 'null' }}</span>
                                                                                @break
                                                                            @case('register_id')
                                                                                @php
                                                                                    $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $user->name }}</span>
                                                                                @break
                                                                            @case('caja_id')
                                                                                @php
                                                                                    $user = App\Caja::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $user->title }}</span>
                                                                                @break
                                                                            @case('cupon_id')
                                                                                @php
                                                                                    $cupon = App\Cupone::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $cupon->title }}</span>
                                                                                @break
                                                                            @case('delivery_id')
                                                                                @php
                                                                                    $delivery = App\Mensajero::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $delivery->name }}</span>
                                                                                @break
                                                                            @case('option_id')
                                                                                @php
                                                                                    $option = App\Option::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $option->title }} </span>
                                                                                @break
                                                                            @case('sucursal_id')
                                                                                @php
                                                                                    $sucursal = App\Sucursale::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $sucursal ? $sucursal->name : null }}</span>
                                                                                @break
                                                                            @case('chofer_id')
                                                                                @php
                                                                                    $chofer =  TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $chofer ? $chofer->name : null }}</span>
                                                                                @break
                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>


                                                        @endforeach

                                                    </tr>
                                                @elseif(Auth::user()->id == 1 OR Auth::user()->role_id == 5 )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif
                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('pago_id')
                                                                                @php
                                                                                    $pago = App\Pago::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $pago ? $pago->title : null }}</span>
                                                                                @break

                                                                            @case('status_id')
                                                                                @php
                                                                                    $estado = App\Estado::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $estado ? $estado->title : null }}</span>
                                                                                @break
                                                                            @case('cliente_id')
                                                                                @php
                                                                                    $cliente = App\Cliente::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $cliente ? $cliente->display : null }}</span>
                                                                                @break
                                                                            @case('register_id')
                                                                                @php
                                                                                    $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $user ? $user->name : null }}</span>
                                                                                @break
                                                                            @case('caja_id')
                                                                                @php
                                                                                    $user = App\Caja::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $user ? $user->title : null }}</span>
                                                                                @break
                                                                            @case('cupon_id')
                                                                                @php
                                                                                    $cupon = App\Cupone::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $cupon->title }}</span>
                                                                                @break
                                                                            @case('option_id')
                                                                                @php
                                                                                    $option = App\Option::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $option->title }}</span>
                                                                                @break
                                                                            @case('sucursal_id')
                                                                                @php
                                                                                    $sucursal = App\Sucursale::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $sucursal->name }}</span>
                                                                                @break
                                                                            @case('delivery_id')
                                                                                @php
                                                                                    $delivery = App\Mensajero::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $delivery ? $delivery->name : null }}</span>
                                                                                @break
                                                                            @case('chofer_id')
                                                                                @php
                                                                                    $chofer =  TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $chofer ? $chofer->name : null }}</span>
                                                                                @break
                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>
                                                        @endforeach

                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @break
                            @case('compras')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                {{-- <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th> --}}
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                @if($data->register_id == Auth::user()->id )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        {{-- <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td> --}}

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('insumo_id')
                                                                                @php
                                                                                    $insumo = App\Insumo::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $insumo ? $insumo->name : null }}</span>
                                                                            @break

                                                                            @case('unidad_id')
                                                                                @php
                                                                                    $unidad = App\Unidade::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $unidad ? $unidad->title : null }}</span>
                                                                            @break

                                                                            @case('proveedor_id')
                                                                                @php
                                                                                    $proveedor = App\Proveedore::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $proveedor ? $proveedor->name : null }}</span>
                                                                            @break

                                                                            @case('editor_id')
                                                                                @php
                                                                                    $comprador =  TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $comprador ? $comprador->name : null }}</span>
                                                                            @break

                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>


                                                        @endforeach

                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                    </tr>
                                                @elseif(Auth::user()->id == 1 OR Auth::user()->role_id == 5 )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif
                                                        {{-- <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td> --}}
                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)

                                                                            @case('unidad_id')
                                                                                @php
                                                                                    $unidad = App\Unidade::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $unidad ? $unidad->title : null }}</span>
                                                                            @break

                                                                            @case('insumo_id')
                                                                                @php
                                                                                    $insumo = App\Insumo::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $insumo ? $insumo->name : null }}</span>
                                                                            @break

                                                                            @case('proveedor_id')
                                                                                @php
                                                                                    $proveedor = App\Proveedore::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $proveedor ? $proveedor->name : null }}</span>
                                                                            @break

                                                                            @case('editor_id')
                                                                                @php
                                                                                    $comprador =  TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $comprador ? $comprador->name : null }}</span>
                                                                            @break

                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>
                                                        @endforeach

                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @break
                            @case('productos')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                <tr>

                                                    @if($showCheckboxColumn)
                                                        <td>
                                                            <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                        </td>
                                                    @endif
                                                    @foreach($dataType->browseRows as $row)


                                                        @php
                                                        if ($data->{$row->field.'_browse'}) {
                                                            $data->{$row->field} = $data->{$row->field.'_browse'};
                                                        }
                                                        @endphp

                                                        <td>
                                                            @if (isset($row->details->view))
                                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                            @elseif($row->type == 'image')
                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                            @elseif($row->type == 'relationship')
                                                                @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                            @elseif($row->type == 'select_multiple')
                                                                @if(property_exists($row->details, 'relationship'))

                                                                    @foreach($data->{$row->field} as $item)
                                                                        {{ $item->{$row->field} }}
                                                                    @endforeach

                                                                @elseif(property_exists($row->details, 'options'))
                                                                    @if (!empty(json_decode($data->{$row->field})))
                                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif
                                                                @endif

                                                                @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                    @if (@count(json_decode($data->{$row->field})) > 0)
                                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif

                                                            @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                    {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'checkbox')
                                                                @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                    @if($data->{$row->field})
                                                                        <span class="label label-info">{{ $row->details->on }}</span>
                                                                    @else
                                                                        <span class="label label-primary">{{ $row->details->off }}</span>
                                                                    @endif
                                                                @else
                                                                {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'color')
                                                                <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                            @elseif($row->type == 'text')


                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                            @elseif($row->type == 'text_area')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                            @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                @if(json_decode($data->{$row->field}) !== null)
                                                                    @foreach(json_decode($data->{$row->field}) as $file)
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                            {{ $file->original_name ?: '' }}
                                                                        </a>
                                                                        <br/>
                                                                    @endforeach
                                                                @else
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                        Download
                                                                    </a>
                                                                @endif
                                                            @elseif($row->type == 'rich_text_box')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                            @elseif($row->type == 'coordinates')
                                                                @include('voyager::partials.coordinates-static-image')
                                                            @elseif($row->type == 'multiple_images')
                                                                @php $images = json_decode($data->{$row->field}); @endphp
                                                                @if($images)
                                                                    @php $images = array_slice($images, 0, 3); @endphp
                                                                    @foreach($images as $image)
                                                                        <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                    @endforeach
                                                                @endif
                                                            @elseif($row->type == 'media_picker')
                                                                @php
                                                                    if (is_array($data->{$row->field})) {
                                                                        $files = $data->{$row->field};
                                                                    } else {
                                                                        $files = json_decode($data->{$row->field});
                                                                    }
                                                                @endphp
                                                                @if ($files)
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                        <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                        @endforeach
                                                                    @else
                                                                        <ul>
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                            <li>{{ $file }}</li>
                                                                        @endforeach
                                                                        </ul>
                                                                    @endif
                                                                    @if (count($files) > 3)
                                                                        {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                    @endif
                                                                @elseif (is_array($files) && count($files) == 0)
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @elseif ($data->{$row->field} != '')
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                    @else
                                                                        {{ $data->{$row->field} }}

                                                                    @endif
                                                                @else
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @endif
                                                            @else
                                                                    {{-- AQUI EL CODIGO --}}
                                                                @switch($row->field)
                                                                    @case('categoria_id')
                                                                    @php
                                                                        $categoria = App\Categoria::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $categoria ? $categoria->name : null }}</span>
                                                                    @break

                                                                    @case('type_producto_id')
                                                                    @php
                                                                        $type_producto = App\TypeProducto::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $type_producto ? $type_producto->name : null }}</span>
                                                                    @break

                                                                    @case('presentacion_id')
                                                                    @php
                                                                        $presentacion_producto = App\Presentacione::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $presentacion_producto ? $presentacion_producto->name : null }}</span>
                                                                    @break

                                                                    @case('laboratorio_id')
                                                                    @php
                                                                        $laboratorio_producto = App\Laboratorio::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $laboratorio_producto ? $laboratorio_producto->name : null }}</span>
                                                                    @break

                                                                    @case('marca_id')
                                                                    @php
                                                                        $marca_producto = App\Marca::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $marca_producto ? $marca_producto->name : null }}</span>
                                                                    @break

                                                                    {{-- @case('status')
                                                                    @php
                                                                        if(($data->{$row->field})){
                                                                            $estado="Activo";
                                                                        }
                                                                        else{
                                                                            $estado="Inactivo";
                                                                        }
                                                                    @endphp
                                                                    <span>{{ $estado ? $estado : null }}</span>
                                                                    @break --}}


                                                                    @default
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <span>{{ $data->{$row->field} }}</span>

                                                                @endswitch


                                                            @endif
                                                        </td>
                                                    @endforeach



                                                    <td class="no-sort no-click bread-actions">
                                                        @foreach($actions as $action)
                                                            @if (!method_exists($action, 'massAction'))
                                                                @include('voyager::bread.partials.actions', ['action' => $action])
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @break

                            @case('compras-productos')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                <tr>

                                                    @if($showCheckboxColumn)
                                                        <td>
                                                            <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                        </td>
                                                    @endif
                                                    @foreach($dataType->browseRows as $row)


                                                        @php
                                                        if ($data->{$row->field.'_browse'}) {
                                                            $data->{$row->field} = $data->{$row->field.'_browse'};
                                                        }
                                                        @endphp

                                                        <td>
                                                            @if (isset($row->details->view))
                                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                            @elseif($row->type == 'image')
                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                            @elseif($row->type == 'relationship')
                                                                @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                            @elseif($row->type == 'select_multiple')
                                                                @if(property_exists($row->details, 'relationship'))

                                                                    @foreach($data->{$row->field} as $item)
                                                                        {{ $item->{$row->field} }}
                                                                    @endforeach

                                                                @elseif(property_exists($row->details, 'options'))
                                                                    @if (!empty(json_decode($data->{$row->field})))
                                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif
                                                                @endif

                                                                @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                    @if (@count(json_decode($data->{$row->field})) > 0)
                                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif

                                                            @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                    {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'checkbox')
                                                                @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                    @if($data->{$row->field})
                                                                        <span class="label label-info">{{ $row->details->on }}</span>
                                                                    @else
                                                                        <span class="label label-primary">{{ $row->details->off }}</span>
                                                                    @endif
                                                                @else
                                                                {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'color')
                                                                <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                            @elseif($row->type == 'text')


                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                            @elseif($row->type == 'text_area')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                            @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                @if(json_decode($data->{$row->field}) !== null)
                                                                    @foreach(json_decode($data->{$row->field}) as $file)
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                            {{ $file->original_name ?: '' }}
                                                                        </a>
                                                                        <br/>
                                                                    @endforeach
                                                                @else
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                        Download
                                                                    </a>
                                                                @endif
                                                            @elseif($row->type == 'rich_text_box')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                            @elseif($row->type == 'coordinates')
                                                                @include('voyager::partials.coordinates-static-image')
                                                            @elseif($row->type == 'multiple_images')
                                                                @php $images = json_decode($data->{$row->field}); @endphp
                                                                @if($images)
                                                                    @php $images = array_slice($images, 0, 3); @endphp
                                                                    @foreach($images as $image)
                                                                        <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                    @endforeach
                                                                @endif
                                                            @elseif($row->type == 'media_picker')
                                                                @php
                                                                    if (is_array($data->{$row->field})) {
                                                                        $files = $data->{$row->field};
                                                                    } else {
                                                                        $files = json_decode($data->{$row->field});
                                                                    }
                                                                @endphp
                                                                @if ($files)
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                        <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                        @endforeach
                                                                    @else
                                                                        <ul>
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                            <li>{{ $file }}</li>
                                                                        @endforeach
                                                                        </ul>
                                                                    @endif
                                                                    @if (count($files) > 3)
                                                                        {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                    @endif
                                                                @elseif (is_array($files) && count($files) == 0)
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @elseif ($data->{$row->field} != '')
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                    @else
                                                                        {{ $data->{$row->field} }}

                                                                    @endif
                                                                @else
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @endif
                                                            @else
                                                                    {{-- AQUI EL CODIGO --}}
                                                                @switch($row->field)
                                                                    @case('editor_id')
                                                                    @php
                                                                        $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $user->name }}</span>
                                                                    @break
                                                                    @case('unidad_id')
                                                                    @php
                                                                        $unidad = App\Unidade::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $unidad ? $unidad->name : null }}</span>
                                                                    @break

                                                                    @case('proveedor_id')
                                                                    @php
                                                                        $proveedor = App\TypeProducto::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $proveedor ? $proveedor->name : null }}</span>
                                                                    @break

                                                                    @case('producto_id')
                                                                    @php
                                                                        $producto = App\Producto::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $producto ? $producto->name : null }}</span>
                                                                    @break
                                                                    @case('presentacion_id')
                                                                    @php
                                                                        $presentacion = App\Presentacione::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $presentacion ? $presentacion->name : null }}</span>
                                                                    @break

                                                                    @case('laboratorio_id')
                                                                    @php
                                                                        $laboratorio_producto = App\Laboratorio::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $laboratorio_producto ? $laboratorio_producto->name : null }}</span>
                                                                    @break

                                                                    @case('marca_id')
                                                                    @php
                                                                        $marca_producto = App\Marca::find($data->{$row->field});
                                                                    @endphp
                                                                    <span>{{ $marca_producto ? $marca_producto->name : null }}</span>
                                                                    @break

                                                                    @default
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <span>{{ $data->{$row->field} }}</span>

                                                                @endswitch


                                                            @endif
                                                        </td>
                                                    @endforeach



                                                    <td class="no-sort no-click bread-actions">
                                                        @foreach($actions as $action)
                                                            @if (!method_exists($action, 'massAction'))
                                                                @include('voyager::bread.partials.actions', ['action' => $action])
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @break

                            @case('productions')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                @if($data->register_id == Auth::user()->id )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('producto_id')
                                                                                @php
                                                                                    $producto = App\Producto::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $producto ? $producto->name : null }}</span>
                                                                                @break

                                                                            @case('user_id')
                                                                                @php
                                                                                $editor=TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $editor ? $editor->name : null }}</span>

                                                                                @break



                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>


                                                        @endforeach




                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->id == 1)
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('producto_id')
                                                                                @php
                                                                                    $producto = App\Producto::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $producto ? $producto->name : null }}</span>
                                                                                @break

                                                                            @case('user_id')
                                                                                @php
                                                                                $editor=TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $editor ? $editor->name : null }}</span>

                                                                                @break


                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>
                                                        @endforeach
                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @break
                            @case('production-insumos')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                @if($data->register_id == Auth::user()->id )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else
                                                                            @switch($row->field)

                                                                                @case('insumo_id')
                                                                                    @php
                                                                                        // $type = App\ProductionInsumo::find($data->id);
                                                                                        // $miinsumo = false;
                                                                                        // if ($type->type_insumo == 'elaborado') {
                                                                                        //     $miinsumo = App\ProductosSemiElaborado::find($data->{$row->field});
                                                                                        // } else if($type->type_insumo == 'simple'){
                                                                                        //     $miinsumo = App\Insumo::find($data->{$row->field});
                                                                                        // }
                                                                                            $insumo= App\Insumo::find($data->{$row->field});
                                                                                    @endphp
                                                                                    {{-- <span>{{ $miinsumo ? $miinsumo->name : null }}</span> --}}
                                                                                        <span>{{ $insumo ? $insumo->name : null }}</span>

                                                                                    @break

                                                                                @case('elaborado_id')
                                                                                    @php
                                                                                        $elaborado= App\ProductosSemiElaborado::find($data->{$row->field});
                                                                                    @endphp
                                                                                    <span>{{ $elaborado ? $elaborado->name : null }}</span>



                                                                                @break

                                                                                @case('proveedor_id')
                                                                                    @php
                                                                                        $proveedor = App\Proveedore::find($data->{$row->field});
                                                                                    @endphp
                                                                                    <span>{{ $proveedor ? $proveedor->name : null }}</span>
                                                                                    @break


                                                                                @default
                                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                    <span>{{ $data->{$row->field} }}</span>
                                                                            @endswitch
                                                                    @endif
                                                                </td>


                                                        @endforeach




                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->id == 1)
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('insumo_id')
                                                                            @php
                                                                                // $type = App\ProductionInsumo::find($data->id);
                                                                                // $miinsumo = false;
                                                                                // if ($type->type_insumo == 'elaborado') {
                                                                                //     $miinsumo = App\ProductosSemiElaborado::find($data->{$row->field});
                                                                                // } else if($type->type_insumo == 'simple'){
                                                                                //     $miinsumo = App\Insumo::find($data->{$row->field});
                                                                                // }
                                                                                    $insumo= App\Insumo::find($data->{$row->field});
                                                                            @endphp
                                                                            {{-- <span>{{ $miinsumo ? $miinsumo->name : null }}</span> --}}
                                                                                <span>{{ $insumo ? $insumo->name : null }}</span>

                                                                            @break

                                                                            @case('elaborado_id')
                                                                                @php
                                                                                    $elaborado= App\ProductosSemiElaborado::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $elaborado ? $elaborado->name : null }}</span>


                                                                            @break


                                                                            @case('proveedor_id')
                                                                                @php
                                                                                    $proveedor = App\Proveedore::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $proveedor ? $proveedor->name : null }}</span>
                                                                                @break


                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }} </span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>
                                                        @endforeach
                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @break
                            @case('production-semis')
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                @if($data->register_id == Auth::user()->id )
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('user_id')
                                                                                @php
                                                                                $editor=TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $editor ? $editor->name : null }}</span>

                                                                                @break

                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>


                                                        @endforeach




                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->id == 1)
                                                    <tr>
                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                                <td>
                                                                    @if (isset($row->details->view))
                                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                    @elseif($row->type == 'image')
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                    @elseif($row->type == 'relationship')
                                                                        @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                    @elseif($row->type == 'select_multiple')
                                                                        @if(property_exists($row->details, 'relationship'))

                                                                            @foreach($data->{$row->field} as $item)
                                                                                {{ $item->{$row->field} }}
                                                                            @endforeach

                                                                        @elseif(property_exists($row->details, 'options'))
                                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif
                                                                        @endif

                                                                        @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                            @if (@count(json_decode($data->{$row->field})) > 0)
                                                                                @foreach(json_decode($data->{$row->field}) as $item)
                                                                                    @if (@$row->details->options->{$item})
                                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                {{ __('voyager::generic.none') }}
                                                                            @endif

                                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                        @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                        @else
                                                                            {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'checkbox')
                                                                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                            @if($data->{$row->field})
                                                                                <span class="label label-info">{{ $row->details->on }}</span>
                                                                            @else
                                                                                <span class="label label-primary">{{ $row->details->off }}</span>
                                                                            @endif
                                                                        @else
                                                                        {{ $data->{$row->field} }}
                                                                        @endif
                                                                    @elseif($row->type == 'color')
                                                                        <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                    @elseif($row->type == 'text')


                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                    @elseif($row->type == 'text_area')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        @if(json_decode($data->{$row->field}) !== null)
                                                                            @foreach(json_decode($data->{$row->field}) as $file)
                                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                    {{ $file->original_name ?: '' }}
                                                                                </a>
                                                                                <br/>
                                                                            @endforeach
                                                                        @else
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                                Download
                                                                            </a>
                                                                        @endif
                                                                    @elseif($row->type == 'rich_text_box')
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                    @elseif($row->type == 'coordinates')
                                                                        @include('voyager::partials.coordinates-static-image')
                                                                    @elseif($row->type == 'multiple_images')
                                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                                        @if($images)
                                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                                            @foreach($images as $image)
                                                                                <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @endif
                                                                    @elseif($row->type == 'media_picker')
                                                                        @php
                                                                            if (is_array($data->{$row->field})) {
                                                                                $files = $data->{$row->field};
                                                                            } else {
                                                                                $files = json_decode($data->{$row->field});
                                                                            }
                                                                        @endphp
                                                                        @if ($files)
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                                @endforeach
                                                                            @else
                                                                                <ul>
                                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                                    <li>{{ $file }}</li>
                                                                                @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            @if (count($files) > 3)
                                                                                {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                            @endif
                                                                        @elseif (is_array($files) && count($files) == 0)
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @elseif ($data->{$row->field} != '')
                                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                            @else
                                                                                {{ $data->{$row->field} }}

                                                                            @endif
                                                                        @else
                                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                                        @endif
                                                                    @else

                                                                        @switch($row->field)
                                                                            @case('user_id')
                                                                                @php
                                                                                $editor=TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $editor ? $editor->name : null }}</span>

                                                                            @break

                                                                            @default
                                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                                <span>{{ $data->{$row->field} }}</span>
                                                                        @endswitch

                                                                    @endif
                                                                </td>
                                                        @endforeach
                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @break
                            @case('detalle-ventas')
                                <div class="col-sm-4">
                                    @php
                                        $venta =  App\Venta::find($_GET['s']);
                                        $cliente = App\Cliente::find($venta->cliente_id);
                                        $caja = App\Caja::find($venta->caja_id);
                                        $sucursal = App\Sucursale::find($venta->sucursal_id);
                                        $delivery = App\Mensajero::find($venta->delivery_id);
                                        $editor = TCG\Voyager\Models\User::find($venta->register_id);
                                        $estado = App\Estado::find($venta->status_id);
                                        $option = App\Option::find($venta->option_id);
                                        $pago = App\Pago::find($venta->pago_id);
                                        $cupon = App\Cupone::find($venta->cupon_id);
                                        $location = App\Location::find($venta->location);
                                        $banipay = App\Banipay::where('venta_id', $venta->id)->first();

                                    @endphp
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-not-orderable">Key</th><th>Valor</th>
                                            <tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ID</td><th>{{ $venta->id;  }}</th>
                                            <tr>
                                            <tr>
                                                <td>Ticket</td><th>{{ $venta->ticket;  }}</th>
                                            <tr>
                                            <tr>
                                                <td>Total</td><th>{{ $venta->total }}</th>
                                            <tr>
                                            <tr>
                                                <td>Recibo/Factura</td><th>{{ $venta->factura;  }}</th>
                                            <tr>
                                            <tr>
                                                <td>Estado</td><th>{{ $estado->title;  }}</th>
                                            <tr>
                                            <tr>
                                                <td>Tipo</td><th>{{ $option->title;  }}</th>
                                            <tr>
                                            <tr>
                                                <td>Fecha</td><th>{{ $venta->created_at }}</th>
                                            <tr>
                                            <tr>
                                                <td>Cliente</td><th>{{ $cliente->first_name.'  '.$cliente->last_name }}</th>
                                            <tr>
                                            <tr>
                                                <td>Direccion</td><th>{{ $location->descripcion }}</th>
                                            <tr>
                                            <tr>
                                                <td>Cupon</td><th>{{ $cupon->title }}</th>
                                            <tr>
                                            <tr>
                                                <td>Pasarela</td><th>
                                                    {{ $pago->title;  }} <br>
                                                    @if ($banipay)
                                                        <a href="{{ setting('banipay.url_base').$banipay->urlTransaction }}" target="_blank" >Link de Pago - BaniPay</a>
                                                    @endif

                                                </th>
                                            <tr>
                                            <tr>
                                                <td>Caja</td><th>{{ $caja->title }}</th>
                                            <tr>
                                            <tr>
                                                <td>Sucursal</td><th>{{ $sucursal->name }}</th>
                                            <tr>
                                            <tr>
                                                <td>Delivery</td><th>{{ $delivery->name }}</th>
                                            <tr>
                                            <tr>
                                                <td>Control</td><th>{{ $venta->caja_status }}</th>
                                            <tr>
                                            <tr>
                                                <td>Cantidad</td><th>{{ $venta->cantidad }}</th>
                                            <tr>
                                            <tr>
                                                <td>Recibido</td><th>{{ $venta->recibido }}</th>
                                            <tr>
                                            <tr>
                                                <td>Cambio</td><th>{{ $venta->cambio }}</th>
                                            <tr>
                                            <tr>
                                                <td>Descuento</td><th>{{ $venta->descuento }}</th>
                                            <tr>

                                            <tr>
                                                <td>Editor</td><th>{{ $editor->name }}</th>
                                            <tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-8">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    @if($showCheckboxColumn)
                                                        <th class="dt-not-orderable">
                                                            <input type="checkbox" class="select_all">
                                                        </th>
                                                    @endif
                                                    @foreach($dataType->browseRows as $row)
                                                        <th>
                                                            @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                                <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                            @endif
                                                            {{ $row->getTranslatedAttribute('display_name') }}
                                                            @if ($isServerSide)
                                                                @if ($row->isCurrentSortField($orderBy))
                                                                    @if ($sortOrder == 'asc')
                                                                        <i class="voyager-angle-up pull-right"></i>
                                                                    @else
                                                                        <i class="voyager-angle-down pull-right"></i>
                                                                    @endif
                                                                @endif
                                                                </a>
                                                            @endif
                                                        </th>
                                                    @endforeach

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dataTypeContent as $data)
                                                    <tr>

                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif
                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                            <td>
                                                                @if (isset($row->details->view))
                                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                @elseif($row->type == 'image')
                                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                @elseif($row->type == 'relationship')
                                                                    @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                @elseif($row->type == 'select_multiple')
                                                                    @if(property_exists($row->details, 'relationship'))

                                                                        @foreach($data->{$row->field} as $item)
                                                                            {{ $item->{$row->field} }}
                                                                        @endforeach

                                                                    @elseif(property_exists($row->details, 'options'))
                                                                        @if (!empty(json_decode($data->{$row->field})))
                                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                                @if (@$row->details->options->{$item})
                                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            {{ __('voyager::generic.none') }}
                                                                        @endif
                                                                    @endif

                                                                    @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                        @if (@count(json_decode($data->{$row->field})) > 0)
                                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                                @if (@$row->details->options->{$item})
                                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            {{ __('voyager::generic.none') }}
                                                                        @endif

                                                                @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                    @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                        {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                    @else
                                                                        {{ $data->{$row->field} }}
                                                                    @endif
                                                                @elseif($row->type == 'checkbox')
                                                                    @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                        @if($data->{$row->field})
                                                                            <span class="label label-info">{{ $row->details->on }}</span>
                                                                        @else
                                                                            <span class="label label-primary">{{ $row->details->off }}</span>
                                                                        @endif
                                                                    @else
                                                                    {{ $data->{$row->field} }}
                                                                    @endif
                                                                @elseif($row->type == 'color')
                                                                    <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                @elseif($row->type == 'text')


                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                @elseif($row->type == 'text_area')
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    @if(json_decode($data->{$row->field}) !== null)
                                                                        @foreach(json_decode($data->{$row->field}) as $file)
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                {{ $file->original_name ?: '' }}
                                                                            </a>
                                                                            <br/>
                                                                        @endforeach
                                                                    @else
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                            Download
                                                                        </a>
                                                                    @endif
                                                                @elseif($row->type == 'rich_text_box')
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                @elseif($row->type == 'coordinates')
                                                                    @include('voyager::partials.coordinates-static-image')
                                                                @elseif($row->type == 'multiple_images')
                                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                                    @if($images)
                                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                                        @foreach($images as $image)
                                                                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                        @endforeach
                                                                    @endif
                                                                @elseif($row->type == 'media_picker')
                                                                    @php
                                                                        if (is_array($data->{$row->field})) {
                                                                            $files = $data->{$row->field};
                                                                        } else {
                                                                            $files = json_decode($data->{$row->field});
                                                                        }
                                                                    @endphp
                                                                    @if ($files)
                                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                            <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @else
                                                                            <ul>
                                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                                <li>{{ $file }}</li>
                                                                            @endforeach
                                                                            </ul>
                                                                        @endif
                                                                        @if (count($files) > 3)
                                                                            {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                        @endif
                                                                    @elseif (is_array($files) && count($files) == 0)
                                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                                    @elseif ($data->{$row->field} != '')
                                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                        @else
                                                                            {{ $data->{$row->field} }}

                                                                        @endif
                                                                    @else
                                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                                    @endif
                                                                @else

                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <span>{{ $data->{$row->field} }}</span>
                                                                @endif
                                                            </td>
                                                        @endforeach




                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <label for="">Mueve el marcador para mejorar tu ubicacion</label>
                                            <div id="map"></div>
                                        </div>
                                    </div>

                                </div>
                                @break
                            @case('detalle-cajas')

                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    @if($showCheckboxColumn)
                                                        <th class="dt-not-orderable">
                                                            <input type="checkbox" class="select_all">
                                                        </th>
                                                    @endif
                                                    <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                                    @foreach($dataType->browseRows as $row)
                                                        <th>
                                                            @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                                <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                            @endif
                                                            {{ $row->getTranslatedAttribute('display_name') }}
                                                            @if ($isServerSide)
                                                                @if ($row->isCurrentSortField($orderBy))
                                                                    @if ($sortOrder == 'asc')
                                                                        <i class="voyager-angle-up pull-right"></i>
                                                                    @else
                                                                        <i class="voyager-angle-down pull-right"></i>
                                                                    @endif
                                                                @endif
                                                                </a>
                                                            @endif
                                                        </th>
                                                    @endforeach

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dataTypeContent as $data)
                                                    <tr>

                                                        @if($showCheckboxColumn)
                                                            <td>
                                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                            </td>
                                                        @endif

                                                        <td class="no-sort no-click bread-actions">
                                                            @foreach($actions as $action)
                                                                @if (!method_exists($action, 'massAction'))
                                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        @foreach($dataType->browseRows as $row)


                                                            @php
                                                            if ($data->{$row->field.'_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                                            }
                                                            @endphp

                                                            <td>
                                                                @if (isset($row->details->view))
                                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                                @elseif($row->type == 'image')
                                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                                @elseif($row->type == 'relationship')
                                                                    @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                                @elseif($row->type == 'select_multiple')
                                                                    @if(property_exists($row->details, 'relationship'))

                                                                        @foreach($data->{$row->field} as $item)
                                                                            {{ $item->{$row->field} }}
                                                                        @endforeach

                                                                    @elseif(property_exists($row->details, 'options'))
                                                                        @if (!empty(json_decode($data->{$row->field})))
                                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                                @if (@$row->details->options->{$item})
                                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            {{ __('voyager::generic.none') }}
                                                                        @endif
                                                                    @endif

                                                                    @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                        @if (@count(json_decode($data->{$row->field})) > 0)
                                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                                @if (@$row->details->options->{$item})
                                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            {{ __('voyager::generic.none') }}
                                                                        @endif

                                                                @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                    @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                        {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                    @else
                                                                        {{ $data->{$row->field} }}
                                                                    @endif
                                                                @elseif($row->type == 'checkbox')
                                                                    @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                        @if($data->{$row->field})
                                                                            <span class="label label-info">{{ $row->details->on }}</span>
                                                                        @else
                                                                            <span class="label label-primary">{{ $row->details->off }}</span>
                                                                        @endif
                                                                    @else
                                                                    {{ $data->{$row->field} }}
                                                                    @endif
                                                                @elseif($row->type == 'color')
                                                                    <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                                @elseif($row->type == 'text')


                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                                @elseif($row->type == 'text_area')
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    @if(json_decode($data->{$row->field}) !== null)
                                                                        @foreach(json_decode($data->{$row->field}) as $file)
                                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                                {{ $file->original_name ?: '' }}
                                                                            </a>
                                                                            <br/>
                                                                        @endforeach
                                                                    @else
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                            Download
                                                                        </a>
                                                                    @endif
                                                                @elseif($row->type == 'rich_text_box')
                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                                @elseif($row->type == 'coordinates')
                                                                    @include('voyager::partials.coordinates-static-image')
                                                                @elseif($row->type == 'multiple_images')
                                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                                    @if($images)
                                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                                        @foreach($images as $image)
                                                                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                        @endforeach
                                                                    @endif
                                                                @elseif($row->type == 'media_picker')
                                                                    @php
                                                                        if (is_array($data->{$row->field})) {
                                                                            $files = $data->{$row->field};
                                                                        } else {
                                                                            $files = json_decode($data->{$row->field});
                                                                        }
                                                                    @endphp
                                                                    @if ($files)
                                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                            <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                            @endforeach
                                                                        @else
                                                                            <ul>
                                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                                <li>{{ $file }}</li>
                                                                            @endforeach
                                                                            </ul>
                                                                        @endif
                                                                        @if (count($files) > 3)
                                                                            {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                        @endif
                                                                    @elseif (is_array($files) && count($files) == 0)
                                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                                    @elseif ($data->{$row->field} != '')
                                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                        @else
                                                                            {{ $data->{$row->field} }}

                                                                        @endif
                                                                    @else
                                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                                    @endif
                                                                @else

                                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                                    <span>{{ $data->{$row->field} }}</span>
                                                                @endif
                                                            </td>
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @break
                            @default
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <input type="checkbox" class="select_all">
                                                    </th>
                                                @endif
                                                @foreach($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataTypeContent as $data)
                                                <tr>

                                                    @if($showCheckboxColumn)
                                                        <td>
                                                            <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                        </td>
                                                    @endif
                                                    @foreach($dataType->browseRows as $row)


                                                        @php
                                                        if ($data->{$row->field.'_browse'}) {
                                                            $data->{$row->field} = $data->{$row->field.'_browse'};
                                                        }
                                                        @endphp

                                                        <td>
                                                            @if (isset($row->details->view))
                                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                            @elseif($row->type == 'image')
                                                                <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                            @elseif($row->type == 'relationship')
                                                                @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                            @elseif($row->type == 'select_multiple')
                                                                @if(property_exists($row->details, 'relationship'))

                                                                    @foreach($data->{$row->field} as $item)
                                                                        {{ $item->{$row->field} }}
                                                                    @endforeach

                                                                @elseif(property_exists($row->details, 'options'))
                                                                    @if (!empty(json_decode($data->{$row->field})))
                                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif
                                                                @endif

                                                                @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                    @if (@count(json_decode($data->{$row->field})) > 0)
                                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif

                                                            @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                                {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                    {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'checkbox')
                                                                @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                    @if($data->{$row->field})
                                                                        <span class="label label-info">{{ $row->details->on }}</span>
                                                                    @else
                                                                        <span class="label label-primary">{{ $row->details->off }}</span>
                                                                    @endif
                                                                @else
                                                                {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'color')
                                                                <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                            @elseif($row->type == 'text')


                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                            @elseif($row->type == 'text_area')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                            @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                @if(json_decode($data->{$row->field}) !== null)
                                                                    @foreach(json_decode($data->{$row->field}) as $file)
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                            {{ $file->original_name ?: '' }}
                                                                        </a>
                                                                        <br/>
                                                                    @endforeach
                                                                @else
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                        Download
                                                                    </a>
                                                                @endif
                                                            @elseif($row->type == 'rich_text_box')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                            @elseif($row->type == 'coordinates')
                                                                @include('voyager::partials.coordinates-static-image')
                                                            @elseif($row->type == 'multiple_images')
                                                                @php $images = json_decode($data->{$row->field}); @endphp
                                                                @if($images)
                                                                    @php $images = array_slice($images, 0, 3); @endphp
                                                                    @foreach($images as $image)
                                                                        <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                    @endforeach
                                                                @endif
                                                            @elseif($row->type == 'media_picker')
                                                                @php
                                                                    if (is_array($data->{$row->field})) {
                                                                        $files = $data->{$row->field};
                                                                    } else {
                                                                        $files = json_decode($data->{$row->field});
                                                                    }
                                                                @endphp
                                                                @if ($files)
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                        <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                        @endforeach
                                                                    @else
                                                                        <ul>
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                            <li>{{ $file }}</li>
                                                                        @endforeach
                                                                        </ul>
                                                                    @endif
                                                                    @if (count($files) > 3)
                                                                        {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                    @endif
                                                                @elseif (is_array($files) && count($files) == 0)
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @elseif ($data->{$row->field} != '')
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                    @else
                                                                        {{ $data->{$row->field} }}

                                                                    @endif
                                                                @else
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @endif
                                                            @else

                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <span>{{ $data->{$row->field} }}</span>
                                                            @endif
                                                        </td>
                                                    @endforeach



                                                    <td class="no-sort no-click bread-actions">
                                                        @foreach($actions as $action)
                                                            @if (!method_exists($action, 'massAction'))
                                                                @include('voyager::bread.partials.actions', ['action' => $action])
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @endswitch
                        @if ($isServerSide)
                            @switch($dataType->getTranslatedAttribute('slug'))


                                @case('cocinas')

                                    @break
                                @default
                                <div class="pull-left">
                                    <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                        'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                            'from' => $dataTypeContent->firstItem(),
                                            'to' => $dataTypeContent->lastItem(),
                                            'all' => $dataTypeContent->total()
                                        ]) }}</div>
                                </div>
                                <div class="pull-right">
                                    {{ $dataTypeContent->appends([
                                        's' => $search->value,
                                        'filter' => $search->filter,
                                        'key' => $search->key,
                                        'order_by' => $orderBy,
                                        'sort_order' => $sortOrder,
                                        'showSoftDeleted' => $showSoftDeleted,
                                    ])->links() }}
                                </div>
                            @endswitch
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------------MODAL-------------------  -->
    <!-- ---------------------MODAL-------------------  -->

        <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="#" id="delete_form" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                        </form>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal modal-primary fade" tabindex="-1" id="modal_deudas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <h4>Deudas Choferes</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-sm-6">
                                <label for="">Elija una Caja</label>
                                <select name="" id="micajas" class="form-control js-example-basic-single"></select>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Elija un Chofer</label>
                                <select name="" id="michoferes" class="form-control js-example-basic-single"></select>
                            </div>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary pull-right" onclick="filtro1()">Consultar</button>
                            </div>
                            <div class="col-sm-12">
                                <table class="table" id="table_deudas">
                                    <thead>
                                        <tr>
                                            <th>Venta</th>
                                            <th>Cliente</th>
                                            <th>Pasarela</th>
                                            <th>Delivery</th>
                                            <th>Subtotal</th>
                                            <th>Creado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Consultar</button> --}}
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <div class="modal modal-primary fade" tabindex="-1" id="modal_kardex" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <h4>Kardex Pensionados</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-6">
                                {{-- <label for="">Elija una Sucursal</label> --}}
                                <strong>Elija una Sucursal</strong>
                                <select name="" id="sucursalpensionado" class="form-control js-example-basic-single"></select>
                            </div>
                            <div class="col-sm-6">
                                {{-- <label for="">Elija un Pensionado</label> --}}
                                <strong>Elija un Pensionado</strong>
                                <select name="" id="mipensionado" class="form-control js-example-basic-single"></select>
                            </div>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary pull-right" onclick="FiltroKardex()">Consultar</button>
                            </div>
                            <div class="col-sm-12">
                                <table class="table" id="table_kardex">
                                    <thead>
                                        <tr>
                                            <th>Venta</th>
                                            <th>Cliente</th>

                                            <th>Creado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Consultar</button> --}}
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <div class="modal modal-primary fade" tabindex="-1" id="modal_cobros" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <h4>Ventas a Crédito</h4>
                    </div>
                    <div class="modal-body">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Créditos</a></li>
                            <li role="presentation" ><a href="#historial" aria-controls="historial" role="tab" data-toggle="tab">Historial</a></li>
                            <li role="presentation" ><a href="#cobro" aria-controls="cobro" role="tab" data-toggle="tab">Cobrar</a></li>

                        </ul>
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="home">

                                    <div class="col-sm-4">
                                        {{-- <label for="">Elija una Sucursal</label> --}}
                                        <strong>Elija una Sucursal</strong>
                                        <select name="" id="sucursal_consulta" class="form-control js-example-basic-single"></select>
                                    </div>
                                    <div class="col-sm-4">
                                        {{-- <label for="">Elija un Pensionado</label> --}}
                                        <strong>Elija un Cliente</strong>
                                        <select name="" id="cliente_consulta" class="form-control js-example-basic-single"></select>
                                    </div>


                                    <div class="col-sm-7">
                                        <button type="button" class="btn btn-primary pull-right" onclick="ConsultarCredito()">Consultar</button>
                                    </div>
                                    <div class="col-sm-12">
                                        <table class="table" id="table_consultas_cobros">
                                            <thead>
                                                <tr>
                                                    <th>Venta</th>
                                                    <th>Estado</th>
                                                    <th>Cliente</th>
                                                    <th>Deuda</th>
                                                    <th>Creado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                        </table>

                                    </div>
                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>

                            </div>

                            <div role="tabpanel" class="tab-pane" id="historial">

                                <div class="col-sm-12">
                                    <table class="table" id="table_historial">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Venta</th>
                                                <th>Cliente</th>
                                                <th>Deuda</th>
                                                <th>Cuota</th>
                                                <th>Restante a Pagar</th>
                                                <th>Creado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>

                                    </table>

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="cobro">
                                <div class="col-sm-12">
                                    <table class="table" id="table_cobros">
                                        <thead>
                                            <tr>
                                                <th>Venta</th>
                                                <th>Cliente</th>
                                                <th>Deuda</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>

                                    </table>
                                    <div class="form-group col-md-4 text-center">
                                        <form class="form-horizontal" role="form">
                                            <label class="radio-inline"> <input type="radio" name="season" id="" value="1" checked> Pago En Efectivo </label>
                                            <label class="radio-inline"> <input type="radio" name="season" id="" value="0"> Pago en Línea </label>
                                        </form>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Cuota</label>
                                        <input class="form-control" type="number" value="0" min="0" placeholder="Ingrese Monto" id="cuota_cobro">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Venta" id="venta_id">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Deuda" id="deuda">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Cliente" id="cliente_id">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese texto Cliente" id="cliente_text">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Restante" id="restante">
                                    </div>

                                </div>
                                <button type="button" class="btn btn-primary pull-right" onclick="ActualizarCredito()">Guardar</button>
                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>



                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Consultar</button> --}}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <div class="modal modal-primary fade" tabindex="-1" id="modal_capital" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <h4>Capital en Productos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            {{-- <div class="col-sm-6">
                                <strong>Elija una Sucursal</strong>
                                <select name="" id="sucursalpensionado" class="form-control js-example-basic-single"></select>
                            </div> --}}

                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary pull-right" onclick="CalcularCapitalDefault()">Consultar</button>
                            </div>
                            <div class="col-sm-12">
                                <table class="table" id="table-capital-productos">
                                    <thead>
                                        <tr>
                                            <th>Cantidad Productos</th>
                                            <th>Total Stock * Cantidad Productos</th>
                                            <th>Promedio de Ganancia por Producto</th>
                                            <th><b>Capital en Productos</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Consultar</button> --}}
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

@stop



<!-- ---------------------CSS-------------------  -->
<!-- ---------------------CSS-------------------  -->

@section('css')
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
    <style>
        #map {
            width: 100%;
            height: 350px;
            /* box-shadow: 5px 5px 5px #888; */
        }
    </style>
@stop

@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
@endif


<!-- ---------------------JS-------------------  -->
<!-- ---------------------JS-------------------  -->
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    @php
        $mislug =  $dataType->getTranslatedAttribute('slug');
    @endphp
    <script>
        $('document').ready(function () {
            $('.js-example-basic-single').select2();
            DesactivarPensionados();
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [
                            ['targets' => 'dt-not-orderable', 'searchable' =>  false, 'orderable' => false],
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif
            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });

        async function DesactivarPensionados(){
            var table=await axios.get("{{ setting('admin.url') }}api/pos/pensionados");
            for(let index=0;index < table.data.length;index++){
                var aux= parseInt(CalculoDiasRestantes(table.data[index].fecha_final));
                if(aux<0){
                var actualizar= await axios("{{ setting('admin.url') }}api/pos/pensionados/actualizar/"+table.data[index].id);
                }
            }
        }

        function CalculoDiasRestantes(fecha_final){
            var today=new Date();
            var fechaInicio =   today.toISOString().split('T')[0];
            var fechaFin    = fecha_final;
            var fi=fechaInicio.toString();
            var ff=fechaFin.toString();
            var fechai = new Date(fi).getTime();
            var fechaf    = new Date(ff).getTime();
            var diff = fechaf - fechai;
            return (diff/(1000*60*60*24));
        }

        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                    }else{
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                    }

                    $('#redir')[0].click();
                })
            })
        @endif

        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });

        @switch($mislug)
            @case('detalle-ventas')
                $('document').ready(function () {
                    getlocation()
                });
                function getlocation() {
                    var lat = '{{ $location->latitud }}'
                    var lng =  '{{ $location->longitud }}'
                    var map = L.map('map').setView([lat, lng], 14);
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 22
                    }).addTo(map);
                    var mimarker = L.marker([lat, lng], { title: "My marker", draggable: true }).addTo(map);
                    mimarker.bindPopup("Ubicacion solicitada").openPopup();
                }
                @break
            @case('cocinas')
                function cocina(id) {
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/cocina/"+id,
                        dataType: "json",
                        success: function () {
                            location.reload();
                        }
                    });
                    socket.emit("{{ setting('notificaciones.socket_cocina') }}", id);
                }
                @break
            @case('ventas')
                $('#search_key').on('change', async function() {
                    $('.js-example-basic-single').select2();
                    switch (this.value) {
                        case 'cliente_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/clientes",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cliente'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].first_name +" "+ response[index].last_name  +" "+ response[index].ci_nit
                                        }));
                                    }
                                }
                            });
                            break;
                        case 'sucursal_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/sucursales",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige una Sucursal'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                            case 'delivery_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/deliverys",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Delivery'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                            case 'chofer_id':
                            $('#s').find('option').remove().end();
                            const queryString = window.location.search;
                            const urlParams = new URLSearchParams(queryString);
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/choferes/",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Chofer'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                        case 'status_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/estados",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Estado'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                }
                            });
                            break
                        case 'pago_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/pagos",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Tipo de Pago'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                }
                            });
                            break
                        case'register_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/cajeros",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cajero'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                        case'cupon_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/cupones",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cajero'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        // const element = response[index];
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                }
                            });
                            break
                        case'option_id':
                            $('#s').find('option').remove().end();
                                $('#s').append($('<option>', {
                                    value: null,
                                    text: 'Elige una Opción'
                                }));
                                $('#s').append($('<option>', {
                                    value: 'Mesa',
                                    text: 'En Mesa'
                                }));
                                $('#s').append($('<option>', {
                                    value: 'Delivery',
                                    text: 'Delivery'
                                }));
                                $('#s').append($('<option>', {
                                    value: 'Recoger',
                                    text: 'Para Llevar'
                                }));
                            break
                        case 'chofer_deudas':
                                $('#modal_deudas').modal();
                                Cajas_Deudas_Choferes();
                                Choferes_Deudas();
                            break
                        case 'pensionado_kardex':
                            LimpiarKardex();
                            $('#modal_kardex').modal();
                            Sucursales();
                        break
                        case 'credito':
                            LimpiarCobroCreditos();
                            $('#modal_cobros').modal();
                            sucursal_consulta();
                        break
                        case 'caja_id':
                        $('#s').find('option').remove().end();
                                Cajas();
                        break
                        default:
                            //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
                            break
                    }
                });

                async function Cajas() {
                    var table= await axios.get("{{setting('admin.url')}}api/pos/cajas");
                    $('#s').append($('<option>', {
                        value: null,
                        text: 'Elige una Caja'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#s').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                    }

                }

                async function Cajas_Deudas_Choferes(){
                    $('#micajas').find('option').remove().end();
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/cajas");
                    $('#micajas').append($('<option>', {
                        value: null,
                        text: 'Elige una Caja'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#micajas').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].id + ' - '+ table.data[index].title +' - '+ table.data[index].sucursal.name
                        }));
                    }
                }

                async function Choferes_Deudas() {
                    $('#michoferes').find('option').remove().end();
                    var table=await axios.get("{{ setting('admin.url') }}api/pos/choferes/");
                    $('#michoferes').append($('<option>', {
                        value: null,
                        text: 'Elige un Chofer'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#michoferes').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                function filtro1() {
                    $('#table_deudas tbody tr').remove();
                    var urli = "{{ setting('admin.url') }}api/pos/choferes/deudas/"+$("#michoferes").val()+"/"+$("#micajas").val();
                    var mitable = "";
                    var total_efectivo=0;
                    var total_credito=0;
                    var total_banipay=0;
                    $.ajax({
                        url: urli,
                        dataType: "json",
                        success: function (response) {
                            if (response.length == 0 ) {
                                toastr.error('Sin Resultados.');
                            } else {

                                for (let index = 0; index < response.length; index++) {

                                    mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].cliente.display+"</td><td>"+response[index].pasarela.title+"</td><td>"+response[index].delivery.name+"</td><td>"+response[index].total+"</td><td>"+response[index].published+"</td></tr>";
                                    if(response[index].pasarela_id=="{{setting('ventas.banipay_1')}}"||response[index].pasarela_id=="{{setting('ventas.banipay_2')}}"){
                                        total_banipay+=response[index].total;
                                    }
                                    else{
                                        if(response[index].credito=='Contado'){
                                            total_efectivo+=response[index].total;
                                        }
                                        else{
                                            total_credito+=response[index].total;
                                        }
                                    }
                                    //console.log(response[index]);
                                }
                                mitable = mitable +"<tr><td></td><td></td><td></td><td></td><td>Total en Banipay</td><td><b>"+total_banipay+"</b></td> </tr>"
                                mitable = mitable +"<tr><td></td><td></td><td></td><td></td><td>Total a Credito</td><td><b>"+total_credito+"</b></td> </tr>"
                                mitable = mitable +"<tr><td></td><td></td><td></td><td><td></td>Total en Efectivo</td><td><b>"+total_efectivo+"</b></td> </tr>"

                                $('#table_deudas').append(mitable);
                            }
                        }
                    });
                    Cajas_Deudas_Choferes();
                    Choferes_Deudas();
                }

                async function Sucursales(){
                    $('#sucursalpensionado').find('option').remove().end();
                    var table = await axios.get("{{setting('admin.url')}}api/pos/sucursales");
                    $('#sucursalpensionado').append($('<option>', {
                        value: 0,
                        text: 'Elige una Sucursal'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#sucursalpensionado').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }
                $('#sucursalpensionado').on('change', function() {
                    Pensionados();

                });
                async function Pensionados(){
                    $('#mipensionado').find('option').remove().end();
                    var table = await axios.get("{{setting('admin.url')}}api/pos/pensionados");
                    $('#mipensionado').append($('<option>', {
                        value: 0,
                        text: 'Elige un Pensionado'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#mipensionado').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].cliente.display
                        }));
                    }

                }
                async function FiltroKardex() {
                    $('#table-kardex tbody tr').remove();
                    var table= await axios.get(" {{setting('admin.url')}}api/pos/pensionados/kardex/"+$("#sucursalpensionado").val()+"/"+$("#mipensionado").val());
                    var midata="";
                    total=0;
                    if (table.data.length == 0 ) {
                        toastr.error('Sin Resultados.');
                    } else {
                        for (let index = 0; index < table.data.length; index++) {
                            midata = midata + "<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].cliente.display+"</td><td>"+table.data[index].published+"</td></tr>";
                            total+=1;
                            var fecha=table.data[index].pensionado.fecha_final;
                        }
                        midata = midata +"<tr><td></td><td></td><td></td></tr>"
                        midata = midata +"<tr><td></td><td>Dias Ventas</td><td><b>"+total+"</b></td> </tr>"
                        midata = midata +"<tr><td></td><td>Dias Restantes del Plan</td><td><b>"+CalculoDiasRestantes(fecha)+"</b></td> </tr>"
                        $('#table_kardex').append(midata);
                    }
                    Sucursales();
                    Pensionados();
                }
                function CalculoDiasRestantes(fecha_final){
                    var today=new Date();
                    var fechaInicio =   today.toISOString().split('T')[0];
                    var fechaFin    = fecha_final;
                    var fi=fechaInicio.toString();
                    var ff=fechaFin.toString();
                    var fechai = new Date(fi).getTime();
                    var fechaf    = new Date(ff).getTime();
                    var diff = fechaf - fechai;
                    return (diff/(1000*60*60*24));
                }
                async function sucursal_consulta(){
                    $('#sucursal_consulta').find('option').remove().end();
                    var table= await axios.get("{{setting('admin.url')}}api/pos/sucursales");

                    $('#sucursal_consulta').append($('<option>', {
                        value: 0,
                        text: 'Elige una Sucursal'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#sucursal_consulta').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                $('#sucursal_consulta').on('change', function() {
                    cliente_consulta();
                });

                async function cliente_consulta() {
                    $('#cliente_consulta').find('option').remove().end();
                    var table= await axios.get("{{setting('admin.url')}}api/pos/clientes");
                    $('#cliente_consulta').append($('<option>', {
                        value: 0,
                        text: 'Elige una Sucursal'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        if(table.data[index].default==0){
                            $('#cliente_consulta').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].display+' - '+table.data[index].ci_nit
                            }));
                        }
                    }
                }

                async function ConsultarCredito() {
                    $('#table_consultas_cobros tbody tr').remove();
                    var venta= await axios.get("{{setting('admin.url')}}api/pos/ventas-creditos/"+$("#cliente_consulta").val()+"/"+$("#sucursal_consulta").val());
                    var midata="";
                    total=0;
                    if (venta.data.length == 0 ) {
                        toastr.error('Sin Resultados.');
                    } else {
                        for (let index = 0; index < venta.data.length; index++) {
                            if(venta.data[index].status_credito==0){
                                var estado="Pagado";
                            }
                            else{
                                var estado="Debe";
                            }
                            $('#table_consultas_cobros').append("<tr><td>"+venta.data[index].id+"</td><td>"+estado+"</td><td>"+venta.data[index].cliente.display+"</td><td>"+venta.data[index].subtotal+"</td><td>"+venta.data[index].published+"</td><td><a href='#historial' aria-controls='historial' role='tab' data-toggle='tab' class='btn btn-sm btn-primary' onclick='DetalleCredito("+venta.data[index].id+")'>Historial</a></td></tr>");
                        }
                    }
                }

                async function DetalleCredito(id) {
                    $('#table_historial tbody tr').remove();
                    var credito= await axios.get("{{setting('admin.url')}}api/pos/creditos/cliente/"+id);
                    var midata="";
                    var pagar=0;
                    var venta=0;
                    var cliente=0;
                    var cliente_text="";
                    var deuda=0;
                    var status=0;
                    if(credito.data.length==0){
                        toastr.error('No se encontraron creditos del cliente.'+credito.data[index].cliente.display);
                    }
                    else{
                        for(let index=0;index<credito.data.length;index++){
                            $('#table_historial').append("<tr><td>"+credito.data[index].id+"</td><td>"+id+"</td><td>"+credito.data[index].cliente.display+"</td><td>"+credito.data[index].deuda+"</td><td>"+credito.data[index].cuota+"</td><td>"+credito.data[index].restante+"</td><td>"+credito.data[index].created_at+"</td></tr>");
                            pagar=credito.data[index].restante;
                            cliente=credito.data[index].cliente.id;
                            cliente_text=credito.data[index].cliente.display;
                            deuda=credito.data[index].deuda;
                            status=credito.data[index].status;
                        }
                        if(status==0){
                            $('#table_historial').append("<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><a href='#cobro' aria-controls='cobro' role='tab' data-toggle='tab' class='btn btn-sm btn-primary' >Pagar Cuota</a></td></tr>");
                            $('#table_cobros tbody tr').remove();
                            $('#table_cobros').append("<tr><td>"+id+"</td><td>"+cliente_text+"</td><td>"+deuda+"</td></tr>");
                            $('#venta_id').val(id);
                            $('#cliente_id').val(cliente);
                            $('#cliente_text').val(cliente_text);
                            $('#deuda').val(deuda);
                            $('#restante').val(pagar);
                        }
                    }
                }

                async function ActualizarCredito() {
                    $('#table_cobros tbody tr').remove();
                    if($('#cuota_cobro').val()==0){
                        toastr.error("Error, revise que los datos ingresados sean correctos");
                    }
                    else{
                        var venta_id=$('#venta_id').val();
                        var cliente_id=$('#cliente_id').val();
                        var deuda=$('#deuda').val();
                        var cuota=$('#cuota_cobro').val();
                        var restante=parseFloat( $('#restante').val()).toFixed(2)-parseFloat($('#cuota_cobro').val()).toFixed(2);
                        if(restante<=0){
                            var status=1;
                            var venta_actualizada= await axios.get("{{setting('admin.url')}}api/pos/status_credito/actualizar/"+venta_id);
                            if(venta_actualizada){
                                toastr.success('Estado de Crédito en Venta Actualizado');
                            }
                        }
                        else{
                            var status=0;
                        }
                        var midata = JSON.stringify({'venta_id':venta_id,'cliente_id':cliente_id,'deuda':deuda,'cuota':cuota,'restante':restante,'status':status});

                        var table= await axios("{{setting('admin.url')}}api/pos/cobrar-credito/"+midata);
                        if(table){
                            toastr.success('Pago de Crédito Registrado');

                            if ($("input[name='season']:checked").val() == '0') {
                            var pagotext="En Linea";
                            }
                            if ($("input[name='season']:checked").val() == '1'){
                                var pagotext="En Efectivo";
                            }
                            var pago=$("input[name='season']:checked").val();
                            var micaja = JSON.parse(localStorage.getItem('micaja'));
                            var concepto = "Pago por cuota de Crédito de Venta: "+ $('#venta_id').val() +" del cliente: "+$('#cliente_text').val()+"";
                            var monto = $('#cuota_cobro').val();
                            var type = "Ingresos";
                            var caja_id = micaja.caja_id;
                            var editor_id = '{{ Auth::user()->id }}';
                            var midata = JSON.stringify({caja_id: caja_id, type: type, monto: monto, editor_id: editor_id, concepto: concepto, pago:pago});
                            var asiento= await axios("{{setting('admin.url')}}api/pos/asiento/save/"+midata);
                            if(asiento){
                                toastr.success('Asiento registrado como: '+asiento.data.type);
                            }
                        }
                    }
                }

                async function LimpiarDeudasChofer() {
                    $('#micajas').find('option').remove().end();
                    $('#michoferes').find('option').remove().end();
                    $('#table_deudas tbody tr').remove();
                }
                async function LimpiarKardex(){
                    $('#sucursalpensionado').find('option').remove().end();
                    $('#cliente_consulta').find('option').remove().end();
                    $('#table-kardex tbody tr').remove();
                }
                async function LimpiarCobroCreditos() {
                    $('#table_consultas_cobros tbody tr').remove();
                    $('#table_historial tbody tr').remove();
                    $('#table_cobros tbody tr').remove();
                    $('#venta_id').val(0);
                    $('#cliente_id').val(0);
                    $('#cliente_text').val("");
                    $('#deuda').val(0);
                    $('#restante').val(0);
                    $('#cuota_cobro').val(0);
                    $('#sucursal_consulta').find('option').remove().end();
                    $('#cliente_consulta').find('option').remove().end();
                }

                function imprimir(){
                    const queryString = window.location.search;
                    const urlParams = new URLSearchParams(queryString);
                    location.href = '{{"setting('admin.url')"}}admin/afiliados/recepciones/imprimir?key='+urlParams.get('key')+'&s='+urlParams.get('s');
                }
                @break
            @case('productos')
                $('#search_key').on('change',async function() {
                    $('.js-example-basic-single').select2();

                    // alert(this.value);
                    switch (this.value) {
                        case ('categoria_id'):
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/categorias_all",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Categoria'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });

                        break;

                        case ('name'):
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/productos",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Producto'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });

                        break;

                        case('capital_productos'):
                            $('#table-capital-productos tbody tr').remove();
                            $('#modal_capital').modal();

                        break;

                        default:

                        break
                    }
                });

                async function CalcularCapitalDefault() {

                    var table= await axios.get("{{setting('admin.url')}}api/pos/productos");
                    var num_productos=table.data.length;
                    var num_total_stock_productos=0;
                    var promedio_prod=0;
                    var capital=0;

                    for(let index=0;index<table.data.length;index++){
                        if(table.data[index].stock!=null){
                            promedio_prod+=(table.data[index].precio-table.data[index].precio_compra);
                            capital+=(table.data[index].precio_compra*table.data[index].stock);
                            num_total_stock_productos+=table.data[index].stock;
                        }
                    }

                    promedio_prod=promedio_prod/num_productos;

                    $('#table-capital-productos').append("<tr><td><h5>"+num_productos+"</h5></td><td><h5>"+num_total_stock_productos+"</h5></td><td><h5>"+promedio_prod.toFixed(2)+"</h5></td><td><h4>"+capital+"</h4></td></tr>");


                }

                @break
            @case('compras')
                $('.js-example-basic-single').select2();
                $('#search_key').on('change', async function() {


                    switch (this.value) {

                        case 'proveedor_id':
                            $('#s').find('option').remove().end();

                            var tabla= await axios("{{setting('admin.url')}}api/pos/proveedores");

                            $('#s').append($('<option>', {
                                value: null,
                                text: 'Elige un Proveedor'
                            }));
                            for (let index = 0; index < tabla.data.length; index++) {
                                $('#s').append($('<option>', {
                                    value: tabla.data[index].id,
                                    text: tabla.data[index].name
                                }));
                            }



                        break;

                        case 'insumo_id':
                            $('#s').find('option').remove().end();

                            var tabla= await  axios("{{setting('admin.url')}}api/pos/insumos");

                            $('#s').append($('<option>', {
                                value: null,
                                text: 'Elige un Insumo'
                            }));
                            for (let index = 0; index < tabla.data.length; index++) {
                                $('#s').append($('<option>', {
                                    value: tabla.data[index].id,
                                    text: tabla.data[index].name
                                }));
                            }




                        break;

                    }
                });
            @break
            @default

        @endswitch

    </script>
@stop
