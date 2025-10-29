<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Contactos;
use App\Models\proyecto;
use App\Models\Tareas;
use Illuminate\Support\Facades\DB;

class BuscadorController extends Controller
{

    public function busqueda(Request $request){

      
        if($request->tipo==true){
         
            $arResp=proyecto::where('nombre','LIKE','%'.$request->busqueda.'%')
            ->where('id_create','LIKE','%'.Auth::user()->email.'%')
            ->orWhere('id_collaborate','LIKE','%'.Auth::user()->email.'%')
            ->get();
        }else{
        
            $arResp=DB::table('tareas')
            ->where('titulo','LIKE','%'.$request->busqueda.'%')
            ->join('proyectos','tareas.id_proyecto','=','proyectos.id')
            ->where('proyectos.id_create','LIKE','%'.Auth::user()->email.'%')
            ->orWhere('proyectos.id_collaborate','LIKE','%'.Auth::user()->email.'%')
         
        
            ->get();
        }
       

      

        return response()->json(Array('Res'=>'Resultado de busqueda','rdatos'=>$arResp));

    }
}