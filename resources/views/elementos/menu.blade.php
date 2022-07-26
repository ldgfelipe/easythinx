<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ env('APP_URL') }}"><img src="{{ env('APP_URL') }}/public/images/logo/logo.png"
            class="logotp" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Acerca de</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">T & C</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contacto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Servicios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Preguntas Más Frecuentes</a>
            </li>
            @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}/home">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}/logout">logout</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}/login">Iniciar Sesión</a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}/register">Registro</a>
                </li>
            @endif
        </ul>

      </div>
    </div>
  </nav>
