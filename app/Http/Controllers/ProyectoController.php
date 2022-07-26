<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proyecto;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    //
    public function registraproyecto(Request $request){
        if($request->action=='crear'){
        $addproyecto = new proyecto;

        $addproyecto->nombre = $request->nombre;
        $addproyecto->desc = $request->desc ? $request->desc : '';
        $addproyecto->status = $request->status ? $request->status : 0;
        $addproyecto->notas = $request->notas ? $request->notas : '';
        $addproyecto->id_create=json_encode(Array(Auth::user()->email));
        $addproyecto->id_collaborate=json_encode(Array(""));

        $addproyecto->save();
        $respuesta=Array('res'=>'Proyecto creado correctamente');

    }
        if($request->action=='editar'){
            $update=proyecto::where('id','=',$request->id);
            $upproyect=Array(
                "id_create"=>$request->id_create,
                "id_collaborate"=>$request->id_collaborate,
                "nombre" => $request->nombre ? $request->nombre : '',
                "desc" => $request->desc ? $request->desc : '',
                "status" => $request->status ? $request->status : 0,
                "notas" => $request->notas ? $request->notas : ''
            );
            $update->update($upproyect);
            $respuesta=Array('res'=>'Cambios realizados');
        }



        if($request->action=='eliminar'){

            $proy=proyecto::find($request->id);
            $proy->delete();

            $respuesta=Array('res'=>'Proyecto Eliminado');
        }

        return response()->json($respuesta);

    }

    public function cargaproyectos(Request $request){
        $cargarespuesta=proyecto::where('id_create','LIKE','%'.Auth::user()->email.'%')->orWhere('id_collaborate','LIKE','%'.Auth::user()->email.'%')->get();
        return response()->json($cargarespuesta);
    }



}
