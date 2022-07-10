<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proyecto;

class ProyectoController extends Controller
{
    //
    public function registraproyecto(Request $request){
        proyecto::insert($request);
        $respuesta=Array('res'=>1);
     return response()->json($respuesta);
    }
}
