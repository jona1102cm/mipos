@extends('layouts.master')

@section('css')
    <style>
        #map {
            width: 100%;
            height: 400px;
            box-shadow: 5px 5px 5px #888;
        }
    </style>
   <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
@endsection
@section('content')
<br>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="">Telefono</label>
                    <input type="number" class="form-control" id="telefono" placeholder="escribe tu whatsapp">
                </div>
                <div class="form-group">
                    <label for="">Nombres</label>
                    <input type="text" class="form-control" id="nombres" placeholder="escribe tu nombre">
                </div>
                <div class="form-group">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" placeholder="escribe tu apellido">
                </div>
                <div class="form-group">
                    <label for="">Carnet o NIT</label>
                    <input type="text" id="ci_nit" class="form-control" placeholder="escribe tu carnet o nit">
                </div>
                <div class="form-group">
                    <label for="">Direccion</label>
                    <input type="text" class="form-control" id="direccion" placeholder="escribe tu direccion">
                </div>
                <div class="form-group">
                    <label for="">Locacion</label>
                    <div id="map"></div>
                </div>
                <input type="text" id="latitud" hidden>
                <input type="text" id="longitud" hidden>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Opciones</label>
                    <select class="browser-default custom-select" id="miopciones">
                        @php
                            $options = App\Option::where('view', 'frontend')->get();
                        @endphp
                        @foreach ($options as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pasarela de Pago</label>
                    <select class="browser-default custom-select" id="pago_id">
                        @php
                        $options = App\Pago::where('view', 'frontend')->get();
                        @endphp
                        @foreach ($options as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                      </select>
                </div>

                {{-- <div class="form-group">
                    <label for="">Cupon</label>
                    <input type="text" class="form-control" placeholder="escribe el codigo de tu cupon">
                </div> --}}
                <div class="form-group">
                    <label for="">Descuento</label>
                    <input type="number" class="form-control" value="0" id="descuento" readonly>
                </div>
                <div class="form-group">
                    <label for="">Total</label>
                    <input type="number" class="form-control" id="total" readonly>
                </div>
                <div class="form-group">
                    <label for="">Mensaje al Vendedor</label>
                    <textarea id="observacion" class="form-control"></textarea>
                </div>
                <div class="form-group text-center">
                    <a href="#" class="btn btn-primary" onclick="save_pedido()">Enviar Pedido</a>
                </div>
                <div class="form-group text-center">
                    <p>Luego de confirmar el pedido, se le notificara todo los detalles de su compra.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>

        $('document').ready(function () {
            pagototal(null)
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var milocation = JSON.parse(localStorage.getItem('milocation'))
            if (miuser || milocation ) {
                getuser(miuser)
                if (milocation) {
                    getlocation(milocation)
                } else {
                    navigator.geolocation.getCurrentPosition(success, error, options);
                }

            } else {
                navigator.geolocation.getCurrentPosition(success, error, options);
            }
        });

        function pagototal(delivery) {
            var micart = JSON.parse(localStorage.getItem('micart'))
            var mitotal = 0
            for (let index = 0; index < micart.length; index++) {
                var stotal = micart[index].precio * micart[index].cant
                mitotal += stotal
            }
            mitotal = delivery ? (mitotal + parseFloat(delivery)) : mitotal
            $('#total').val(mitotal)
            return mitotal
        }
        function getlocation(midata) {
            var map = L.map('map').setView([midata.latitud, midata.longitud], 14);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 22
            }).addTo(map);
            var mimarker = L.marker([midata.latitud, midata.longitud], { title: "My marker", draggable: true }).addTo(map);
            mimarker.bindPopup("Mi Ubicacion").openPopup();
            $('#latitud').val(midata.latitud)
            $('#longitud').val(midata.longitud)
            $('#direccion').val(midata.descripcion)
            mimarker.on('drag', function (e) {
                var marker = e.target;
                var position = marker.getLatLng();
                $('#latitud').val(position.lat)
                $('#longitud').val(position.lng)
                $('#direccion').val('nueva direccion')
            }).addTo(map);
        }

        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };
        function success(pos) {
            var crd = pos.coords;
            var map = L.map('map').setView([crd.latitude, crd.longitude], 13);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18
            }).addTo(map);
            var mimarker = L.marker([crd.latitude, crd.longitude], { title: "My marker", draggable: true }).addTo(map);
            mimarker.bindPopup("Mi Ubicacion").openPopup();
            $('#latitud').val(crd.latitude)
            $('#longitud').val(crd.longitude)
            mimarker.on('drag', function (e) {
                var marker = e.target;
                var position = marker.getLatLng();
                $('#latitud').val(position.lat)
                $('#longitud').val(position.lng)
            }).addTo(map);
        };

        function error(err) {
            alert(err.message)
            // alert('ERROR(' + err.code + '): ' + err.message)
            console.warn('ERROR(' + err.code + '): ' + err.message)
        };
        // navigator.geolocation.getCurrentPosition(success, error, options);

        async function save_pedido() {
            var cliente = {
                'nombres': $('#nombres').val(),
                'apellidos': $('#apellidos').val(),
                'telefono': $('#telefono').val(),
                'ci_nit': $('#ci_nit').val()
            }
            var micliente = await axios.get("{{ setting('admin.url') }}api/cliente/"+JSON.stringify(cliente))

            var pedido = {
                'cliente_id': micliente.data.id,
                'option_id': $('#miopciones').val(),
                'pago_id': $('#pago_id').val(),
                'total': $('#total').val(),
                'descuento': $('#descuento').val(),
                'observacion': $('#observacion').val(),
            }
            console.log(pedido)
            var newpedido = await axios.post("{{ setting('admin.url') }}api/pedido/save", pedido)

            // var micart = localStorage.getItem('micart')
            // var products = await axios.post("{{ setting('admin.url') }}api/pedido/products/save", micart)
            // console.log(products.data)

            localStorage.setItem('micart', JSON.stringify([]));
            location.href = "{{ route('pages', 'consultas') }}"
        }

        $('#telefono').on('keypress', async function (e) {
            if(e.which === 13){
                var midata = {
                    'telefono': this.value
                }
                var miuser = await axios.get("{{ setting('admin.url') }}api/cliente/"+JSON.stringify(midata))
                $('#nombres').val(miuser.data.first_name)
                $('#apellidos').val(miuser.data.last_name)
                $('#telefono').val(miuser.data.phone)
                $('#ci_nit').val(miuser.data.ci_nit)
            }
        });
        $('#miopciones').on('change', async function (e) {
            toastr.success('Delivery Actualizado')
            var options = await axios("{{ setting('admin.url') }}api/option/"+this.value)
            pagototal(options.data.valor)

        });



        // async function setuser(phone) {
        //     var midata = {
        //         'telefono': phone
        //     }
        //     var miuser = await axios.get("{{ setting('admin.url') }}api/cliente/"+JSON.stringify(midata))
        //     if (miuser.data) {
        //         localStorage.setItem('miuser', JSON.stringify(miuser.data));
        //         var user = JSON.parse(localStorage.getItem('miuser'))
        //         $('#nombres').val(user.first_name)
        //         $('#apellidos').val(user.last_name)
        //         $('#telefono').val(user.phone)
        //         $('#ci_nit').val(user.ci_nit)

        //         var midata2 = {
        //             'cliente_id': miuser.data.id
        //         }
        //         var milocation = await axios.get("{{ setting('admin.url') }}api/location/"+JSON.stringify(midata2))
        //         if (milocation.data) {
        //             localStorage.setItem('milocation', JSON.stringify(milocation.data));
        //             var location = JSON.parse(localStorage.getItem('milocation'))
        //             $('#direccion').val(location.descripcion)
        //             getlocation(location)
        //         }else{
        //             toastr.error("Cliente NO registra locacion")
        //         }
        //         toastr.success("Cliente Registrado")
        //     } else {
        //         toastr.error("Cliente NO registrado")
        //     }

        // }

        async function getuser(midata) {
            $('#nombres').val(midata.first_name)
            $('#apellidos').val(midata.last_name)
            $('#telefono').val(midata.phone)
            $('#ci_nit').val(midata.ci_nit)
        }

    </script>
@stop
