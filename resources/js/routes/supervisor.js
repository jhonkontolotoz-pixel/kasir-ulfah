import Dashboard  from '../Components/Supervisor/pages/Dashboard.vue'
import Categories from '../Components/Supervisor/pages/category/categories.vue'
import Category from '../Components/Supervisor/pages/category/category.vue'
import CategoryCreate from '../Components/Supervisor/pages/category/create.vue'
import CategoryEdit from '../Components/Supervisor/pages/category/edit.vue'
import Products from '../Components/Supervisor/pages/product/products.vue'
import Product from '../Components/Supervisor/pages/product/product.vue'
import ProductEdit from '../Components/Supervisor/pages/product/edit.vue'
import ProductCreate from '../Components/Supervisor/pages/product/create.vue'
import Orders from '../Components/Supervisor/pages/order/orders.vue'
import Order from '../Components/Supervisor/pages/order/order.vue'
import OrderCreate from '../Components/Supervisor/pages/order/create.vue'
import OrderEdit from '../Components/Supervisor/pages/order/edit.vue'
import Customers from '../Components/Supervisor/pages/customer/customers.vue'
import Customer from '../Components/Supervisor/pages/customer/customer.vue'
import CustomersCreate from '../Components/Supervisor/pages/customer/create.vue'
import CustomersEdit from '../Components/Supervisor/pages/customer/edit.vue'

const routes = [
    {
        path: '/profile',
        name: 'supervisor.dashboard',
        component: Dashboard,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/categories',
        name: 'supervisor.categories',
        component: Categories,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/category/:id(\\d+)',
        name: 'supervisor.category',
        component: Category,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/category/create',
        name: 'supervisor.category.create',
        component: CategoryCreate,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/category/:id(\\d+)/edit',
        name: 'supervisor.category.edit',
        component: CategoryEdit,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/products',
        name: 'supervisor.products',
        component: Products,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/products/:id(\\d+)',
        name: 'supervisor.products.product',
        component: Product,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/products/create',
        name: 'supervisor.products.create',
        component: ProductCreate,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/products/:id(\\d+)/edit',
        name: 'supervisor.products.edit',
        component: ProductEdit,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/orders',
        name: 'supervisor.orders',
        component: Orders,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/orders/:id(\\d+)',
        name: 'supervisor.orders.order',
        component: Order,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/customers/:cid(\\d+)/orders/:oid(\\d+)/edit',
        name: 'supervisor.customers.orders.edit',
        component: OrderEdit,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/customers/:cid(\\d+)/orders/create',
        name: 'supervisor.customers.orders.create',
        component: OrderCreate,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/customers',
        name: 'supervisor.customers',
        component: Customers,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/customers/create',
        name: 'supervisor.customers.create',
        component: CustomersCreate,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/customers/:cid(\\d+)/edit',
        name: 'supervisor.customers.edit',
        component: CustomersEdit,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    },
    {
        path: '/supervisor/customers/:id(\\d+)',
        name: 'supervisor.customers.customer',
        component: Customer,
        meta : {
            middleware : "supervisor",
            layout : "SupervisorLayout"
        }
    }

];

export default routes;