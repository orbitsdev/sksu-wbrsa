




<template>

    <div class="wrap mx-2">
        <div class="search">
           <input 
           type="text" 
           class="searchTerm" 
           :placeholder="label"
           @input="$emit('update:modelValue', $event.target.value)"
           />
           <button type="submit" class="searchButton">
             <i class="fa fa-search"></i>
          </button>
        </div>
     </div>

</template>

<script>
    export default {
        props:  {
            label: {
                type: String,
                required: false,
                deault: 'Search..'
            }
        },

        modelValue: {
                type: [String, Number],
                default: '',
                
            },
    }
</script>

<style  scoped>
button{
    width: 34px;
    height: 34px;
    padding: 4px;
    border-radius: 2px;
    outline:none;
    border:none;
    background: transparent;
}

input {
    outline: none;
    border: none;
    padding: 6px 8px ;
    background: #f2f2f2;
    border-radius: 4px;

}

</style>