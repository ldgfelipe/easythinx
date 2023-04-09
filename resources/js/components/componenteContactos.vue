<template>
    <v-card>
        <v-card-title>
            Contactos <v-spacer></v-spacer>
            <v-btn
                @click="cargaListadeContacto()"
                class="greenD"
                title="Cargar Lista de contactoas actual"
            >
                <v-icon class="white--text">mdi-reload</v-icon>
                <v-icon class="white--text">mdi-account</v-icon>
            </v-btn>
        </v-card-title>
        <v-card-text>
            <v-row>
                <!-----<v-col cols="6">
                    <v-text-field
                        v-model="search1"
                        outlined
                        label="Buscar usuario"
                    ></v-text-field>

                    <v-card>
                        <v-card-text>
                            <v-data-table
                                :search="search1"
                                :headers="titulocontacto"
                                :items="contactos1"
                            >
                                <template v-slot:item.action="{ item }">
                                    <v-btn
                                        class="greenD white--text"
                                        @click="EditaContacto(item)"
                                    >
                                        <v-icon class="white--text"
                                            >mdi-pencil</v-icon
                                        >
                                    </v-btn>
                                </template>

                                <template v-slot:item.register="{ item }">
                                    <v-chip
                                        :class="
                                            item.register === 1
                                                ? 'greenD white--text'
                                                : 'red white--text'
                                        "
                                    >
                                        {{
                                            item.register === 1
                                                ? "Registrado"
                                                : "No registrado"
                                        }}</v-chip
                                    >
                                </template>
                            </v-data-table>


                        </v-card-text>
                    </v-card>
                </v-col>---->
                <v-col cols="12">
                    <v-row>
                        <v-col cols="10">
                            <v-text-field
                                v-model="search2"
                                outlined
                                @keypress.enter="buscarContacto()"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-btn class="greenD" @click="buscarContacto()"
                                ><v-icon class="white--text"
                                    >mdi-magnify</v-icon
                                ></v-btn
                            >
                        </v-col>
                        <v-col cols="12" v-if="enviaIncitacion === true">
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field
                                        outlined
                                        v-model="nameSend"
                                        label="Agrega nombre destinatario"
                                    ></v-text-field
                                ></v-col>
                                <v-col cols="6">


                                    <v-progress-circular
                                v-if="stsave"
                                :width="4"
                                color="green"
                                indeterminate
                                ></v-progress-circular>



                                    <v-btn
                                    v-if="!stsave"
                                        class="greenD white--text"
                                        @click="InvitaryAgregar()"
                                        >Enviar a: <b>{{ search2 }}</b></v-btn
                                    >
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>

                    <v-card>
                        <v-card-text>
                            <v-data-table
                                :headers="titulocontacto"
                                :items="contactos"
                            >
                                <template v-slot:item.action="{ item }">


                                   <!------ <v-btn v-if="actioncontact===false"
                                        class="greenD white--text"
                                        @click="AgregarContacto(item)"
                                    >
                                        <v-icon class="white--text"
                                            >mdi-plus</v-icon
                                        >
                                    </v-btn>
                                     v-if="actioncontact===true"
                                    ---->

                                    <v-btn
                                        class="greenD white--text"
                                        @click="EditaContacto(item)"
                                    >
                                        <v-icon class="white--text"
                                            >mdi-pencil</v-icon
                                        >
                                    </v-btn>



                                </template>
                                <template v-slot:item.status="{ item }">
                                    <v-chip   v-if="actioncontact===true &&  item.status === 1"
                                        class="greenD white--text"
                                    >
                                       <v-icon class="white--text">mdi-check</v-icon></v-chip
                                    >
                                            <v-btn @click="resendSystem(item)" v-if="item.status===0" class="red white--text">
                                            <v-icon>mdi-send</v-icon>
                                            </v-btn>
                                </template>
                            </v-data-table>
                            <v-dialog v-model="resendview" persistent max-width="600">
                                <v-card>
                                    <v-card-title class="greenD white--text">
                                        Reenvia Invitación <v-spacer></v-spacer> <v-btn class="white greenD--text" @click="resendview=false"><v-icon>mdi-close</v-icon></v-btn>
                                    </v-card-title>
                                    <v-card-text><br /><br />

                                        <v-text-field outlined v-model="resendItem.email" ></v-text-field>

                                        <v-btn class="greenD white--text" @click="ReenviarCorreo()">Reenviar Correo de Invitación</v-btn>


                                        <v-progress-circular v-if="loadResend" color="greenD" indeterminate size="30"></v-progress-circular>

                                    </v-card-text>
                                </v-card>
                            </v-dialog>
                            <v-dialog v-model="editcontact" max-width="800">
                                <v-card>
                                    <v-card-title class="greenD white--text">
                                        Edita Contacto <v-spacer></v-spacer> <v-btn @click="editcontact=false" class="white greenD--text"><v-icon>mdi-close</v-icon></v-btn>
                                    </v-card-title>
                                    <v-card-text>
                                        <br /><br />

                                        <v-text-field
                                            outlined
                                            v-model="contacselect.name"
                                        ></v-text-field>
                                        <v-text-field
                                            outlined
                                            readonly
                                            v-model="contacselect.email"
                                        ></v-text-field>
                                        <v-textarea
                                            outlined
                                            v-model="contacselect.info"
                                        ></v-textarea>
                                        {{
                                            contacselect.register === 1
                                                ? "Usuario registrado"
                                                : "Usuario no registrado"
                                        }}
                                          <v-progress-circular
                                v-if="stsave"
                                :width="4"
                                color="green"
                                indeterminate
                                ></v-progress-circular>
                                        <v-btn
                                        v-if="!stsave"
                                            class="greenD white--text"
                                            @click="GuardaCambiosContacto()"
                                            ><v-icon
                                                >mdi-content-save</v-icon
                                            ></v-btn
                                        >
                                        <v-btn
                                            class="red"
                                            @click="eliminarContacto()"
                                        >
                                            <v-icon class="white--text"
                                                >mdi-delete</v-icon
                                            ></v-btn
                                        >
                                    </v-card-text>
                                </v-card>
                            </v-dialog>



                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>
<script>
import { mapActions } from "vuex";
export default {
    data() {
        return {
            contactos: [],
            contactos2: [],
            contacselect: {},
            editcontact: false,
            stsave:false,
            titulocontacto: [
                {
                    text: "Nombre",
                    value: "name",
                },
                {
                    text: "Correo",
                    value: "email",
                },
                {
                    text: "Status",
                    value: "status",
                },
                {
                    text: "Acción",
                    value: "action",
                },
            ],
            search1: "",
            search2: "",
            enviaIncitacion: false,
            nameSend: "",
            actioncontact:true,
            resendview:false,
            resendItem:{},
            cloneresend:{},
            loadResend:false

        };
    },
    destroyed(){
        this.cargaListadeContacto();
    },
    mounted() {
        this.cargaListadeContacto();
    },
    methods: {
          ...mapActions(['cargaUsuarios','cambiaStatuSnackBar']),
          ReenviarCorreo(){
            var applichange=false
            this.loadResend=true
                if(this.resendItem.email!=this.cloneresend.email){
                    if(confirm('¿Seguro que desea cambiar el correo?')){
                        applichange=true
                    }
                }else{
                    applichange=false
                }


                var payload = {};
                payload.email = this.resendItem.email;
                payload.name = this.resendItem.name;
                payload.id_user = this.sesion.id;
                payload.register = 0;
                payload.sendmail = true;
                payload.url = this.url;

            fetch(this.url +'enviarcorreoinvitacion',{
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(payload),
                })
                .then(res=>res.json())
                .then((res)=>{
                    this.loadResend=false
                    console.log(res)
                    if(applichange===true){
                    this.contacselect=this.resendItem
                    this.GuardaCambiosContacto()
                    }
                    this.resendview=false
                })
          },
          resendSystem(item){
            this.resendview=true
            this.resendItem={...item}
            this.cloneresend={...item}

          },
        EditaContacto(p) {
            this.editcontact = true;
            this.contacselect = p;
        },
        eliminarContacto(p) {
            if (confirm("¿Seguro que desea eliminar el contacto?")) {
                fetch(this.url + "eliminacontacto", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(this.contacselect),
                })
                    .then((res) => res.json())
                    .then((res) => {
                        console.log(res);
                        this.editcontact = false;
                        this.cargaListadeContacto();
                        this.cargaUsuarios(this.sesion)
                    });
            }
        },
        InvitaryAgregar() {
            this.stsave=true
            if (this.nameSend) {
                var payload = {};
                payload.email = this.search2;
                payload.name = this.nameSend;
                payload.id_user = this.sesion.id;
                payload.register = 0;
                payload.sendmail = true;
                payload.url = this.url;

                fetch(this.url + "agregarcontacto", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(payload),
                })
                    .then((res) => res.json())
                    .then((res) => {

                        this.stsave=false
                        this.cargaListadeContacto();
                        this.contactos = [];
                        this.search2 = "";
                        this.nameSend = "";
                        this.cargaUsuarios(this.sesion)
                    })
                    .error((e)=>{
                        this.stsave=false
                    })
            }
        },

        GuardaCambiosContacto() {
            this.stsave=true
            fetch(this.url + "guardarcambios", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(this.contacselect),
            })
                .then((res) => res.json())
                .then((res) => {
                    this.stsave=false
                    console.log(res);
                    this.editcontact = false;
                    this.resendview= false;
                    this.cargaListadeContacto();
                    this.cargaUsuarios(this.sesion)
                })
                .error((e)=>{
                    this.stsave=false
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
                    console.log(res);
                    this.contactos = res;
                    this.actioncontact=true
                    this.enviaIncitacion=false
                });
        },
        AgregarContacto(p) {
            var payload = {};
            payload = { ...p };
            payload.id_user = this.sesion.id;
            payload.register = 1;
            payload.sendmail = false;

            fetch(this.url + "agregarcontacto", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((res) => {


                this.cambiaStatuSnackBar({
                status:true,
                text:res.res,
                color:res.code===1 ?  'green' : 'red'
                 })

                    this.cargaListadeContacto();
                    this.contactos = [];
                    this.search2 = "";
                    this.cargaUsuarios(this.sesion)
                });
        },

        buscarContacto() {
            var payload = {
                search: this.search2,
            };
            fetch(this.url + "buscausuarios", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((res) => {
                    console.log(res)
                    let regex = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");

                    if (res.length === 0 && regex.test(this.search2)) {
                        this.enviaIncitacion = true;
                        console.log("enviar invitacion");
                    } else {
                        this.enviaIncitacion = false;
                        console.log("sin datos para agregar");
                    }
                    console.log(res);
                    this.contactos = res;
                    this.actioncontact=false
                });
        },
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
