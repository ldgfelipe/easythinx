<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\webrouter;
use Illuminate\Support\Facades\View;
use App\Models\CabeceraBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
$modelwebrouter=new webrouter();
        if ($modelwebrouter)
{
    $cargaDataMenu=webrouter::where('status','=',1)
    ->where('tipo','<>','inicio')
    ->get();

    $cab=CabeceraBuilder::get();



View::share(['menus'=>$cargaDataMenu,'cabecera'=>$cab]);

}else{

}



    }
}
