
const routes = [

    
    {name: 'main', path: '/' , component: ()=> import('../views/WelcomePage.vue'), meta:{ middleware: "guest"},}, 
    {name: 'token-catcher', path: '/authorize/google/callback' , component: ()=> import('../views/auth/SocialAccounTokenCatcher.vue'), meta: {middleware: "guest"}},
    {name: 'login', path: '/login' ,component: ()=> import('../views/auth/LoginPage.vue'),    meta: {middleware: "guest"}},
    {name: 'register', path: '/register' , component: ()=> import('../views/auth/RegisterPage.vue'), meta: {middleware: "guest"}},
    {name: 'forgotpassword', path: '/forgot-password' , component: ()=> import('../views/auth/ForgotPasswordPage.vue'), meta: {middleware: "guest"}},
    {name: 'setnewpassword', path: '/set-new-password' , component: ()=> import('../views/auth/SetNewPasswordPage.vue'), meta: {middleware: "guest"}},
    {name: 'requestsuccess', path: '/request-succesfully-sent/:email' , component: ()=> import('../views/RequestSuccessPage.vue'), meta: {middleware: "guest"},},
    
    // DASH BOARD
    {name: 'dashboard', path: '/dashboard' , component: ()=>import('../views/auth/DashboardPage.vue'), meta: {middleware: "auth"}, children:[
        {name: 'osas-manage-school', path: 'osas/manage/school' , component: ()=> import('../views/osas/ManageSchoolPage.vue')},
        {name: 'osas-manage-sbo', path: 'osas/manage/sbo' , component: ()=> import('../views/osas/ManageSboPage.vue')},
        {name: 'osas-manage-application', path: 'osas/manage/application' , component: ()=> import('../views/osas/ManageApplicationPage.vue')},
        
    ]},
    {name: 'filepond', path: '/test' , component: ()=> import('../views/TestPage.vue'),},

    // TEST ROUTES
    {path: '/:notFound(.*)' , component: ()=> import('../views/NotFoundPage.vue'),},
];


export default routes;