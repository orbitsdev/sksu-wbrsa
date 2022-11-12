



<template>
    <BaseSceenLoading/>
</template>

<script>


import BaseSceenLoading from '../../components/BaseScreenLoading.vue';
    export default {   
        
        created () {
            this.loginUser();
        },

        components: {
            BaseSceenLoading,
        },
        methods: {
            loginUser(){

              localStorage.setItem('token',this.$route.query.code);
              if(localStorage.getItem('token')){
                window.location.reload(true);
              }
                //  console.log(this.$route.query.code);
                // if(localStorage.getItem('token')){
                //     window.location.reload(true);
                //     console.log('has token');
                // }else{
                //     console.log('no teken');

                // }

            }   
        }
        
    }
</script>

<style  scoped>

</style>