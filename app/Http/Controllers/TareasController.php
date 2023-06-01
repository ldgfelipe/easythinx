<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tareas;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificaciones;
use App\Mail\Notificacion;
use App\Models\Folder;
use Mail;

class TareasController extends Controller
{

    public function altaMutipleTareas (Request $request){

        foreach($request->tareas as $tituloTarea){

            $tarea=new Tareas();
            $tarea->id_proyecto=intval($request->id_proyecto);
            $tarea->titulo=$tituloTarea;
            $tarea->obs=json_encode(Array(Array("fecha"=>date('d-m-Y'),"hora"=>date('H:i:s'),"correo"=>Auth::user()->email,"contenido"=> "Se crea tarea de plantilla")));
            $tarea->desc= '';
            $tarea->status=0;
            $tarea->asignado= json_encode(Array(''));
            $tarea->caducidad= NULL;
            $tarea->folder= '';
            $tarea->save();

        }
        $respuesta=Array('res'=>'Registro correcto');
        return response()->json($respuesta);


    }


    public function registrotareas(Request $request){

        //// toma datos de la tarea actual
        $tarea_old=Tareas::where('id','=',$request->id)->first();
        $newArray=Array();
        if($tarea_old!=NULL){
        $varArray=explode(",",$tarea_old->asignado);
        $newArray=Array();
        forEach($varArray as $key){
            $viewkey=str_replace('"','',$key);
            $viewkey=str_replace("[",'',$viewkey);
            $viewkey=str_replace("]",'',$viewkey);
            $newArray[]=$viewkey;
        }
        }



        if(isset($request->asignado) and $request->asignado!=NULL){
        forEach($request->asignado as $correo){
            $respuestaSearch=array_search($correo,$newArray);

            if($respuestaSearch==0){

            $not=new Notificaciones();
            if($correo){
                $arraydatos=Array(
                    "correo"=>$correo,
                    "proynombre"=>$request->proynombre,
                    "titulo"=>$request->titulo,
                    "nombreInvita"=>$request->name
                );
            $not->nombre_des='Adminstrado de proyecto';
            $not->mensaje_des='La tarea "'.$request->titulo.'" te fue asignada de proyecto "'.$request->proynombre.'"';
            $not->email_des=$correo ? $correo : '';
            $not->id_user_des=$request->id ? $request->id : 0;
            $not->socket_des= '';
            $not->id_user_rem=Auth::user()->id;
            $not->nombre_rem=Auth::user()->name;
            $not->socket_rem='';
            $not->status=0;
            $not->save();
                /// envia correo de asignacion de tareas
                Mail::to($correo)->send(new Notificacion($arraydatos));
            }
        }
        }
    }
        if($request->action=='crear'){
            $tarea=new Tareas();
            $tarea->id_proyecto=intval($request->id_proyecto);
            $tarea->titulo=$request->titulo ? $request->titulo : '';
            $tarea->obs=$request->obs ? json_encode(Array($request->obs)) : json_encode(Array(Array("fecha"=>date('d-m-Y'),"hora"=>date('H:i:s'),"correo"=>Auth::user()->email,"contenido"=> "Se crea tarea")));
            $tarea->desc=$request->desc ? $request->desc : '';
            $tarea->status=$request->status ? $request->status : 0;
            $tarea->asignado=$request->asignado ? json_encode($request->asignado) : json_encode(Array(''));
            $tarea->caducidad=$request->caducidad ? $request->caducidad: NULL;
            $tarea->folder=$request->folder ? $request->folder : '';
            $tarea->save();
            $respuesta=Array('res'=>'Registro correcto');

            ///// notifica a quienes tiene que recibir tarea




        }

        if($request->action=='editar'){
            $tarea=Tareas::where('id','=',$request->id);

            $UpdateTarea=Array(
                "id_proyecto"=>$request->id_proyecto ? $request->id_proyecto : 0,
                "titulo"=>$request->titulo ? $request->titulo : '',
                "desc"=>$request->desc ? $request->desc : '',
                "obs"=>$request->obs ? $request->obs : '',
                "status"=>$request->status ? $request->status : 0,
                "asignado"=>$request->asignado ? $request->asignado : json_encode(Array('')),
                "caducidad"=>$request->caducidad ? $request->caducidad: NULL,
                "folder"=>$request->folder ? $request->folder : ''
            );
            $tarea->update($UpdateTarea);

            $respuesta=Array('res'=>'Actualización correcta');

        }

        if($request->action=='eliminar'){
            $tarea=Tareas::find($request->id);
            $tarea->delete();
            $respuesta=Array('res'=>'Tarea eliminada');
        }

        return response()->json($respuesta);

    }

    public function cargatareas(Request $request){
        $folder=Folder::where('id_proyecto','=',$request->id_proyecto)->where('tipo','=','Tareas')->get();

        foreach($folder as $fol){
            $listaTareas[$fol->nombre]=Tareas::where('id_proyecto','=',$request->id_proyecto)->where('folder','=',$fol->nombre)->get();
        }

        $listaTareas['sinfolder']=Tareas::where('id_proyecto','=',$request->id_proyecto)->where('folder','=','')->get();


       // $tarea=Tareas::where('id_proyecto',$request->id_proyecto)->get();

        return response()->json($listaTareas);


    }

    public function eliminatarea(Request $request){

        Tareas::where('id','=',$request->id)->delete();

        return response()->json('ok');

    }
}
