<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payments;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pay=false;
        $getPay=payments::where('id_user',Auth::user()->id)->first();
        /// toma datos de pago 
        if(isset($getPay->status) and $getPay->status==1){
            $pay=true;
        }
        
        if(Auth::user()->tipo_usuario==2){
            $pay=true;
        }

        return view('home',compact('pay'));
    }
}
