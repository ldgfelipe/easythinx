<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Folder;
class FolderController extends Controller
{

    public function addfolder(Request $request){
        $res=Folder::where("nombre","=",$request->nombre)->where('id_proyecto','=',$request->id_proy)->count();
            if($res==0){
                $fol=new Folder();
                $fol->nombre=$request->nombre;
                $fol->id_proyecto=$request->id_proy;
                $fol->tipo=$request->tipo;
                $fol->save();
                $respuesta=Array("resultado"=>"Carpeta creada id:".$fol->id);
            }else{
                $respuesta=Array("resultado"=>"La carpeta ya existe");
            }
        return response()->json($respuesta);
    }
    public function cargafolder(Request $request){

        $folders=Array();
        $status=Array();
        $folders=Folder::where('id_proyecto','=',$request->id_proyecto)->where('tipo','=',$request->tipo)->get();

        foreach($folders as $folder){
            $status[$folder->nombre]=false;
        }

        $result=Array(
                    "datos"=>$folders,
                    "status"=>$status
                );

        return response()->json($result);

    }
    public function deletefolder(Request $request){
        Folder::where('id','=',$request->id_folder)->delete();
        return response()->json(Array('res'=>'Folder Eliminado'));
    }
}
