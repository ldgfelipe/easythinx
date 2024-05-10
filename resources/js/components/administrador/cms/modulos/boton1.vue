<template>
	<div class='secctioncontet' >
		<div  v-if="!editable" @dblclick="openEditable()" >
		{{textbtn}}
		</div>
		<div  v-if="editable" >
			<v-text-field v-model="textbtn" />
			<v-btn class="greenD white--text" @click="closeEditable()">
				<v-icon>mdi-close</v-icon>
			</v-btn>
		</div >
	</div>

</template>

<script>
	export default{
		data(){
			return {
				textbtn:"leermas"
			}
		},
		methods:{
			openEditable(){
				this.$emit('openEditable',true)
			},
			closeEditable(){
				this.$emit('closeEditable',false)
			}
		},
		props:{
			editable:{
				default:false
			}
		}
	}
	</script>