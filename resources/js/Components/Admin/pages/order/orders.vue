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

            </div>
        </div>
    </div>
</template>

<script setup>
import {
    onMounted,
    ref
} from 'vue';



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
