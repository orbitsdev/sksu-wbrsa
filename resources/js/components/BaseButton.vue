


<!-- 
    <button :class="['button',mode]" v-if="link"> <slot>Button</slot></button>
    <router-link  :to="to" v-else><slot>{{ to }} here</slot></router-link>
 -->

<template>

    <button v-if="!link" :class="['button', mode]"> <slot> Button</slot> </button>
<router-link v-else :class="[mode]" :to="to"><slot> Link</slot></router-link>    

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
    margin: 0;
    cursor: pointer;
    width: 100%;
    min-width: 90px;
    min-height: 45px;
    max-height: 45px;
    padding: 0px 16px;
    font-size: 18px;
    font-weight: 600;
    color: white;
    background: #429460;
    border-color: #429460;
    border-radius: 4px;
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

.link{
    display: block;
    text-decoration: none;
    background: white;
    color: #327959;
    min-width: 90px;
    border-radius: 4px;
    padding: 6px 16px;
    font-size: 18px;
    font-weight: 600;
    border: 0.5px solid #327959;
    transition: all 0.1s ease;


}

.link:hover{
    transform: scale(0.98);
    background: #327959;
    color: white;
}

</style>