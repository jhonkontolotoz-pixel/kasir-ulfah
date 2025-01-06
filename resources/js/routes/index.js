import { createRouter, createWebHistory } from "vue-router";
import adminRoutes from "./admin";
import publicRoutes from "./public";
import { useAuthStore } from "@/store/auth";

const routes = [...publicRoutes, ...adminRoutes];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'border border-indigo-500',
    linkExactActiveClass: 'border border-gray-500',
});

router.beforeEach(async (to, from, next) => {

    const auth = useAuthStore();
    
    if (to.meta && to.meta.title) {
        document.title = to.meta.title;
    }

    if(to.query.logingout)
    {
        auth.logout()
    }
    
    if (to.meta.notRequireAuth && auth.isAuthenticated) {
        // Redirect authenticated users away from login
        return next({ name: "admin.dashboard" });
    }

    if (to.meta.notRequireAuth && !auth.isAuthenticated) {
        // Redirect unauthenticated users away from dashboard
        return next();
    }

    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        // Redirect unauthenticated users away from dashboard
        return next({ name: "login" , query: { redirect: to.fullPath } });
    } 

    next();
});

export default router;
