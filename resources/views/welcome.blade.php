@extends('layout.template')
@section('title','Welcome')
@section('content')

<!---@include('elementos.slider')---->

<?php
if(isset($inicio->html) and $inicio->html!=NULL){
echo $inicio->html;
}
?>

@endsection()
