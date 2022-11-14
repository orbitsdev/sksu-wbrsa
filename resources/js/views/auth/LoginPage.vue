<template>
    <section class="body">
      <div class="container">
        <div class="login-box">
          <!-- <div class="row">
                      <div class="col-sm-6">
                          <div class="logo">
                              <span class="logo-font">Go</span>Snippets
                          </div>
                      </div>
                  </div> -->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="header-title">Login </h3>
              <form @submit.prevent="loginUser" class="login-form">
                <div class="form-group">
                  <label for="first name"> Email</label>
                  <input
                    type="email"
                    :class="['form-control', { 'error-border': emailError }]"
                    placeholder="example@gmail.com"
                    autocomplete="email"
                    v-model="form.email"
                  />
                  <div class="error-card" v-if="!!error.email">{{ error.email[0] }}</div>
                </div>
                <div class="form-group">
                  <label for="first name"> Password</label>
                  <input
                    type="Password"
                    :class="['form-control', { 'error-border': passwordError }]"
                    placeholder="Password"
                    v-model="form.password"
                  />
                  <div class="error-card" v-if="!!error.password">
                    {{ error.password[0] }}
                  </div>
                </div>
  
                <base-spinner v-if="isLoading"></base-spinner>
                <div class="form-group mt-2" v-else>
                  <BaseButton> Login</BaseButton>
                </div>
                
                
                
                <div class="form-group mt-2">
                  <div class="text-center">
                    Dont have an account? <a href="/register">Register</a>
                  </div>
                </div>
              </form>
              <base-spinner v-if="isGoogleLoading"></base-spinner>
              <div class="form-group mt-2" v-else>
                <GoogleButton  @click="continueWithSocialAccount"> Continue with Google</GoogleButton>
              </div>

            </div>
            
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>

import axios from "axios";
import BaseButton from "../../components/BaseButton.vue";
import GoogleButton from '../../components/GoogleButton.vue';
import { mapActions } from "vuex";
  
  export default {

  
    components: {
      BaseButton,
      GoogleButton
    },
  
    computed: {
      emailError() {
        return !!this.error.email;
      },
      passwordError() {
        return !!this.error.password;
      },
    },

    mounted () {
     
      this.showAuthError();
    
    },
  
    data() {
      return {
        form: {
          email: "admin@gmail.com",
          password: "@admin123",
          device_name: "browser",
        
        },
        loginError: null,
        isLoading: false,
        isGoogleLoading: false,
        error: {},
        requestError: null,

      };
    },
  
    methods: {  

      async continueWithSocialAccount(){
        this.$store.dispatch('logInWithSocialAccount').then(res=>{
           window.location.href = res.data.url;
        }).catch(err=>{
          console.log(err);
        });
      },

      showAuthError(){
        if(this.$route.query.error ){
        this.loginError = this.$route.query.error;
        console.log(this.loginError);
      }

      },



      async loginUser(){
        
        this.isLoading  = true;
        await this.$store.dispatch('loginUser', this.form).then(res=>{
          console.log(res.data);
            localStorage.setItem('token', res.data);
            window.location.reload(true);
            

        }).catch(err=>{
          console.log(err.response);
            if(err.response.status === 422){  
              this.err  = err.response.data.errors;
            }else{
              this.requestError = err.response;
            }          
        }).finally(()=>{
          this.isLoading  = false;
        });
        
      }
    },
  };
  </script>
  
  <style scoped>
  @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap);
  
  body {
    background: #f5f5f5;
  }
  
  @media only screen and (max-width: 767px) {
    .hide-on-mobile {
      display: none;
    }
  }
  
  .login-box {
    background-size: cover;
    background-position: center;
    padding: 50px;
    margin: 34px auto;
    min-height: 700px;
    -webkit-box-shadow: 0 2px 60px -5px rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 60px -5px rgba(0, 0, 0, 0.1);
  }
  
  .logo {
    font-family: "Script MT";
    font-size: 54px;
    text-align: center;
    color: #888888;
    margin-bottom: 50px;
  }
  
  .logo .logo-font {
    color: #3bc3ff;
  }
  
  @media only screen and (max-width: 767px) {
    .logo {
      font-size: 34px;
    }
  }
  
  .header-title {
    text-align: center;
    margin-bottom: 50px;
  }
  
  .login-form {
    max-width: 300px;
    margin: 0 auto;
  }
  
  .login-form .form-control {
    border-radius: 0;
    margin-bottom: 4px;
  }
  
  .login-form .form-group {
    margin: 10px 0px;
    position: relative;
  }
  
  .login-form .form-group .forgot-password {
    position: absolute;
    top: 6px;
    right: 15px;
  }
  
  .login-form .btn {
    border-radius: 0;
    -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }
  
  .login-form .btn.btn-primary {
    background: #0076de;
    border-color: #0076de;
  }
  
  .slider-feature-card {
    background: #fff;
    max-width: 280px;
    margin: 0 auto;
    padding: 30px;
    text-align: center;
    -webkit-box-shadow: 0 2px 25px -3px rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 25px -3px rgba(0, 0, 0, 0.1);
  }
  
  .slider-feature-card img {
    height: 80px;
    margin-top: 30px;
    margin-bottom: 30px;
  }
  
  .slider-feature-card h3,
  .slider-feature-card p {
    margin-bottom: 30px;
  }
  
  .carousel-indicators {
    bottom: -50px;
  }
  
  .carousel-indicators li {
    cursor: pointer;
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
  