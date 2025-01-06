<template>
<div class="h-16 border-b flex justify-center items-center">
  
</div>
    <ul class="text-gray-600 py-3 p-2 flex justify-start flex-col gap-2 font-medium size tex-md tracking-wide text-nowrap">
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" :to="{ name: 'admin.dashboard' }"><span class="pi pi-home px-2"></span>Dashboard</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" :to="{ name: 'admin.categories' }"><span class="pi pi-list px-2"></span>Categories</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" :to="{ name: 'admin.products' }"><span class="pi pi-shopping-bag px-2"></span>Products</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" :to="{ name: 'admin.orders' }"><span class="pi pi-shopping-cart px-2"></span>Orders</router-link></li>
        <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" :to="{ name: 'admin.customers' }"><span class="pi pi-users px-2"></span>Customers</router-link></li>
<!--         <li class="hover:text-indigo-500 "><router-link class="block pl-1 pr-3 py-2.5" to="/admin/settings"><span class="pi pi-cog px-2"></span>Settings</router-link></li>
 -->    </ul>
</template>
<script setup>
</script>
<style></style>