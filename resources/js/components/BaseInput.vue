


<template>

    <div class="inp mb-2">
        <label>{{ label }}</label> 
       <div class="input-group my-0">
            <input 
             :class="['form-control shadow-none', { 'error-border': error }]"
             :type="type"
             :placeholder="!showLabel ? '' : label"
             :value="modelValue"
             @input="$emit('update:modelValue', $event.target.value)"
             >
        </div>
        <div class="error-card"  v-if="error">
            {{ error[0] }}
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            
            showLabel:{

                type: Boolean,
                default: true,
                required: false,
            },

            label: {
                type: String,
                default: null,
                required: false,
            },
            type: {
                type: String,
                default: 'text',
                required: false,
            },

            modelValue: {
                type: [String, Number],
                default: '',
                
            },

        

            mode: {
                type: String,
                default: '',
                required: false,
            },
            
            
            
            error: {
                type: [String, Array],
                default: null,
                required: false,

            }


        }
        
    }
</script>

<style  scoped>

label{
    margin: 0px;
}

.error-border {
    border: 1px solid red;
  }
  .error-card {
    padding: 2px 4px;
    color: red;
    font-size: 14px;
    display: inline-block;
    border-radius: 4px;
  }


</style>