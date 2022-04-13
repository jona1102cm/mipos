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
                    <label for="">Nombres</label>
                    <input type="text" class="form-control" id="nombres">
                </div>
                <div class="form-group">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos">
                </div>
                <div class="form-group">
                    <label for="">Telefono</label>
                    <input type="number" class="form-control" id="telefono">
                </div>
                {{-- <div class="form-group">
                    <label for="">Correo</label>
                    <input type="text" class="form-control">
                </div> --}}
                <div class="form-group">
                    <label for="">Direccion</label>
                    <input type="text" class="form-control" id="direccion">
                </div>
                <div class="form-group">
                    <label for="">Locacion</label>
                    <div id="map"></div>
                </div>
                <input type="text" id="latitud">
                <input type="text" id="longitud">
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Carrito</label>
                    <code>
                        <div id="micart"></div>
                    </code>
                </div>
                <div class="form-group">
                    <label for="">Pasarela de Pago</label>
                    <select class="browser-default custom-select">
                        <option selected>BaniPay</option>
                        <option value="1">Contra Reembolso</option>
                      </select>
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
            var micart = JSON.parse(localStorage.getItem('micart'));
            $('#micart').html(JSON.stringify(micart))
            console.log(micart)
            if (localStorage.getItem('micart')) {
                mitotal()
            } else {
                localStorage.setItem('micart', JSON.stringify([]));
                mitotal()
            }
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            $('#nombres').val(miuser.first_name)
            $('#apellidos').val(miuser.last_name)
            $('#telefono').val(miuser.phone)
        });


        var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
        };

        function success(pos) {
            var crd = pos.coords;
            console.log('Your current position is:');
            console.log('Latitude : ' + crd.latitude);
            console.log('Longitude: ' + crd.longitude);
            console.log('More or less ' + crd.accuracy + ' meters.');
            var map = L.map('map').setView([crd.latitude, crd.longitude], 13);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
                maxZoom: 18
            }).addTo(map);
            var mimarker = L.marker([crd.latitude, crd.longitude], { title: "My marker" }).addTo(map);
            mimarker.bindPopup("<b>Location</b><br>Actual").openPopup();
            $('#latitud').val(crd.latitude)
            $('#longitud').val(crd.longitude)
        };

        function error(err) {
            alert(err.message)
            console.warn('ERROR(' + err.code + '): ' + err.message);
        };
        navigator.geolocation.getCurrentPosition(success, error, options);


        async function save_pedido() {
            var cliente = {
                'nombres': $('#nombres').val(),
                'apellidos': $('#apellidos').val(),
                'telefono': $('#telefono').val(),
                'direccion': $('#direccion').val(),
                'latitud': $('#latitud').val(),
                'longitud': $('#longitud').val()
            }
            var misave = await axios.post("{{ setting('admin.url') }}api/pos/save_pedido", cliente)
            console.log(misave.data)
            localStorage.setItem('micart', JSON.stringify([]));
            location.href = "{{ route('pages', 'consultas') }}"
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
@stop
