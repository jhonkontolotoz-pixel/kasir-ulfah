<template>
<div>
    <div class="dialog">
        <div class="card">
            <div class="card-header">
                <h4>Are You Sure You Want To Delete This Item ?</h4>
            </div>
            <div class="card-body" style="padding:10px;text-align:center;">
                <div class="btn-group">
                    <a class="btn btn-danger mx-4" @click.prevent="deleteProduct()">Delete</a>
                    <a class="btn btn-primary" @click.prevent="cancel()">Cancel</a>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
            <router-link :to="{name : 'admin.products.create'}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm "></i>
                Create Product</router-link>
        </div>

        <!-- Content Row -->
        <div class="row">

            <div class="col-md-12">

                <!--
                <div class="card">
                    <div class="card-header">
                        <h6 class="h6 text-muted">All products</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <template v-if="loading">
                            <skeleton cols="8"></skeleton>
                        </template>
                        <template v-else>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Careated At</th>
                                        <th scope="col">Last Update</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="(product , index) in products" :key="product.id">
                                        <td scope="row">{{(index + 1)}}</td>
                                        <td>
                                            <router-link :to="{name : 'admin.products.product' , params : {id : product.id}}">
                                                {{product.title}}</router-link>
                                        </td>
                                        <td>{{product.price}}</td>
                                        <td>{{product.quantity}}</td>
                                        <td>
                                            <router-link :to="{name : 'admin.category' , params : {id : product.category.id}}" class="btn text-decoration-none">{{product.category.name}}</router-link>
                                        </td>
                                        <td>{{formateDate(product.created_at)}}</td>
                                        <td>{{formateDate(product.updated_at)}}</td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <router-link :to="{name : 'admin.products.edit', params : {id : product.id}}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </router-link>
                                                <a @click.prevent="warning(product.id)" :data-id="product.id" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </template>
                    </div>
                </div>
            -->

                <v-card eleveation="10">

                    <template v-slot:text>
                        <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" single-line variant="outlined" hide-details>
                        </v-text-field>
                    </template>

                    <v-data-table hover :loading="loading" :headers="headers" :items="products" :search="search">
                        <template v-slot:loading>
                            <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
                        </template>
                        <template v-slot:item.created_at="{item}">
                            {{item.created_at }}
                        </template>

                        <template v-slot:item.actions="{ item }">
                            <v-icon size="small" class="me-2" @click="return">
                                mdi-pencil
                            </v-icon>
                            <v-icon size="small" @click="return">
                                mdi-delete
                            </v-icon>
                        </template>
                    </v-data-table>
                </v-card>

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
import moment from 'moment'
import {
    VDataTable,
    VCard,
    VIcon,
    VSkeletonLoader,
    VTextField
} from 'vuetify/components';

const headers = ref([{
        title: 'Title',
        key: 'title'
    },
    {
        title: 'Price',
        key: 'price'
    },
    {
        title: 'Quantity',
        key: 'quantity'
    },
    {
        title: 'Category',
        key: 'category.name'
    },
    {
        title: 'Quantity',
        key: 'quantity'
    },
    {
        title: 'Created',
        key: 'created_at'
    },
    {
        title: 'Updated',
        key: 'updated_at'
    },
    {
        title: 'Actions',
        key: 'actions',
        sortable: false
    },

])

const products = ref([])
const search = ref('')
const loading = ref(true)
const _id = ref('')

async function getProducts() {
    await axios.get("/api/products").then(res => {

        products.value = res.data;

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
        text: 'Do you want to delete this product!',
        icon: 'warning',
        confirmButtonText: 'yes',
        showCancelButton: true
    }).then(res => {
        if (res.isConfirmed) {
            deleteProduct(id)
        }
    })

}

async function deleteProduct(id) {

    await axios.delete(`/api/products/${id}`).then(res => {

        Swal.fire({
            title: 'deleted!',
            text: 'Product Deleted Successfully..!',
            icon: 'success',
            showCancelButton: true
        })
        getProducts()
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
    getProducts()
    document.title = "Store | Products"
})
</script>

<style scoped>

</style>
