<template>
<v-snackbar
v-model="snackbar.status"
:color="snackbar.color"
>
<p v-html="snackbar.text"></p>

<template v-slot:action="{ attrs }">
  <v-btn
    :color="snackbar.color === 'yellow' ? 'black' : 'white'"
    text
    v-bind="attrs"
    @click="cambiaSnack()"
  >
    Close
  </v-btn>
</template>
</v-snackbar>
</template>
<script>
import {mapState,mapMutation,mapActions} from 'vuex'
export default {
computed:{
    ...mapState(['snackbar'])
},
methods:{
    ...mapActions(['cambiaStatuSnackBar']),
    cambiaSnack(){
        this.cambiaStatuSnackBar({
            text:'',
            snackbar:false,
            color:''
        })
    }
}
}
</script>
