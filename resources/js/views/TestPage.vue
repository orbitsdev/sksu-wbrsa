





<template>
    <div>   
            <BaseInput
            label="First Name"
            v-model="firstname"
            />

            {{ firstname }}

    </div>
</template>

<script>


import axiosApi from '../api/axiosApi';
  import BaseButton from '../components/BaseButton.vue';
  import DragAndDropFiles from '../components/DragAndDropFiles.vue';
  import BaseInput from '../components/BaseInput.vue';
    export default {

        data() {
            return {
                
            }
        },

        components: {
            BaseButton,
            DragAndDropFiles,
            BaseInput,
        },

        methods: {
        async testUploadApi(){
            await axiosApi.post('api/school/upload/local').then(res=>{
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