<template>
    <div class="areadash">
        <v-row>
            <v-col cols="12" md="8">

                <componenteproyectos @cargaproyecto="cargaProy($event)" :csrf="csrf" :url="url" :sesion="sesion" :usuarios="usuarios"></componenteproyectos>
            </v-col>
                <v-col cols="12" md="4">

                    <componenteiconos :sesion="sesion"></componenteiconos>

                </v-col>
            <v-col cols="12" md="4" class="tabledata" v-if="Object.keys(proyectoSelect).length>0">
             <componentetareas :csrf="csrf" :url="url"  :sesion="sesion" :idproy="proyectoSelect" ></componentetareas>
            </v-col>
             <v-col cols="12" md="4" class="tabledata" v-if="Object.keys(proyectoSelect).length>0">
                <componentearchivos :csrf="csrf" :url="url" :sesion="sesion" :idproy="proyectoSelect" ></componentearchivos>
            </v-col>
             <v-col cols="12" md="4" class="tabledata" v-if="Object.keys(proyectoSelect).length>0">
                <componentechat :csrf="csrf" :url="url" :sesion="sesion" :idproy="proyectoSelect" ></componentechat>
            </v-col>
                 <v-col  cols="12" md="12" v-if="loader" >
                        <v-progress-linear
      indeterminate
      color="greenD darken-2"
    ></v-progress-linear>
                 </v-col>


        </v-row>

    </div>
</template>
<style>


.areadash{
    padding:15px;
}

.tabledata{
    height: 90%;

}

</style>

<script>

    export default {
        data(){
            return {
                proyectoSelect:{},
                usuarios:[],
                loader:false
            }
        },
        mounted(){
                this.cargaUsuarios();
        },
        methods:{
            cargaProy(ev){
                this.loader=true
                this.proyectoSelect={}
                setTimeout(()=>{
                    this.proyectoSelect=ev
                      this.loader=false
                },1500)


            },
            cargaUsuarios(){

             var payload={
                acces:"data"
            }
            fetch(this.url+"cargausuarios",{
                method:'POST',
                headers:{
                    'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
                },
                body:JSON.stringify(payload)
            })
            .then(res=>res.json())
            .then((res)=>{
               this.usuarios=res
            })
        },

        },
        props:{
            csrf:{
                default:""
            },
            url:{
                default:""
            },
            sesion:{}
        }


    }
</script>
