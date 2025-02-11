@extends('layout.template')
@section('title','Dashboard')
@section('content')
<div class="row">
    <div class="col-md-4">

    </div>    
    <div class="col-md-4">
        @if(isset($session->url))
        <div class="card" style="text-align:center; padding:6px;">
            <div class="card-body" style="background-color:green; color:#ffF;">
        <h3>{{$getDataPayment->plan}}</h3>
            </div>
            <div class="card-text">
              <h2> Vigencia:{{$getDataPayment->fecha_fin}}<br /></h2>
               
            </div>

            <div class="card-text">
              <h2> Cantidad de usuarios:{{$getDataPayment->cant}}<br /></h2>
              
            </div>

            @if($getDataPayment->tipo=='admin')
            <div class="card-body">
            <a href="{{ $session->url}}" class="btn btn-primary" >
                    <b>Ver Suscripción de Stripe</b>
                </a>
            </div>
            @endif


@if($getDataPayment->cant>1)
    <div class="card-body">

                <h3>Asignar suscripción</h3>

{{count($getSubPayment)}} / {{$getDataPayment->cant}}

@if(count($getSubPayment) < $getDataPayment->cant)
<form method="POST" >
    @csrf
    <input type="hidden" name="action" value="registro_sub" />
    <table>
    <tr>
        <td><input type="text" name="correoAlta" class="form-control" /></td>
        <td><input type="submit" value="Crear" class="btn btn-primary" /></td>
    
    </tr>
    </table>
</form>
@endif

                <table>
                <tr>
                    <th>Correo</th>
                    <th>Nombre</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
                        @foreach($getSubPayment as $SubData)
                        <tr>
                            <td  style="font-size:9px; text-align:center;">{{$SubData->correo}}</td>
                            <td  style="font-size:9px;  text-align:center;" >{{$SubData->created_at}}</td>

                            <td>
                            @if($SubData->status==1)
                            <div class="alert alert-success">Activo</div>
                            @else
                            <div class="alert alert-warning">Suspendido</div>
                            @endif

                            </td>

                            <td>
                             @if($SubData->status==1)
                            <form method="post">    
                            @csrf 
                            <input type="hidden" name="action" value="eliminasub" />
                            <input type="hidden" name="id" value="{{$SubData->id}}" />
                            <input type="submit" class="btn btn-danger" style="font-size:9px; width:100%;" value="Eliminar" />
                            </form>

                            <form method="post">
                            @csrf
                            <input type="hidden" name="action" value="suspendesub" />
                            <input type="hidden" name="id" value="{{$SubData->id}}" />
                            <input type="submit" class="btn btn-info"  style="font-size:9px; width:100%;" value="Suspender" />
                            </form>
                                @else
                            <form method="post">
                            @csrf
                            <input type="hidden" name="action" value="activesub" />
                            <input type="hidden" name="id" value="{{$SubData->id}}" />
                            <input type="submit" class="btn btn-info"  style="font-size:9px; width:100%;" value="Activar" />
                            </form>
                                    @endif
                        </td>
                        </tr>
                        @endforeach
                </table>



    </div>

@endif
        </div>

        @else

       
            <script>
                window.location.href="{{env('APP_URL')}}home"
                </script>
        @endif
    </div>
</div>
@endsection