




<template>
    <w-dialog
    overlay-color="rgba(0,0,0,0.5)"
    v-model="dialog" @close="this.$emit('close')" transition="bounce"  
    persistent
    :width="360">
    <Vue3Lottie :animationData="AstronautJSON" :height="240" :width="380" />
    
    <div class="message">
        <h1 class="text-center text-danger"> Ooops! </h1>
        <p class="text-center">
            {{ message }} 
        </p>
    <div class="error-wrapper">

        <w-button
        class="mr2 error-button"
        @click="this.$emit('close')"
        bg-color="error">
       {{ buttontext }}
    </w-button>    
</div>

</div>



    
  </w-dialog>

</template>

<script>
import BaseButton from '../BaseButton.vue';
import { Vue3Lottie } from 'vue3-lottie';
import 'vue3-lottie/dist/style.css';
import AstronautJSON from '../../../../public/assets/90333-error.json';
    export default {
        emits: ['close'],
        props: {
            dialog:{
                type: Boolean,
                required:false,
                default: false,
            },

           
            status: {
                type: String,
                required: false,
                default: '404'
            },

            message: {
                type: String,
                required: false,
                default: 'Error'
            },

            buttontext: {
                type: String,
                required: false,
                default: 'TRY AGAIN'
            }
            
            
        },
        components: {
            BaseButton,
            Vue3Lottie 
         },

            data() {
                return {
                    AstronautJSON,

                   
                }
            },
    }
</script>

<style scoped>
.error-wrapper{
    display:flex;
    justify-content: center;
}
.error-button{

    background: red;
    color: white;
    padding: 20px;
    transition: all 0.1s ease-in-out;
    box-shadow:
     rgba(255,0,0, 0.255) 0px 54px 55px,
    rgba(255,0,0, 0.12) 0px -12px 30px, 
    rgba(255,0,0, 0.12) 0px 4px 6px, 
    rgba(255,0,0, 0.17) 0px 12px 13px, 
    rgba(255,0,0, 0.09) 0px -3px 5px;
}

.error-button:hover{
    transform: scale(0.98);
   
}
.message{
    padding:20px
}

.message p{
    font-size: 16px;
}
.dg{
z-index: 1000;
}

</style>