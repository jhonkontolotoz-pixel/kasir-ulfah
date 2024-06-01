<template>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>

        <router-link :to="{name : 'admin.category.create'}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm "></i>
            Create Category</router-link>

    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-md-12">

            <v-card eleveation="10">

                <template v-slot:text>
                    <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" single-line variant="outlined" hide-details>
                    </v-text-field>
                </template>

                <v-data-table hover :loading="loading" :headers="headers" :items="categories" :search="search">
                    <template v-slot:loading>
                        <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
                    </template>
                    <template v-slot:item.created_at="{item}">
                        {{ item.created_at }}
                    </template>
                    <template v-slot:item.updated_at="{item}">
                        {{ item.updated_at }}
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

const categories = ref([])
const headers = ref([{
        title: 'Name',
        key: 'name'
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
const search = ref('')
const loading = ref(true)

async function getCategories() {
    await axios.get("/api/categories").then(res => {
        categories.value = res.data;
    }).catch(err => {
        console.log(err)
    }).finally(() => {
        loading.value = false
    })
}

onMounted(() => {
    getCategories()
    document.title = "Store | Categories"
})
</script>

<style scoped>

</style>
