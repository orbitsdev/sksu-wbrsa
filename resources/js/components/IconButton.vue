




<template>
    <button :class="[mode]">

        <i :class="[icon]"></i>


        <span v-if="!!label"> {{ label }}</span>

    </button>
</template>

<script>
    export default {

        props: {
            icon:{
                type: String,
                required: false,
                default: 'fa-regular fa-ey',
            },

            
            mode:{
                type: String,
                required: false,
                default: null,
            },

            label: {
                type: String,
                required: false,
                default: null,
            }

        }
        
    }
</script>

<style scoped>

button{
    outline: none;
    border:none;
    padding: 4px 8px;
    border-radius: 4px;
    margin: 0px 2px;
    background: transparent;
    color: white !important;
    transition: all 0.1s ease-out;

    
}

button:hover{
    background: rgb(235, 235, 239);
    transform: scale(0.95);
}


.red{
   background: red;
   
}
.red:hover{
    
    background: rgb(179, 5, 5);
}
.blue{
   background: #00B0FF;
    
}
.blue:hover{
   background: #108bc3;
    
}

i{
    font-size: 16px;
    color:white;
}

.green{
    
   background: #00BFA6;
}
.green:hover{
    
   background: #0aa792;
}
span{
    margin: 0px 4px;
}

</style>