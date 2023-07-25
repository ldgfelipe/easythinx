<template>
    <div class="areadash">
        <v-row>
            <v-col cols="1" md="1">
                <v-navigation-drawer
                            v-model="menuup"
                            absolute
                            temporary
                            >
                    <v-list>
                        <v-list-item link>
                            <v-list-item-content>
                                <v-list-item-title class="text-h6">
                                    {{sesion.name}}
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    > {{sesion.email}}</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-list nav >
                        <v-list-item>
                            <v-list-item-title>
                                <componenteproyectos></componenteproyectos>
                                </v-list-item-title>
                                </v-list-item>



                        <v-list-item>
                            <v-list-item-title>
                                <componenteiconos
                                    :csrf="csrf"
                                    :url="url"
                                    :websocket="websocket"
                                    :sesion="sesion"
                                    :idproy="proyectoSelect"
                                ></componenteiconos>
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-navigation-drawer>
            </v-col>

            <v-col cols="12" >
                <v-btn class="greenD white--text" @click="menuup=true"><v-icon>mdi-menu</v-icon></v-btn>
            </v-col>
            <v-col cols="12" v-if="!loader">
                <v-row>
                    <v-col
                        cols="12"
                        :md="anchocol"
                        class="tabledata"
                        v-if="
                            Object.keys(proyectoSelect).length > 0 &&
                            ventanas.tareas === true
                        "
                    >
                        <componentetareas
                            @minimizar="minimizado('tareas', $event)"
                        ></componentetareas>
                    </v-col>

                    <v-col
                        cols="12"
                        :md="anchocol"
                        class="tabledata"
                        v-if="
                            Object.keys(proyectoSelect).length > 0 &&
                            ventanas.archivos === true
                        "
                    >
                        <componentearchivos
                            @minimizar="minimizado('archivos', $event)"
                        ></componentearchivos>
                    </v-col>

                    <v-col
                        cols="12"
                        :md="anchocol"
                        class="tabledata"
                        v-if="
                            Object.keys(proyectoSelect).length > 0 &&
                            ventanas.chats === true
                        "
                    >
                        <componentechat
                            @minimizar="minimizado('chats', $event)"
                        ></componentechat>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="12" v-if="loader">
                <v-progress-linear
                    indeterminate
                    color="greenD darken-2"
                ></v-progress-linear>
            </v-col>
        </v-row>
        <div
            v-if="
                ventanas.archivos === false ||
                ventanas.tareas === false ||
                ventanas.chats === false
            "
            class="barraminimizados"
        >
            <v-btn
                class="greenD white--text"
                v-if="ventanas.tareas === false"
                @click="minimizado('tareas', true)"
                >Tareas
            </v-btn>
            <v-btn
                class="greenD white--text"
                v-if="ventanas.archivos === false"
                @click="minimizado('archivos', true)"
            >
                Archivos</v-btn
            >
            <v-btn
                class="greenD white--text"
                v-if="ventanas.chats === false"
                @click="minimizado('chats', true)"
                >Chats
            </v-btn>
        </div>
        <snackbar />
    </div>
</template>
<style>
.areadash {
    padding: 15px;
}
.tabledata {
    height: 90%;
}
</style>
<script>
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        return {
            menuup:false,
            socket: {},
            ventanas: {
                tareas: true,
                archivos: true,
                chats: true,
            },
            anchocol: 4,
        };
    },
    computed: {
        ...mapState(["usuarios", "socketid", "proyectoSelect", "loader"]),
    },
    created() {
        this.cargaCSRF(this.csrf);
        this.cargaURL(this.url);
        this.cargaSesion(this.sesion);
    },
    mounted() {
        this.cargaUsuarios(this.sesion);
        setTimeout(() => {
            this.socket = io(this.websocket);
            this.cargaSocket(this.socket);
        }, 2000);
    },
    methods: {
        ...mapMutations([
            "cargaCSRF",
            "cargaURL",
            "cargaListaUsuarios",
            "cargaSocket",
            "cargaSesion",
        ]),
        ...mapActions(["cargaUsuarios", "LoadProyecto"]),

        minimizado(type, state) {
            new Promise((resolv, reject) => {
                this.ventanas[type] = state;
                state;
                resolv(state);
            }).then((res) => {
                let contfalse = 0;
                for (var p in this.ventanas) {
                    if (this.ventanas[p] === false) {
                        contfalse++;
                    }
                }
                if (contfalse === 1) {
                    this.anchocol = 6;
                }
                if (contfalse === 2) {
                    this.anchocol = 12;
                }
                if (contfalse === 0) {
                    this.anchocol = 4;
                }
            });
        },
        cargaProy(ev) {
            /// mapAction LoadProyecto
            this.LoadProyecto(ev);
        },
    },
    props: {
        csrf: {
            default: "",
        },
        url: {
            default: "",
        },
        sesion: {},
        websocket: "",
    },
};
</script>
