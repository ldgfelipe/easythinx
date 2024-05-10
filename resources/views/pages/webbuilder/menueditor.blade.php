@extends('layout.template')
@section('title','Welcome')
@section('content')

<div class="p-3 border bg-light muted">
    <a class="btn btn-primary"  href=" {{env('APP_URL')}}webbuilder" style="background-color:green;" >
        Lista de Páginas <i class="bi bi-clipboard"></i>
     </a>

    <a class="btn btn-primary"  href=" {{env('APP_URL')}}editorbuilder" style="background-color:green;" >
       Crear Página <i class="bi bi-clipboard-plus"></i>
    </a>



</div>
<div class="container">
    <div class="row">
        <div class="col-md-3" style="border:solid 1px grey; border-radius:10px;">
            <h4 class="color:green;">Lista de páginas</h4>
            <hr />
            <ul style="list-style:none;">
                @foreach($webs as $web)
                <li >
                    {{$web->nombrepage}}
                    <div class="btn btn-primary" style="background-color:green;" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="cargadatosModal('{{$web->nombrepage}}','{{$web->url}}','{{$web->id}}','{{$web->id}}')" >
                        <i class="bi bi-arrow-bar-right"></i>
                    </div>

                </li>
                @endforeach()
            </ul>
        </div>
        <div class="col-md-9" style="border:solid 1px grey; border-radius:10px;">
            <h4 class="color:green;">Lista de Menú</h4>
            <hr />

            <ul style="list-style:none;">
                @foreach ($route as $rout)
                    <li>

                        <div style="border:solid 1px grey; background-color:#f4f5f6; width:100%; max-width:300px; padding:10px;">
                            {{$rout->menu}}
                            <a class="btn btn-primary" style="background-color:green;"  data-bs-toggle="modal" data-bs-target="#exampleModal"
                            onclick="editarmenu('{{$rout->idpage}}','{{$rout->id}}','{{$rout->menu}}','{{$rout->url}}','{{$rout->tipo}}','{{$rout->status}}','{{$rout->posicion}}','{{$rout->desc}}')">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a class="btn btn-danger" onclick="eliminarMenu('{{$rout->id}}')" >
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>

                    </li>

                @endforeach
            </ul>


        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id"  />
            <input type="text" class="form-control" id="idpage" placeholder="idpage" />
            <label>Nombre Menú</label>
            <input type="text" class="form-control" id="menu"   />
            <label>Url destino</label>
            <input type="text" class="form-control"  readonly id="url"   />
            <label>Inicio</label>
            <select class="form-control" id="tipo">
                <option value="">No Principal</option>
                <option value="inicio">Inicio</option>
            </select>
            <label>Status</label>
            <select class="form-control" id="status">
                <option value="1">Visible</option>
                <option value="0">Oculto</option>
            </select>
            <label>Posición</label>
            <input type="number" id="posicion" class="form-control"  />
            <label>Descripción:</label>
            <textarea class="form-control" id="desc"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="guardarMenu()">Save changes</button>
          </div>
        </div>
      </div>
    </div>

</div>



<script>

function editarmenu(idpage,id,menu,url,tipo,status,posicion,desc){
        $('#idpage').val($idpage);
        $('#id').val(id)
        $('#menu').val(menu)
        $('#url').val(url)
        $('#tipo').val(tipo)
        $('#status').val(status)
        $('#posicion').val(posicion)
        $('#desc').val(desc)

}

function cargadatosModal(nom,url,id,$idpage){

        $('#exampleModalLabel').html(nom)
        $('#menu').val(nom)
        $('#url').val(url)
        $('#idpage').val($idpage);

}


function guardarMenu(){
    var payload={
        id:$('#id').val(),
        menu:$('#menu').val(),
        url:$('#url').val(),
        tipo:$('#tipo').val(),
        status:parseInt($('#status').val()),
        posicion:$('#posicion').val(),
        desc:$('#desc').val(),
        idpage: $('#idpage').val()

    }


fetch('<?php echo env('APP_URL'); ?>creareditarmenu',{
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
        setTimeout(()=>{
         window.location.reload()
        },2000)
    })


}

function eliminarMenu(p){

    var payload={
        id:p
    }

    if(confirm('¿Desea eliminar el menú?')){
        fetch('<?php echo env('APP_URL'); ?>eliminamenu',{
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
            window.location.reload()
        })
    }
}

    </script>


@endsection()
