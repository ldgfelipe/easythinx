<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contactos;
use App\Models\User;
use App\Http\Controllers\ContactosController;
use App\Mail\ContactoMailable;

class ContactosController extends Controller
{
    //

    public function cargalistacontacto (Request $request){

        $Contac=Contactos::where('id_user',$request->id)->get();

        $DataUsers=Array();

        forEach($Contac as $key){
            $datosAdd=Array();
            $datosAdd['name']=$key['name'];
            $datosAdd['email']=$key['email'];
            $datosAdd['info']=$key['info'];

            $datosAdd['register']=$key['register'];


            if($key['register']==0){
                $users=User::where('email',$datosAdd['email'])->first();
            if($users==null){
                $datosAdd['status']=0;
            }else{
              ///// lo cambia el register a 1
              $datosAdd['status']=1;
              Contactos::where('email',$datosAdd['email'])->update($datosAdd);
            }

            }else{
                $datosAdd['status']=$key['register'];
            }


            array_push($DataUsers,$datosAdd);
        }


        return response()->json($DataUsers);


    }
    public function enviarcorreoinvitacion(Request $request){
        $correo = new ContactoMailable($request->all());
        Mail::to($request->email)->send($correo);

        return response()->json(Array('res'=>'envio de correo correcto'));

    }
    public function agregarcontacto(Request $request){


        if($request->sendmail==true){
            $correo = new ContactoMailable($request->all());
            Mail::to($request->email)->send($correo);
        }


        $con=Contactos::where('id_user','=',$request->id_user)
        ->where('email','=',$request->email)->get();
        $Contac=new Contactos();

        if(count($con)==0){
            $Contac->id_user=$request->id_user;
            $Contac->name=$request->name ? $request->name : "";
            $Contac->email=$request->email;
            $Contac->info=$request->info ? $request->info : "";
            $Contac->register=$request->register ? $request->register : 0;
            $Contac->save();
            $respuesta=Array('code'=>1,'res'=>'Registro de contacto correcto');
        }else{
            $respuesta=Array('code'=>0,'res'=>'El correo ya esta agregado');
        }


        return response()->json($respuesta);

    }

    public function eliminacontacto(Request $request){
        $Contac=Contactos::find($request->id);
        $Contac->delete();

        return response()->json(Array('res'=>'Contacto eliminado'));
    }

    public function guardarcambios(Request $request){
        $Contac=Contactos::where('id',$request->id);
        $data=Array(
            'name'=>$request->name ? $request->name : "",
            'info'=>$request->info ? $request->info : ""
        );

        $Contac->update($data);

        return response()->json(Array('res'=>'Cambios Guardados'));

    }
}
