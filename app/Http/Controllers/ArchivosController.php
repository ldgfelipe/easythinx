<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Archivos;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
class ArchivosController extends Controller
{
    //
    public function subirarchivo(Request $request){
        $numc=0;
        $grupo="";
        $ininame=time().$request->nombre;
        $totalArchivos=count($request->archivo);
        if($totalArchivos>0){
            $grupo=$ininame;
        }
        forEach($request->archivo as $arch){
         $fileName =$ininame.$numc.'.'.$arch->getClientOriginalExtension();
        //// guarda archivo en base de datos
        //// sube archivo
        $urlArchivo="";
        $urlArchivo=public_path('upload/'.$request->proyecto);
        $arch->move($urlArchivo, $fileName);
                $file= new Archivos();
                $file->urlArchivo='upload/'.$request->proyecto."/".$fileName;
                $file->nombre=$request->nombre;
                $file->user=Auth::user()->id;
                $file->comentario=$request->comentario ? $request->comentario : "";
                $file->grupo=$grupo;
                $file->permiso=$request->permiso != NULL ? $request->permiso : 2;
                $file->folder=$request->folder != NULL ? $request->folder : "";
                $file->id_proyecto=$request->proyecto;
                $file->permisos=$request->permisos ? $request->permisos : '';
                $file->asignado="";
                $file->extension=$arch->getClientOriginalExtension();
                $file->save();
                $numc++;
        }
        return response()->json(['success'=>'Archivo subido correctamente']);
    }
    public function cargarachivos(Request $request){
        $folder=Folder::where('id_proyecto','=',$request->id_proyecto)->get();
        foreach($folder as $fol){
            $listaArchivos[$fol->nombre]=Archivos::where('id_proyecto','=',$request->id_proyecto)->where('folder','=',$fol->nombre)->get();
        }
        $listaArchivos['sinfolder']=Archivos::where('id_proyecto','=',$request->id_proyecto)->where('folder','=','')->get();
        return response()->json($listaArchivos);
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
    public function guardacambiosarchivo(Request $request){
            $file=Array(
            'nombre'=>$request->nombre,
            //'permiso'=>$request->permiso != NULL ? $request->permiso : '',
            'comentario'=>$request->comentario ? $request->comentario : '',
            'permisos'=>$request->permisos ? $request->permisos : '',
            'folder'=>$request->folder ? $request->folder : ''
        );
            Archivos::where('id','=',$request->id)->update($file);
            return response()->json(Array('res'=>'Cambios guardados'));
    }
}