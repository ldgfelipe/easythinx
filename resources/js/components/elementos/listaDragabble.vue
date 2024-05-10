<template>
    <div >
        <v-progress-circular v-if="loaderlista" loaderlista></v-progress-circular>

        <v-card v-if="!loaderlista">
            <div v-for="(fol, index) in folder" :key="'folder' + index">
                <div class="container">
                    <div class="drop-folder" @drop="endrop($event, fol.nombre)" @dragenter.prevent @dragover.prevent>
                        -<v-icon>mdi-folder</v-icon>{{ fol.nombre }}
                    </div>

                    <div class="drop-zone" @drop="endrop($event, fol.nombre)" @dragenter.prevent @dragover.prevent>
                        <div v-for="(item, index) in listado[fol.nombre]" @dragstart="starDrag($event, item)" :key="item.id"
                            class="drag-el" draggable="true">
                           <v-icon >{{ item.tipoarchivo==='Enlace' ? 'mdi-link' : 'mdi-file' }}</v-icon> {{ item.id }} {{ item.nombre }}

                            <v-btn
                                                v-if="
                                                    validapermiso({val:item, tp:'ver'})===true
                                                "
                                                class="greenD"
                                                elevation="2"
                                                icon
                                                raised
                                                @click="openvisor(item)"
                                                title="Ver Archivo"
                                            >
                                                <v-icon class="white--text"
                                                    >mdi-eye</v-icon
                                                >
                                            </v-btn>


                                            <v-btn
                                                v-if="
                                                    proyectoSelect.adminproy ===
                                                    true
                                                "
                                                class="red"
                                                elevation="2"
                                                icon
                                                raised
                                                @click="EliminarArchivo(item)"
                                                title="Eliminar Archivo"
                                            >
                                                <v-icon class="white--text"
                                                    >mdi-delete</v-icon
                                                >
                                            </v-btn>

                                            <v-btn
                                                v-if="
                                                    proyectoSelect.adminproy ===
                                                    true
                                                "
                                                class="greenD"
                                                elevation="2"
                                                icon
                                                raised
                                                title="Cambiar Permisos"
                                                @click="Cambiarpermisos(item)"
                                            >
                                                <v-icon class="white--text"
                                                    >mdi-lock</v-icon
                                                >
                                            </v-btn>

                        </div>
                    </div>
                </div>
            </div>
            <div class="drop-zone" @drop="endrop($event, 'sinfolder')" @dragenter.prevent @dragover.prevent>
                <div class="drop-folder" @drop="endrop($event, 'sinfolder')" @dragenter.prevent @dragover.prevent>..</div>
                <div v-for="(item, index) in listado['sinfolder']" @dragstart="starDrag($event, item)" :key="item.id"
                    class="drag-el" draggable="true">
                  <v-icon >{{ item.tipoarchivo==='Enlace' ? 'mdi-link' : 'mdi-file' }}</v-icon>   {{ item.id }} {{ item.nombre }}  
                    
                
                    <v-btn
                                                v-if="
                                                    validapermiso({val:item,tp:'ver'})
                                                "
                                                class="greenD"
                                                elevation="2"
                                                icon
                                                raised
                                                @click="openvisor(item)"
                                                title="Ver Archivo"
                                            >
                                                <v-icon class="white--text"
                                                    >mdi-eye</v-icon
                                                >
                                            </v-btn>

                                            <v-btn
                                                v-if="
                                                    proyectoSelect.adminproy ===
                                                    true
                                                "
                                                class="red"
                                                elevation="2"
                                                icon
                                                raised
                                                @click="EliminarArchivo(item)"
                                                title="Eliminar Archivo"
                                            >
                                                <v-icon class="white--text"
                                                    >mdi-delete</v-icon
                                                >
                                            </v-btn>

                                            <v-btn
                                                v-if="
                                                    proyectoSelect.adminproy ===
                                                    true
                                                "
                                                class="greenD"
                                                elevation="2"
                                                icon
                                                raised
                                                title="Cambiar Permisos"
                                                @click="Cambiarpermisos(item)"
                                            >
                                                <v-icon class="white--text"
                                                    >mdi-lock</v-icon
                                                >
                                            </v-btn>


                </div>
            </div>
        </v-card>

    </div>
</template>
<script>
//import draggable from "vuedraggable";
//import pdf from 'vue-pdf'
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        return {
            listado:{},
            loaderlista:false
        }
    },
    mounted() {
        this.cargalistado()
    },
    computed:{
        ...mapState([
            "proyectoSelect",
            "userproy",
            "url",
            "csrf",
            "sesion",
            "archivos",
            "socket",
            "listauser",
        ]),
    },
    methods: {
        ...mapActions(['validapermiso']),
        validapermiso(data) {
            
            var resp = true;
            if (this.proyectoSelect.adminproy === false) {
                //// SI NO ES ADMINISTRADOR VALIDA LOS PERMISOS POR USUARIO           ///  ? item.permiso >= 1
                if (data.val.permisos !== "" && data.val.permisos !== "[object Object]") {
                    var resp =   JSON.parse(data.val.permisos).find(e => e.usuario === this.sesion.email)[data.tp]
                }else{
                    resp = true;
                }
            } else {
                resp = true;
            }
      
            return resp;
        },
        cargalistado(){
            this.loaderlista=true

           
            setTimeout(()=>{
                this.listado=this.lista
                this.loaderlista=false
            },1000)
        },
        starDrag(event, item) {
            console.log(item)
            event.dataTransfer.dropEffect = 'move'
            event.dataTransfer.effectAllowed = 'move'
            event.dataTransfer.setData('itemID', item.id)
            event.dataTransfer.setData('profolder', item.folder)
        },
        endrop(event, list) {
            
           this.loaderlista=true
            const itemID = event.dataTransfer.getData('itemID')
            const profolder=event.dataTransfer.getData('profolder')
        
            var prov=profolder==='' || profolder===null || profolder==='null' ?  'sinfolder' : profolder
          
            var getData=this.listado[prov].find(e=>e.id===parseInt(itemID))
            var posicion=this.listado[prov].indexOf(getData)

            var urlub=this.url+'actualizaArchivos';
            getData.folder=list === 'sinfolder' ? '' : list

            
            //// actualiza  listado en base de datos
            fetch(urlub,{
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(getData),
            })
            .then(res=>res.json())
            .then((e)=>{
                console.log(e)
          
            /// guarda nueva lista a la que va
                 
            //// agrega a nueva lita 
                this.listado[list].push(getData)
            //// elimina de la lista 
                this.listado[prov].splice(posicion,1)
             //   this.loaderlista=false

             var cambioArchivo = {
                                accion: "Guarda Archivo",
                                id: this.proyectoSelect.id,
                            };
             this.socket.emit(
                                "actualiza_archivo",
                                cambioArchivo
                            );
       
            })



               /// this.$emit('updatelista',this.listado)
           
           
        },
        openvisor(item){
            this.$emit('openvisor',item)
        },
        EliminarArchivo(item){
            this.loaderlista=true
            this.$emit('eliminaArchivo',item)
            this.$nextTick(() => {
                this.cargalistado()
                this.loaderlista=false
                 })
        },
        Cambiarpermisos(item){
           
            this.loaderlista=true
            this.$emit('cambiapermisos',item)
            this.$nextTick(() => {
                this.cargalistado()
                this.loaderlista=false
                 })
            
        }
    },
    props: {
        lista: {},
        folder: {}
    },
    watch:{
        lista(){
            this.cargalistado()
        }
    }
}
</script>
<style >


.drop-folder {
    background-color: green;
    width: 100%;
    color: white;
}

.drag-el {
    color: #000;
    padding: 5px;
    margin-bottom: 10px;
}
</style>