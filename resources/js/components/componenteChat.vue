<template>
    <div class="container">
      <v-app-bar color="greenD" >

      <v-toolbar-title  class="white--text"
        >Chat


        </v-toolbar-title> <v-spacer></v-spacer>

       <v-icon class="white--text">mdi-account-supervisor</v-icon>

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

    export default {
        data: function() {
            return {
                chat: [
                    ],
                msg: null,
                socket:io(this.websocket)

            }
        },
        mounted() {
            this.socket.on('chat_respuesta',(data)=>{
                    console.log('respuesta de socket')
            })
        },

     methods: {
    send(){
        var payload = {
            message:this.msg,
            username:this.sesion.email
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
    }
  },
props:{
    csrf:"",
    url:"",
    websocket:"",
    sesion:{}

    }
    }
</script>
