<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificaciones;

class NotificacionesController extends Controller
{
    //

    public function guardanotificacion(Request $request){

        $not=new Notificaciones();

        $not->nombre_des=$request->name ? $request->name : '';
        $not->mensaje_des=$request->mensaje ? $request->mensaje : '';
        $not->email_des=$request->email ? $request->email : '';
        $not->id_user_des=$request->id ? $request->id : 0;
        $not->socket_des=$request->idsocket ? $request->idsocket : '';
        $not->id_user_rem=$request->id_rem ? $request->id_rem : 0;
        $not->nombre_rem=$request->name_rem ? $request->name_rem : '';
        $not->socket_rem=$request->socket_rem ? $request->socket_rem : '';
        $not->status=0;
        $not->save();

        return response()->json(Array('res'=>'Notificacion enviada'));
    }

    public function carganotificaciones(Request $request){
        $not=Notificaciones::where('email_des','=',$request->email)
        ->where('status','=',0)
        ->get();
        return response()->json($not);
    }

    public function marcaleido(Request $request){
        $not=Notificaciones::where('id','=',$request->id)
        ->update(Array('status'=>1));

    }
}
