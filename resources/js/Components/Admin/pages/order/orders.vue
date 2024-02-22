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
                    <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" single-line variant="outlined" hide-details>
                    </v-text-field>
                </template>

                <v-data-table hover :loading="loading" :headers="headers" :items="orders" :search="search">
                    <template v-slot:loading>
                        <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
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
</template>
<script setup>
import moment from 'moment'
import {
    VDataTable,
    VCard,
    VIcon,
    VSkeletonLoader,
    VTextField
} from 'vuetify/components'
import { onMounted , ref } from 'vue';

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
                    title: 'Actions',
                    key: 'actions',
                    sortable: false
                },
            ]);

const orders = ref([])
const search = ref('')
const loading = ref(true)

/*
import moment from 'moment'
import {
    VDataTable,
    VCard,
    VIcon,
    VSkeletonLoader,
    VTextField
} from 'vuetify/components'

export default {
    components : {
        VDataTable,
        VCard,VIcon,
        VSkeletonLoader,VTextField
    },

    data: function () {
        return {
            headers: [{
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
                    title: 'Actions',
                    key: 'actions',
                    sortable: false
                },
            ],
            orders: [],
            search: '',
            price: 0,
            loading: true
        };
    },
    methods: {
        async getOrders() {
            await axios.get("/api/orders").then(res => {
                this.orders = res.data.orders;
            }).catch(err => {
                console.log(err);
            }).finally(() => {
                this.loading = false;

            });
        },
        formateDate(date) {
            return moment(date).format("MMMM Do YYYY, h:mm:ss a");
        },
        currency(value) {
            let val = (value / 1).toFixed(2).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        warning(id) {
            Swal.fire({
                title: "Warning!",
                text: "Do you want to delete this order!",
                icon: "warning",
                confirmButtonText: "yes",
                showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    this.deleteOrder(id);
                }
            });
        },
        async deleteOrder(id) {
            await axios.delete(`/api/orders/${id}`).then(res => {
                Swal.fire({
                    title: "deleted!",
                    text: "Order Deleted Successfully..!",
                    icon: "success",
                    showCancelButton: true
                });
                this.getOrders();
            }).catch(err => {
                Swal.fire({
                    title: "error!",
                    text: "something went wrong..!",
                    icon: "error",
                    showCancelButton: true
                });
            });
        }
    },
    mounted() {
        this.getOrders();
        document.title = "Store | Orders";

    }
}
*/
</script>
<style>

</style>
