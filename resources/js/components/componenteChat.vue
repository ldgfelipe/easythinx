<template>
    <div>
        <v-app-bar color="greenD">
            <v-toolbar-title class="white--text">Chat
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn fab dark small color="white" v-bind="attrs" v-on="on">
                        <v-icon class="greenD--text">{{listausercon.length===1 ? 'mdi-account': 'mdi-account-group'}}
                        </v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item class="greenD white--text">
                        Usuarios Conectados
                    </v-list-item>
                    <v-list-item v-for="(item, index) in listausercon" :key="index"  v-if="sesion.email !== item.email">
                        <v-list-item-title>
                            <v-icon :class="item.online ? 'greenD--text':'grey--text'">mdi-account</v-icon>{{
                            item.name }}
                            <v-btn @click="abrechatpar(item)" v-if="item.online" class="greenD white--text"><v-icon>mdi-chat</v-icon></v-btn>
                            <v-btn class="greenD white--text" @click="enviarNotificacion(item)">
                                <v-icon>mdi-bell</v-icon>
                            </v-btn>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-dialog v-model="chatpart" persistent max-width="500" >
                <v-card>
                    <v-card-title class="greenD white--text">
                        Usuario:
                    </v-card-title>
                    <v-card-text>

                    </v-card-text>
                </v-card>
            </v-dialog>

            <v-dialog v-model="sendnot" max-width="auto" persistent>
                <v-card>
                    <v-card-title class="greenD white--text">
                        Enviar notificación a: {{datosnot.name}} <v-spacer></v-spacer>
                        <v-btn class="greeD--white"
                        @click="cierraNot()"
                        ><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <br />
                        <v-textarea outlined v-model="datosnot.mensaje">
                        </v-textarea>
                        <v-btn class="greenD white--text" @click="envianotifi()">Enviar Mensaje Privado</v-btn>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-btn class="mx-2" fab dark small color="white" @click="verhistorial()" title="Historial de conversación">
                <v-icon class="greenD">mdi-format-list-group</v-icon>
            </v-btn>
            <v-btn class="white greenD--text" title="Minimizar" @click="minimizar()">
                <v-icon>mdi-arrow-bottom-left-bold-box</v-icon>
            </v-btn>
            <v-dialog v-model="hisview" fullscreen>
                <v-card>
                    <v-card-title class="greenD white--text">Historial completo chat <v-spacer></v-spacer>
                        <v-btn @click="hisview=false" class="white">
                            <v-icon class="greenD--text">mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <br />
                        <v-text-field v-model="searchat" outlined label="Ingrese la palabra que desea buscar" />
                        <v-data-table :search="searchat" :headers="tithis" :items="todochat">
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-app-bar>
        <v-container class="fill-height "
            :style="`height:${heightWindow-300}px; overflow:auto; padding-bottom:10px;`"
            ref="conversations">
            <v-row class="fill-height pb-14" align="end">
                <v-col cols="12" v-for="(item, index) in chat" :key="index"
                    :align="item.id == sesion.id ? 'left' : 'right'">
                    <v-card :class="item.id == sesion.id ? 'mt-4 mb-4 secondary' : 'mt-4 mb-4 greenD white--text'"
                        max-width="80%">
                        <v-card-text class="white--text grey" align="left">
                            <v-chip :color="item.id == sesion.id ? 'greenD' : 'secondary' " style="font-size:9px;">
                                {{ item.id == sesion.id ? 'YO' : item.from }} <br /> <b>: {{item.fecha}}
                                    {{item.hora}}</b>
                            </v-chip>
                            <br />
                            {{ item.msg }}
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-footer>
            <v-container class="ma-0 pa-0">
                <v-row no-gutters>
                    <v-col>
                        <div class="d-flex flex-row align-center">
                            <v-textarea v-model="msg" rows="1" placeholder="Mensaje" @keypress.enter="send()">
                            </v-textarea>
                            <v-btn icon class="ml-4" @click="send()">
                                <v-icon>mdi-send</v-icon>
                            </v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-footer>
    </div>
</template>
<script>
const altoWindow= window.innerHeight;
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
    data: function () {
        return {
            chat: [],
            msg: null,
            heightWindow:altoWindow,
            datosnot: {},
            showMenu: false,
            hisview: false,
            listausercon: [],
            searchat:"",
            tithis: [
                {
                    text: 'ID',
                    value: 'id'
                },
                {
                    text: 'Fecha',
                    value: 'created_at'
                },
                {
                    text: 'Nombre',
                    value: 'name'
                },
                {
                    text: 'Mensaje',
                    value: 'mensaje'
                }
            ],
            todochat: [],
            timescroll: 500,
            chatpart:false
        }
    },
    mounted() {
        this.inichatgral();
        var payloadinises = {
            proyectoSelect: this.proyectoSelect,
            sesion: this.sesion
        }
        this.socket.emit('inichannel', payloadinises);
        this.socket.on('message', (data) => {


            this.listausercon = []


            this.listauser.gral.map((p)=>{
               var datauser=data.usuarios.find(data=>data.email===p)
                if(datauser){
                   datauser.online=true
                    this.listausercon.push(datauser)
                }else{
                    let nameis=p.split('@')[0];
                    this.listausercon.push({
                        name:nameis,
                        email:p,
                        online:false
                    })
                }
            })


        });
        this.socket.on('loadroom', (data) => {
            this.cargaridSocket(data)
        })
        this.socket.on('chat_respuesta', (data) => {
            this.cargachat(data)
            setTimeout(() => {
                const container = this.$refs.conversations;
                container.scrollTop = container.scrollHeight;
            }, this.timescroll)
        })
        this.socket.on('actualizanotificaciones', (data) => {
            ///// actualiza datos de notificaciones con una mutacion
            let payload = {
                url: this.url,
                email: data.email,
                id: data.id
            }
            this.cargaNotifi(payload)
        })
    },
    computed: {
        ...mapState(['usuarios', 'socketid', 'listauser', 'socket', 'proyectoSelect', 'url', 'csrf', 'sesion', 'sendnot'])
    },
    methods: {
        ...mapMutations(['cargaridSocket','cargaSendnot']),
        ...mapActions(['cargaNotifi']),
        abrechatpar(p) {

            this.chatpart=true

        },
        envianotifi() {
            this.cargaNotifi
        },
        cierraNot(){
            this.cargaSendnot(false)
        },
        enviarNotificacion(p) {
            this.datosnot = {}
            this.cargaSendnot(true)
            this.datosnot = p
        },
        minimizar() {
            this.$emit('minimizar', false);
        },
        verhistorial() {
            this.hisview = true
            fetch(this.url + 'cargatodochat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf
                },
                body: JSON.stringify(this.proyectoSelect)
            })
                .then(res => res.json())
                .then((res) => {
                    this.todochat = res


                })
        },
        inichatgral() {
            var payload = {
                proyecto: this.proyectoSelect
            }
            fetch(this.url + 'tomamensajes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then((res) => {
                    res.sort(function (a, b) {
                        if (a.id > b.id) {
                            return 1;
                        }
                        if (a.id < b.id) {
                            return -1;
                        }
                        // a must be equal to b
                        return 0;
                    })
                    res.map((p) => {
                        //console.log(p)
                        this.cargachat(p)
                    })
                    setTimeout(() => {
                        const container = this.$refs.conversations;
                        container.scrollTop = container.scrollHeight;
                    }, this.timescroll)
                })
        },
        cargachat(p) {
            this.chat.push({
                id: p.id_usuario ? p.id_usuario : p.id,
                from: p.name,
                msg: p.mensaje,
                fecha: p.fecha,
                hora: p.hora
            })
        },
        send() {
            if (this.msg.length > 0) {
                var hoy = new Date();
                var fecha = hoy.getDate() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getFullYear();
                var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
                var payload = {
                    proyecto: this.proyectoSelect,
                    session: this.sesion,
                    message: {
                        msj: this.msg,
                        fecha: fecha,
                        hora: hora,
                        to: "",
                        type: ""
                    }
                }
                /// primero guarda los mensajes despues emite a websocket
                fetch(this.url + 'guardamensaje', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify(payload)
                })
                    .then(res => res.json())
                    .then((res) => {
                        this.socket.emit('chat_mensaje', payload)
                        this.msg = ""
                        setTimeout(() => {
                            const container = this.$refs.conversations;
                            container.scrollTop = container.scrollHeight;
                        }, this.timescroll)
                    })
            }
        },
        selectuser(p) {
            // console.log(p)
        }
    },
    watch: {
        proyectoSelect() {
            console.log('sale de la sala y entra a otra')
        }
    }
}
</script>
