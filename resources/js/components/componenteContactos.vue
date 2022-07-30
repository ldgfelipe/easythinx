<template>
<v-card>
    <v-card-title>
        Contactos
    </v-card-title>
    <v-card-text>

        <v-row>
            <v-col cols="10">
                <v-text-field v-model="search" outlined  ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-btn class="greenD" @click="buscarContacto()" ><v-icon class="white--text">mdi-magnify</v-icon></v-btn>
            </v-col>
        </v-row>
        <v-data-table  :headers="titulocontacto" :items="contactos" >

        </v-data-table>
    </v-card-text>
</v-card>
</template>
<script>
export default{
    data(){
        return {
            contactos:[],
            titulocontacto:[
                {
                    text:'Nombre',
                    value:'name'
                },
                {
                    text:'Correo',
                    value:'email'
                },
                {
                    text:'Acción',
                    value:'action'
                }
                ],
                search:""
        }
    },
    methods:{
        buscarContacto(){
            var payload={
                search:this.search
            }
                fetch(this.url+'buscausuarios',{
                    method:'POST',
                    headers:{
                        'Content-type':'application/json',
                         'X-CSRF-TOKEN':this.csrf
                    },
                    body:JSON.stringify(payload)
                })
                .then(res=>res.json())
                .then((res)=>{
                    console.log(res)
                    this.contactos=res
                })

        }
    },
    props:{
        csrf:"",
        url:"",
        websocket:"",
        sesion:{},
        idproy:""
    }
}
</script>
