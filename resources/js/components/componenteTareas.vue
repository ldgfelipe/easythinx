<template>
<div>
<v-card>
    <v-card-title>
        Tareas <v-spacer></v-spacer>  <v-btn class="greenD white--text"><v-icon>mdi-plus</v-icon></v-btn>
    </v-card-title>
    <v-card-text>
        Carga tareas
    </v-card-text>
</v-card>


    <v-dialog v-model="dialog" max-width="700">
        <v-card>
            <v-card-title>
                Nueva tarea
            </v-card-title>
            <v-card-text>
                <v-text-field></v-text-field>

            </v-card-text>
        </v-card>

    </v-dialog>

</div>
</template>
<script>
export default{
data(){
    return {
        dialog:true
    }
}

}
</script>