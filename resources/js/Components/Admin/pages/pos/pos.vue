<template>
    
    <div v-if="loadingCounts" class="flex justify-between flex-row items-center  gap-4 p-4">
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
    <div v-else class="flex justify-between flex-row  gap-4">
        <div class="w-[22%] rounded p-3">
            <strong>{{ dashboard.users_count }}</strong>
        </div>
        <div class="w-[22%] rounded p-3">
            <strong>{{ dashboard.customers_count }}</strong>
        </div>
        <div class="w-[22%] rounded p-3">
            <strong>{{ dashboard.products_count }}</strong>
        </div>
        <div class="w-[22%] rounded p-3">
            <strong>{{ dashboard.orders_count }}</strong>
        </div>

    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from 'primevue/usetoast';
import { useRoute } from 'vue-router'

const route = useRoute()
const toast = useToast();
const auth = useAuthStore()
const loadingCounts = ref(false)
const loadingSalesChart = ref(false)
const loadingCustomersChart = ref(false)
const dashboard = ref([])

const getCounts = async () => {
    loadingCounts.value = true
    await axios.get("/api/counts")
    .then(res => {
        dashboard.value = res.data.data
    }).catch(err => {
        console.log(err)
    }).finally(()=>{
        loadingCounts.value = false
    })
}

onMounted(async () => {
    await getCounts()
})

</script>


<style scoped></style>
