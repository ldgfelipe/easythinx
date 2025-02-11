@extends('layout.template')
@section('title','Dashboard')
@section('content')
@if($pay==true)
    <div id="app">
        <v-app class="appdata">
            <dashoardterminal  :sesion="{{Auth::user()}}" :websocket="'{{ env('APP_SOCKET_IO') }}'" :csrf="'{{ csrf_token() }}'" :url="'{{env('APP_URL')}}'"></dashoardterminal>
        </v-app>
    </div>
@else
<div class="container">
<div class="row">
<div class="col-md-1"></div>
    <div class="col-md-4">
    <div class="card" style="text-align:center; box-shadow:10px 10px 10px #000;">
        <div class="card-title"><h2>Cuenta Individual</h2></div>
        <div class="card-body">
<!-------areade trabajo------------------>

<section>
      <div class="product">
        <img src="http://localhost/Lapmaster/easythinx//public/images/payment/logopayment.jpg" alt="Activa tu cuenta" width="100%" />
        <div class="description">
          <h3>Suscripción a Easythinx</h3>
          <h5>$350.00 MXN</h5>
        </div>
      </div>

      <form  method="POST" action="{{env('APP_URL')}}contrato">
        @csrf
        <button type="submit" id="checkout-button" class="btn btn-success" style="color:#fff;">Comprar</button>
      </form>
    </section>

<!-------areade trabajo-------------------->

        </div>
    </div>


    </div>
    <div class="col-md-1"></div>
    <div class="col-md-4">
    <div class="card" style="text-align:center; box-shadow:10px 10px 10px #000;">
        <div class="card-title"><h2>Cuenta Grupal</h2></div>
        <div class="card-body">
<!-------areade trabajo------------------>

<section>
<form  method="POST" action="{{env('APP_URL')}}contrato">
      <div class="product">
        <img src="http://localhost/Lapmaster/easythinx//public/images/payment/logopayment.jpg" alt="Activa tu cuenta" width="100%" />
        <div class="description">
         <center> <input type="number" name="cantidad" style="width:100px;" id="canuser" class="form-control" value="2" onchange="calculateTotal()" /> $200.00 MXN / por Usuario</center>
          <h5>Total:<span id="totaluser">400</span> MXN</h5>
        </div>
      </div>

    
        @csrf
        <button type="submit" id="checkout-button" class="btn btn-success" style="color:#fff;">Comprar</button>
      </form>
    </section>

<!-------areade trabajo-------------------->

        </div>
    </div>

    </div>
</div>
</div>
@endif
    
@endsection
@section('under')

<script> 
function calculateTotal(){
  
  var cantidad=$('#canuser').val();
  if(cantidad<2){
    alert('la cantidad debe de ser mayor a 1 para entrar en pago grupal')
    $('#canuser').val(2)
  }else{
  $('#totaluser').html(cantidad*200);
  }

}
  </script>

@endsection