<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CabeceraBuilder;

class CabeceraBuilderController extends Controller
{
    //
    public function cargaCabecera(){
        $cab=CabeceraBuilder::get();

        return response()->json($cab);
    }

    public function guardarcabecera(Request $request){

            $bus=CabeceraBuilder::where('id','=',$request->id)->first();

            $arup=Array("contenido"=>$request->contenido);
            CabeceraBuilder::where('id','=',$request->id)->update($arup);
            /*
        if($bus){
            $cab=new CabeceraBuilder();
            $cab->contenido=$request->contenido ? $request->contenido : "";
            $cab->save();
        }else{


        }
*/

            return response()->json(Array('res'=>'Cabecera Guardada'));
    }

    public function actualizarbuilder(Request $request){

            $cab=CabeceraBuilder::where('id','=',$request->id)
            ->update(Array('contenido'=>$request->contenido ? $request->contenido :""));

            return response()->json(Array('res'=>'Cambios actualizados'));
    }
}
