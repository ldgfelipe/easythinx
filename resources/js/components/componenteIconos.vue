<template>
<v-card>
    <v-card-title>
        <v-row>
            <v-col cols="4" md="1">
            <v-btn class="greenD"
                elevation="2"
                icon
                raised
                @click="perfilview=true"
                >
                    <v-icon class="white--text" >mdi-account</v-icon>
                    <v-dialog v-model="perfilview" fullscreen persistent>
                        <v-card>
                            <v-card-title>
                                Perfil de usuario <v-spacer></v-spacer><v-btn @click="perfilview=false"><v-icon>mdi-close</v-icon></v-btn>
                            </v-card-title>
                            <v-card-text>
                                 <componenteperfil></componenteperfil>
                            </v-card-text>
                        </v-card>


                    </v-dialog>
            </v-btn>
            </v-col>
            <v-col cols="4" md="1">
            <v-btn class="greenD"
                elevation="2"
                icon
                raised
                >
                    <v-icon class="white--text">mdi-bell</v-icon>
            </v-btn>
            </v-col>
            <v-col cols="4" md="1">
                <v-btn class="greenD"
                elevation="2"
                icon
                raised
                @click="configview=true"
                >
                    <v-icon class="white--text">mdi-cog-outline</v-icon>
            </v-btn>


            <v-dialog v-model="configview" fullscreen persistent>
                        <v-card>
                            <v-card-title>
                                Configuración <v-spacer></v-spacer><v-btn @click="configview=false"><v-icon>mdi-close</v-icon></v-btn>
                            </v-card-title>
                            <v-card-text>
                                 <componenteperfil></componenteperfil>
                            </v-card-text>
                        </v-card>


                    </v-dialog>
            </v-col>
            <v-col cols="12" md="9" >

               <p style="font-size:10px;">{{sesion.email}}</p>
            </v-col>
        </v-row>
    </v-card-title>
</v-card>
</template>
<script>
export default{
    data(){
        return{
            perfilview:false,
            configview:false
        }
    },
    props:{
        sesion:{}
    }
}
</script>
