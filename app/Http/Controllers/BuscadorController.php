<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Contactos;
use App\Models\proyecto;
use App\Models\Tareas;


class BuscadorController extends Controller
{

    public function busqueda(Request $request){

        $fdatos=Folder::where('nombre','LIKE','%'.$request->busqueda.'%')->get();
        $cdatos=Contactos::where('name','LIKE','%'.$request->busqueda.'%')->get();
        $pdatos=proyecto::where('nombre','LIKE','%'.$request->busqueda.'%')->where('id_create','LIKE',Auth::user()->email)->where('id_collaborate','LIKE',Auth::user()->email)->get();
        $tdatos=Tareas::where('titulo','LIKE','%'.$request->busqueda.'%')->get();

        $arResp=Array(
            "folder"=>$fdatos,
            "contactos"=>$cdatos,
            "proyectos"=>$pdatos,
            'tareas'=>$tdatos
        );

        return response()->json(Array('Res'=>'Prueba de datos','rdatos'=>$arResp));

    }
}