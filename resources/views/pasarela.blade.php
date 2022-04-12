@extends('layouts.master')

@section('css')

    <style>
        .myButton {
            background-color:#8ea742;
            border-radius:4px;
            border:1px solid #8ea742;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Arial;
            font-size:17px;
            padding:11px 31px;
            text-decoration:none;
            text-shadow:0px 1px 0px #2f6627;
        }
        .myButton:hover {
            background-color:#5cbf2a;
        }
        .myButton:active {
            position:relative;
            top:1px;
        }
        #map { height: 180px; }
    </style>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
     integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
     crossorigin=""/>
@endsection
@section('content')
<br>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="">Nombres</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Telefono</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Locacion</label>
                    <div id="map"></div>
                </div>
            </div>
            <div class="col-sm-4">

                <a href="https://banipay.me/super/payment?b=6ba7af45-f5d9-4568-91dc-65dc30e8eaf0" class="myButton">PAGA</a>
            </div>

        </div>
    </div>
@endsection

@section('javascript')

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>

<script>
    var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(map);
</script>
@stop
