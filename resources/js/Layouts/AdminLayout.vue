<template>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <router-link class="sidebar-brand d-flex align-items-center justify-content-center"
                :to="{name :'dashboard'}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">POS <sup>1</sup></div>
            </router-link>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <router-link class="nav-link " :to="{name : 'dashboard'}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></router-link>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <li class="nav-item">
                <router-link class="nav-link" :to="{name : 'admin.categories'}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Categories</span></router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{name :'admin.products'}">
                    <i class="fab fa-product-hunt"></i>
                    <span>Products</span></router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{name : 'admin.orders'}">
                    <i class="fa fa-shipping-fast"></i>
                    <span>Orders</span></router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{name : 'admin.customers'}">
                    <i class="fab fa-intercom"></i>
                    <span>Customers</span></router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{name : 'admin.supervisors'}">
                    <i class="fab fa-intercom"></i>
                    <span>Supervisors</span></router-link>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary text-white" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->

                            <div class="dropdown-menu dropdown-search dropdown-menu-right p-3 shadow animated--grow-in show" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" @click.prevent="dropdownToggle()" id="userDropdown"
                                role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ AuthUser.name }}</span>
                                <img class="img-profile rounded-circle" src="/imgs/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>

                                <form method="POST" action="/logout">

                                    <a class="btn btn-primary dropdown-item" data-toggle="modal"
                                        data-target="#logoutModal" @click.once.prevent="logout()">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </form>

                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->


                <router-view></router-view>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <ul class="list-style-type-none d-flex justify-content-center p-0"
                                style="list-style: none;">
                                <li class="m-2"><a class="text-decoration-none font-size-2" style="color: #555"
                                        href="https://www.facebook.com/silent.e3gle"><i
                                            class="fab fa-facebook-f"></i></a></li>
                                <li class="m-2"><a class="text-decoration-none font-size-2" style="color: #555"
                                        href="https://github.com/mafifi96/"><i class="fab fa-github"></i></a></li>
                                <li class="m-2"><a class="text-decoration-none font-size-2" style="color: #555"
                                        href="https://www.linkedin.com/in/mafifi-fstack-dev/"><i
                                            class="fab fa-linkedin"></i></a></li>
                                <li class="m-2"><a class="text-decoration-none font-size-2" style="color: #555"
                                        href="https://wa.me/+201093852164"><i class="fab fa-whatsapp"></i></a></li>
                            </ul>
                            <p class="text-center text-monospace text-capitalize py-2">developed by &commat;mohamed
                                afifi</p>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
</template>

<script>
    import {
        mapActions
    } from 'vuex'
    import {
        mapGetters
    } from 'vuex'

    export default {
        data: function () {
            return {

            }
        },
        computed: {
            ...mapGetters({
                AuthUser: 'user'
            })
        },
        methods: {
            ...mapActions({
                signout: 'logout'
            }),
            async logout() {
                await axios.post('/api/logout').then(res => {
                    window.axios.defaults.headers.common = {
                        'Authorization': ''
                    }
                    this.signout()
                    this.$router.push({
                        name: "login"
                    })
                }).catch(err => {
                    console.log(err)
                })
            },
            dropdownToggle() {

                $(".dropdown-menu").slideToggle();

            }

        },
        mounted()
        {

            $("#searchDropdown").click(function(e){
                e.preventDefault();
                $(".dropdown-search").toggleClass("show");
            });
            !function(l){"use strict";l("#sidebarToggle, #sidebarToggleTop").on("click",function(e){l("body").toggleClass("sidebar-toggled"),l(".sidebar").toggleClass("toggled"),l(".sidebar").hasClass("toggled")&&l(".sidebar .collapse").collapse("hide")}),l(window).resize(function(){l(window).width()<768&&l(".sidebar .collapse").collapse("hide"),l(window).width()<480&&!l(".sidebar").hasClass("toggled")&&(l("body").addClass("sidebar-toggled"),l(".sidebar").addClass("toggled"),l(".sidebar .collapse").collapse("hide"))}),l("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel",function(e){var o;768<l(window).width()&&(o=(o=e.originalEvent).wheelDelta||-o.detail,this.scrollTop+=30*(o<0?1:-1),e.preventDefault())}),l(document).on("scroll",function(){100<l(this).scrollTop()?l(".scroll-to-top").fadeIn():l(".scroll-to-top").fadeOut()}),l(document).on("click","a.scroll-to-top",function(e){var o=l(this);l("html, body").stop().animate({scrollTop:l(o.attr("href")).offset().top},1e3,"easeInOutExpo"),e.preventDefault()})}(jQuery);
        }

    }

</script>

<style scoped>


</style>
