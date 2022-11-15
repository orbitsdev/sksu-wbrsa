




<template>
    <w-dialog
    overlay-color="rgba(0,0,0,0.5)"
    v-model="dialog" @close="this.$emit('close')" transition="bounce"  :title="title"
    persistent
    :width="550">
    <Vue3Lottie :animationData="AstronautJSON" :height="300" :width="500" />
    
    <div class="message">
        <h1 class="text-center text-danger"> {{ status }}</h1>
        <p>
            {{ message }}
        </p>
    <div class="error-wrapper">

        <w-button
        class="mr2 error-button"
        @click="this.$emit('close')"
        bg-color="error">
        I understand
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

            title: {
                type: String,
                required: false,
                default: 'Opps!'
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
    justify-content: end;
}
.error-button{

    background: #25924E;
    color: white;
    padding: 20px;
    transition: all 0.1s ease-in-out;
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