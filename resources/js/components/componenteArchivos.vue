<template>
    <div>
        <v-card min-height="550px">
            <v-card-title class="greenD white--text">
                Archivos <v-spacer></v-spacer>
                <v-btn class="white greenD--text" @click="dialog = true">
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
                <v-btn class="white greenD--text" @click="cargaArchivos()">
                    <v-icon>mdi-reload</v-icon>
                </v-btn>
                <v-btn
                    class="white greenD--text"
                    title="Minimizar"
                    @click="minimizar()"
                >
                    <v-icon>mdi-arrow-bottom-left-bold-box</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text v-if="visorFile">
                <br />
                <v-row>
                    <v-col cols="7" md="7">
                        <v-text-field
                            outlined
                            v-model="searchgral"
                            label="Buscar Archivo"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="3" md="3">
                        <v-select
                            v-model="extfile"
                            label="Extensión"
                            filled
                            :items="tipoArchivos"
                        ></v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-btn
                            class="greenD white--text"
                            @click="addfolder = true"
                            ><v-icon>mdi-folder</v-icon></v-btn
                        >
                        <v-dialog v-model="addfolder" max-width="400">
                            <v-card>
                                <v-card-title> Folder </v-card-title>
                                <v-card-text>
                                    <v-text-field
                                        v-model="folder"
                                    ></v-text-field
                                    ><v-btn
                                        class="greenD white--text"
                                        @click="crearfolder()"
                                        ><v-icon>mdi-folder-plus</v-icon></v-btn
                                    >
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-col>
                </v-row>

                <v-dialog max-width="600" v-model="listapermisos" persistent>
                    <v-card>
                        <v-card-title class="greenD text-white">
                            Permisos de archivo <v-spacer></v-spacer>
                            <!---- <v-btn
                                class="white text--greenD"
                                @click="listapermisos = false"
                                ><v-icon>mdi-close</v-icon></v-btn
                            >-->
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                                :headers="cabecerausers"
                                :items="listauserpermiso"
                            >
                                <template v-slot:item.ver="{ item }">
                                    <v-checkbox v-model="item.ver"></v-checkbox>
                                </template>
                                <template v-slot:item.descargar="{ item }">
                                    <v-checkbox
                                        v-model="item.descargar"
                                    ></v-checkbox>
                                </template>
                            </v-data-table>
                            <v-btn
                                class="greenD text-white"
                                @click="GuardaCambiosPermisos(archivoselect)"
                            >
                                <v-icon>mdi-content-save</v-icon>
                            </v-btn>
                        </v-card-text>
                    </v-card>
                </v-dialog>
                <!------carga carpetas ------>

                <v-card v-for="(fole, index) in folders" :key="'fol' + index">
                    <v-card-title class="greenD white--text">
                        {{ fole.nombre }}
                        <v-spacer></v-spacer>
                        <v-btn v-if="Object.keys(archivos[fole.nombre]).length===0" class="red white--text" @click="eliminaCarpeta(fole.id)"><v-icon>mdi-delete</v-icon></v-btn>
                        <v-btn
                            class="white greenD--text"
                            @click="muestraCarpeta(fole.nombre)"
                            ><v-icon>{{
                                carpetas[fole.nombre] === false
                                    ? "mdi-arrow-down"
                                    : "mdi-arrow-up"
                            }}</v-icon></v-btn
                        >
                    </v-card-title>
                    <v-card-text>
                        <v-data-table
                            v-if="carpetas[fole.nombre] && archivos[fole.nombre]"
                            :search="searchgral"
                            :headers="titlearch"
                            :items="archivos[fole.nombre]"
                        >
                            <template v-slot:item.comentario="{ item }">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon
                                            color="greenD"
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            style="cursor: pointer"
                                        >
                                            mdi-chat
                                        </v-icon>
                                    </template>
                                    <span>
                                        {{ item.comentario }}
                                    </span>
                                </v-tooltip>
                            </template>

                            <template v-slot:item.acciones="{ item }">
                                <v-btn
                                    v-if="validapermiso(item, 'ver')"
                                    class="greenD"
                                    elevation="2"
                                    icon
                                    raised
                                    @click="openvisorfile(item)"
                                    title="Ver Archivo"
                                >
                                    <v-icon class="white--text">mdi-eye</v-icon>
                                </v-btn>

                                <v-btn
                                    v-if="proyectoSelect.adminproy === true"
                                    class="red"
                                    elevation="2"
                                    icon
                                    raised
                                    @click="EliminarArchivo(item)"
                                    title="Eliminar Archivo"
                                >
                                    <v-icon class="white--text"
                                        >mdi-delete</v-icon
                                    >
                                </v-btn>

                                <v-btn
                                    v-if="proyectoSelect.adminproy === true"
                                    class="greenD"
                                    elevation="2"
                                    icon
                                    raised
                                    title="Cambiar Permisos"
                                    @click="Cambiarpermisos(item)"
                                >
                                    <v-icon class="white--text"
                                        >mdi-lock</v-icon
                                    >
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
                <!------carga carpetas ------>
                <!------carga sin carpetas ------>
                <v-data-table
                v-if="Object.keys(archivos.sinfolder).length>0"
                    :search="searchgral"
                    :headers="titlearch"
                    :items="archivos.sinfolder"
                >
                    <template v-slot:item.comentario="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    color="greenD"
                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                    style="cursor: pointer"
                                >
                                    mdi-chat
                                </v-icon>
                            </template>
                            <span>
                                {{ item.comentario }}
                            </span>
                        </v-tooltip>
                    </template>

                    <template v-slot:item.acciones="{ item }">
                        <v-btn
                            v-if="validapermiso(item, 'ver')"
                            class="greenD"
                            elevation="2"
                            icon
                            raised
                            @click="openvisorfile(item)"
                            title="Ver Archivo"
                        >
                            <v-icon class="white--text">mdi-eye</v-icon>
                        </v-btn>

                        <v-btn
                            v-if="proyectoSelect.adminproy === true"
                            class="red"
                            elevation="2"
                            icon
                            raised
                            @click="EliminarArchivo(item)"
                            title="Eliminar Archivo"
                        >
                            <v-icon class="white--text">mdi-delete</v-icon>
                        </v-btn>

                        <v-btn
                            v-if="proyectoSelect.adminproy === true"
                            class="greenD"
                            elevation="2"
                            icon
                            raised
                            title="Cambiar Permisos"
                            @click="Cambiarpermisos(item)"
                        >
                            <v-icon class="white--text">mdi-lock</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
                <!------carga sin carpetas ------>
            </v-card-text>
            <v-card-text v-if="!visorFile">
                <v-btn class="greenD white--text" @click="visorFile = true">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-btn>
                <v-btn
                    @click="visorArchivo(fileselect)"
                    class="greenD white--text"
                >
                    <v-icon class="white--text">mdi-fullscreen</v-icon>
                </v-btn>

                <div
                    v-if="tpfile === 'imagen'"
                    style="height: 100%; width: 100%; overflow: auto"
                >
                    <div
                        style="text-align: center; max-width: 100%; width: 100%"
                    >
                        <v-img
                            :src="this.url + 'public/' + fileselect.urlArchivo"
                        ></v-img>
                    </div>
                </div>
                <div v-if="tpfile === 'video'"></div>
                <div v-if="tpfile === 'audio'"></div>
                <div v-if="tpfile === 'pdf'">
                    <iframe
                        :width="width"
                        style="width: 100%; height: 100%; min-height: 400px"
                        :src="'public/' + fileselect.urlArchivo"
                    ></iframe>
                </div>
                <div v-if="tpfile === 'simple'"></div>
            </v-card-text>
        </v-card>

        <v-dialog v-model="dialog" max-width="700">
            <v-card>
                <v-card-title class="greenD white--text">
                    Nueva Archivo <v-spacer></v-spacer>
                    <v-btn @click="dialog = false" class="white greenD--text"
                        ><v-icon>mdi-close</v-icon></v-btn
                    >
                </v-card-title>
                <v-card-text>
                    <v-text-field
                        label="Titulo de Archivo"
                        v-model="addfile.nombre"
                    ></v-text-field>

                    <!----<v-select
                        v-model="addfile.permiso"
                        v-if="proyectoSelect.adminproy === true"
                        outlined
                        item-text="text"
                        item-value="value"
                        :items="[
                            {
                                text: 'visible y disponible para descarga',
                                value: 2,
                            },
                            {
                                text: 'visible y no disponible para descarga',
                                value: 1,
                            },
                            {
                                text: 'no visible',
                                value: 0,
                            },
                        ]"
                    >
                    </v-select>--->
                    <v-select
                                            v-model="addfile.folder"
                                            v-if="
                                                proyectoSelect.adminproy ===
                                                true
                                            "
                                            label="Carpeta"
                                            outlined
                                            :items="listcarpetas"
                                        >
                                        </v-select>

                    <v-textarea
                        v-model="addfile.comentario"
                        style="width: 100%"
                        outlined
                        label="Agrege comentarios al archivo"
                    ></v-textarea>

                    <br />

                    <v-file-input
                        multiple
                        v-model="addfile.archivo"
                        label="Seleccione el Archivo"
                        filled
                        prepend-icon="mdi-camera"
                    ></v-file-input>

                    <v-btn
                        class="greenD"
                        v-if="!cargafile"
                        @click="SubirArchivo()"
                    >
                        <v-icon class="white--text">mdi-content-save</v-icon>
                    </v-btn>

                    <v-progress-circular
                        v-if="cargafile"
                        indeterminate
                        color="primary"
                    ></v-progress-circular>

                    <v-chip class="red white--text" v-if="mensajefile">{{
                        mensajefile
                    }}</v-chip>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="viewdialog" fullscreen>
            <v-card>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="12">
                            <div
                                v-if="tpfile === 'imagen'"
                                style="
                                    height: 100%;
                                    width: 100%;
                                    overflow: auto;
                                "
                            >
                                <v-row>
                                    <v-col cols="8">
                                        <v-slider
                                            v-model="width"
                                            class="align-self-stretch"
                                            min="10"
                                            max="100"
                                            step="1"
                                        >
                                        </v-slider>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        style="text-align: center; width: 100%"
                                    >
                                        <v-img
                                            :src="
                                                this.url +
                                                'public/' +
                                                fileselect.urlArchivo
                                            "
                                            :style="'width:' + width + '%;'"
                                        ></v-img>
                                    </v-col>
                                </v-row>
                            </div>
                            <div v-if="tpfile === 'video'"></div>
                            <div v-if="tpfile === 'audio'"></div>
                            <div v-if="tpfile === 'pdf'">
                                <v-row>
                                    <v-col cols="10">
                                        <v-slider
                                            v-model="width"
                                            class="align-self-stretch"
                                            min="10"
                                            max="100"
                                            step="1"
                                        >
                                        </v-slider>
                                    </v-col>
                                    <v-col cols="2">
                                        <!---- <v-btn @click="fullscreenImage()" class="greenD white--text">
                                        <v-icon>mdi-fullscreen</v-icon>
                                    </v-btn>--->
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        style="text-align: center; width: 100%"
                                    >
                                        <iframe
                                            :style="
                                                'height: 100%; min-height:800px; width:' +
                                                width +
                                                '%;'
                                            "
                                            :src="
                                                'public/' +
                                                fileselect.urlArchivo
                                            "
                                        ></iframe>
                                    </v-col>
                                </v-row>
                            </div>
                            <div v-if="tpfile === 'simple'"></div>
                        </v-col>
                       
                    </v-row>
                    <v-card style="position:fixed; top:0px; right:0px;">
                                <v-card-title class="greenD white--text">
                                    <v-spacer v-if="datavisible"></v-spacer>

                                    <v-btn
                                        class="greenD white--text"
                                        @click="viewdetalles()"
                                        ><v-icon class="white--greenD">{{
                                            datavisible
                                                ? "mdi-arrow-collapse-right"
                                                : "mdi-arrow-collapse-left"
                                        }}</v-icon></v-btn
                                    >

                                    <v-btn
                                        class="white"
                                        elevation="2"
                                        icon
                                        raised
                                        @click="viewdialog = false"
                                    >
                                        <v-icon class="white--greenD"
                                            >mdi-close</v-icon
                                        >
                                    </v-btn>
                                </v-card-title>
                                <v-card-text v-if="datavisible">
                                    <br /><br />
                                    <v-text-field
                                        outlined
                                        v-model="fileselect.nombre"
                                        v-if="proyectoSelect.adminproy === true"
                                    ></v-text-field>

                                    <hr />

                                    URL:{{ fileselect.urlArchivo }}
                                    <hr />
                                    Extensión:{{ fileselect.urlArchivo }}
                                    <hr />

                                    <v-textarea
                                        v-model="fileselect.comentario"
                                        outlined
                                        :disabled="!proyectoSelect.adminproy"
                                    ></v-textarea>

                                    <div v-if="validapermiso(item, 'descarga')">
                                        Descargar:
                                        <v-btn
                                            class="primary"
                                            elevation="2"
                                            icon
                                            raised
                                            @click="
                                                descargarArchivo(fileselect)
                                            "
                                        >
                                            <v-icon class="white--text"
                                                >mdi-download</v-icon
                                            >
                                        </v-btn>
                                    </div>
                                    <hr />
                                    <div
                                        v-if="
                                            proyectoSelect.adminproy === true
                                                ? true
                                                : sesion.id === fileselect.user
                                        "
                                    >
                                        Eliminar Archivo:

                                        <v-btn
                                            class="error"
                                            elevation="2"
                                            icon
                                            raised
                                            @click="EliminarArchivo(fileselect)"
                                        >
                                            <v-icon class="white--text"
                                                >mdi-delete</v-icon
                                            >
                                        </v-btn>
                                    </div>
                                    <div
                                        v-if="proyectoSelect.adminproy === true"
                                    >
                                        <!----<v-select
                                            label="Permisos de archivo"
                                            v-model="fileselect.permiso"
                                            v-if="
                                                proyectoSelect.adminproy ===
                                                true
                                            "
                                            outlined
                                            item-text="text"
                                            item-value="value"
                                            :items="[
                                                {
                                                    text: 'visible y disponible para descarga',
                                                    value: 2,
                                                },
                                                {
                                                    text: 'visible y no disponible para descarga',
                                                    value: 1,
                                                },
                                                {
                                                    text: 'no visible',
                                                    value: 0,
                                                },
                                            ]"
                                        >
                                        </v-select>--->

                                        <v-select
                                            v-model="fileselect.folder"
                                            v-if="
                                                proyectoSelect.adminproy ===
                                                true
                                            "
                                            label="Carpeta"
                                            outlined
                                            :items="listcarpetas"
                                        >
                                        </v-select>

                                        <v-btn
                                            class="greenD white--text"
                                            @click="
                                                GuardarCambiosArchivo(
                                                    fileselect
                                                )
                                            "
                                        >
                                            Guardar Cambios de Archivo</v-btn
                                        >
                                    </div>
                                </v-card-text>
                            </v-card>
                </v-card-text>
            </v-card>
            <v-dialog v-model="fullImage" persistent fullscreen>
                <v-card>
                    <v-card-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="greenD white--text"
                            @click="fullImage = false"
                            ><v-icon>mdi-close</v-icon></v-btn
                        >
                    </v-card-title>
                    <v-card-text>
                        <v-slider
                            v-model="width"
                            class="align-self-stretch"
                            min="100"
                            max="2000"
                            step="1"
                        >
                        </v-slider>
                        <v-img
                            v-if="tpfile === 'imagen'"
                            :src="this.url + 'public/' + fileselect.urlArchivo"
                            :style="'width:' + width + 'px;'"
                        ></v-img>

                        <iframe
                            v-if="tpfile === 'pdf'"
                            :style="
                                'height: 100%; min-height:800px; width:' +
                                width +
                                'px;'
                            "
                            :src="'public/' + fileselect.urlArchivo"
                        ></iframe>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-dialog>
    </div>
</template>
<script>
//import pdf from 'vue-pdf'
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        return {
            carpetas: [],
            listcarpetas:[],
            folder: "",
            folders: [],
            addfolder: false,
            listapermisos: false,
            dialog: false,
            viewdialog: false,
            cargafile: false,
            addfile: {},
            cabecerausers: [
                {
                    text: "usuario",
                    value: "usuario",
                },
                {
                    text: "ver",
                    value: "ver",
                },
                {
                    text: "descargar",
                    value: "descargar",
                },
            ],
            tipoArchivos: [
                {
                    text: "Todo",
                    value: null,
                },
                {
                    text: "pdf",
                    value: "pdf",
                },
                {
                    text: "jpg",
                    value: "jpg",
                },
                ,
                {
                    text: "png",
                    value: "png",
                },
                {
                    text: "doc",
                    value: "doc",
                },
                ,
                {
                    text: "xlsx",
                    value: "xlsx",
                },
            ],
            file: "",
            searchgral: "",
            visorFile: true,
            extfile: null,
            fileselect: {},
            tpfile: "",
            width: 100,
            colspdetalles1: 11,
            colspdetalles2: 1,
            datavisible: false,
            mensajefile: "",
            fullImage: false,
            listauserpermiso: [],
            archivoselect: {},
        };
    },
    computed: {
        ...mapState([
            "proyectoSelect",
            "userproy",
            "url",
            "csrf",
            "sesion",
            "archivos",
            "socket",
            "listauser",
        ]),
        /* listauserpermiso(){
            var listadogral=[]
            this.listauser.gral.map((e)=>{
                listadogral.push(
                                {usuario:e,
                                  ver:true,
                                  descargar:true
                                }
                                )
            })


            return listadogral

        }, */
        titlearch() {
            return [
                {
                    text: "Nombre",
                    value: "nombre",
                },
                {
                    text: "",
                    value: "comentario",
                },
                {
                    text: "Ext",
                    value: "extension",
                    align: "left",
                    sortable: false,
                    filter: (value) => {
                        if (this.extfile === null) {
                            return true;
                        } else {
                            return value === this.extfile;
                        }
                    },
                },
                {
                    text: "Acciones",
                    value: "acciones",
                },
            ];
        },
    },
    mounted() {
        this.cargaArchivos();
        this.cargacarpetas();
    },
    methods: {
        ...mapActions(["loadArchivos", "cambiaStatuSnackBar"]),

        validapermiso(val, tp) {
            var resp = false;
            if (this.proyectoSelect.adminproy === false) {
                //// SI NO ES ADMINISTRADOR VALIDA LOS PERMISOS POR USUARIO           ///  ? item.permiso >= 1
                if (val.permisos !== "") {
                    var permis = JSON.parse(val.permisos);
                    resp = permis.filter((permiso) =>
                        permiso.usuario === this.sesion.email
                            ? permiso[tp]
                            : false
                    );
                }
            } else {
                resp = true;
            }
            return resp;
        },
        GuardaCambiosPermisos(p) {
            this.GuardarCambiosArchivo(p);
            this.listapermisos = false;
        },
        Cambiarpermisos(item) {
            this.archivoselect = {};
            this.listapermisos === false
                ? (this.listapermisos = true)
                : (this.listapermisos = false);
            //// carga los permisos segun
            this.listauserpermiso = [];

            console.log(item.permisos);
            if (item.permisos !== "") {
                this.listauserpermiso = JSON.parse(item.permisos);
            } else {
                this.listauser.gral.map((e) => {
                    this.listauserpermiso.push({
                        usuario: e,
                        ver: true,
                        descargar: true,
                    });
                });
            }
            item.permisos = this.listauserpermiso;
            this.archivoselect = item;
        },
        viewdetalles() {
            this.datavisible
                ? (this.datavisible = false)
                : (this.datavisible = true);

          
        },
        minimizar() {
            this.$emit("minimizar", false);
        },
        fullscreenImage() {
            this.fullImage = true;
        },
        SubirArchivo() {
            var error = [];
            var mensajes = "";

            if (!this.addfile.nombre) {
                error.push(
                    "Debe ingresar el <b>Titulo o Nombre del Archivo</b> para continuar"
                );
                mensajes +=
                    "Debe ingresar el <b>Titulo o Nombre del Archivo</b> para continuar<br />";
            }

            if (!this.addfile.archivo) {
                error.push(
                    "Debe seleccionar el <b> Archivo</b> para continuar"
                );
                mensajes +=
                    "Debe seleccionar el <b> Archivo</b> para continuar<br />";
            }

            /*
            if(!this.addfile.permiso){
                 error.push('Debe seleccionar el <b> Permiso</b> para continuar')
                 mensajes+='Debe seleccionar el <b> Permiso</b> para continuar<br />'
             }
             */

            if (error.length > 0) {
                this.cambiaStatuSnackBar({
                    status: true,
                    text: mensajes,
                    color: "red",
                });
            } else {
                if (this.addfile.nombre && this.addfile.archivo) {
                    this.cargafile = false;
                    const config = {
                        headers: { "content-type": "multipart/form-data" },
                    };

                    let formData = new FormData();
                    formData.append("proyecto", this.proyectoSelect.id);
                    formData.append("nombre", this.addfile.nombre);
                    formData.append("comentario", this.addfile.comentario);
                    for (var i = 0; i < this.addfile.archivo.length; i++) {
                        formData.append("archivo[]", this.addfile.archivo[i]);
                    }

                    formData.append(
                        "permiso",
                        this.addfile.permiso ? this.addfile.permiso : 2
                    );

                    formData.append(
                        "folder",
                        this.addfile.folder ? this.addfile.folder : ''
                    );

                    /*var listauserpermiso = {};
                    this.listauser.gral.map((e) => {
                        listauserpermiso.push({
                            usuario: e,
                            ver: true,
                            descargar: true,
                        });
                    });*/
                    formData.append(
                        "permisos", {}
                    );


                    axios
                        .post(this.url + "subirarchivo", formData, config)
                        .then((response) => {
                            console.log(response);
                            this.dialog = false;
                            this.cargaArchivos();
                            this.addfile.nombre = "";
                            this.addfile.archivo = "";
                            this.addfile.comentario = "";
                            this.cargafile = false;
                            var cambioArchivo = {
                                accion: "Guarda Archivo",
                                id: this.proyectoSelect.id,
                            };
                            this.socket.emit(
                                "actualiza_archivo",
                                cambioArchivo
                            );
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    this.mensajefile =
                        "Debe ingresar el nombre al archivo y el archivo";

                    setTimeout(() => {
                        this.mensajefile = "";
                    }, 3000);
                }
            }
        },
        cargaArchivos() {
            this.loadArchivos();
            this.socket.on("actualizaArchivo", (data) => {
                console.log("Actualiza Archivos");
                console.log(data);
                this.loadArchivos();
            });
        },

        descargarArchivo(item) {
            if (confirm("¿Seguro que desea descargar el archivo?")) {
                fetch(this.url + "downloadfile", {
                    method: "POST",

                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(item),
                })
                    .then((response) => response.blob())
                    .then((blob) => URL.createObjectURL(blob))
                    .then((uril) => {
                        var link = document.createElement("a");
                        link.href = uril;
                        link.download = "public/" + item.urlArchivo;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });
            }
        },
        openvisorfile(item) {
            this.fileselect = item;
            this.visorFile = false;
            switch (item.extension) {
                case "png":
                case "PNG":
                case "GIF":
                case "gif":
                case "jpg":
                case "JPG":
                case "JPEG":
                case "jpeg":
                    this.tpfile = "imagen";
                    break;
                case "mp4":
                case "ogg":
                case "mov":
                case "avi":
                    this.tpfile = "video";
                    break;
                case "pdf":
                    this.tpfile = "pdf";
                    break;
                default:
                    this.tpfile = "simple";
                    break;
            }
        },
        visorArchivo(item) {
            this.viewdialog = true;
        },
        GuardarCambiosArchivo(item) {
            fetch(this.url + "guardacambiosarchivo", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(item),
            })
                .then((res) => res.json())
                .then((res) => {
                    this.viewdialog = false;
                    this.cargaArchivos();

                    var cambioArchivo = {
                        accion: "Guarda Cambios de archivo",
                        id: this.proyectoSelect.id,
                    };
                    this.socket.emit("actualiza_archivo", cambioArchivo);
                });
        },
        EliminarArchivo(item) {
            if (confirm("¿Seguro que desea eliminar el archivo?")) {
                fetch(this.url + "eliminaArchivo", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(item),
                })
                    .then((res) => res.json())
                    .then((res) => {
                        this.viewdialog = false;
                        this.cargaArchivos();
                        this.visorFile = true;
                        var cambioArchivo = {
                            accion: "Elimina Archivo",
                            id: this.proyectoSelect.id,
                        };

                        this.socket.emit("actualiza_archivo", cambioArchivo);
                    });
            }
        },
        cargacarpetas() {
            var payload = {
                id_proyecto: this.proyectoSelect.id,
            };

            fetch(this.url + "cargafolder", {
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
                    this.folders = res.datos;
                    this.carpetas = res.status;

                    res.datos.map((pp)=>{
                        this.listcarpetas.push(pp.nombre)
                    })
                    this.listcarpetas.push('')
                });
        },
        crearfolder() {
            var payload = {
                nombre: this.folder,
                id_proy: this.proyectoSelect.id,
            };

            fetch(this.url + "addfolder", {
                method: "POST",

                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((res) => {
                    this.cargaArchivos();
                    this.cargacarpetas();
                    this.addfolder = false;
                });
        },
        muestraCarpeta(n) {
            this.carpetas[n] === true
                ? (this.carpetas[n] = false)
                : (this.carpetas[n] = true);
        },
        eliminaCarpeta(id) {
var payload={
    id_folder:id
}
            fetch(this.url + "deletefolder", {
                method: "POST",

                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
            .then(res=>res.json())
            .then((tres)=>{
                console.log(tres)
                this.cargaArchivos();
                this.cargacarpetas();
            })

        },
        cambiarnombreCarpeta() {},
    },
};
</script>
