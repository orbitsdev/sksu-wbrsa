

<template>
    <button class="btn btn-succes"> <slot>Click Me</slot></button>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>

button{
    padding: 8px 12px;
    background: #327959;
    color:white;
    outline: none;
    border: none;
    border-radius: 6px;
    transition:  all 0.1s ease;
    
}
button:hover{
    transform: scale(0.98);
    background: #69dca8;

}
</style>