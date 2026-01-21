<template>
    <div v-if="loadingCounts" class="flex justify-between flex-row items-center w-full gap-4 p-4">
        <div class="w-[22%] h-10">
            <Skeleton />
        </div>
        <div class="w-[22%] h-10">
            <Skeleton />
        </div>
        <div class="w-[22%] h-10">
            <Skeleton />
        </div>
        <div class="w-[22%] h-10">
            <Skeleton />
        </div>

    </div>
    <div v-else
        class="flex justify-between w-full flex-row sm:flex-wrap gap-4 font-mono font-semibold text-slate-600 tracking-wider lg:text-sm md:text-sm text-xs">
        <!-- <div class="lg:w-[22%] md:2/4 w-full relative p-3 shadow-md rounded-md border-r-4 border-r-indigo-600 ">
            <h4>Users</h4>
            <strong class="text-lg text-slate-700 ">{{ dashboard.users_count }}</strong>
            <div class="absolute right-3 top-[40%] ">
                <i class="pi pi-user"></i>
            </div>
        </div> -->
        
        <div class="lg:w-[22%] md:2/4 w-full  relative p-3 shadow-md rounded-md border-r-4 border-r-green-500">
            <h4>Revenue</h4>
            <strong class="text-lg text-slate-700">&#36;{{ dashboard.revenue }}</strong>
            <div class="absolute right-3 top-[40%] ">
                <i class="pi pi-money-bill"></i>
            </div>
        </div>
        <div class="lg:w-[22%] md:2/4 w-full relative p-3 shadow-md rounded-md border-r-4 border-r-rose-500 ">
            <h4>Products</h4>
            <strong class="text-lg text-slate-700">{{ dashboard.products_count }}</strong>
            <div class="absolute right-3 top-[40%] ">
                <i class="pi pi-shopping-bag"></i>
            </div>
        </div>
        <div class="lg:w-[22%] md:2/4 w-full relative  p-3 shadow-md rounded-md border-r-4 border-r-orange-500 ">
            <h4>Orders</h4>
            <strong class="text-lg text-slate-700">{{ dashboard.orders_count }}</strong>
            <div class="absolute right-3 top-[40%] ">
                <i class="pi pi-cart-plus"></i>
            </div>
        </div>
        <div class="lg:w-[22%] md:2/4 w-full  relative p-3 shadow-md rounded-md border-r-4 border-r-fuchsia-500 ">
            <h4>Customers</h4>
            <strong class="text-lg text-slate-700">{{ dashboard.customers_count }}</strong>
            <div class="absolute right-3 top-[40%] ">
                <i class="pi pi-users"></i>
            </div>
        </div>
    </div>
    <div class="w-full flex justify-between gap-3 flex-row my-5 ">
        <div class="lg:w-4/6 md:w-4/6 w-full shadow-md">
            <OrdersChart/>
        </div>
        <div class="lg:w-2/6 md:w-2/6 w-full shadow-md">
            <OrdersStatusChart/>
        </div>
    </div>
    <div class="w-full flex justify-between gap-3 flex-row my-5 ">
        <div class="lg:w-4/6 md:w-4/6 w-full shadow-md">
            <RevenueChart/>
        </div>
        <div class="lg:w-2/6 md:w-2/6 w-full shadow-md">
        <TopProducts />    
        </div>
    </div>
    
</template>

<script setup>
import { onMounted, ref } from 'vue';
import OrdersStatusChart from '@/Components/inc/OrdersStatusChart.vue'
import OrdersChart from '@/Components/inc/OrdersChart.vue'
import RevenueChart from '@/Components/inc/RevenueChart.vue'
import TopProducts from '@/Components/inc/TopProducts.vue'

const loadingCounts = ref(false)

const dashboard = ref([])
const getCounts = async () => {
    loadingCounts.value = true
    await axios.get("/api/counts")
        .then(res => {
            dashboard.value = res.data.data
        }).catch(err => {
            console.log(err)
        }).finally(() => {
            loadingCounts.value = false
        })
}

onMounted(async () => {
    await getCounts()
})
</script>