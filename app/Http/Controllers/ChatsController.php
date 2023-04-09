<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chats;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    //
    public function guardamensaje(Request $request){
          //  dd($request);
        $mensaje=new Chats();
        $mensaje->mensaje=$request->message['msj'] ? $request->message['msj'] : "";
        $mensaje->id_usuario=$request->session['id'];
        $mensaje->id_proyecto=$request->proyecto['id'];
        $mensaje->name=$request->session['name'] ? $request->session['name'] : "";
        $mensaje->email=$request->session['email'] ? $request->session['email'] : "";
        $fecha =  date('Y-m-d H:i:s', strtotime('-2 day', strtotime($request->message['fecha'])));

        $mensaje->para=$request->message['to'] ? $request->message['to'] : "";
        $mensaje->tipo=$request->message['type'] ? $request->message['type'] : "";
        $mensaje->fecha=   $fecha  ?    $fecha  : "";
        $mensaje->hora=$request->message['hora'] ? $request->message['hora'] : "";

        $mensaje->save();
        $respuesta=Array('res'=>'Mensaje enviado correctamente');
        return response()->json($respuesta);
    }
    public function tomamensajes(Request $request){
        $mensajes=Chats::where('id_proyecto',$request->proyecto['id'])->orderBy('id','DESC')->limit(10)->get();
        return response()->json($mensajes);
    }
    public function cargatodochat(Request $request){
        $mensajes=Chats::where('id_proyecto',$request->id)->orderBy('id','DESC')->get();
        return response()->json($mensajes);
    }
}
