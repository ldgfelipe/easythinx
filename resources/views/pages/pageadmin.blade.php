@extends('layout.template')
@section('title','Dashboard')
@section('content')

<h3>Administración de pagos</h3>


<table>
  <tr>
    <th>Correo</th>
    <th>Fecha de pago</th>
    <th>Status</th>
    <th>Ver Pago</th>
  </tr>
  @foreach($paydata as $pay)
  <tr>
    <td>{{$pay->correo}}</td>
    <td>{{$pay->created_at}}</td>
    <td>{{$pay->status == 1 ? 'Pagado' : 'pendiente' }}</td>
    <td><a href="" class="btn btn-primary" target="_blank"></a></td>
  </tr>
  @endforeach
  
</table>


@endsection