<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Orders</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <div class="col-md-12">

                <v-card eleveation="10">

                    <template v-slot:text>
                        <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" single-line
                            variant="outlined" hide-details>
                        </v-text-field>
                    </template>

                    <v-data-table hover :loading="loading" :headers="headers" :items="orders" :search="search">
                        <template v-slot:loading>
                            <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
                        </template>
                        <template v-slot:item.total_price="{ item }">
                            <v-icon size="small" class="m-0">mdi-currency-usd</v-icon>
                            {{ item.total_price }}
                        </template>
                        <template v-slot:item.created_at="{ item }">
                            {{ item.created_at }}
                        </template>

                        <template v-slot:item.actions="{ item }">
                            <v-icon size="small" class="me-2" @click="return">
                                mdi-pencil
                            </v-icon>
                            <v-icon size="small" @click="warning(item.id)">
                                mdi-delete
                            </v-icon>
                        </template>
                    </v-data-table>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    onMounted,
    ref
} from 'vue';

import {
    VDataTable,
    VCard,
    VIcon,
    VSkeletonLoader,
    VTextField
} from 'vuetify/components'


const headers = ref([{
    title: 'Id',
    key: 'id'
},
{
    title: 'Status',
    key: 'status'
},
{
    title: 'Price',
    key: 'total_price'
},
{
    title: 'Customer',
    key: 'user.name'
},
{
    title: 'Created',
    key: 'created_at'
},
{
    title: 'Actions',
    key: 'actions',
    sortable: false
},
]);

const orders = ref([])
const search = ref('')
const loading = ref(true)



async function getOrders() {

    await axios.get("/api/orders").then(res => {
        orders.value = res.data.orders;
    }).catch(err => {
        console.log(err);
    }).finally(() => {
        loading.value = false;

    });
}



function warning(id) {
    Swal.fire({
        title: "Warning!",
        text: "Do you want to delete this order!",
        icon: "warning",
        confirmButtonText: "yes",
        showCancelButton: true
    }).then(res => {
        if (res.isConfirmed) {
            deleteOrder(id);
        }
    });
}

async function deleteOrder(id) {
    await axios.delete(`/api/orders/${id}`).then(res => {
        Swal.fire({
            title: "deleted!",
            text: "Order Deleted Successfully..!",
            icon: "success",
            showCancelButton: true
        });
        getOrders();
    }).catch(err => {
        Swal.fire({
            title: "error!",
            text: "something went wrong..!",
            icon: "error",
            showCancelButton: true
        });
    });
}


onMounted(() => {
    getOrders();
    document.title = "Store | Orders";
})


</script>

<style></style>
