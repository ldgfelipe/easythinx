@extends('layout.template')
@section('title','Dashboard')
@section('content')

    <div id="app">
        <v-app class="appdata">
        
            <dashoardterminal :csrf="'{{ csrf_token() }}'" :url="'{{env('APP_URL')}}'"></dashoardterminal>
        </v-app>
    </div>
@endsection
