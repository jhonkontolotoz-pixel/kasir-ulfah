<template>
    
        <div class="card text-left border-b-2 border-slate-200 mb-4">
            <h4 class="p-2">Top Products</h4>
        </div>
            <DataTable :value="products"  class="text-xsm ">
                <Column  header="#" style="width: 5%">
                    <template #body="{index}">
                        {{ index + 1 }}
                    </template>
                    </Column>
                <Column field="image" header="Image"  style="width: 5%">
                    <template #body="slotProps">
                        <router-link :to="{name : 'admin.products.product' , params : {id : slotProps.data.id}}"><img class="block w-7 h-7 rounded-sm" alt="cover" :src="slotProps.data?.image ? '/storage/'+ slotProps.data?.image : '/storage/default.png'"></router-link>
                    </template>
                </Column>
                <Column field="title" header="Title"  style="width: 10%;text-overflow: ellipsis;"></Column>
                <Column field="sold_count" header="Sold"  style="width: 5%"></Column>
            </DataTable>
</template>

<script setup>

import {ref, onMounted } from 'vue';

const products = ref([])

async function getProducts() {
    
    await axios.get(`/api/topProducts`).then(res => {
        products.value = res.data.data;
    }).catch(err => {
        console.log(err)
    })
}

onMounted(async () => {
    await getProducts()
})
</script>

<style scoped></style>