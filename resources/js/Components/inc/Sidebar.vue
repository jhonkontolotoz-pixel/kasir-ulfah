<template>
    <div class="h-16 border-b flex justify-start items-center pl-5 ">
        <router-link :to="{ name: 'admin.dashboard' }"
            class="flex cursor-pointer border-none outline-none h-16 w-16 justify-center items-center overflow-hidden"><img
                class="block align-middle w-full h-full" src="@/assets/imgs/credit-card.png" alt="logo" /></router-link>
    </div>
    <ul
        class="text-gray-600 py-3 p-2 flex justify-start  flex-col gap-2 font-semibold text-md tracking-wide text-nowrap">
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5"
                :to="{ name: 'admin.dashboard' }"><span class="pi pi-home px-2"></span>Dashboard</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5"
                :to="{ name: 'admin.categories' }"><span class="pi pi-list px-2"></span>Categories</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5"
                :to="{ name: 'admin.products' }"><span class="pi pi-shopping-bag px-2"></span>Products</router-link>
        </li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5"
                :to="{ name: 'admin.orders' }"><span class="pi pi-shopping-cart px-2"></span>Orders</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5"
                :to="{ name: 'admin.customers' }"><span class="pi pi-users px-2"></span>Customers</router-link></li>
                <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5"
                :to="{ name: 'admin.pos' }"><span class="pi pi-shopping-cart px-2"></span>POS</router-link></li>
        <!--         <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" to="/admin/settings"><span class="pi pi-cog px-2"></span>Settings</router-link></li>
 -->
    </ul>
</template>
<script setup>
</script>
<style></style>