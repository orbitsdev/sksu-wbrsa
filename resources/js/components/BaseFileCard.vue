





<template>
    <div :class="[error ? 'error' : 'success' ]"> 
        {{ text }}
    </div>
</template>

<script>
    export default {
        props: {
            text:{
            type: String,
            default: 'Laravel Vue',
            required: false               
            }
            ,
            error: {
                type: Boolean,
                default: false,
                required: false
            }

            
        }
        
    }
</script>

<style  scoped>
div{
    display: inline-block;
    border-radius: 4px;
    padding: 2px 4px;

    margin: 1px 2px;
    color: white;
    font-size: 12px;
    text-align: center;
    transition: all 0.3s ease-in-out;
}

.success{
    background: #00BFA6;
}
.error{
    background: #F50057;
}
</style>