
//import Home from '../Components/inc/Home'

 import Login from '../Components/auth/Login.vue'

 import Register from '../Components/auth/Register.vue'

 import ForgotPassword from '../Components/auth/ForgotPassword.vue'

 import NotFound from '../Components/inc/NotFound.vue'

/*

import Category from '../Components/Guest/Category'

import Brand from '../Components/Guest/Brand'

import Search from '../Components/Guest/Search'

import Product from '../Components/Guest/Product'

import Cart from '../Components/Guest/Cart'

import Checkout from '../Components/Guest/Checkout'
 */

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: ForgotPassword
    }/* ,
    {
        path : '/:pathMatch(.*)*',
        name : 'NotFound',
        component : NotFound
    } */
];

export default routes;
