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
        <div class="w-[22%]">

        </div>
        <div class="w-[22%]">

        </div>
        <div class="w-[22%]">

        </div>
        <div class="w-[22%]">

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


const getCounts = async () => {
    loadingCounts.value = true
    await axios.get("/api/counts")
    .then(res => {
        console.log(res.data.data)
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
