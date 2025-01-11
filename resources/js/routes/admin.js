const routes = [
    {
        path: '/dashboard',
        name: 'admin.dashboard',
        component: () => import('@/Components/Admin/pages/Dashboard.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : 'Dashboard',
        }
    },
    {
        path: '/admin/categories',
        name: 'admin.categories',
        component: () => import('@/Components/Admin/pages/category/categories.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : 'Categories'
        }
    },
    {
        path: '/admin/categories/:id(\\d+)',
        name: 'admin.categories.category',
        component: () => import('@/Components/Admin/pages/category/category.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Categories"

        }
    },
    {
        path: '/admin/categories/create',
        name: 'admin.category.create',
        component: () => import('@/Components/Admin/pages/category/create.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Categories Create"
        }
    },
    {
        path: '/admin/categories/:id(\\d+)/edit',
        name: 'admin.category.edit',
        component: () => import('@/Components/Admin/pages/category/edit.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Categories Edit"
        }
    },
    {
        path: '/admin/products',
        name: 'admin.products',
        component: () => import('@/Components/Admin/pages/product/products.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : 'Products'
        }
    },
    {
        path: '/admin/products/:id(\\d+)',
        name: 'admin.products.product',
        component: () => import('@/Components/Admin/pages/product/product.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title  : 'Products'
        }
    },
    {
        path: '/admin/products/create',
        name: 'admin.products.create',
        component: () => import('@/Components/Admin/pages/product/create.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : 'Create Product',
        }
    },
    {
        path: '/admin/products/:id(\\d+)/edit',
        name: 'admin.products.edit',
        component: () => import('@/Components/Admin/pages/product/edit.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Products Edit"
        }
    },
    {
        path: '/admin/orders',
        name: 'admin.orders',
        component: () => import('@/Components/Admin/pages/order/orders.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Orders"
        }
    },
    {
        path: '/admin/orders/:id(\\d+)',
        name: 'admin.orders.order',
        component: () => import('@/Components/Admin/pages/order/order.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Orders"
        }
    },
    {
        path: '/admin/orders/:id(\\d+)/edit',
        name: 'admin.orders.edit',
        component: () => import('@/Components/Admin/pages/order/edit.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            titel : "Orders Edit"
        }
    },
    {
        path: '/admin/orders/create',
        name: 'admin.orders.create',
        component: () => import('@/Components/Admin/pages/order/create.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Orders Create"
        }
    },
    {
        path: '/admin/customers',
        name: 'admin.customers',
        component: () => import('@/Components/Admin/pages/customer/customers.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Customers"
        }
    },
    {
        path: '/admin/customers/create',
        name: 'admin.customers.create',
        component: () => import('@/Components/Admin/pages/customer/create.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Customers Create"
        }
    },
    {
        path: '/admin/customers/:id(\\d+)/edit',
        name: 'admin.customers.edit',
        component: () => import('@/Components/Admin/pages/customer/edit.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : "Customer Edit"
        }
    },
    {
        path: '/admin/customers/:id(\\d+)',
        name: 'admin.customers.customer',
        component: () => import('@/Components/Admin/pages/customer/customer.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : 'Customers'
        }
    },
    {
        path: '/admin/cart',
        name: 'admin.cart',
        component: () => import('@/Components/Admin/pages/cart/cart.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            title : 'Cart'
        }
    },
    {
        path: '/admin/pos',
        name: 'admin.pos',
        component: () => import('@/Components/Admin/pages/pos/pos.vue'),
        meta : {
            requiresAuth: true,
            layout : "AdminLayout",
            titlle : "POS"
        }
    } 
];

export default routes
