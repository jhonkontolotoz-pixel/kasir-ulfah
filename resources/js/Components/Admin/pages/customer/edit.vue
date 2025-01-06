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
                            <h6 class="h6 text-muted">Update Customer</h6>
                            <Errors :errors="errors"></Errors>
                        </div>

                        <div v-if="saved" class="alert alert-success alert-dismissible fade show m-2" role="alert">
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
                            <button :disabled="processing" @click.prevent="updateCustomer()"
                                class="btn btn-primary btn-user btn-block">
                                {{ processing ? "Saving..." : "Update" }}
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
                    _method: "PATCH"
                },
                _id : this.$route.params.cid,
                saved: false,
                message: null,
                processing: false,
                errors: null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        methods: {

            async updateCustomer() {
                this.processing = true

                await axios.post(`/api/customers/${this._id}`, this.customer)
                    .then(res => {

                        this.saved = true
                        this.message = res.data.message

                    }).catch(err => {

                        this.errors = err.response.data.errors
                    }).finally(() => {
                        this.processing = false
                    })
            },
           async getCustomer(){
                await axios.get(`/api/customers/${this._id}/edit`)
                .then(res=>{
                    this.customer = res.data.customer
                }).catch(err=>{
                    console.log(err)
                    console.log("error to get customer")
                })
            }
        },
        mounted() {

            document.name = "Store | customer - Create"
            this.getCustomer()

        },
        watch : {
            '_id' : function(){
                this.getCustomer()
            }
        }

    }

</script>

<style>

</style>
