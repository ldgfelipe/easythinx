<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivos;
use Illuminate\Support\Facades\Auth;

class ArchivosController extends Controller
{
    //
    public function subirarchivo(Request $request){

        $fileName = time().$request->nombre.'.'.$request->archivo->getClientOriginalExtension();


        //// guarda archivo en base de datos


        //// sube archivo
        $urlArchivo=public_path('upload/'.$request->proyecto);
        $request->archivo->move($urlArchivo, $fileName);

            $file= new Archivos();
            $file->urlArchivo='upload/'.$request->proyecto."/".$fileName;
            $file->nombre=$request->nombre;
            $file->user=Auth::user()->id;
            $file->id_proyecto=$request->proyecto;
            $file->extension=$request->archivo->getClientOriginalExtension();
            $file->save();

        return response()->json(['success'=>'Archivo subido correctamente']);

    }

    public function cargarachivos(Request $request){
        $cargaArchivos=Archivos::where('id_proyecto','=',$request->id_proyecto)->get();
        return response()->json($cargaArchivos);
    }
    public function eliminaArchivo(Request $request){
        if(file_exists(public_path($request->urlArchivo))){
            unlink(public_path($request->urlArchivo));
        }

        if(!file_exists('public/'.$request->urlArchivo)){
            $delete=Archivos::where('id','=',$request->id);
            $delete->delete();
            $respuesta="El archivo se elimino correctamente de la base de datos";
        }else{
            $respuesta="No se pudo eliminar el archivo de la base por que aun esta disponible el archivo";
        }

        return response()->json(['success'=>$respuesta]);

    }
    public function downloadfile(Request $request){


        $filePath = public_path($request->urlArchivo);
        $headers = ['Content-Type: application/'.$request->extension];
        $fileName = time().$request->extension;
        return response()->download($filePath, $fileName, $headers);
    }
}
