@extends('layout.template')
@section('title','Contratar')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4">
    <div class="card">
        <div class="card-title">Suscripción</div>
        <div class="card-body">
<!-------areade trabajo------------------>

<section>
      <div class="product">
        <img src="https://i.imgur.com/EHyR2nP.png" alt="The cover of Stubborn Attachments" width="100%" />
        <div class="description">
          <h3>Suscripción a Easythinx</h3>
          <h5>$350.00 MXN</h5>
        </div>
      </div>

      <form  method="POST">
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
@endsection()
