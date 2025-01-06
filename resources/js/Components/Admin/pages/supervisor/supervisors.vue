<template>
<div>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Supervisors</h1>
            <router-link :to="{name : 'admin.supervisors.create'}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm "></i>
                Create supervisor</router-link>
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

const supervisors = ref([])
const search = ref('')
const loading = ref(true)

async function getsupervisors() {
   await axios.get("/api/supervisors").then(res => {

        supervisors.value = res.data.supervisors;

    }).catch(err => {
        console.log(err)
    }).finally(()=>{
        loading.value = false
    })
}

function warning(id) {

    Swal.fire({
        title: 'Warning!',
        text: 'Do you want to delete this supervisor!',
        icon: 'warning',
        confirmButtonText: 'yes',
        showCancelButton: true
    }).then(res => {
        if (res.isConfirmed) {
            deletesupervisor(id)
        }
    })
}

async function deletesupervisor(id) {

    await axios.delete(`/api/supervisors/${id}`).then(res => {

        Swal.fire({
            title: 'deleted!',
            text: 'supervisor Deleted Successfully..!',
            icon: 'success',
            showCancelButton: true
        })
        getsupervisors()
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
    getsupervisors()
    document.title = "Store | supervisors"

})
</script>

<style>

</style>
