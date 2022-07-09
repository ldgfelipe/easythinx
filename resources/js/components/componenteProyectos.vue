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
                    Administrador de Proyectos <v-spacer></v-spacer> <v-btn class="white"><v-icon class="greenD--text">mdi-plus</v-icon></v-btn><v-btn class="white"><v-icon class="greenD--text" @click="adminproyect=false">mdi-close</v-icon></v-btn>
                </v-card-title>
                <v-card-text>

                    <v-data-table></v-data-table>


                </v-card-text>
            </v-card>

    </v-dialog>


</div>
</template>
<script>
export default{
    data(){
        return{
            adminproyect:false
        }
    }
}
</script>