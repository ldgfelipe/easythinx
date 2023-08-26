<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Http\Request;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ContactosController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\FolderController;
use App\Mail\ContactoMailable;
use App\Http\Controllers\WebbuilderController;
use App\Http\Controllers\CabeceraBuilderController;
use App\Http\Controllers\PlantillasController;
use App\Models\webrouter;
use App\Models\Webbuilder;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    $inicio=Array();
    $menus=webrouter::where('tipo','=','inicio')->first();
    if(isset($menus->idpage)){
        $inicio=Webbuilder::where('id','=',$menus->idpage)->first();
    }
    return view('welcome',compact('inicio'));
});
Auth::routes([
"verify"=>
true
]);
// E-mail verification
Route::get('/register/verify/{code}', 'GuestController@verify');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout',function(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});
////api de proyecto
Route::post('/registraproyecto',[ProyectoController::class,'registraproyecto']);
Route::post('/cargaproyectos',[ProyectoController::class,'cargaproyectos']);
Route::post('/cargausuarios',[Usuarios::class,'cargaUsuarios']);
Route::post('/cargausuariosadmin',[Usuarios::class,'cargausuariosAdmin']);
Route::post('/cambiosusuario',[Usuarios::class,'cambiosusuario']);
///api de tareas
Route::post('/registrotareas',[TareasController::class,'registrotareas']);
Route::post('/altaMutipleTareas',[TareasController::class,'altaMutipleTareas']);


Route::post('cargatareas',[TareasController::class,'cargatareas']);
Route::post('eliminatarea',[TareasController::class,'eliminatarea']);
Route::post('subirarchivo',[ArchivosController::class,'subirarchivo']);
Route::post('guardacambiosarchivo',[ArchivosController::class,'guardacambiosarchivo']);
Route::post('cargarachivos',[ArchivosController::class,'cargarachivos']);
Route::post('downloadfile',[ArchivosController::class,'downloadfile']);
Route::post('eliminaArchivo',[ArchivosController::class,'eliminaArchivo']);
////Chats
Route::post('guardamensaje',[ChatsController::class,'guardamensaje']);
Route::post('tomamensajes',[ChatsController::class,'tomamensajes']);
Route::post('cargatodochat',[ChatsController::class,'cargatodochat']);
////Contactos
Route::post('buscausuarios',[Usuarios::class,'busquedausers']);
Route::post('cargalistacontacto',[ContactosController::class,'cargalistacontacto']);
Route::post('agregarcontacto',[ContactosController::class,'agregarcontacto']);
Route::post('eliminacontacto',[ContactosController::class,'eliminacontacto']);
Route::post('enviarcorreoinvitacion',[ContactosController::class,'enviarcorreoinvitacion']);
Route::post('guardarcambios',[ContactosController::class,'guardarcambios']);
/// perfil
Route::post('cargaperfil',[Usuarios::class,'cargaperfil']);
Route::post('guardaperfil',[Usuarios::class,'guardaperfil']);
Route::post('cambiacontrasena',[Usuarios::class,'cambiacontrasena']);
//// correos
Route::get('contactanos',function(){
    $correo = new ContactoMailable();
    Mail::to('ldgfelipecarrera@gmail.com')->send($correo);
    return "Return Mensaje Enviado";
});
///notificaciones
Route::post('/guardanotificacion',[NotificacionesController::class,'guardanotificacion']);
Route::post('/carganotificaciones',[NotificacionesController::class,'carganotificaciones']);
Route::post('/marcaleido',[NotificacionesController::class,'marcaleido']);
///webbuilder
Route::get('/webbuilder',[WebbuilderController::class,'webbuilder']);
Route::get('/editorbuilder',[WebbuilderController::class,'editorbuilder']);
Route::get('/menueditor',[WebbuilderController::class,'menueditor']);
Route::get('/cabecera',[WebbuilderController::class,'cabeceraeditor']);
Route::post('/guardarcabecera',[CabeceraBuilderController::class,'guardarcabecera']);
///api
Route::post('guardaplantilla',[WebbuilderController::class,'savetemplate']);
Route::post('eliminatsitioweb',[WebbuilderController::class,'eliminatsitioweb']);
///menus dato
Route::post('creareditarmenu',[WebbuilderController::class,'creareditarmenu']);
Route::post('eliminamenu',[WebbuilderController::class,'eliminamenu']);
Route::get('/{url}',[WebbuilderController::class,'loadpage']);
Route::post('/addfolder',[FolderController::class,'addfolder']);
Route::post('/cargafolder',[FolderController::class,'cargafolder']);
Route::post('/deletefolder',[FolderController::class,'deletefolder']);

//plantillas

Route::post('/addplantilla',[PlantillasController::class,'addplantilla']);
Route::post('/cargaplantillas',[PlantillasController::class,'cargaplantillas']);
Route::post('/eliminaplantilla',[PlantillasController::class,'eliminaplantilla']);

Route::post('/guardacambioasplantilla',[PlantillasController::class,'guardacambioasplantilla']);
