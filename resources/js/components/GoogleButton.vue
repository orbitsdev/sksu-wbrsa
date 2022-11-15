
 <template>
<button>

    <div class="logo-wrapper">
        <img src='../../../public/assets/google.png'>
    </div>
    <div class="button-text">
        <p>
            <slot> Continue with Gogle</slot>
        </p>
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
*{
    padding: 0;
    margin: 0;
} 
button{
    display: flex;
    padding: 4px 8px;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
    width: 100%;
    font-size: 18px;
    font-weight: 600;
   
}

button:hover{
    transform: scale(0.98);
}

.logo-wrapper{
    
}
.logo-wrapper img{
    width: 34px;
    height: 34px;
    margin-right: 4px;
}

.button-text{
        font-size: 16px;
}





</style>