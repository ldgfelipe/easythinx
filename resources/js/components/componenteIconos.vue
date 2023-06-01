<template>
    <v-card>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="12" style="font-size:10px; padding:0px; margin:0px; padding-left:20px;">
                  <v-icon>mdi-email</v-icon> {{ sesion.email }}
                </v-col>
                <v-col cols="4" md="2">
                    <v-btn class="greenD" elevation="2" icon raised @click="perfilview = true">
                        <v-icon class="white--text">mdi-account</v-icon>
                        <v-dialog v-model="perfilview" max-width="800" persistent>
                            <v-card>
                                <v-card-title>
                                    {{ this.sesion.email }}
                                    <b> Perfil de usuario</b>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="perfilview = false" class="greenD white--text">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-card-text>
                                    <componenteperfil :csrf="csrf" :url="url" :websocket="websocket" :sesion="sesion"
                                        :idproy="idproy"></componenteperfil>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-btn>
                </v-col>
                <v-col cols="4" md="2">
                    <v-btn class="greenD" elevation="2" icon raised @click="viewnotify=true">
                        <v-icon class="white--text">mdi-bell</v-icon>
                        <v-badge v-if="listanot.length>0" :content="listanot.length"></v-badge>
                    </v-btn>

                    <v-dialog v-model="viewnotify" persistent max-width="800px">
                        <v-card>
                            <v-card-title class="greenD white--text">
                               {{ newnot ? 'Listado de Notificaciones' : 'Envia una notificación' }}  <v-spacer></v-spacer> <!------<v-btn v-if="!newnot && contactos.length>0" title="crea nueva notificación" @click="newnot=true" > <v-icon>mdi-plus</v-icon></v-btn>---->

                               <v-btn v-if="newnot" title="Regresar a listado de notificaciones" @click="newnot=false" ><v-icon>mdi-arrow-left</v-icon></v-btn>

                               <v-btn class="white greenD--text" @click="viewnotify=false" >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>

                            </v-card-title>
                            <v-card-text v-if="!newnot">
                                <v-data-table :headers="titulonotify" :items="listanot">
                                    <template v-slot:item.action="{ item }">
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn class="greenD white--text" v-bind="attrs" v-on="on"
                                                    @click="marcaleido(item)">
                                                    <v-icon>mdi-eye</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Marcar como leido</span>
                                        </v-tooltip>
                                    </template>

                                </v-data-table>

                            </v-card-text>
                            <v-card-text v-if="newnot">
                            <v-select :items="contactos" v-model="notifi.email" item-text="name" item-value="email">

                            </v-select>

                            <v-textarea outlined v-model="notifi.mensaje"></v-textarea>

                            <v-btn class="greenD white--text" @click="EnviarNotificacion()">Enviar Notificacion</v-btn>
                            </v-card-text>
                        </v-card>

                    </v-dialog>
                </v-col>
                <v-col cols="4" md="2" v-if="sesion.tipo_usuario===2">
                    <v-btn class="greenD" elevation="2" icon raised @click="configview = true">
                        <v-icon class="white--text">mdi-cog-outline</v-icon>
                    </v-btn>

                    <v-dialog v-model="configview" fullscreen persistent>
                        <v-card>
                            <v-card-title>
                                Configuración <v-spacer></v-spacer>
                                <v-btn @click="configview = false">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <componenteconfiguracion :csrf="csrf" :url="url" :websocket="websocket" :sesion="sesion"
                                    :idproy="idproy"></componenteconfiguracion>
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </v-col>
                <v-col cols="4" md="2" v-if="sesion.tipo_usuario===2">
                    <v-btn title="Gestor CMS" class="greenD" elevation="2" icon raised @click="redirectotocms()">
                        <v-icon class="white--text">mdi-page-layout-header-footer</v-icon>
                    </v-btn>

                    <v-dialog v-model="cmsview" fullscreen persistent>
                        <v-card>
                            <v-card-title class="greenD white--text">
                                Gestor CMS <v-spacer></v-spacer>
                                <v-btn @click="redirectotocms()">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <componentecms :csrf="csrf" :url="url" :websocket="websocket" :sesion="sesion"
                                    :idproy="idproy"></componentecms>
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </v-col>
                <v-col v-if="sesion.tipo_usuario>=1">
                    <v-btn class="greenD" elevation="2" icon raised @click="contacts = true">
                        <v-icon class="white--text">mdi-book-open-variant</v-icon>
                    </v-btn>
                    <v-dialog screen persistant max-width="800" v-model="contacts">
                        <v-card>
                            <v-card-title class="greenD white--text">
                                Lista de contactos <v-spacer></v-spacer>
                                <v-btn class="white greenD--text" @click="contacts = false">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <componentecontactos :csrf="csrf" :url="url" :websocket="websocket" :sesion="sesion"
                                    :idproy="idproy"></componentecontactos>
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </v-col>
                <v-col cols="12" md="12" style="display:none;">
                    <p style="font-size: 10px;">{{ sesion.email }}
                        ||
                        {{
                        sesion.tipo_usuario === 0 ? 'Normal' :
                        sesion.tipo_usuario === 1 ? 'Administrado' :
                        sesion.tipo_usuario === 2 ? 'Super Administrador' :
                        'Sin Tipo Usuario'
                        }}
                    </p>
                </v-col>
            </v-row>
        </v-card-title>
    </v-card>
</template>
<script>
import { mapActions, mapState } from "vuex";
export default {
    data() {
        return {
            perfilview: false,
            configview: false,
            contacts: false,
            contactos:[],
            cmsview: false,
            socket: {},
            newnot:false,
            viewnotify: false,
            notifi:{},
            titulonotify: [
                {
                    text: "Acciones",
                    value: "action"
                },
                {
                    text: "Mensaje",
                    value: 'mensaje_des'
                },
                {
                    text: "De",
                    value: "nombre_rem"
                },
                {
                    text: "Fecha",
                    value: "created_at"
                }
            ]
        };
    },
    computed: {
        ...mapState(['listanot'])
    },
    mounted() {
        this.cargaNotifi({ email: this.sesion.email })
        this.cargaListadeContacto();
    },
    methods: {
        ...mapActions(['cargaUsuarios', 'cargaNotifi']),
        redirectotocms(){
            window.location.href=this.url+"webbuilder"
        },
        EnviarNotificacion(){
            this.notifi.name_rem = this.sesion.name;
            this.notifi.id_rem = this.sesion.id;
            this.notifi.socket_rem = ""


            fetch(this.url + 'guardanotificacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf
                },
                body: JSON.stringify(this.notifi)
            })
                .then(res => res.json())
                .then((res) => {
                    this.newnot = false
                    this.viewnotify=false

                    this.notifi={}
                })

        },
        cargaListadeContacto() {
            fetch(this.url + "cargalistacontacto", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(this.sesion),
            })
                .then((res) => res.json())
                .then((res) => {

                    this.contactos = res;

                });
        },
        marcaleido(p) {

            fetch(this.url + 'marcaleido', {
                method: "POST",
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf
                },
                body: JSON.stringify(p)
            })
                .then(res => res.json)
                .then((res) => {
                    this.cargaNotifi({email: this.sesion.email})
                })
        }

    },
    props: {
        csrf: "",
        url: "",
        websocket: "",
        sesion: {},
        idproy: "",
    },
};
</script>
