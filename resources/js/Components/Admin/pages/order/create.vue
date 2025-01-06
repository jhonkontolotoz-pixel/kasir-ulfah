<template>
    <div>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Orders</h1>
            </div>

            <!-- Content Row -->
            <div class="row">


                <div class="col-sm-12 col-md-12 col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h6 class="h6 text-muted">Create New Order</h6>

                            <div class="alert alert-danger" v-if="errors ">
                                <ul>
                                    <li v-for="error in errors" :key="error" class="text-sm">
                                        {{ error[0] }}
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div v-if="saved" class="alert alert-success alert-dismissible fade show m-2" role="alert">
                            {{message}}
                            <button @click="!saved" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>


                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">


                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h4>orders</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item,index) in items" :key="index">
                                                        <td scope="row">
                                                            {{item.title}}
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number"
                                                                    class="form-control form-control-sm" min="1"
                                                                    name="quantity" placeholder="1" :max="item.quantity"
                                                                    v-model="item.currentQuantity">
                                                            </div>
                                                        </td>
                                                        <td>&dollar;{{currency(TotalPrice(item)) }}</td>
                                                        <td><button class="btn btn-danger  deletefromcart"
                                                                @click.prevent="deleteItem(item)"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">TotalPrice</td>
                                                        <td colspan="2">&dollar;{{net()}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="card-footer">
                                            <button v-if="items.length != 0" :disabled="processing"
                                                @click.prevent="confirmOrder()"
                                                class="btn btn-primary btn-user btn-block">
                                                {{ processing ? "Saving..." : "Create" }}
                                                <img v-show="processing" src="" alt="loading">
                                            </button>

                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            Customer`s Orders
                                        </div>
                                        <div class="card-body">
                                            <div class="accordion" id="oaccordion">

                                                <div class="accordion-item" v-for="(order , index) in orders"
                                                    :key="index">
                                                    <h2 class="accordion-header" :id="'oheading'+index">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            :data-bs-target="'#ocollapse'+index" aria-expanded="false"
                                                            :aria-controls="'ocollapse'+index">
                                                            {{formateDate(order.created_at)}}
                                                        </button>
                                                    </h2>
                                                    <div :id="'ocollapse'+index" class="accordion-collapse collapse"
                                                        :aria-labelledby="'oheading'+index" data-bs-parent="#oaccordion">
                                                        <div class="accordion-body table-responsive">
                                                            <table class="table ">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">name</th>
                                                                        <th scope="col">quantity</th>
                                                                        <th scope="col">price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(product,index) in order.products"
                                                                        :key="index">
                                                                        <td scope="row">
                                                                            <router-link
                                                                                :to="{name :'admin.products.product', params :{id : product.id}}">
                                                                                {{product.title}}
                                                                            </router-link>
                                                                        </td>
                                                                        <td>{{product.pivot.quantity}}</td>
                                                                        <td>&dollar;{{currency(product.price) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <strong class="text-bold">TotalPrice  &dollar;{{total_price}}
                                            </strong>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6">

                                    <div class="card">
                                        <div class="card-header">
                                            <h4>categories</h4>
                                        </div>
                                        <div class="card-body">

                                            <div class="accordion" id="caccordion">

                                                <div class="accordion-item" v-for="(category , index) in categories"
                                                    :key="index">
                                                    <h2 class="accordion-header" :id="'cheading'+index">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            :data-bs-target="'#ccollapse'+index" aria-expanded="false"
                                                            :aria-controls="'ccollapse'+index">
                                                            {{category.name}}
                                                        </button>
                                                    </h2>
                                                    <div :id="'ccollapse'+index" class="accordion-collapse collapse"
                                                        :aria-labelledby="'cheading'+index" data-bs-parent="#caccordion">
                                                        <div class="accordion-body table-responsive">
                                                            <table class="table ">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">name</th>
                                                                        <th scope="col">quantity</th>
                                                                        <th scope="col">price</th>
                                                                        <th scope="col">add</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(product,index) in category.products"
                                                                        :key="index">
                                                                        <td scope="row">
                                                                            <router-link
                                                                                :to="{name :'admin.products.product', params :{id : product.id}}">
                                                                                {{product.title}}
                                                                            </router-link>
                                                                        </td>
                                                                        <td>{{product.quantity}}</td>
                                                                        <td>&dollar;{{currency(product.price) }}</td>
                                                                        <td class="text-center"><button type="button"
                                                                                @click.prevent="addItem(product)"
                                                                                :data-item=product
                                                                                class="btn btn-info add"
                                                                                :id="product.id">
                                                                                <i class="fas fa-plus"></i></button>
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</template>

<script>
    
    export default {
        data: function () {
            return {
                categories: [],
                items: [],
                product: {},
                orders: [],
                CID: this.$route.params.cid,
                saved: false,
                message: null,
                processing: false,
                errors: null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                total_price: 0
            }
        },
        methods: {
            async getCategories() {

                await axios.get(`/api/categories`)
                    .then(res => {
                        this.categories = res.data
                    }).catch(err => {
                        console.log(err)

                    })
            },
            async getOrders() {
                await axios.get(`/api/customers/${this.CID}/orders`)
                    .then(res => {
                        this.orders = res.data.orders
                        this.total_price = res.data.total_price
                    }).catch(err => {
                        console.log(err)
                    })
            },
            addItem(item) {

                const isFound = this.items.find(el => {

                    if (el.id === item.id) {
                        return true
                    }

                    return false
                })

                if (!isFound) {

                    item['currentQuantity'] = 1
                    this.items.push(item)
                    document.getElementById(item.id).disabled = true
                }
            },
            deleteItem(item) {
                this.items.pop(item)
                document.getElementById(item.id).disabled = false

            },
            currency(value) {
                let val = (value / 1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            formateDate(date) {
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            },
            TotalPrice(item) {

                return item.price * item.currentQuantity
            },
            net() {
                let total = this.items.reduce((t, p) => {
                    return t += (p.price * p.currentQuantity)
                }, 0)

                return this.currency(total)
            },
            async confirmOrder() {
                this.processing = true
                await axios.post("/api/order/confirm", [this.items, this.CID]).then(res => {
                    this.saved = true
                    this.message = res.data.message
                    let els = document.getElementsByClassName("add");
                    for (let i = 0; i < els.length; i++) {
                        els[i].disabled = false
                    }
                    this.items = []

                }).catch(err => {

                    console.log(err)

                }).finally(() => {
                    this.processing = false
                    this.getCategories()
                    this.getOrders()
                })
            }
        },
        mounted() {

            document.name = "Store | Order - Create"
            this.getCategories()
            this.getOrders()
        }

    }

</script>

<style>

</style>
