@extends('layout.template')
@section('title', 'Welcome')
@section('content')


<div class="p-3 border bg-light muted">

    <a class="btn btn-primary"  href=" {{env('APP_URL')}}webbuilder" style="background-color:green;" >
        Lista de Páginas <i class="bi bi-clipboard"></i>
     </a>

     <a class="btn btn-primary"  href=" {{env('APP_URL')}}menueditor" style="background-color:green;" >
        Menú <i class="bi bi-menu-button-wide"></i>

     </a>


</div>
<div class="row">
    <div class="col-md-12" style="text-align: center;">
    <div style="padding:5px;">
    <div id="preview">

    </div>
</div>
    <input type="hidden" id="id_content"  value="{{$cab->id}}" />

            <textarea id="areasave" style="width:100%; height:100%; max-width:100%; min-height:250px; margin:0 auto; border:solid 1px #000; background-color:#000; color:#fff;">
                @if($cab)
                    {{ $cab ? utf8_encode($cab->contenido) : "" }}
                @endif
            </textarea>

            <div  class="btn btn-primary" style="background-color:green; color:#fff;" onclick="ReiniciarEstructura()">Reiniciar Estructura</div>

        <div class="btn btn-primary" style="background-color:green; color:#fff;" onclick="ActualizaPreview()">Actualizar Vista Previa</div>

        <div id="loader" class="btn btn-default" style="display:none;"><img src="public/images/loader/loader.gif" width="30"  /></div>
        <button id="guardando" class="btn btn-primary" style="color:#fff;" onclick="guardarDatos()">Guardar</button>


        <a class="btn btn-primary"  href="https://icons.getbootstrap.com/" target="_blank">iconos</a>
    </div>
</div>
@if($cab)
<script>


$('#areasave').val(`<?php echo utf8_encode($cab->contenido); ?>`)
$('#preview').html(`<?php echo utf8_encode($cab->contenido); ?>`)

</script>
@endif
<script>


function ActualizaPreview(){
    $('#preview').html($('#areasave').val())
}

function guardarDatos(){
    $('#loader').css('display','inline');
    $('#guardando').css('display','none');
    var payload={
        id:$('#id_content').val(),
        contenido:$('#areasave').val()
    }

    console.log('<?php echo env('APP_URL'); ?>guardarcabecera');

    fetch('<?php echo env('APP_URL'); ?>guardarcabecera',{
        method:'POST',
        headers:{
            'Content-type':'application/json',
            'X-CSRF-TOKEN':'<?php echo csrf_token(); ?>'
        },
        body:JSON.stringify(payload)
    })
    .then(res=>res.json())
    .then((resp)=>{

        alert('Cambios Guardados');
        console.log(resp)
        $('#loader').css('display','none');
    $('#guardando').css('display','inline');
    })
}

function ReiniciarEstructura(){
    if(confirm('¿Seguro que deseas reiniciar la cabecera?')){
    var estruc= `
    <div style="padding:10px; width:100%; height:auto; background-color:#222; color:#fff; ">
        <div class="row">
            <div class="col-md-6" style="text-align:left;">

                    <a href="#" target="_blank"><i style="color:blue; font-size:24px;" class="bi bi-facebook"></i></a>
                    <a href="#" target="_blank"><i style="color:purple; font-size:24px;" class="bi bi-instagram"></i></a>
                    <a href="#" target="_blank"><i style="color:cyan; font-size:24px;" class="bi bi-twitter"></i></a>

                </div>
                <div class="col-md-2">

                    <i style="color:#fff; font-size:24px;" class="bi bi-phone"></i>
                    Llamanos: (415) 2456-789

                </div>
                <div class="col-md-2">

                    <i style="color:#fff; font-size:24px;" class="bi bi-envelope"></i>
                    info@gmail.com

                </div>

            </div>

        </div>
        `
        $('#areasave').val(estruc)

$('#preview').html(estruc)
    }


}



    </script>
@endsection()
