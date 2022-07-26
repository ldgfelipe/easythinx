<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tareas;
use Illuminate\Support\Facades\Auth;

class TareasController extends Controller
{
    public function registrotareas(Request $request){

        if($request->action=='crear'){
            $tarea=new Tareas();
            $tarea->id_proyecto=intval($request->id_proyecto);
            $tarea->titulo=$request->titulo;
            $tarea->obs=$request->obs ? json_encode(Array($request->obs)) : json_encode(Array(Array("fecha"=>date('d-m-Y'),"hora"=>date('d-m-Y'),"correo"=>Auth::user()->email,"contenido"=> "Se crea tarea")));
            $tarea->desc=$request->desc;
            $tarea->status=$request->status;
            $tarea->asignado=$request->asignado ? json_encode($request->asignado) : json_encode(Array(Auth::user()->email));
            $tarea->save();
            $respuesta=Array('res'=>'Registro correcto');
        }

        if($request->action=='editar'){
            $tarea=Tareas::where('id','=',$request->id);

            $UpdateTarea=Array(
                "id_proyecto"=>$request->id_proyecto,
                "titulo"=>$request->titulo,
                "desc"=>$request->desc,
                "obs"=>$request->obs,
                "status"=>$request->status,
                "asignado"=>$request->asignado ? $request->asignado : json_encode(Array(Auth::user()->email))
            );
            $tarea->update($UpdateTarea);

            $respuesta=Array('res'=>'Actualización correcta');

        }

        if($request->action=='eliminar'){
            $tarea=Tareas::find($request->id);
            $tarea->delete();
            $respuesta=Array('res'=>'Tarea eliminada');
        }

        return response()->json($respuesta);

    }

    public function cargatareas(Request $request){

        $tarea=Tareas::where('id_proyecto',$request->id_proyecto)->get();

        return response()->json($tarea);


    }
}
