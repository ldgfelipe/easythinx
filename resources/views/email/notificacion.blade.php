
<!DOCTYPE html>
<html>
    <head>
        <title>Invitación Easythinx</title>
</head>
    <body>



<img src="{{env('APP_URL')}}public/images/logo/logo.png" /><br />
<h4>Tiene una invitación de EasyThinx para trabajar en un proyecto:</h4>
<a href="{{$request['url']}}register?email={{$request['email']}}&name={{$request['name']}}">Registrate</a>

<br />
Si ya estar registrado <a href="{{$request['url']}}login">inicia sesión</a> y espera la actualización de tus proyectos<br />


</body>
    </html>

