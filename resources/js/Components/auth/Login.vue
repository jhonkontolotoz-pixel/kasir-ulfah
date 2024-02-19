<template>

    <div class="col-md-12 col-lg-12 col-sm-12 ">
        <div class="row">
            <div class="container">
                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class=" col-md-6">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4 text-capitalize">{{$t("Welcome Back!")}}
                                                </h1>
                                            </div>
                                            <Errors :errors="errors"></Errors>

                                            <form class="user" @submit.prevent="login" method="post">

                                                <input type="hidden" name="_token" :value="csrf">
                                                <div class="form-group">
                                                    <input type="email" class="form-control form-control-user"
                                                        v-model="creds.email" id="exampleInputEmail" name="email"
                                                        aria-describedby="emailHelp" :placeholder="emailplaceholder"                                                 required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-user"
                                                        v-model="creds.password" id="exampleInputPassword"
                                                        name="password" :placeholder="passwordplaceholder" required >
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck" name="remember">
                                                        <label class="custom-control-label"
                                                            for="customCheck">{{$t('r-me')}}</label>
                                                    </div>
                                                </div>
                                                <button :disabled=processing
                                                    class="btn btn-primary btn-user btn-block text-capitalize">
                                                    {{processing ? $t('login')+"..." : $t('login')}}
                                                </button>
                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                <router-link class="small" :to="{name :'forgot-password'}">
                                                    {{$t('forgot-password')}}</router-link>
                                            </div>
                                            <div class="text-center">
                                                <router-link class="small" :to="{ name : 'register'}">
                                                    {{$t('create account')}}
                                                </router-link>
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

</template>

<script>
import Errors from '../inc/ValidationErrors.vue'

    import {
        mapActions,
        mapGetters
    } from 'vuex'
    import { wTrans } from 'laravel-vue-i18n'

    export default {
        components:{
            Errors
        },
        data() {
            return {
                errors: null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                processing: false,
                creds: {
                    email: 'san@houty.com',
                    password: 'mafifi96',
                },
                passwordplaceholder : wTrans("password"),
                emailplaceholder : wTrans("email")
            }
        },
        methods: {
            ...mapActions({
                signIn: 'login',
            }),
            async login() {
                this.processing = true
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/login', this.creds).then(res => {

                    window.axios.defaults.headers.common = {
                        'Authorization': `Bearer ${res.data.token}`
                    }

                    this.signIn()

                }).catch(err => {
                    this.errors = err.response.data.errors;
                    console.log(err)
                }).finally(() => {
                    this.processing = false
                })
            },
            redirectAuth() {
                if (this.$store.getters.isAdmin) {
                    this.$router.push({
                        name: 'dashboard'
                    })

                } else if (this.$store.getters.isSupervisor) {
                    this.$router.push({
                        name: 'supervisor.dashboard'
                    })
                }
            }

        },
        watch: {
            '$store.getters.authenticated': function () {
                this.redirectAuth()
            }
        },
        created() {
            document.title = "Store | Login"
        },
        mounted() {
            this.redirectAuth()

        }
    }

</script>
