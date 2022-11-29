

<template>
    <button :class="['btn ', mode ] " :disabled="isDisable"> 

         <slot>Click Me</slot></button>
</template>

<script>
    export default {

        props: {
            mode: {
                type: String,
                default: 'gray',
                required: false,
            },
            isDisable : {
                type: Boolean,
                required: false,
                default: false,
            }
        }
        
    }
</script>

<style scoped>

button{
    padding: 8px 12px;
    outline: none;
    border-radius: 6px;
    transition:  all 0.1s ease;
    
}


.green{
    background: #00BFA6;
    color:white;
    border: none;

}

.green:hover{
    transform: scale(0.98);
    background: #4da57e;
}

.blue{
    background: #00B0FF;
    color:white;
    border: none;
}

.blue:hover{
    background: #07a1e8;
    
    
}

.red{
    
    background:#F50057;
    color:white;
}



.red:hover{
    
    
    color:white;
    background:#d7044e;
    
}

.gray{
    background:#eeeff1;
}

.gray:hover{
    
    background:#e7e8ec;
}


.red-o{
    border:1px solid #d7044e;
    background:#ffffff;
    color: #d7044e;
}





</style>