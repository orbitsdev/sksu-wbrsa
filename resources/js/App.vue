


<template>
    <div>

        
        <router-view v-slot="slotProps">
            <transition mode="out-in" name="route">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>
    </div>
    
</template>

<script>
    export default {
        
    }
</script>

<style  scoped>

.route-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}
.route-enter-active {
    transition:  all 0.3s ease-out;
    
}
.route-enter-to {
    opacity: 1;
    transform: translateY(0px);
}
.route-leave-from {
    opacity: 1;
    transform: translateY(0px);
}
.route-leave-active {
    
    transition:  all 0.3s ease-in;
}

.route-leave-to{

    opacity: 0;
    transform: translateY(-30px);
}


</style>