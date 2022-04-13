
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
            <div class="col-lg-4 col-md-12 col-12 pt-4">
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
            //cart
            if (localStorage.getItem('micart')) {
                mitotal()
            } else {
                localStorage.setItem('micart', JSON.stringify([]));
                mitotal()
            }

            //user
            if (localStorage.getItem('miuser')) {

            } else {
                localStorage.setItem('miuser', JSON.stringify([]));
            }
        });

        async function addproduct(id) {
            var micart = JSON.parse(localStorage.getItem('micart'))
            var mirep = false
            var newcant = 0
            for (let index = 0; index < micart.length; index++) {
                if(micart[index].id == id){
                    mirep = true
                    newcant = micart[index].cant
                    break;
                }
            }
            if(mirep){
                toastr.success("Cantidad Actualizada del Item: "+id)
                updatecant(id)
            }else{
                var product = await axios ("{{ setting('admin.url') }}api/pos/producto/"+id)
                toastr.info('Item Agreado: '+product.data.name)
                console.log(product.data)
                var temp = {'id': product.data.id, 'image': product.data.image, 'name': product.data.name, 'precio': product.data.precio, 'cant': 1}
                micart.push(temp)
                localStorage.setItem('micart', JSON.stringify(micart))
                mitotal()
            }
        }

        async function updatecant(id) {
            var milist = JSON.parse(localStorage.getItem('micart'));
            var newlist = [];
            for (let index = 0; index < milist.length; index++) {
                if (milist[index].id == id) {
                    var newcant = milist[index].cant + 1
                    var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'cant': newcant}
                }else{
                    var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'cant': milist[index].cant}
                }
                newlist.push(temp);
            }
            localStorage.setItem('micart', JSON.stringify(newlist));
            mitotal()
        }

        function mitotal() {
            var micart = JSON.parse(localStorage.getItem('micart'))
                var mitotal = 0
                for (let index = 0; index < micart.length; index++) {
                    mitotal += micart[index].cant
                }
            $('#micount').html(mitotal)
        }
    </script>
@endsection
