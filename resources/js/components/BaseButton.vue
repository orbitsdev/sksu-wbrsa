


<!-- 
    <button :class="['button',mode]" v-if="link"> <slot>Button</slot></button>
    <router-link  :to="to" v-else><slot>{{ to }} here</slot></router-link>
 -->

<template>

    <button v-if="!link" :class="['button', mode]"> <slot> Button</slot> </button>
<router-link v-else :class="['button',mode]" :to="to"><slot> Liink</slot></router-link>    

</template>

<script>
    export default {
        props: {

            link: {
                type:Boolean,
                required:false,
                default: false,
            },
            to: {
                type: String,
                required: false,
                default: './'
            },
            mode: {
                type: String,
                required: false,
                default: '',
            }
        }
        
        
    }
</script>

<style  scoped>

.button{
    cursor: pointer;
    width: 100%;
    min-width: 90px;
    max-height: 50px;
    padding:6px 16px;
    font-weight: 600;
    color: white;
    background: #429460;
    border-color: #429460;
    border-radius: 6px;
    transition: all 0.1s ease;
}

.button:hover{
    transform: scale(0.98);
    background: #65b181;
}


.outline{
    color: #327959;
    background: white;
    border: 0.5px solid #327959;
 
}

.outline:hover{
    background: #327959;
    color: white;
}

.grey{
    border: none;
    background: #E1E4E7;
    color: #0D1216;
}

.grey:hover{
    background: #d5dae0;
}

a{
 text-decoration: none;
 text-align: center;   
}

</style>