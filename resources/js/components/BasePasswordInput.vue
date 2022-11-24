


<template>

    <div class="inp mb-2">
        <label>{{ label }}</label> 
       <div class="input-group my-0">
            <input 
             :class="['form-control shadow-none', { 'error-border': error }]"
             :type="show? 'text': 'password'"
             :placeholder="label"
             :value="modelValue"
             @input="$emit('update:modelValue', $event.target.value)"
             >
             <button id="2" tabindex="-2" @click.prevent="$emit('showPassword')" class="input-group-text" >
                <span> <i :class="{'fa-regular fa-eye-slash': !show, 'fa-regular fa-eye': show }"></i> </span>
              </button>
        </div>
        <div class="error-card"  v-if="error">
            {{ error[0] }}
        </div>
    </div>
</template>

<script>
    export default {
        
        imits: ['showPassword'],

        props: {
            label: {
                type: String,
                default: '',
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

            },
           show: {
                type:Boolean,
                default:true,
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