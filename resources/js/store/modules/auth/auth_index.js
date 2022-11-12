



import mutations from './auth_mutations';
import actions from './auth_actions';
import getters from './auth_getters';
export default {
    state(){
        return{

            user: null,
            token:null,
            
        }
    },
    mutations,
    actions,
    getters



}