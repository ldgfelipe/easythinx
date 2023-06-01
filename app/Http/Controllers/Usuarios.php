<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contactos;
use Illuminate\Support\Facades\DB;
use App\Models\Perfil;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class Usuarios extends Controller
{
   public function cargaUsuarios(Request $request){
      $usuarios=Contactos::where('id_user',$request->id_user)->get();
      $used=[];

        forEach($usuarios as $user){

            array_push($used,$user->email);
        }




      return response()->json($used);
   }

   public function busquedausers(Request $request){
        $usuarios=Contactos::where('email','like','%'.$request->search.'%')
        ->where('id_user','=',Auth::user()->id)
        ->orWhere('name','=','%'.$request->search.'%')->get();

        return response()->json($usuarios);
   }

   public function cargausuariosAdmin(){

        $usuarios=User::all();

        return response()->json($usuarios);
   }

   public function cambiosusuario(Request $request){

    $guardaDatos=Array(
        'name'=>$request->name,
        'email'=>$request->email,
        'tipo_usuario'=>$request->tipo_usuario
    );

    $user=User::where('id','=',$request->id)
    ->update($guardaDatos);

    return response()->json(Array('res'=>'Cambios Realizados'));


   }
   function cargaperfil(Request $request){

    $user=User::where('id','=',$request->id)->first();

    $perfil=Perfil::where('id_usuario','=',$request->id)->first();

    $retData=Array('user'=>$user,"perfil"=>$perfil);

    return response()->json($retData);

   }
   function guardaperfil(Request $request){

    $userupdate=Array(
        "name"=>$request->name
    );
        User::where('id','=',$request->id)->update($userupdate);


        $perfil=Perfil::where('id_usuario','=',$request->id)->get();
        if(count($perfil)>0){
            $perfilupdate=Array(
                "apellido"=>$request->apellido ? $request->apellido : "",
                "telefono"=>$request->telefono ? $request->telefono : "",
                "notaria"=>$request->notaria ? $request->notaria : "",
                "pais"=>$request->pais ? $request->pais : "",
                "estado"=>$request->estado ? $request->estado : ""
            );

            Perfil::where('id_usuario','=',$request->id)->update($perfilupdate);


        }else{
            $newper=new Perfil();
            $newper->apellido=$request->apellido ? $request->apellido : "";
            $newper->telefono=$request->telefono ? $request->telefono : "";
            $newper->notaria=$request->notaria ? $request->notaria : "";
            $newper->pais=$request->pais ? $request->pais : "";
            $newper->estado=$request->estado ? $request->estado : "";
            $newper->id_usuario=$request->id ? $request->id : "";
            $newper->save();
        }

        return response()->json(Array("res"=>"Datos actualizado"));

   }
   function cambiacontrasena(Request $request){

    $changepass=Array("password"=>Hash::make($request->password));


    $user=User::where('id','=',$request->id)->update($changepass);


        return response()->json(Array('res'=>'Contraseña Actualizada'));
   }
}
