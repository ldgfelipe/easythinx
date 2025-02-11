<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ env('APP_URL') }}"><img src="{{ env('APP_URL') }}/public/images/logo/logo.png"
            class="logotp" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">

            @foreach ($menus as $menu)
            <li class="nav-item">
                <a class="nav-link" href="{{env('APP_URL')}}{{$menu->url}}">{{$menu->menu}}</a>
            </li>
            @endforeach

            @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ env('APP_URL')}}home">Dashboard</a>
                </li>
                @if(Auth::user()->tipo_usuario==1 or Auth::user()->tipo_usuario==0)
                <li>
                    <a class="nav-link" href="{{env('APP_URL')}}suscripcion" >Suscripción</a>
                    </li>
                @endif
                @if(Auth::user()->tipo_usuario==2)
                <li>
                    <a class="nav-link" href="{{env('APP_URL')}}adminpagos" >Admin Pagos</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ env('APP_URL')}}logout">logout</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ env('APP_URL')}}login">Iniciar Sesión</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ env('APP_URL')}}register">Registro</a>
                </li>
            
              
            @endif
        </ul>

      </div>
    </div>
  </nav>
