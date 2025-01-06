<template>
    <div>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">customers</h1>

            </div>

            <!-- Content Row -->
            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h6 class="h6 text-muted">Create New customer</h6>
                            <Errors :errors="errors"></Errors>
                        </div>


                        <div v-if="saved" class="alert alert-success alert-dismissible fade show" role="alert">
                            {{message}}
                            <button @click="!saved" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="card-body">
                        <form >

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" v-model="customer.name"
                                    placeholder="name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" v-model="customer.email"
                                    placeholder="email" >
                            </div>

                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" v-model="customer.phone"
                                    placeholder="phone" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" v-model="customer.address"
                                    placeholder="address" required>
                            </div>
                            <button :disabled="processing" @click.prevent="createCustomer()"
                                class="btn btn-primary btn-user btn-block">
                                {{ processing ? "Saving..." : "Create" }}
                                <img v-show="processing" src="" alt="loading">
                            </button>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /.container-fluid -->


</template>

<script>
import Errors from '../../../inc/ValidationErrors.vue'

    export default {
        components : {
            Errors
        },
        data: function () {
            return {
                customer: {
                    name: null,
                    email: null,
                    phone: null,
                    address: null,
                    password : "$$hashedPassword200"
                },
                saved: false,
                message: null,
                processing: false,
                errors: null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        methods: {

            async createCustomer() {
                this.processing = true
                /* let formData = new FormData();

                for (let [key, value] of Object.entries(this.customer)) {

                    formData.append(key, value)

                } */
                console.table(this.customer)

                await axios.post("/api/customers", this.customer)
                    .then(res => {

                        this.saved = true
                        this.message = res.data.message

                    }).catch(err => {

                        this.errors = err.response.data.errors

                    }).finally(() => {
                        this.processing = false
                    })
            }
        },
        mounted() {

            document.name = "Store | customer - Create"


        }

    }

</script>

<style>

</style>
