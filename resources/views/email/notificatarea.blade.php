<!DOCTYPE html>
<html>
    <head>
        <title>Invitación a tarea</title>
        <style>
            html,body{
                font-family: Arial, Helvetica, sans-serif;
            }
            </style>
</head>
    <body>
        <img src="{{env('APP_URL')}}public/images/logo/logo.png" /><br />
<h2>Tiene una nueva tarea asignada</h2><br />
    Tarea asignada: <b>{{strtoupper($titulo)}}</b> de proyecto <b>{{strtoupper($proynombre)}}</b> <br /><br />
    <a href="{{env('APP_URL')}}">Ingresa para revisar el proyecto</a>
</body>
    </html>
