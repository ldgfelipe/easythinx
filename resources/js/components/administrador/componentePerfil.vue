<template>
    <v-card>

        <v-card-text>
<v-text-field label="Correo" outlined v-model="datos.email" disabled ></v-text-field>
<v-text-field label="Nombre"  outlined v-model="datos.name" ></v-text-field>
<v-text-field label="Apellido" outlined  v-model="datos.apellido" ></v-text-field>
<v-text-field label="Teléfono"  outlined v-model="datos.telefono" ></v-text-field>
<!---<v-text-field label="Notaria" outlined  v-model="datos.notaria"></v-text-field>--->
<v-text-field label="País"  outlined v-model="datos.pais"></v-text-field>
<v-text-field label="Estado" outlined  v-model="datos.estado"></v-text-field>
</v-card-text>

<v-btn   class="greenD white--text" v-if="!loadperfil" @click="guardarCambios()" >Guardar Perfil</v-btn>
    <v-progress-circular color="greenD" v-if="loadperfil"></v-progress-circular>
<v-chip color="greenD white--text" v-if="mensajeperfil && !loadperfil" >{{mensajeperfil}}</v-chip>

<hr /><br />
<v-card-text>

    <v-text-field type="password" label="Contraseña" outlined v-model="password.pass"  ></v-text-field>
    <v-text-field type="password" label="Confirmar contraseña" outlined v-model="password.confirm"  ></v-text-field>

    <v-btn   class="greenD white--text" @click="cambiarPassword()" >Cambiar Contraseña</v-btn>


    <v-progress-circular color="greenD" v-if="loadpassword"></v-progress-circular>
<v-chip color="greenD white--text" v-if="mensajepass && !loadpassword" >{{mensajepass}}</v-chip>
</v-card-text>


</v-card>
</template>
<script>

export default{
    data(){
        return {
            datos:{
                name:"",
                corre:"",
                apellido:"",
                telefono:"",
                notaria:"",
                pais:"",
                estado:""
            },
            password:{
                pass:"",
                confirm:""
            },
            loadperfil:false,
            mensajeperfil:"",
            mensajepass:"",
            loadpassword:false
        }
    },
    created(){
        this.cargaPerfil()
    },
    methods:{
        cargaPerfil(){
            var payload={
                id:this.sesion.id
            }

        fetch(this.url+'cargaperfil',{
            method:'POST',
            headers:{
                'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
            },
            body:JSON.stringify(payload)
        })
        .then(res=>res.json())
        .then((res)=>{

                this.datos.name=res.user.name
                this.datos.email=res.user.email
                this.datos.apellido=res.perfil.apellido
                this.datos.telefono=res.perfil.telefono
                this.datos.notaria=res.perfil.notaria
                this.datos.pais=res.perfil.pais
                this.datos.estado=res.perfil.estado


        })


        },

        guardarCambios(){
            this.loadperfil=true
            this.datos.id=this.sesion.id
            fetch(this.url+'guardaperfil',{
                method:'POST',
            headers:{
                'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
            },
            body:JSON.stringify(this.datos)

            })
            .then(res=>res.json())
            .then((res)=>{
                this.loadperfil=false
                this.mensajeperfil=res.res
                setTimeout(()=>{
                    this.mensajeperfil=""
                },3000)
            })
        },
        cambiarPassword(){

            if(this.password.pass === this.password.confirm){

                if(confirm('¿Seguro(a) que desea cambiar la contraseña? '))
            var payload={
                id:this.sesion.id,
                password:this.password.pass
            }
            fetch(this.url+'cambiacontrasena',{
            method:'POST',
            headers:{
                'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
            },
            body:JSON.stringify(payload)
            })
            .then(res=>res.json())
            .then((res)=>{
                console.log(res)

                this.mensajepass=res.res

                setTimeout(()=>{
                    this.mensajepass=""
                },3000)

            });


        }else{
            alert('la contraseña y la confirmación no son iguales');
        }
        }
    },
    props:{
        idproy:{},
        csrf:"",
        url:"",
        sesion:{}
    }
}

</script>
