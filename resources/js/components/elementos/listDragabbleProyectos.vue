<template>
    <div>
   
    <v-progress-circular v-if="actualizaData" indeterminate color="green"></v-progress-circular>
        <v-btn class="greenD white--text" @click="creacarpeta = true" title="Agregar Folder"><v-icon>mdi-plus</v-icon><v-icon>mdi-folder</v-icon>
        </v-btn>

        <v-btn class="greenD white--text" @click="inifolderproyect()" title="Actualizar Listado">
            <v-icon>mdi-reload</v-icon>
        </v-btn>

        <v-btn @click="filtroStatus = 1" :class="filtroStatus === 1 ? 'green white--text' : 'black--text'">
            Activos
        </v-btn>

        <v-btn @click="filtroStatus = 0" :class="filtroStatus === 0 ? 'green white--text' : 'black--text'">
            Inactivo
        </v-btn>

        <v-btn @click="filtroStatus = 6" :class="filtroStatus === 6 ? 'green white--text' : 'black--text'">
            Archivados
        </v-btn>

        <v-btn @click="filtroStatus = 2" :class="filtroStatus === 2 ? 'green white--text' : 'black--text'">
            Concluido
        </v-btn>

       <!----- <v-text-field v-model="search" label="Ingrese el nombre del proyecto que desea buscar"></v-text-field>----->

        <v-progress-circular v-if="loaderlista" indeterminate></v-progress-circular>

        <v-dialog max-width="600" v-model="creacarpeta">
            <v-card>
                <v-card-title class="greenD white--text">
                    <v-icon>mdi-plus</v-icon> folder <v-spacer> </v-spacer> <v-btn class="greenD white--text"
                        title="Cerrar"><v-icon>mdi-close</v-icon></v-btn>
                </v-card-title>
                <v-card-text>
                    <v-text-field v-model="addnamefolder"></v-text-field>
                    <v-btn class="greenD white--text" @click="agregafolder()" title="Crear Folder">Crear</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>

        <div class="container">
            
            <v-row>
                <v-col cols="12" md="12" class="carpetastyle" v-if="!loaderlista" v-for="(key, folder,pos) in listafolders"
                    :key="folder + '-seccion'" @drop="endrop($event, folder)" @dragenter.prevent @dragover.prevent>
                    <div class="greenD white--text" style="cursor:pointer;">
                        
                        <v-btn @click="cambiaStatusCarpeta(folder)">

                            <v-icon class=" greenD--text">
                                {{ statusfolders[folder] ? 'mdi-minus-box' : 'mdi-file-tree-outline'}}
                            </v-icon>

                        </v-btn> 
                                
                        <v-btn>
                            {{ folder === 'sf' ? '' : folder }} 
                        </v-btn>    

                        ({{ Object.keys(key).length }})  
                     
                        <v-btn v-if="folder !== 'sf'"  @click="muestaVentanaInfo(key,folder,pos)" class="white greenD--text" title="Configuración de Carpeta">
                            <v-icon>mdi-cog</v-icon>
                        </v-btn>
            
                    </div>
                    <v-row v-if="statusfolders[folder]">
                      
                        <v-col cols="12" md="12" v-for="(item, index) in filteredList(key)" :key="index + 'sec'"
                            @dragstart="starDrag($event, { item: item, folder: folder })" v-if="item.status === filtroStatus"
                            class="drag-el" draggable="true" style="padding:2%;">

                            <v-card>
                                
                                <v-card-text>
                                    {{ item.nombre }}
                                    <v-chip v-if="item.status === 1" class="greenD white--text">Activo</v-chip>
                                    <v-chip v-if="item.status === 6" class="Grey white--text">Archivado</v-chip>
                                    <v-chip v-if="item.status === 0" class="Grey white--text">Inactivo</v-chip>
                                    <v-chip v-if="item.status === 2" class="Grey white--text">Concluido</v-chip>
                                    <v-btn @click="editarPro(item)" v-if="sesion.tipo_usuario >= 1"
                                        title="Editar Proyecto">Editar</v-btn> 
                                    <v-btn @click="openProyecto(item)" title="Abrir Proyecto">Abrir</v-btn>
<v-chip class="orange black--text">Tareas: {{ item.ttareas }}  </v-chip> <v-chip class="red white--text" >Proceso: {{ item.Tfinalizado }} </v-chip> <v-chip class="success">Finalizado: {{ item.Tproceso }} </v-chip>  <v-btn @click="actualizatareasproyecto(item)" title="Actualiza datos proyecto"><v-icon>mdi-reload</v-icon></v-btn>
                                </v-card-text>

                            </v-card>
                        
                        </v-col>

                    </v-row>
                </v-col>
            </v-row>
        </div>

        <v-dialog v-model="IntoFolder">
            <v-card>
                <v-card-title class="greenD white--text">
                    Configuración de carpeta
               <v-spacer></v-spacer> <v-btn
                        @click="IntoFolder = false"><v-icon>mdi-close</v-icon></v-btn>
                </v-card-title>
                <v-card-text>
                    <br />
                    <br />
                    <br />
                   <v-text-field v-model="Nname" label="Nombre de carpeta" outlined ></v-text-field>         
                   <v-btn class="greenD white--text" @click="cambiarNombre()">Guardar Cambio</v-btn>
                    <v-btn v-if="muestraIntoFolder.length===0" @click="eliminafolder()" class="red white--text"  >
                        Eliminar Carpeta
                    </v-btn>

                    <v-btn v-if="muestraIntoFolder.length>0" class="grey white--text"  >
                        No puede eliminar la carpeta
                    </v-btn>
                           
        

                  <!----- <v-row>
                        <v-col cols="12" md="12" v-for="(item, index) in muestraIntoFolder" :key="index + 'sec'"
                            @dragstart="starDrag($event, { item: item, folder: folder })" class="drag-el" draggable="true"
                            style="padding:2%;">
                            <v-card>

                                <v-card-text>

                                    {{ item.nombre }}

                                    <v-chip v-if="item.status === 1" class="greenD white--text">Activo</v-chip>
                                    <v-chip v-if="item.status === 0" class="Grey white--text">Inactivo</v-chip>

                                    <v-chip v-if="item.status === 2" class="Grey white--text">Concluido</v-chip>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="editarPro(item)" title="Editar Proyecto">Editar</v-btn>
                                </v-card-text></v-card>
                        </v-col>
                    </v-row>--->
               
                </v-card-text>

            </v-card>

        </v-dialog>

    </div>
</template>
<script>
import { tSThisType } from '@babel/types'
import { mapState, mapActions } from 'vuex'
export default {
    data() {
        return {
            loaderlista: false,
            listafolders: {},
            creacarpeta: false,
            folders: [],
            addnamefolder: "",
            statusfolders: {},
            muestraIntoFolder: {},
            IntoFolder: false,
            fname: "",
            search: "",
            filtroStatus: 1,
            Nname:"",
            gTotaltareas:{},
            gTotalproceso:{},
            gTotalfinalizados:{}
    
        }
    },
    computed: {
        ...mapState([
            "configuser",
            "proyectos",
            "usuarios",
            "csrf",
            "sesion",
            "url",
            "socket"])
    },
    created() {
        this.inifolderproyect()
         this.$nextTick(()=>{this.actualizatodalistaTareaProyectos()},1000)
    },
    methods: {
        /// actualiza los datos de la base configuser
        ...mapActions(["actualizaDatosDeSesion", "cargaProyectos", "LoadProyecto"]),
        
        actualizatareasproyecto(p){
         var payload={
            id_proyecto:p.id
         }
             fetch(this.url + "actualizatareasproyecto", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .catch((error) => console.error("Error", error))
                .then((resp) => {
                    console.log(resp)
                    p.ttareas=resp.length
                      p.Tproceso=0
                       p.Tfinalizado=0
                    /// cuenta tareas 
                   for(var t=0; t<resp.length; t++){
                    if(resp[t].status===0){
                        console.log('contando 0')
                         p.Tproceso = p.Tproceso+1
                    }
                      if(resp[t].status===1){
                        console.log('contando 1')
                           p.Tfinalizado=p.Tfinalizado+1
                    }
                   }
                      this.actualizatodo()
                });
        },
        actualizatodalistaTareaProyectos(){
              this.gTotaltareas=0
            this.gTotalpendientes=0
            this.gTotalfinalizados=0
               Object.keys(this.listafolders).forEach((i)=>{
                this.listafolders[i].map((e)=>{
                     this.$nextTick(()=>{this.actualizatareasproyecto(e)})
                })
      
             })
          
        },
        eliminafolder(){
            if(confirm('¿Seguro que deseas eliminar la carpeta?')){
                delete this.listafolders[this.fname] 
            }

                 this.actualizatodo()

              this.IntoFolder = false
        },
        cambiarNombre(){
            if(this.Nname!==this.fname){
                 this.$set(this.listafolders,[this.Nname],this.listafolders[this.fname])
                delete this.listafolders[this.fname] 
                this.actualizatodo()
            }else{
                console.log('no hay cambios')
            }
           // delete this.listafolders[this.fname]

                this.IntoFolder = false
        },
        filteredList(p) {
            return p.filter(post => {
                return post.nombre.toLowerCase().includes(this.search.toLowerCase())
            })
        },
        openProyecto(it) {
            this.$emit("closeProyectVentana", false)
            this.LoadProyecto(it)
        },
        muestaVentanaInfo(item, fn, pos) {
            this.IntoFolder = true
            this.muestraIntoFolder = item
            this.fname = fn
            this.Nname= fn
            this.indexfol=pos
    

        },
        cambiaStatusCarpeta(f) {
            this.statusfolders[f] ? this.$set(this.statusfolders, f, false) : this.$set(this.statusfolders, f, true)
            this.actualizatodo()
        },
        editarPro(item) {
            ///methodo para crear el listado de proyectos para exportar la instrucción para crear proyectos
            this.$emit('editaproy', item)
        },

        starDrag(event, item) {
            //methodo cundo inicia el arrastre
            event.dataTransfer.dropEffect = 'move'
            event.dataTransfer.effectAllowed = 'move'
            event.dataTransfer.setData('getData', JSON.stringify(item.item));
            event.dataTransfer.setData('itemID', item.item.id)
            event.dataTransfer.setData('profolder', item.folder)
        },
        endrop(event, list) {
            //methodos cuando finaliza el arrastre
            // console.log(list)
            // console.log(event)
            this.loaderlista = true
            let itemID = event.dataTransfer.getData('itemID')
            let profolder = event.dataTransfer.getData('profolder')
            let prov = profolder === '' || profolder === null || profolder === 'null' || profolder === 'undefined' || profolder === undefined ? 'sf' : profolder
            let getData = this.listafolders[prov].find(e => e.id === parseInt(itemID))
            //let getData=JSON.parse(event.dataTransfer.getData('getData'))
            let posicion = this.listafolders[prov].indexOf(getData)
            // verifica que no tenga duplicados el registro y que el folder a donde va sea diferente del que viene
            if (this.listafolders[list].indexOf(getData) === -1 && list != prov) {
                //elimina de la lista anterior 
                this.listafolders[prov].splice(posicion, 1)
                //agrega a la lista nueva 
                this.listafolders[list].push(getData)
            }
            let payload = {
                folders: this.folders,
                listafolders: this.listafolders,
                user_id: this.sesion.id,
                statusfolders: this.statusfolders
            }

            this.actualizaDatosDeSesion(payload)
            /// this.$emit('updatelista',this.listado)
            this.loaderlista = false
        },
        inifolderproyect() {
            this.configuser.proyectos.listafolders ? this.listafolders = this.configuser.proyectos.listafolders : this.listafolders = {}

            if (!this.configuser.proyectos.statusfolders) {
                for (var fol in this.listafolders) {
                    this.statusfolders[fol] = true
                }
            } else {
                this.statusfolders = this.configuser.proyectos.statusfolders
            }

            // console.log(this.statusfolders)

            this.actualizatodo()
        },
        agregafolder() {
            this.creacarpeta = false
            this.$set(this.listafolders, this.addnamefolder, [])
            this.addnamefolder = ""
            this.folders.push(this.addnamefolder);
            let payload = {
                folders: this.folders,
                listafolders: this.listafolders,
                user_id: this.sesion.id,
                statusfolders: this.statusfolders
            }
            /// actualiza configuración de usuarios
            this.actualizaDatosDeSesion(payload)
        },

        updateListaFolder(proyectos, itemfolder, folder, posicion) {

            /// actualiza listado de carpetas y proyectos
            this.loaderlista = true
            this.listafolders[folder][posicion] = proyectos
            let payload = {
                folders: this.folders,
                listafolders: this.listafolders,
                user_id: this.sesion.id,
                statusfolders: this.statusfolders
            }
            /// actualiza configuración de usuarios
            this.actualizaDatosDeSesion(payload)

            this.loaderlista = false
        },
        updatefolderlist(item, folder, action, posicion) {
            //// ejecuta acción para actualizar listado de usuarios
            //  console.log(item)
            //  console.log(folder)
            // console.log(action)
            // console.log(posicion)
            if (action === 'add') {
                console.log('******* log add' + item.nombre)
                this.listafolders[folder].push(item)
            }


        },
        actualizatodo() {


            var posicion = 0
            if (Object.keys(this.listafolders).length === 0) {
                this.$set(this.listafolders, 'sf', [])
                this.folders.push('sf')
            } else {
                var copialistafolder = this.listafolders
                this.listafolders = {}
                //// agrega primero carpteas 
                var folders = copialistafolder;
                for (var fo in folders) {
                    this.folders.push(fo)
                    this.$set(this.listafolders, fo, [])
                }
            }


            this.proyectos.map((p) => {
                this.loaderlista = true
                let additem = 1
                for (var copfol in copialistafolder) {
                    if (copialistafolder[copfol].find(f => f ? f.id === p.id ? true : false : false)) {
                        additem = 0
                        this.updatefolderlist(p, copfol, 'add', posicion)
                    }
                }
                if (additem === 1) {
                    this.updatefolderlist(p, 'sf', 'add', posicion)
                }
                posicion = posicion + 1
            })
            let payload = {
                folders: this.folders,
                listafolders: this.listafolders,
                user_id: this.sesion.id,
                statusfolders: this.statusfolders
            }
            /// actualiza configuración de usuarios
            this.actualizaDatosDeSesion(payload)
            this.loaderlista = false
        }
    },
    watch: {
        proyectos() {
            /// funcion actualiza todo lo existente
          //  this.actualizatodo()
        },
        actualizaData(){
            console.log(this.actualizaData)
            this.actualizatodo()
            setTimeout(()=>{
                this.$emit('actualizaTodoFalse',false);
            },1000)
            
        }

    },
    props:['actualizaData']

}
</script>
<style>
/*.carpetastyle {

}*/
</style>