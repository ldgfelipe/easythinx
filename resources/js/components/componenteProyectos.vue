<template>
<div>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="11">
                      <v-select label="Seleccione un proyecto"></v-select>
                </v-col>
                <v-col cols="1">
                    <v-btn class="greenD" @click="adminproyect=true"><v-icon class="white--text">mdi-form-select</v-icon></v-btn> 
                </v-col>
          
            </v-row>
        </v-card-text>
    </v-card>

    <v-dialog v-model="adminproyect" fullscreen persistent>
            <v-card>
                <v-card-title class="greenD white--text">
                    Administrador de Proyectos 

                    <v-spacer></v-spacer> 
                    
                    <v-btn class="white" @click="addp=true">
                        <v-icon class="greenD--text">mdi-plus</v-icon>
                    </v-btn>
                    <v-btn class="white">
                        <v-icon class="greenD--text" @click="adminproyect=false">mdi-close</v-icon>
                    </v-btn>

                </v-card-title>
                <v-card-text>
                        
                    <v-data-table></v-data-table>

                <v-dialog v-model="addp" max-width="500">
                    <v-card>
                        <v-card-title>
                            Registra Proyecto
                        </v-card-title>
                        <v-card-text>
                            <v-text-field outlined v-model="addproyect.nombre" label="Nombre del proyecto"></v-text-field>
                            <v-textarea outlined v-model="addproyect.descripcion" label="Descripción"></v-textarea>
                            <v-btn  @click="GuardarProyecto()" class="greenD white--text">Guardar</v-btn>
                        </v-card-text>
                    </v-card>
                </v-dialog>
                </v-card-text>
            </v-card>

    </v-dialog>


</div>
</template>
<script>
export default{
    data(){
        return{
            addp:false,
            adminproyect:false,
            addproyect:{}
        }
    },
    methods:{
        GuardarProyecto(){

            fetch(this.url+"registraproyecto", {
                method: 'POST', // or 'PUT'
                body: JSON.stringify(this.addproyect), // data can be `string` or {object}!
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':this.csrf
                }
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(response => console.log('Success:', response));
        }
    },
   props:{
            csrf:{
                default:""
            },
            url:{
                default:""
            }
        }
}
</script>