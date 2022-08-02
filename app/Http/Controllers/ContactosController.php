<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contactos;
use App\Http\Controllers\ContactosController;
use App\Mail\ContactoMailable;

class ContactosController extends Controller
{
    //

    public function cargalistacontacto (Request $request){

        $Contac=Contactos::where('id_user',$request->id)->get();

        return response()->json($Contac);
    }

    public function agregarcontacto(Request $request){


        if($request->sendmail==true){
            $correo = new ContactoMailable($request->all());
            Mail::to($request->email)->send($correo);
        }



        $Contac=new Contactos();
        $Contac->id_user=$request->id_user;
        $Contac->name=$request->name ? $request->name : "";
        $Contac->email=$request->email;
        $Contac->info=$request->info ? $request->info : "";
        $Contac->register=$request->register ? $request->register : 0;
        $Contac->save();

        return response()->json(Array('res'=>'Registro de contacto correcto'));

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
