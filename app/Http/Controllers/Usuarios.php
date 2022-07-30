<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Usuarios extends Controller
{
   public function cargaUsuarios(){
      $usuarios=User::get();
      $used=[];
        forEach($usuarios as $user){
            array_push($used,$user->email);
        }

      return response()->json($used);
   }

   public function busquedausers(Request $request){

        $users=User::where('email','LIKE','%'.$request->search.'%')->get();

        return response()->json($users);

   }
}
