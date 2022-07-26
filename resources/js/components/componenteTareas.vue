<template>
<div>
<v-card>
    <v-card-title class="greenD white--text">
        Tareas <v-spacer></v-spacer>
        <v-btn class="white greenD--text" @click="abreAddTarea()"><v-icon>mdi-plus</v-icon></v-btn>
        <v-btn class="white greenD--text" @click="cargaTareas()"><v-icon>mdi-reload</v-icon></v-btn>

    </v-card-title>
    <v-card-text>

       <v-data-table :headers="titulotareas" :items="tareas">
        <template v-slot:item.titulo="{ item }">


    <v-tooltip left color="success">
      <template v-slot:activator="{ on, attrs }">
        <span
          v-bind="attrs"
          v-on="on"
          style="cursor:pointer;"
        >
         {{item.titulo}}
    </span>
      </template>
      <span>
        Descripción:<br />
        {{item.desc}}
        <hr />
        Asignado:<br />
        {{item.asignado}}

      </span>
    </v-tooltip>



        </template>

        <template v-slot:item.editar="{ item }" >
            <v-btn class="greenD white--text" @click="EditarTarea(item)" >
                <v-icon>mdi-pencil</v-icon>
            </v-btn>
       </template>

       <template v-slot:item.status="{ item }" >
            <v-chip v-if="item.status===1" class="greenD white--text">Pendiente</v-chip>
             <v-chip v-if="item.status===0" class="Grey white--text">Finalizado</v-chip>
       </template>

       </v-data-table>

    </v-card-text>
</v-card>


    <v-dialog v-model="addtarea" max-width="700" persistent>
        <v-card>
            <v-card-title class="greenD white--text" >
                Nueva tarea  <v-spacer></v-spacer> <v-btn class="white" @click="addtarea=false" ><v-icon class="greenD--text">mdi-close</v-icon></v-btn>
            </v-card-title>
            <v-card-text>
                <br />
                <v-text-field label="Nombre de la Tarea" outlined v-model="addservice.titulo" ></v-text-field>
                <v-textarea label="Sinopsis" outlined v-model="addservice.desc" ></v-textarea>
                <v-row v-if="addservice.action==='editar'">
                    <v-col cols="12" md="10">
                        <v-text-field v-model="AddObs" outlined label="Agregar observaciones a tarea"></v-text-field>
                    </v-col>
                      <v-col cols="12" md="2" >
                        <v-btn class="greenD" @click="addtextobs()"><v-icon class="white--text">mdi-database-plus</v-icon></v-btn>
                      </v-col>
                      <v-col cols="12" md="12">
                            <v-spacer></v-spacer> <v-btn class="greenD" @click="notasfull=true" ><v-icon class="white--text">mdi-fullscreen</v-icon></v-btn>
                            <v-dialog v-model="notasfull" fullscreen persistent>
                            <v-card>
                                <v-card-title class="greenD white--text">
                                    Notas <v-spacer></v-spacer> <v-btn class="white " @click="notasfull=false" ><v-icon class="greenD--text" >mdi-close</v-icon></v-btn>
                                </v-card-title>
                                    <v-card-text>
                                        <v-text-field v-model="search" label="Ingrese a palabra o frase que desea buscar"></v-text-field>
                                        <v-data-table :headers="notastitulo" :items="addservice.obs" :search="search"></v-data-table>
                                    </v-card-text>
                            </v-card>
                            </v-dialog>

                            <div style="width:100%; border:solid grey 1px; height:80px; overflow:auto;" >
                            <div  v-for="(key,index) in addservice.obs" :key="index+'obs'">
                            <v-list-item>
                                    <v-list-item-content >
                                    <v-list-item-title>{{key.fecha}} {{key.hora}} {{key.corre}}: {{key.contenido}}</v-list-item-title>
                                    </v-list-item-content>

                            </v-list-item>
                            <v-divider></v-divider>
                            </div>

                            </div>
                        </v-col>

                </v-row>


                <hr />

                        <v-select
                            v-model="addservice.asignado"
                                chips
                                label="Tarea asignada a:"
                                multiple
                                outlined
                                :items="cargaUsuarios"
                            ></v-select>

                <v-switch :label="addservice.status ? 'Pendiente' : 'Finalizado' " v-model="addservice.status"></v-switch>


                <v-btn class="greenD white--text" @click="GuardarTarea()"><v-icon>mdi-content-save</v-icon></v-btn>
            </v-card-text>
        </v-card>

    </v-dialog>

</div>
</template>
<script>
export default{
data(){
    return {
        addtarea:false,
        addservice:{},
        tareas:[],
        update:true,
        AddObs:"",
        notasfull:false,
        search:"",
        usuarios:[],
        notastitulo:[{
            text:"Fecha",
            value:"fecha"
        },
        {
            text:"Hora",
            value:"hora",

        },
        {
            text:"Correo",
            value:"correo"
        },
        {
            text:"Contenido",
            value:"contenido"
        }],
        titulotareas:[
            {
                text:'Titulo',
                value:'titulo'
            },
            {
                text:'Status',
                value:'status'
            },
            {
                text:'Editar',
                value:'editar'
            }
        ]
    }
},
computed:{
    cargaUsuarios(){
         var colaboradores=[]
         var creadores=[]
        if(this.idproy.id_collaborate){
        colaboradores=JSON.parse(this.idproy.id_collaborate)
        }
         if(this.idproy.id_create){
        creadores=JSON.parse(this.idproy.id_create)
         }

var usuarios=[...colaboradores,...creadores]
    return usuarios
    },
},
mounted(){
    this.cargaTareas()
},
methods:{

    addtextobs(){
        this.update=false

        var hoy = new Date();
        var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
        this.addservice.obs.push({fecha:fecha,hora:hora,correo:this.sesion.email,contenido:this.AddObs})
            this.GuardarTarea()
            this.update=true
    },
    abreAddTarea(){
        this.addservice={}
        this.addservice.action='crear'
        this.addtarea=true
        this.addservice.id_proyecto=this.idproy.id
    },
    EditarTarea(item){
        this.addtarea=true

        this.addservice.action='editar'
        this.addservice.id=item.id
        this.addservice.id_proyecto=item.id_proyecto
        this.addservice.titulo=item.titulo
        this.addservice.id_proyecto=item.id_proyecto
        this.addservice.obs=JSON.parse(item.obs)
        this.addservice.desc=item.desc
        this.addservice.status=item.status
        this.addservice.asignado=JSON.parse(item.asignado)
    },
    GuardarTarea(){

            fetch(this.url+"registrotareas",{
                method:'POST',
                headers:{
                    'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
                },
                body:JSON.stringify(this.addservice)
            })
            .then(res=>res.json())
            .then((res)=>{
                  if(this.update===true){
                this.addtarea=false
                  }
                this.cargaTareas()

            })
    },
    cargaTareas(){
            var payload={
                id_proyecto:this.idproy.id
            }
            fetch(this.url+"cargatareas",{
                method:'POST',
                headers:{
                    'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
                },
                body:JSON.stringify(payload)
            })
            .then(res=>res.json())
            .then((res)=>{
                this.tareas=res
            })
    }

},
props:{
    idproy:{},
    csrf:"",
    url:"",
    sesion:{}
}

}
</script>
