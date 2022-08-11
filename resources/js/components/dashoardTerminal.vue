<template>
    <div class="areadash">
        <v-row>
            <v-col cols="12" md="8">

                <componenteproyectos @cargaproyecto="cargaProy($event)" :websocket="websocket" :csrf="csrf" :url="url" :sesion="sesion" :usuarios="usuarios"></componenteproyectos>
            </v-col>
                <v-col cols="12" md="4">

                    <componenteiconos :csrf="csrf" :url="url"  :websocket="websocket" :sesion="sesion" :idproy="proyectoSelect"></componenteiconos>

                </v-col>
            <v-col cols="12" md="4" class="tabledata" v-if="Object.keys(proyectoSelect).length>0">
             <componentetareas :csrf="csrf" :url="url"  :websocket="websocket" :sesion="sesion" :idproy="proyectoSelect" ></componentetareas>
            </v-col>
             <v-col cols="12" md="4" class="tabledata" v-if="Object.keys(proyectoSelect).length>0">
                <componentearchivos :csrf="csrf" :url="url"  :websocket="websocket" :sesion="sesion" :idproy="proyectoSelect" ></componentearchivos>
            </v-col>
             <v-col cols="12" md="4" class="tabledata" v-if="Object.keys(proyectoSelect).length>0">
                <componentechat :csrf="csrf" :url="url"  :websocket="websocket" :sesion="sesion" :idproy="proyectoSelect" ></componentechat>
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
import { mapState,mapActions,mapMutations } from 'vuex';
    export default {
        data(){
            return {
                proyectoSelect:{},
                loader:false
            }
        },
       computed: {
            ...mapState(['usuarios'])
       },
        created(){
          this.cargaCSRF(this.csrf)
             this.cargaURL(this.url)

        },
        mounted(){
                this.cargaUsuarios(this.sesion);
        },
        methods:{
            ...mapMutations(['cargaCSRF','cargaURL']),
            ...mapActions(['cargaUsuarios']),
            cargaProy(ev){
                this.loader=true
                this.proyectoSelect={}
                setTimeout(()=>{
                    this.proyectoSelect=ev
                      this.loader=false
                },1500)


            },

        },
        props:{
            csrf:{
                default:""
            },
            url:{
                default:""
            },
            sesion:{},
            websocket:""
        }


    }
</script>
