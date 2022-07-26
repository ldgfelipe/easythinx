<template>
<div>
<v-card>
    <v-card-title class="greenD white--text">
        Archivos <v-spacer></v-spacer>
        <v-btn class="white greenD--text" @click="dialog=true"><v-icon>mdi-plus</v-icon></v-btn>
        <v-btn  class="white greenD--text" @click="cargaArchivos()"><v-icon>mdi-reload</v-icon></v-btn>
    </v-card-title>
    <v-card-text>
      <v-data-table :headers="titlearch" :items="archivos">
       <template v-slot:item.acciones="{item}">
                <v-btn class="greenD"
                elevation="2"
                icon
                raised>
                    <v-icon class="white--text" @click="visorArchivo(item)">mdi-eye</v-icon>
                </v-btn>


        </template>
      </v-data-table>

    </v-card-text>
</v-card>


    <v-dialog v-model="dialog" max-width="700">
        <v-card>
            <v-card-title>
                Nueva Archivo
            </v-card-title>
            <v-card-text>
                <v-text-field label="Nombre de Archivo" v-model="addfile.nombre" ></v-text-field>
                <v-file-input
                v-model="addfile.archivo"
                    label="Seleccione el Archivo"
                    filled
                    prepend-icon="mdi-camera"
                ></v-file-input>
                <v-btn class="greenD" @click="SubirArchivo()"><v-icon class="white--text">mdi-content-save</v-icon></v-btn>
            </v-card-text>
        </v-card>

    </v-dialog>

    <v-dialog v-model="viewdialog" fullscreen >
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <div v-if="tpfile==='imagen'" style="height: 100%; width:100%; overflow: auto;" >
                            <v-slider
                                v-model="width"
                                class="align-self-stretch"
                                min="100"
                                max="2000"
                                step="1"
                                ></v-slider>
                            <div style="text-align:center; max-width:100%; width:100%;">
                            <v-img :src="this.url+'public/'+fileselect.urlArchivo"  ></v-img>
                            </div>
                        </div>
                        <div v-if="tpfile==='video'">

                        </div>
                        <div v-if="tpfile==='audio'">

                        </div>
                        <div v-if="tpfile==='pdf'">

                        <v-slider
                                v-model="width"
                                class="align-self-stretch"
                                min="100"
                                max="2000"
                                step="1"
                                ></v-slider>

                            <iframe :width="width" style="height: 100%; min-height: 800px;" :src="'public/'+fileselect.urlArchivo"></iframe>

                        </div>
                        <div v-if="tpfile==='simple'">

                        </div>
                    </v-col>
                    <v-col cols="12" md="6">

                        <v-card>
                            <v-card-title class="greenD white--text">
                                {{fileselect.nombre}}

                                <v-spacer></v-spacer>



                                <v-btn
                                class="white"
                                  elevation="2"
                                    icon
                                    raised
                                    @click="viewdialog=false"
                                    >
                                      <v-icon class="white--greenD" >mdi-close</v-icon>

                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                URL:{{fileselect.urlArchivo}}
                                <hr />
                                  Extensión:{{fileselect.urlArchivo}}
                                <hr />
                                Descargar:
                                <v-btn class="primary"
                                    elevation="2"
                                    icon
                                    raised
                                    @click="descargarArchivo(fileselect)">
                                        <v-icon class="white--text" >mdi-download</v-icon>
                                </v-btn>
                                <hr />
                                Eliminar Archivo:

                                <v-btn class="error"
                                    elevation="2"
                                    icon
                                    raised
                                    @click="EliminarArchivo(fileselect)">
                                        <v-icon class="white--text" >mdi-delete</v-icon>
                                </v-btn>

                            </v-card-text>

                        </v-card>





                    </v-col>

                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>

</div>
</template>
<script>
import pdf from 'vue-pdf'
export default{
data(){
    return {
        dialog:false,
        viewdialog:false,
        addfile:{},
        file:"",
        archivos:[],
        titlearch:[
            {
                text:"Nombre",
                value:"nombre"
            },
            {
                text:"Extensión",
                value:"extension"
            },
            {
                text:"Acciones",
                value:"acciones"
            }
        ],
        fileselect:{},
        tpfile:"",
        width: 800,

    }
},
mounted(){
    this.cargaArchivos()
},
methods:{
    SubirArchivo(){
            const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append('proyecto', this.idproy.id);
                formData.append('nombre', this.addfile.nombre);
                formData.append('archivo', this.addfile.archivo);
                axios.post(this.url+'subirarchivo', formData, config)
                .then((response)=>{
                    console.log(response)
                this.dialog=false
                this.cargaArchivos()
                })
                .catch(function (error) {
                  console.log(error)
                });
    },
    cargaArchivos(){
                var archivos={
                    id_proyecto:this.idproy.id
                }
                fetch(this.url+'cargarachivos',{
                    method:'POST',

                    headers:{
                        'Content-type':'application/json',
                        'X-CSRF-TOKEN':this.csrf
                    },
                    body:JSON.stringify(archivos)
                })
                .then(res=>res.json())
                .then((ret)=>{
                    this.archivos=ret

                })
    },
    descargarArchivo(item){
        if(confirm('¿Seguro que desea descargar el archivo?')){
        fetch(this.url+'downloadfile',{
                    method:'POST',

                    headers:{
                        'Content-type':'application/json',
                        'X-CSRF-TOKEN':this.csrf
                    },
                    body:JSON.stringify(item)
                })
        .then(response => response.blob())
        .then(blob => URL.createObjectURL(blob))
        .then(uril => {
        var link = document.createElement("a");
        link.href = uril;
        link.download = 'public/'+item.urlArchivo;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        });
        }
    },
    visorArchivo(item){

        this.viewdialog=true
        this.fileselect=item
        switch(item.extension){
            case 'png':
            case 'PNG':
            case 'GIF':
            case 'gif':
            case 'jpg':
            case 'JPG':
            case 'JPEG':
            case 'jpeg':
                this.tpfile="imagen"
            break;
            case 'mp4':
            case 'ogg':
            case 'mov':
            case 'avi':
                this.tpfile="video"
            break;
            case 'pdf':
                this.tpfile="pdf"
            break;
            default:
                this.tpfile="simple"
            break;
        }

    },
    EliminarArchivo(item){
        if(confirm('¿Seguro que desea eliminar el archivo?')){

            fetch(this.url+'eliminaArchivo',{
                method:'POST',
                headers:{
                    'Content-type':'application/json',
                     'X-CSRF-TOKEN':this.csrf
                },
                body:JSON.stringify(item)
            })
            .then(res=>res.json())
            .then((res)=>{
                this.viewdialog=false
                 this.cargaArchivos()
                console.log(res)
            })

        }
    }
},
props:{
    idproy:{},
    csrf:"",
    url:"",
    sesion:{}
},
components: {
    pdf
  }
}
</script>
