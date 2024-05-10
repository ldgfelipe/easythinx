<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\configuser;


class ConfiguserController extends Controller
{
    //

    public function cargadatosdeSession(Request $request){
        $configuser=configuser::where('id_user','=',$request->id)->get();
        $configres;
        /// carga configuración de carpetas 
        
        if(count($configuser)==0){
            $config=Array('proyectos'=>Array('folders'=>Array()));
            $addconfig=new configuser();
            $addconfig->id_user=$request->id;
            $addconfig->configsesion=json_encode($config);
            $addconfig->save();
            $configres="reloaddata";
        }else{
            $configres=$configuser;
        }


        return response()->json(Array('res'=>'carga en config controller datos de sesion de respuesta','config'=> $configres));
        
           }

     public function actualizaDatosdeSesion(Request $request){
        $update=Array('configsesion'=>$request->configsesion);
        $configdata=configuser::where('id_user','=',$request->id)->update($update);

        return response()->json(Array('res'=>'Actualizado'));
     }      
}
