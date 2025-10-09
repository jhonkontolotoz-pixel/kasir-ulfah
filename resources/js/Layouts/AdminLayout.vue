<template>
    <div class="wrapper flex justify-center !font-sans-serif antialiased tracking-wide w-full overflow-hidden">
        <div class="sidebar bg-white text-sm leading-3 fixed left-0 top-0 bottom-0 border-r transition-width duration-500 ease-in-out !overflow-hidden z-50 !lg:block "
            :class="{ 'lg:w-1/6 w-0 ': isOpenSidebar, 'w-0': !isOpenSidebar }">
            <Sidebar />
        </div>
        <div class="content rounded-none transition-width  duration-500 ease-in-out"
            :class="{ 'lg:w-5/6 lg:ml-[16%] w-full': isOpenSidebar, 'lg:w-6/6 md:w-6/6 !w-full !ml-0': !isOpenSidebar }">
            <nav class=" flex flex-wrap justify-between items-center  border-b px-4 h-16  mb-5">
                <div>
                    <Button icon="pi pi-bars" severity="secondary" variant="text" rounded aria-label="bars"
                        @click="isOpenSidebar = !isOpenSidebar" />
                </div>

                <div class=" flex flex-wrap flex-row-reverse">
                    <div class="card flex flex-wrap justify-center flex-row-reverse gap-4 ">
                        <a class="flex !w-9 !h-9 cursor-pointer rounded-full hover:outline-1" @click="toggle"
                            aria-haspopup="true" aria-controls="overlay_menu"><img
                                class="block align-middle w-full h-full" src="@/assets/man.png"
                                alt="profile picture" /></a>
                        <Menu ref="menu" id="overlay_menu" :model="items" :popup="true" />
                        <Button icon="pi pi-bell" severity="secondary" variant="text" rounded
                            aria-label="Notification" />
                        <Button icon="pi pi-table" severity="secondary" variant="text" rounded aria-label="Table" />
                        <Button icon="pi pi-search" severity="secondary" variant="text" rounded aria-label="Search" />
                        <Button icon="pi pi-shopping-cart" severity="secondary" variant="text"   aria-label="Cart" :badge="getCartItems > 0 ? getCartItems : ''" badgeSeverity="contrast" as="router-link" to="/admin/cart" />

                    </div>
                </div>
            </nav>
            <div class="px-6 pb-6">
                <div class="card shadow-lg shadow-slate-100 ">
                    <router-view ></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref,computed } from 'vue'
    import Sidebar from '@/Components/inc/Sidebar.vue'
    import { useAuthStore } from '@/store/auth'
    import { useCartStore } from '@/store/cart'
    import { useRouter } from 'vue-router'
    import { storeToRefs } from 'pinia'

    const router = useRouter()
    const auth = useAuthStore()
    const cartStore = useCartStore()
    const {getCartItems} = storeToRefs(cartStore)
    const isOpenSidebar = ref(true)
    const menu = ref();
    const items = ref([
        {
            label: 'Documents',
            items: [
                {
                    label: 'New',
                    icon: 'pi pi-plus'
                },
                {
                    label: 'Search',
                    icon: 'pi pi-search'
                }
            ]
        },
        {
            label: 'Profile',
            items: [
                {
                    label: 'Settings',
                    icon: 'pi pi-cog'
                },
                {
                    label: 'Logout',
                    icon: 'pi pi-sign-out',
                    command: () => {
                        auth.logout()
                        return router.push({name : 'login'})
                    }
                }
            ]
        }
    ]);

    const cartItems = computed(() => getCartItems)

    const toggle = (event) => {
        menu.value.toggle(event);
    };
</script>
