const routes = [
  {
 
    path: '/',
    name: 'home',
    component: () => import('../Components/HomePage.vue'),
    meta: {
      notRequireAuth: true,
      title: 'Home',
    },
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../Components/auth/Login.vue'),
    meta: {
      notRequireAuth: true,
      title: 'Login',
    },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../Components/auth/Register.vue'),
    meta: {
      notRequireAuth: true,
      title: 'Register',
    },
  },
];

export default routes;


