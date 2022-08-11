export default{
  state:{
    usuarios:[],
    csrf:"",
    url:""
  },
  mutations: {
    cargaCSRF(state,datos){
        state.csrf=datos
    },
    cargaURL(state,url){
        state.url=url

    },
    guardausuarios(state,datos){
        state.usuarios=datos
    }
  },
  actions: {
    cargaUsuarios({commit,state},datos){ //// carga los usuarios de contacto
        var payload={
           acces:"data",
           id_user:datos.id
       }
       fetch(state.url+"cargausuarios",{
           method:'POST',
           headers:{
               'Content-type':'application/json',
               'X-CSRF-TOKEN':state.csrf
           },
           body:JSON.stringify(payload)
       })
       .then(res=>res.json())
       .then((res)=>{
        commit('guardausuarios',res)
       })
   },

  }
}


