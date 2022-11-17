import WelcomePage from '../views/WelcomePage.vue';

import DashboardPage from '../views/auth/DashboardPage.vue';
import OsasIndexPage from  '../views/osas/OsasIndexPage.vue';
import SboAdviserIndexPage from '../views/sbo-adviser/SboAdviserIndexPage.vue';
import NotFoundPage from '../views/NotFoundPage.vue';
import SocialAccounTokenCatcher from '../views/auth/SocialAccounTokenCatcher.vue';

const routes = [
    {name: 'main', path: '/' , component: WelcomePage, meta:{ middleware: "guest"},}, 
    {name: 'token-catcher', path: '/authorize/google/callback' , component: SocialAccounTokenCatcher, meta: {middleware: "guest"}},
    {name: 'login', path: '/login' ,component: ()=> import('../views/auth/LoginPage.vue'),    meta: {middleware: "guest"}},
    {name: 'register', path: '/register' , component: ()=> import('../views/auth/RegisterPage.vue'), meta: {middleware: "guest"}},
    {name: 'forgotpassword', path: '/forgot-password' , component: ()=> import('../views/auth/ForgotPasswordPage.vue'), meta: {middleware: "guest"}},
    {name: 'setnewpassword', path: '/set-new-password' , component: ()=> import('../views/auth/SetNewPasswordPage.vue'), meta: {middleware: "guest"}},
    {name: 'requestsuccess', path: '/request-succesfully-sent/:email' , component: ()=> import('../views/RequestSuccessPage.vue'), meta: {middleware: "guest"}},
    {name: 'dashboard', path: '/dashboard' , component: DashboardPage, meta: {middleware: "auth"} },
    {path: '/:notFound(.*)' , component: NotFoundPage},
];


export default routes;