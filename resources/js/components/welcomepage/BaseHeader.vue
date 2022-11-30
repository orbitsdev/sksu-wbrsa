


<template>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
        <div class="container px-5" >
          <div class="sksu-logo">
              <img src="../../../../public/welcomepage/assets/img/sksu1.png" alt="">
              <span class="navbar-brand fw-bold" href="#page-top">SKSU-WBRSA</span>
          </div>
          <div>


          </div>
  
          
        </div>
      </nav>
</template>

<script>
import BaseButton from '../BaseButton.vue';
    export default {
        props:{
            showbuttons: {
                type: Boolean,
                required: false,
                default: true,

            }
        },
        components: {
            BaseButton,
        },
        
    }
</script>

<style scoped>

.sksu-logo {
    display: flex;
    align-items: center;
    justify-content: center;
}
.sksu-logo img{
    width:40px;
    height:40px;
    margin-right: 8px;
}

</style>