<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use App\Models\payments;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StripePaymentController extends Controller
{

    public function suscripcion(Request $request){

          $getPay=payments::where('id_user',Auth::user()->id)->first();
          if($getPay==null){
            $session="redirect";
          }else{
          $stripeSecretKey = env('STRIPE_MODE_TEST') ? env('STRIPE_PRIVATE_KEY_TEST') : env('STRIPE_PRIVATE_KEY');
          \Stripe\Stripe::setApiKey($stripeSecretKey);
          header('Content-Type: application/json');
          $YOUR_DOMAIN = env('APP_URL');
          $checkout_session = \Stripe\Checkout\Session::retrieve($getPay->session_id);
          $session = \Stripe\BillingPortal\Session::create([
            'customer' => $checkout_session->customer,
            'return_url' => $YOUR_DOMAIN.'suscripcion',
          ]);
 
        }

        $getDataPayment=payments::where('id_user',Auth::user()->id)->first();

        if($request->_token and $request->action=="eliminasub"){
              payments::where('id',$request->id)->delete();
        }

        if($request->_token and $request->action=="suspendesub"){
          payments::where('id',$request->id)->update(Array('status'=>0));
        }
        if($request->_token and $request->action=="activesub"){
          payments::where('id',$request->id)->update(Array('status'=>1));
        }

        if($request->_token and $request->action == 'registro_sub'){

          ////busca si el usuario esta registrado en el sistema 

          $getUser=User::where('email',$request->correoAlta)->first();
          $idUserdata=0;
          if(isset($getUser->id)){
            $idUserdata=$getUser->id;
          }

          $addPay=new payments();
          $addPay->id_user=$idUserdata;
          $addPay->customer_id=$getDataPayment->customer_id;
          $addPay->correo=$request->correoAlta;
          $addPay->medio='stripe';
          $addPay->fecha_int=$getDataPayment->fecha_int;
          $addPay->fecha_fin=$getDataPayment->fecha_fin;
          $addPay->plan=$getDataPayment->plan;
          $addPay->cant=1;
          $addPay->status=1;
          $addPay->tipo="subadd";
          $addPay->session_id=$getDataPayment->session_id;
          $addPay->save();

          ///agregar envio por aviso de correo
          if(isset($idUserdata->id) and $idUserdata->id==0){
              // Pendiente ----realiza el envío de correo para alertar
          }

        }

        $getSubPayment=Array();

        if($getDataPayment->cant>1 and $getDataPayment->tipo=='admin'){
              $getSubPayment=payments::where('customer_id',$getDataPayment->customer_id)->where('tipo','subadd')->get();
        }

        return view('suscription',compact('session','getDataPayment','getSubPayment'));
    }
    //
    public function paymentarea(Request $request){
      if(isset($request->_token) and $request->_token!=NULL){
      $stripeSecretKey = env('STRIPE_MODE_TEST') ? env('STRIPE_PRIVATE_KEY_TEST') : env('STRIPE_PRIVATE_KEY');
          //// registra el inicio del pago 
            ///// primero busca si hay algun pago realizado  y en status activo 

            
            $cantidad=1;
            $precioUnidad=35000;
            $namepago="Suscripción Individual";
            $priceSus="price_1PWNfGI2JG4QhrOhzDqP8ioE";
            
          if(isset($request->cantidad)){

              $cantidad=$request->cantidad;
              $precioUnidad=20000;
              $namepago="Suscripción Grupal";
              $priceSus="price_1PWNg0I2JG4QhrOhG2PnZ2nH";

          }

          $getPay=payments::where('id_user',Auth::user()->id)->first();
            if(isset($getPay->id_user) and $getPay->id_user!=NULL){

              $updatePay=Array(
              "customer_id"=>"",
              "correo"=>Auth::user()->email,
              "medio"=>'stripe',
              "fecha_int"=>date('Y-m-d',0000-00-00),
              "fecha_fin"=>date('Y-m-d',0000-00-00),
              "plan"=>$namepago,
              "cant"=>$cantidad,
              "status"=>0,
              "tipo"=>"admin",
              "session_id"=>""
              );

              $updatePay=payments::where('id_user',Auth::user()->id)->update($updatePay);
            }else{
                $addPay=new payments();
                $addPay->id_user=Auth::user()->id;
                $addPay->customer_id="";
                $addPay->correo=Auth::user()->email;
                $addPay->medio='stripe';
                $addPay->fecha_int=date('Y-m-d',0000-00-00);
                $addPay->fecha_fin=date('Y-m-d',0000-00-00);
                $addPay->plan=$namepago;
                $addPay->cant=$cantidad;
                $addPay->status=0;
                $addPay->tipo="admin";
                $addPay->session_id="";
                $addPay->save();
            }



      \Stripe\Stripe::setApiKey($stripeSecretKey);
      header('Content-Type: application/json');
      
      $YOUR_DOMAIN = env('APP_URL');

      /*
      $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [/*[
          # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
         # 'price' => 'price_1PMcx3I2JG4QhrOh49ZCW3D0',
          #'quantity' => 1,
          'price_data'=>[
          'currency' => 'mxn',
          'product_data'=>[
            'name'=>$namepago
          ],
          'unit_amount' => $precioUnidad
        ],
        'price'=>$priceSus,
        'quantity'=>$cantidad
        ],
        'mode' => 'subscription',
        'success_url' => $YOUR_DOMAIN . 'success?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $YOUR_DOMAIN . 'cancel'
      ]);
      */
 

      
      $checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [
    [
        'price'=>$priceSus,
        'quantity'=>$cantidad,
    ],
  ],
  'mode' => 'subscription',
  'success_url' => $YOUR_DOMAIN . 'success?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => $YOUR_DOMAIN . 'cancel'
]);




      header("Location: " . $checkout_session->url);
      die();
    }else{

      return view('payment');

    }
        
    }

 public function webhookStripe(Request $request){

// webhook.php
//
// Use this sample code to handle webhook events in your integration.
//
// 1) Paste this code into a new file (webhook.php)
//
// 2) Install dependencies
//   composer require stripe/stripe-php
//
// 3) Run the server on http://localhost:4242
//   php -S localhost:4242
// The library needs to be configured with your account's secret key.
// Ensure the key is kept out of any version control system you might be using.
$stripe = new \Stripe\StripeClient(env('STRIPE_MODE_TEST')==true ? env('STRIPE_PRIVATE_KEY_TEST') :env('STRIPE_PRIVATE_KEY'));

// This is your Stripe CLI webhook secret for testing your endpoint locally.
$endpoint_secret = 'whsec_62ca1727f0816347124f8365135e7831d65b9f60a753880a3f42cb02f4d864d8';

$payload = @file_get_contents('php://input');

/*
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}
*/
// Handle the event
//echo 'Received unknown event type ' . $event->type;

$event=json_decode($payload);
$session = $event->data->object;

switch($event->type){
  case 'checkout.session.completed':
    $email=$session->customer_details->email; 
    payments::where('correo',$email)->update(Array('customer_id'=>$session->customer));
    echo "Cliente ".$email. " Registro el customer id ";
    break;

  case 'customer.subscription.updated':
    
      if(isset($event->data->object->cancel_at_period_end) and $event->data->object->cancel_at_period_end==true){

        payments::where('customer_id',$session->customer)->update(Array('status'=>0));
        echo "Cliente ".$session->customer. " Suscripción Cancelada ";
      }

    break;
}



http_response_code(200);
    }

    
    public function success(Request $request){
      $fecha_actual=date('Y-m-d');
      $getPay=payments::where('id_user',Auth::user()->id)->update(
        Array(
          'status'=>1,'session_id'=>$request->session_id,
          'fecha_int'=>$fecha_actual,
          'fecha_fin'=>date('Y-m-d',strtotime($fecha_actual." + 1 month"))
        ));
      return view('success');
    }

    public function cancel(Request $request){

      return view('cancel');
    }

    public function adminpagos(Request $request){

      $paydata=payments::get();

      return view('pages.pageadmin',compact('paydata'));
    }

}
