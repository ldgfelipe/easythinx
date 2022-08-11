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
                <v-col cols="6">
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

                            <v-dialog v-model="editcontact" max-width="800">
                                <v-card>
                                    <v-card-title class="greenD white--text">
                                        Edita Contacto
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

                                        <v-btn
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
                <v-col cols="6">
                    <v-row>
                        <v-col cols="10">
                            <v-text-field
                                v-model="search2"
                                outlined
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
                                        label="Nombre "
                                    ></v-text-field
                                ></v-col>
                                <v-col cols="6">
                                    <v-btn
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
                                :items="contactos2"
                            >
                                <template v-slot:item.action="{ item }">
                                    <v-btn
                                        class="greenD white--text"
                                        @click="AgregarContacto(item)"
                                    >
                                        <v-icon class="white--text"
                                            >mdi-plus</v-icon
                                        >
                                    </v-btn>
                                </template>
                            </v-data-table>
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
            contactos1: [],
            contactos2: [],
            contacselect: {},
            editcontact: false,

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
                    text: "Registrado",
                    value: "register",
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
        };
    },
    mounted() {
        this.cargaListadeContacto();
    },
    methods: {
          ...mapActions(['cargaUsuarios']),
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
                        this.cargaListadeContacto();
                        this.contactos2 = [];
                        this.search2 = "";
                        this.nameSend = "";
                        this.cargaUsuarios(this.sesion)
                    });
            }
        },
        GuardaCambiosContacto() {
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
                    console.log(res);
                    this.editcontact = false;
                    this.cargaListadeContacto();
                    this.cargaUsuarios(this.sesion)
                });
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
                    this.contactos1 = res;
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
                    console.log(res);
                    this.cargaListadeContacto();
                    this.contactos2 = [];
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
                    let regex = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");

                    if (res.length === 0 && regex.test(this.search2)) {
                        this.enviaIncitacion = true;
                        console.log("enviar invitacion");
                    } else {
                        this.enviaIncitacion = false;
                        console.log("sin datos para agregar");
                    }
                    console.log(res);
                    this.contactos2 = res;
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
