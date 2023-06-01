@extends('layout.template')
@section('title','Dashboard')
@section('content')

    <div id="app">
        <v-app class="appdata">
            <dashoardterminal  :sesion="{{Auth::user()}}" :websocket="'{{ env('APP_SOCKET_IO') }}'" :csrf="'{{ csrf_token() }}'" :url="'{{env('APP_URL')}}'"></dashoardterminal>
        </v-app>
    </div>
@endsection
