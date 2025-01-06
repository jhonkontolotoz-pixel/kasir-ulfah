<template>
<div>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">customers</h1>
            <router-link :to="{name : 'admin.customers.create'}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm "></i>
                Create customer</router-link>
        </div>

        <!-- Content Row -->
        <div class="row">

            <div class="col-md-12">

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
</div>
</template>

<script setup>

import {
    onMounted,
    ref
} from 'vue';


const headers = ref([{
        title: 'Name',
        key: 'name'
    },
    {
        title: 'Phone',
        key: 'phone'
    },
    {
        title: 'Email',
        key: 'email'
    },
    {
        title: 'address',
        key: 'address'
    },

    {
        title: 'Created',
        key: 'created_at'
    },
    {
        title: 'Actions',
        key: 'actions',
        sortable: false
    }

])

const customers = ref([])
const search = ref('')
const loading = ref(true)
const _id = ref('')

async function getcustomers() {
    await axios.get("/api/customers").then(res => {

        customers.value = res.data.customers;

    }).catch(err => {
        console.log(err)
    }).finally(() => {
        loading.value = false
    })

}

function warning(id) {
    _id.value = id
    Swal.fire({
        title: 'Warning!',
        text: 'Do you want to delete this customer!',
        icon: 'warning',
        confirmButtonText: 'yes',
        showCancelButton: true
    }).then(res => {
        if (res.isConfirmed) {
            deletecustomer(id)
        }
    })
}

async function deletecustomer(id) {

    await axios.delete(`/api/customers/${_id.value}`).then(res => {

        Swal.fire({
            title: 'deleted!',
            text: 'customer Deleted Successfully..!',
            icon: 'success',
            showCancelButton: true
        })
        getcustomers()
    }).catch(err => {

        Swal.fire({
            title: 'error!',
            text: 'something went wrong..!',
            icon: 'error',
            showCancelButton: true
        })

    })

}

onMounted(() => {
    getcustomers()
    document.title = "Store | customers"
})

</script>

<style>

</style>
