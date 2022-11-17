



import {createStore} from  'vuex';
import auth from './modules/auth/auth_index';
import helper from './modules/helper/helper_index';
const store =  createStore({
    modules: {
        auth,
        helper,
    }
});

export default store;