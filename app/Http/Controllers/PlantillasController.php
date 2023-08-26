<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Plantillas;

class PlantillasController extends Controller
{
    //
    public function addplantilla(Request $request){

        $addp=new Plantillas();
        $addp->nombre=$request->nombre ? $request->nombre : "";
        $addp->tareas=$request->tareas ? $request->tareas : "";
        $addp->save();

        $respuesta=Array('res'=>'guarda pantilla','data'=>$request->nombre);
        return response()->json($respuesta);

    }

    public function cargaplantillas(Request $request){

        $plan=Plantillas::get();
        return response()->json($plan);

    }

    public function guardacambioasplantilla(Request $request){

        $plan=Plantillas::where('id','=',$request->id)->update(Array(
            "tareas"=>$request->tareas
        ));

            $respuesta=Array("res"=>"Cambios actualizados");
        return response()->json($respuesta);
    }

    public function eliminaplantilla(Request $request){
        Plantillas::where('id','=',$request->id)->delete();
        $respuesta=Array("res"=>"Categoría eliminada");
        return response()->json($respuesta);
    }
}
