@extends('layout.template')
@section('title','Welcome')
@section('content')

<div class="p-3 border bg-light muted">

    <a class="btn btn-primary"  href=" {{env('APP_URL')}}editorbuilder" style="background-color:green;" >
       Crear Página <i class="bi bi-clipboard-plus"></i>
    </a>

    <a class="btn btn-primary"  href=" {{env('APP_URL')}}menueditor" style="background-color:green;" >
        Menú <i class="bi bi-menu-button-wide"></i>

     </a>
     <a class="btn btn-primary" href="{{env('APP_URL')}}cabecera" style="background-color:green;" >
        Cabecera <i class="bi bi-card-heading"></i>
    </a>

</div>


</div>
<div class="container">
    <div class="row">
        @foreach($webs as $key)
            <div class="col-md-3" >

                <div class="card" style="width: 18rem;">

                    <div class="card-body">
                    <h5 class="card-title">{{$key->nombrepage}}</h5>
                    <p class="card-text">
                    {{$key->metatags}}<br />
                    <a href="{{env('APP_URL').$key->url}}" class="btn btn-primary" style="background-color:green;" target="_blank" >
                        <i class="bi bi-eye"></i>
                    </a>
                    <a onclick="eliminarPagina('<?php echo $key->nombrepage; ?>',<?php echo $key->id; ?>)" class="btn btn-danger" target="_blank" >
                        <i class="bi bi-trash"></i>
                    </a>
                    </p>
                    <a href="{{env('APP_URL')}}editorbuilder?idpage={{$key->id}}" class="btn btn-primary" style="width:100%; background-color:grey;">Editar Sitio</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
function eliminarPagina(nom,id){
    alert('eliminar pagina ['+nom+'] con id:['+id+']')
    var payload={
        id:id
    }
    fetch('<?php echo env('APP_URL'); ?>eliminatsitioweb',{
        method:'POST',
        headers:{
            'Content-type':'application/json',
            'X-CSRF-TOKEN': "<?php echo csrf_token(); ?>"
        },
        body:JSON.stringify(payload)
    })
    .then(res=>res.json())
    .then((res)=>{
        console.log(res)
        window.location.reload();
    })


}
</script>
@endsection()
