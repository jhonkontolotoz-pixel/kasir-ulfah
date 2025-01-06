
const routes = [
    {
        path: '/',
        redirect: '/login'
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../Components/auth/Login.vue'),
        meta : {
            notRequireAuth : true,
            title : 'Login'
        }
    },
    
];

export default routes;
