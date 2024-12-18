import {
    createRouter,
    createWebHistory
} from 'vue-router'
import adminRoutes from './admin'
import publicRoutes from './public'
import supervisorRoutes from './supervisor'
import store from '../store/index.js'

const routes = [...adminRoutes, ...publicRoutes, ...supervisorRoutes]

const router = createRouter({
    history: createWebHistory(),
    routes
})

/* router.beforeEach((to, from, next) => {

    if (to.meta.middleware == "admin" && !store.getters.isAdmin ) {

        store.dispatch('logout')

        next({name: "login"})
    }

    if (to.meta.middleware == "supervisor" && !store.getters.isSupervisor) {

        store.dispatch('logout')
        
        next({name: "login"})

    }

    
next()

}) */

export default router
