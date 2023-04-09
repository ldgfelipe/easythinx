@extends('layout.template')
@section('title','Dashboard')
@section('content')

<div style="width:100%; max-width:100%; text-align:center; ">
    <img src="{{ env('APP_URL') }}/public/images/logo/logo.png"
    class="logotp" /><br />
    <h3>Lo sentimos el sitio que busca<br /> no esta disponible por el momento</h3>
<h4><a href="{{ env('APP_URL') }}" class="btn btn-primary" style="background-color:green;">Regresar al Inicio</a></h4>


</div>
@endsection
