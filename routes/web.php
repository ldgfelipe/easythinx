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
use App\Mail\ContactoMailable;

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
    return view('welcome');
});

Auth::routes();

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


///api de tareas
Route::post('/registrotareas',[TareasController::class,'registrotareas']);
Route::post('cargatareas',[TareasController::class,'cargatareas']);


Route::post('subirarchivo',[ArchivosController::class,'subirarchivo']);
Route::post('cargarachivos',[ArchivosController::class,'cargarachivos']);

Route::post('downloadfile',[ArchivosController::class,'downloadfile']);
Route::post('eliminaArchivo',[ArchivosController::class,'eliminaArchivo']);

////Chats
Route::post('guardamensaje',[ChatsController::class,'guardamensaje']);
Route::post('tomamensajes',[ChatsController::class,'tomamensajes']);

////Contactos
Route::post('buscausuarios',[Usuarios::class,'busquedausers']);
Route::post('cargalistacontacto',[ContactosController::class,'cargalistacontacto']);

Route::post('agregarcontacto',[ContactosController::class,'agregarcontacto']);
Route::post('eliminacontacto',[ContactosController::class,'eliminacontacto']);

Route::post('guardarcambios',[ContactosController::class,'guardarcambios']);


//// correos
Route::get('contactanos',function(){
    $correo = new ContactoMailable();
    Mail::to('ldgfelipecarrera@gmail.com')->send($correo);
    return "Return Mensaje Enviado";
});
