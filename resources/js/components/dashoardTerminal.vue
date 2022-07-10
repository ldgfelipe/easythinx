<template>
    <div class="areadash">
        <v-row>
            <v-col cols="12" md="8">
         
                <componenteproyectos :csrf="csrf" :url="url"></componenteproyectos> 
            </v-col>
                <v-col cols="12" md="4"></v-col>
            <v-col cols="12" md="4" class="tabledata">
             <componentetareas :csrf="csrf" :url="url"></componentetareas>
            </v-col>
             <v-col cols="12" md="4" class="tabledata">
                <componentearchivos :csrf="csrf" :url="url"></componentearchivos>
            </v-col>
             <v-col cols="12" md="4" class="tabledata">
                <componentechat :csrf="csrf" :url="url"></componentechat>
            </v-col>
        </v-row>
       
    </div>
</template>
<style>


.areadash{
    padding:15px;
}

.tabledata{
    height: 90%;
 
}

</style>

<script>

    export default {
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
