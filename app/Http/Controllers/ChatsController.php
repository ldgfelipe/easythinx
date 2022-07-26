<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chats;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    //
    public function enviamensaje(Request $request){

        $mensaje=new Chats();
        $mensaje->mensaje=$request->mensaje;
        $mensaje->usuario=Auth::user()->email;
        $mensaje->id_proyecto=$request->id_proyecto;
        $mensaje->para=$request->para ? $request->para : "";
        $mensaje->tipo=$request->tipo ? $request->tipo : "";

        $mensaje->save();
        $respuesta=Array('res'=>'Mensaje enviado correctamente');
        return response()->json($respuesta);
    }
}
