





<template>
    <div>   
        
        <base-button @click="testUploadApi">Test Uplaod Api</base-button>
        <BaseDragFile/>
    </div>
</template>

<script>


import axiosApi from '../api/axiosApi';
  import BaseDragFile from '../components/BaseDragFile.vue';
  import BaseButton from '../components/BaseButton.vue';
    export default {

        components: {
            BaseDragFile,
            BaseButton,
        },

        methods: {
        async testUploadApi(){
            await axiosApi.post('api/upload/school').then(res=>{
                console.log(res);
            }).catch(err=>{
                console.log(err);
            }).finally(()=>{

            });
                
            }
        }   
        
    }
</script>

<style  scoped>

</style>