



<template>
    <section>

        <div> <BaseCircularLoader/> </div>
            
    </section>
</template>

<script>
import BaseCircularLoader from './BaseCircularLoader.vue';
    export default {
        components: {
            BaseCircularLoader,
        },
    }
</script>

<style  scoped>
section{
    

    transition: all 0.3s ease-in;
    position: absolute;
    background: rgba(255, 255, 255, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    top:0;
    left:0;

}

</style>