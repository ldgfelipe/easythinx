@extends('layout.template')

@section('content')
<div class="row" style="height:95%; background-image:url('public/images/secciones/login/loginimg.jpg'); background-size:cover;">

<div class="col-md-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card" style="text-align:center; padding:15px;">

                    <img src="public/images/logo/logo.png"  class="logotp" style="margin:0 auto;" />

                        <div class="card-body">
                            <!----onsubmit="return validacatcha()"--->
                            <form method="POST" action="{{ route('login') }}" >
                                @csrf

                                <div class="row mb-12">


                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="{{ __('Email Address') }}" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-12">


                                    <div class="col-md-12">
                                        <input id="password" type="password"  placeholder="{{ __('Password') }}" class="form-control" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-12" >
                                    <div class="col-md-12 offset-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                              Recordarme
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="height: 20px;">
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-12">
                                      
                                   <!-- <div id="recatcha"></div>--->
        
                                    </div>
                                </div>
                                <div class="row mb-12">
                                    <div class="col-md-12 offset-md-12">
                                        <button type="submit" class="btn btn-secondary" style="color:#fff;">
                                           Iniciar
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                               Olvide mi contraseña
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('under')
<script>
    var claveId=""
   var verifyCallback = function(response) {
    claveId=response;
      };
      var widgetId1;
      var widgetId2;
      var onloadCallback = function() {
        // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
        // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
        
        grecaptcha.render('recatcha', {
          'sitekey' : '6LdkevcpAAAAAOKuG9oaWMqHVEn5b-oslY0Zl6NN',
          'callback' : verifyCallback,
          'theme' : 'light'
        });
      };


        function validacatcha(){
            return true
            @if(env('APP_URL')=='http://localhost/Lapmaster/easythinx/')
            return true
            @else
            if(claveId.length>0){
                return true
            }else{
                alert('Debe validad el captcha')
                return false
            }
            @endif

        }

    </script>
 <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
 async defer>
@endsection