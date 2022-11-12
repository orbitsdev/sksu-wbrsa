import MainPage from '../views/MainPage.vue';
import LoginPage from '../views/auth/LoginPage.vue';
import RegisterPage from '../views/auth/RegisterPage.vue';
import DashboardPage from '../views/auth/DashboardPage.vue';
import OsasIndexPage from  '../views/osas/OsasIndexPage.vue';
import SboAdviserIndexPage from '../views/sbo-adviser/SboAdviserIndexPage.vue';
import NotFoundPage from '../views/NotFoundPage.vue';
import SocialAccounTokenCatcher from '../views/auth/SocialAccounTokenCatcher.vue';

const routes = [
    {name: 'main', path: '/' , component: MainPage, meta:{ middleware: "guest"}, children:[
        {path: '/osas', component: OsasIndexPage},
        {path: '/sbo-adviser', component: SboAdviserIndexPage},
    ] },
    {name: 'token-catcher', path: '/authorize/google/callback' , component: SocialAccounTokenCatcher, meta: {middleware: "guest"}},
    {name: 'login', path: '/login' , component: LoginPage,  meta: {middleware: "guest"}},
    {name: 'register', path: '/register' , component: RegisterPage, meta: {middleware: "guest"}},
    {name: 'dashboard', path: '/dashboard' , component: DashboardPage, meta: {middleware: "auth"} },
    {path: '/:notFound(.*)' , component: NotFoundPage},
];


export default routes;