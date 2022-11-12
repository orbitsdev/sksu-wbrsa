import { createRouter } from "vue-router";
import { createWebHistory } from "vue-router";

import routes from "./routes";

import store from '../store/store';
import axios from "axios";
import axiosApi from "../api/axiosApi";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

function authentecated() {
    return localStorage.getItem('token');
}

router.beforeEach( async (to, from, next) =>{
    if (to.meta.middleware == "guest" && authentecated()) {
        next('/dashboard')
    
    } else if (to.meta.middleware === "auth" && !authentecated()) {
        next('/login');
       

    } else if(to.meta.middleware === "auth" && authentecated()){
       
        
            const token = localStorage.getItem('token');

          next();
      
           
    }else {
        next();
    }
});

export default router;
