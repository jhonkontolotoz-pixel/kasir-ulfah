<template>
    <Toast />

    <div class="card flex justify-between">
        <div>
            <Breadcrumb :home="home" :model="items" class="mb-5 text-md">
                <template #item="{ item, props }">
                    <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                        <a :href="href" v-bind="props.action" @click="navigate">
                            <span :class="[item.icon, 'text-color']" />
                            <span class="text-primary font-semibold">{{ item.label }}</span>
                        </a>
                    </router-link>
                    <a v-else :href="item.url" :target="item.target" v-bind="props.action">
                        <span class="text-surface-700 dark:text-surface-0">{{ item.label }}</span>
                    </a>
                </template>
            </Breadcrumb>
        </div>
        <div class="flex gap-2">
                <Button v-tooltip.bottom="{ value: 'Edit Product', pt: { text: '!text-[0.7rem]' } }" type="text"
                    class="self-center" as="router-link" severity="contrast" variant="text" icon="pi pi-pen-to-square"

                    :to="'/admin/products/'+product.id+'/edit'" />
            </div>

    </div>
    <div v-if="loadingProduct" class="w-full ">
        <div class="flex gap-3">
            <div class=" lg:w-3/4 md:w-3/4 w-full">
                <div class="flex mb-4 ">
                    <div class="w-full">
                        <Skeleton />
                    </div>
                </div>
                <div class="flex justify-between gap-2 mb-4">
                    <div class="w-full">
                        <Skeleton />
                    </div>
                    <div class="w-full">
                        <Skeleton />
                    </div>
                </div>

                <div class="w-full h-16">
                    <Skeleton />
                </div>


            </div>

            <div class="fileupload flex flex-col gap-4 lg:w-1/4 md:w-1/4 w-full">
                <div class="w-full ">
                    <Skeleton />
                </div>
                <div class="w-full h-5">
                    <Skeleton />
                </div>
                <div class="w-full h-10">
                    <Skeleton />
                </div>

            </div>
        </div>
    </div>
    <div v-else class="card flex w-full p-3">

            <div class="flex gap-6 mb-3">

                <div class="inputs lg:w-3/4 md:w-3/4 w-full">

                    <div class="flex mb-4 ">
                        <div class="w-full">

                            <label for="title" class=" font-medium mb-2 block">Title</label>
                            <span>{{ product.title }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between gap-2 mb-4">
                        <div class="w-full">
                            <label for="price" class=" font-medium mb-2 block">Price</label>
                            <span>${{ product.price }}</span>
                        </div>
                        <div class="w-full">
                            <label for="quantity" class="font-medium mb-2 block">Quantity</label>
                            <span>{{ product.quantity }}</span>
                        </div>
                    </div>

                    <div class="w-full card flex">
                        <label class=" font-medium mb-2 block">Description</label>

                        <div v-html="product.description">

                        </div>
                    </div>


                </div>

                <div class="fileupload flex flex-col gap-4 lg:w-1/4 md:w-1/4 w-full">
                    <div v-if="product.category_name" class="w-full">
                        <label class=" font-medium mb-2 ">Category: </label>
                        <Button
                    class="p-3 !text-gray-700 hover:!text-black" as="router-link" variant="text"

                    :to="'/admin/categories/'+product.category_id" >{{ product.category_name }}</Button>
                    </div>
                    <div class="w-full">
                        <label class=" font-medium mb-2 block">Image</label>

                            <img :src="product?.image ? '/storage/' + product?.image : '/imgs/default.png'" alt="Product Image"
                                class="shadow-md rounded-xl w-full sm:w-64" style="filter: grayscale(100%)" />


                    </div>

                </div>
            </div>
    </div>
</template>

<script setup>
import { onMounted, ref , computed } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from 'primevue/usetoast';
import { useRoute } from 'vue-router'

const route = useRoute()
const toast = useToast();
const auth = useAuthStore()
const loadingProduct = ref(true)
const product = ref({
    title: null,
    description: null,
    price: null,
    quantity: null,
    category_id: null,
    image: null,
})

const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});

const getProductTitle = computed(()=> product.value.title)

const items = ref([
    { label: 'Products', icon: 'pi pi-shopping-bag', route: { name: 'admin.products' } },
    { label: getProductTitle , icon: 'pi pi-bag' , class: 'text-slate-50'},

])



async function getProduct() {

    loadingProduct.value = true
    await axios.get(`/api/products/${route.params.id}`).then(res => {

        product.value = res.data.data
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Get Record!', life: 4000 });
    }).finally(() => {

        loadingProduct.value = false
    })

}


onMounted(async () => {
    await getProduct()
})



</script>

<style scoped></style>
