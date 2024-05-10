<template>
<v-card>
<v-card-title>	
Administrador de paginas
	<v-spacer></v-spacer> 
	<v-btn class='greenD white-text' @click="abrirEditorHTML()"><v-icon>mdi-plus</v-icon></v-btn>

</v-card-title>
<v-card-text>



<v-dialog fullscreen persistent v-model="editor">
	<v-card>
		<v-card-title>
			<v-spacer></v-spacer> <v-btn class="greenD white--text" @click="editor=false"><v-icon>mdi-close</v-icon></v-btn>
		</v-card-title>
		<v-card-text>
			<editorhtml ></editorhtml>
		</v-card-text>
	</v-card>
</v-dialog>

</v-card-text>
</v-card>

</template>
<script>

export default {
	data(){
		return {
			editor:false
		}
	},
	created(){
		console.log('carga paginas')
	},
	methods:{
		abrirEditorHTML(){
			this.editor=true
		}

	}
}
</script>