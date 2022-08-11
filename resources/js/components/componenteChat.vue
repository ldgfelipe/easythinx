<template>
    <div class="container">
      <v-app-bar color="greenD" >

      <v-toolbar-title  class="white--text"
        >Chat


        </v-toolbar-title> <v-spacer></v-spacer>


  <v-menu
      v-model="showMenu"
      absolute
      offset-y
    >
    <template v-slot:activator="{ on, attrs }">
       <v-icon class="white--text"
        v-bind="attrs"
        v-on="on"
       >mdi-account-supervisor</v-icon>
  </template>


     <v-list>
        <v-list-item
          v-for="(item, index) in usuarios"
          :key="index"
        >
          <v-list-item-title @click="selectuser(item)">{{ item }}</v-list-item-title>
        </v-list-item>
      </v-list>



</v-menu>

    </v-app-bar>
    <v-container class="fill-height ">
      <v-row class="fill-height pb-14" align="end">
        <v-col>
          <div v-for="(item, index) in chat" :key="index"
              :class="['d-flex flex-row align-center my-2', item.from == sesion.email ? 'justify-end': null]">
            <span v-if="item.from == sesion.email " class="blue--text mr-3">{{ item.msg }}</span>
            <v-avatar :color="item.from == sesion.email  ? 'indigo': 'red'" size="36">
               <span class="white--text">{{ item.from[0] }}</span>
            </v-avatar>
            <span v-if="item.from != sesion.email" class="blue--text ml-3">{{ item.msg }}</span>
          </div>
        </v-col>
      </v-row>
    </v-container>
    <v-footer >
      <v-container class="ma-0 pa-0">
        <v-row no-gutters>
          <v-col>
            <div class="d-flex flex-row align-center">
              <v-text-field v-model="msg" placeholder="Mensaje" @keypress.enter="send()"></v-text-field>
              <v-btn icon class="ml-4" @click="send()"><v-icon>mdi-send</v-icon></v-btn>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>
    </div>
</template>

<script>
import { mapState } from 'vuex'
    export default {
        data: function() {
            return {
                chat: [
                    ],
                msg: null,
                socket:io(this.websocket),
                showMenu: false,

            }
        },
        mounted() {
            this.socket.on('chat_respuesta',(data)=>{
                    console.log('respuesta de socket')
            })
        },
    computed:{
        ...mapState(['usuarios'])
    },
     methods: {
    send(){
        var payload = {
            proyecto:this.idproy,
            session:this.sesion,
            message:{
                msj:this.msg,
                to:"",
                type:""
            }
        }
 this.socket.emit('chat_mensaje',payload)

      this.chat.push(
      {
        from:"user",
        msg: this.msg
      })
      this.msg = null

    },
    addReply(){
      this.chat.push({
        from: "sushant",
        msg: "Hmm"
      })
    },
    selectuser(p){
        console.log(p)
    }
  },
props:{
    csrf:"",
    url:"",
    websocket:"",
    sesion:{},
    idproy:{}

    }
    }
</script>
