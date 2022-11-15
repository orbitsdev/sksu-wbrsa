



import axiosApi from "../../../api/axiosApi";

import axios from "axios";
export default {


   async getUserDetails({commit}, token){
    // axios.defaults.headers.common['Authorization']= "Bearer "+token;
      return await  axiosApi.get('api/user').then(res=>{
        return res
      }).catch(err=>{
          throw new Error(err);
      });


    },


    logoutUser({commit}){
      
        commit('setUserDetails',{
          user:null,
          roles:null,
          token: null
        });
        
    },

    

    async logInWithSocialAccount(){
      return axios.get('/api/authorize/google/redirect').then(res=>{
        return res;
      }).catch(err=>{
        throw new Error(err);
      })
    },


    async loginUser({commit }, payload ){
    return axios.post('api/login', payload).then(res=>{
          return res;
      }).catch(err=>{
        throw err;
      });
    }

    

}