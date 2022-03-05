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
                <a href="{{ url('admin/clientes') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-people"></i> <span>Clientes</span>
                </a>
                <a href="{{ url('admin/mensajeros') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-truck"></i> <span>Delivery</span>
                </a>
                @break
            @case('insumos')
                <a href="{{ url('admin/unidades') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-milestone"></i> <span>Unidades</span>
                </a>
                <a href="{{ url('admin/productions') }}" class="btn btn-default btn-add-new" title="">
                    <i class="voyager-puzzle"></i> <span>Volver</span>
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
                <a href="{{ url('admin/productions') }}" class="btn btn-default btn-add-new" title="">
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
                                @case('ventas')
                                    <form method="get" class="form-search">
                                        <div id="search-input">
                                            <div class="col-4">
                                                <select id="search_key" name="key" style="width: 200px" class="js-example-basic-single">
                                                        <option value=""> ---- Elige un Filtro ----</option>
                                                        <option value="cliente_id"> Cliente </option>
                                                        <option value="status_id"> Estado</option>
                                                        <option value="pago_id"> Pago </option>
                                                        <option value="register_id"> Cajero </option>
                                                        <option value="cupon_id"> Cupón </option>
                                                        <option value="option_id"> Tipo Entrega </option>
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
                                    @php
                                        $venta =  App\Venta::find($_GET['s']);
                                    @endphp
                                    <pre> <code>{{ $venta }}</code></pre>
                                    @break
                                
                                @case('productos')
                                    <form method="get" class="form-search">
                                        <div id="search-input">
                                            <div class="col-4">
                                                <select id="search_key" name="key" style="width: 200px" class="js-example-basic-single">
                                                        <option value=""> ---- Elige un Filtro ----</option>
                                                        <option value="categoria_id"> CATEGORIA </option>
                                                       
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
                                       
                                        @switch($dataType->getTranslatedAttribute('slug'))
                                            @case('ventas')
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
                                            @break

                                            @case('productos')
                                            
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
                                            @break
                                        
                                            @case('productions')
                                                @if($data->user_id == Auth::user()->id )

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
                                                                                    $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $user->name }}</span>
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
                                                                                    $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                                @endphp
                                                                                <span>{{ $user->name}}</span>
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
                                                @break

                                            @case('production-insumos')
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
                                                                    HOLA
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @endif
                                                            @else
                                                                HOLA    
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <span>{{ $data->{$row->field} }} </span>
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
                                                @break

                                            @case('detalle-ventas')
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
                                                @break
                                            @default
                                               
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
                                        @endswitch

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
 
                        @if ($isServerSide)
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

                                {{-- {{ $dataTypeContent->links() }} --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------------MODAL-------------------  -->
    <!-- ---------------------MODAL-------------------  -->
    @switch($dataType->getTranslatedAttribute('slug'))
        @case('ventas')
            
            @break
    
        @case('')
            Second case...
            @break
    
        @default
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
        @endswitch
@stop



<!-- ---------------------CSS-------------------  -->
<!-- ---------------------CSS-------------------  -->
@section('css')
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
@endif




<!-- ---------------------JS-------------------  -->
<!-- ---------------------JS-------------------  -->
@section('javascript')
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    @php
        $mislug =  $dataType->getTranslatedAttribute('slug');
    @endphp
    <script>
        $(document).ready(function () {
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

            $('.js-example-basic-single').select2();
        });


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
            @case('ventas')
                $('#search_key').on('change', function() {
                    switch (this.value) {
                        case 'cliente_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "https://pos.loginweb.dev/api/pos/clientes",
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
                        case 'status_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "https://lamarea.loginweb.dev/api/pos/estados",
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
                                url: "https://lamarea.loginweb.dev/api/pos/pagos",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Tipo de Pago'
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
                        case'register_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "https://lamarea.loginweb.dev/api/pos/cajeros",
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
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break             
                        case'cupon_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "https://lamarea.loginweb.dev/api/pos/cupones",
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
                        default:
                            //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
                            break
                    }
                });
                function imprimir(){
                    const queryString = window.location.search;
                    const urlParams = new URLSearchParams(queryString);
                    location.href = 'https://pos.loginweb.dev/admin/afiliados/recepciones/imprimir?key='+urlParams.get('key')+'&s='+urlParams.get('s');
                }
            

            @break
            @case('productos')
                $('#search_key').on('change', function() {
                    // alert(this.value);
                    switch (this.value) {
                        case ('categoria_id'):
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/categorias",
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
                        default:

                        break
                    }
                });
            @break
        
            @default
               
        @endswitch

    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop
