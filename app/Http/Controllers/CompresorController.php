<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class CompresorController extends Controller
{
    /*
Datos de request 
$request->idproyecto [integer]
$request->folders [Array]
$request->folders [Array][archivos]


    */ 

    public function createAndDownloadZip(Request $request)
    {
        // Rutas

        $nombreRuta='zipcompresor/'.$request->idproyect.'-'.date('YmdHis');
        $mainFolderPath = public_path($nombreRuta);
        $zipFilePath = public_path($nombreRuta);
        
        // Crear carpeta principal si no existe
        if (!File::isDirectory($mainFolderPath)) {
            File::makeDirectory($mainFolderPath, 0777, true);
        }
    
        // Crear subcarpetas dentro de la carpeta principal
       
        $subfolderNames =$request->folders;

        foreach ($subfolderNames as $keyv => $subfolderName) {

            $subfolderPath = $mainFolderPath . '/' . $keyv;
            File::makeDirectory($subfolderPath, 0777, true);
            
            // Simular archivos dentro de las subcarpetas
           foreach($subfolderName as $archivos ){
            $fileContent = $archivos['urlArchivo'];
            $nomF=$archivos['nombre'].".".$archivos['extension'];
            File::copy(public_path($fileContent),$subfolderPath .'/'.$nomF);
           }
        }
        //archivo nombre zip
       // $nomzip=public_path($request->idproyect.'-'.date('YmdHis').'.zip');
        // Crear archivo ZIP
        $dirZip=$request->idproyect.'-'.date('YmdHis').'.zip';
        $nameZip=public_path($request->idproyect.'-'.date('YmdHis').'.zip');
        $zip = new ZipArchive;
        if ($zip->open($nameZip , ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = File::allFiles($mainFolderPath);
            foreach ($files as $key=>$value) {
                $relativePath=$value->getRelativePath(); /// nombre del folder
                $relativePathName=$value->getRelativePathName(); // nombre del folder y el archivo
               
                if($archivos['folder']==null){
                    $relativePathName=str_replace("sinfolder\\",'',$relativePathName);
                }
               
                //dd($archivos['folder']."/".basename($value));
                $zip->addFile($value,$relativePathName);
          
            }
            $zip->close();
        } else {
        
            return response()->json(['error' => 'No se pudo crear el archivo ZIP'], 500);
        }
    
        // Descargar archivo ZIP
        ///return Response::download($nameZip)->deleteFileAfterSend(true);
        $respuesta=Array(
            "path"=>env('APP_URL')."/public/".$dirZip,
            "root_path"=>public_path($dirZip),
            "nomzip"=>$dirZip,
            "main_folder"=>$mainFolderPath
        );
        return response()->json($respuesta);
    }
    
    public function cleanupAfterDownload(Request $request)
    {
        $mainFolderPath = $request->main_folder;
        $zipFilePath =$request->root_path;
    
        // Eliminar archivo ZIP y carpeta principal
        if (File::exists($zipFilePath)) {
            File::delete($zipFilePath);
        }

        if (File::isDirectory($mainFolderPath)) {
            File::deleteDirectory($mainFolderPath);
        }
    
        return response()->json(['message' => 'Limpieza completada']);
    }
}
