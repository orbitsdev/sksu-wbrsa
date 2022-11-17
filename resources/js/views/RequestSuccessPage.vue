

<template>
    <section>
        
        <div>
            <img :src="assets('undraw_Mail_sent_re_0ofv.png')" alt="dasd">
            <p>An email was sent  to {{this.$route.params.email  }}. Click the link to reset password</p>
            <router-link to="/login"> Go to login page</router-link>
        </div>
    </section>
</template>

<script>


    export default {
        methods: {

          assets(path){
            return 'http://127.0.0.1:5173/public/assets/'+path;
          }    

        }
    }
</script>

<style  scoped>
p{
    text-align: center;
}
section{

    width: 100%;

    display: flex;
    justify-content: center;
    align-items: center;
    
}

section div{


}
img{

    width: 300px;
    height: 300px;
    text-align: center;
}
a{
    display: block;
    text-align: center;
}


</style>