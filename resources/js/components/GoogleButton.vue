


<!-- 
    <button :class="['button',mode]" v-if="link"> <slot>Button</slot></button>
    <router-link  :to="to" v-else><slot>{{ to }} here</slot></router-link>
 -->

 <template>
<button>

    <div class="logo-wrapper">
        <img src='https://developers.google.com/identity/images/g-logo.png'>
    </div>
    <div class="button-text">
        <slot> Continue with Google</slot>
    </div>

</button>    

</template>

<script>
    export default {
        props: {

           
        }
        
        
    }
</script>

<style  scoped>

button{
    border: 6px;
    margin: 0;
    padding:0;
    width: 100%;
    border-radius: 6px;
    display: flex;
    align-items: center;
    transition: all 0.1s ease;
    background: #4285F4;
    color: white;
    transition: all 0.1s ease;
}

button:hover{
    transform: scale(0.98);
    background: rgb(125, 170, 242);
}

.logo-wrapper{
    background: white;
    padding:0px  8px;
    width:60px;
}
.logo-wrapper img{
    width: 34px;
    height: 34px;
    font-size: 16px;
    font-weight: 600;
    color: white;
}

.button-text{
    width: 100%;
    padding:  0px 8px;
}


.button-text p{
    text-align: center;
}


</style>