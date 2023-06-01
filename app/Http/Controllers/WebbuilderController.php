<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Webbuilder;
use App\Models\webrouter;
use App\Models\CabeceraBuilder;

class WebbuilderController extends Controller
{
    public function webbuilder(Request $request){
        if(Auth::check()){
            //// carga paginas realizadas
            $webs=Webbuilder::get();
            return view('pages.webbuilder',compact('webs'));
        }else{
             return redirect('/');
        }
    }

    public function cabeceraeditor(){
        if(Auth::check()){
            $cab=Array();
            //// carga paginas realizadas
            $bus=CabeceraBuilder::count();

            if($bus==0){
                $cab=new CabeceraBuilder();
                $cab->contenido= "";
                $cab->save();
            }
                $cab=CabeceraBuilder::first();



            return view('pages.webbuilder.cabecerabuilder',compact('cab'));
        }else{
             return redirect('/');
        }
    }

    public function editorbuilder (Request $request){
        if(Auth::check()){
            if(isset($_REQUEST['idpage']) and $_REQUEST['idpage']!=NULL){
                $page=Webbuilder::where('id','=',$_REQUEST['idpage'])->first();
                return view('pages.webbuilder.editorpage',compact('page'));
            }else{
                return view('pages.webbuilder.editorpage');
            }

        }else{
             return redirect('/');
        }
    }

    public function savetemplate(Request $request){
        if($request->action=='create'){

            $webb=new Webbuilder();
            $webb->nombrepage=$request->nombrepage;
            $webb->metatags=$request->metatags ? $request->metatags : '';
            $webb->html=$request->html ? $request->html : '';
            $webb->url=$request->url ? $request->url : '';
            $webb->visitas=0;
            $webb->status=$request->status ? $request->status : '';
            $webb->save();
            $respuesta=Array("res"=>"proceso terminado","id"=>$webb->id);

        }

        if($request->action=='update'){

            $webUpdate=Array(
                "nombrepage"=>$request->nombrepage,
                "metatags"=>$request->metatags,
                "html"=>$request->html,
                "url"=>$request->url,
                "visitas"=>$request->visitas,
                "status"=>$request->status
            );

            $webb=Webbuilder::where('id','=',$request->idpage)
            ->update($webUpdate);

            $respuesta=Array("res"=>"proceso terminado","id"=>$request->id);
        }

        return response()->json($respuesta);


    }

    public function loadpage(Request $request, $url){

       $webload=Webbuilder::where('url','=',$url)
                            ->where('status','=',1)
                            ->first();
        if(isset($webload->nombrepage)){
            return view('loadpage',compact('webload'));
        }else{
            return view('errors.500');
        }


    }

    public function eliminatsitioweb(Request $request){
        $webdel=Webbuilder::where('id','=',$request->id)->delete();
        return response()->json(Array('res'=>"pagina eliminada"));
    }

    public function menueditor(Request $request){
        if(Auth::check()){
            //// carga paginas realizadas
            $webs=Webbuilder::get();
            $route=webrouter::get();
            return view('pages.webbuilder.menueditor',compact('webs','route'));

        }else{
             return redirect('/');
        }
    }

    public function creareditarmenu(Request $request){

        if(isset($request->id) and $request->id!=NULL){
            //// edita el menu
            $updatemenu=Array(
                'url'=>$request->url,
                'menu'=>$request->menu,
                'tipo'=>$request->tipo ? $request->tipo : "",
                'status'=>$request->status ? $request->status : 0,
                'desc'=>$request->desc ? $request->desc : "",
                'posicion'=>$request->posicion ? $request->posicion : 0,
                'idpage'=>$request->idpage

            );

            $menu=webrouter::where('id','=',$request->id)->update($updatemenu);
            return response()->json(Array('res'=>'Actualiza menú'));
        }else{
            ///// crea el menu
            $menu=new webrouter();
            $menu->url=$request->url;
            $menu->menu=$request->menu;
            $menu->tipo=$request->tipo ? $request->tipo : "";
            $menu->status=$request->status ? $request->status : 0;
            $menu->desc=$request->desc ? $request->desc : "";
            $menu->posicion=$request->posicion ? $request->posicion : 0;
            $menu->idpage=$request->idpage;
            $menu->save();



            return response()->json(Array('res'=>'Crea menú'));
        }
    }

    public function eliminamenu(Request $request){

        webrouter::where('id','=',$request->id)->delete();
        return response()->json(Array("res"=>"Menu eliminado"));

    }

}
