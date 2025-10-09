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
        <form @submit.prevent="updateProduct" enctype="multipart/form-data" class="w-full">
            <div class="flex gap-6 mb-3">

                <div class="inputs lg:w-3/4 md:w-3/4 w-full">

                    <div class="flex mb-4 ">
                        <div class="w-full">

                            <label for="title" class=" font-medium mb-2 block">Title</label>
                            <InputText inputId="title" v-model="product.title" type="text" placeholder="Title"
                                class="w-full " />
                        </div>
                    </div>
                    <div class="flex justify-between gap-2 mb-4">
                        <div class="w-full">
                            <label for="price" class=" font-medium mb-2 block">Price</label>
                            <InputNumber inputId="price" v-model="product.price" type="umber" placeholder="Price"
                                class="w-full" />
                        </div>
                        <div class="w-full">
                            <label for="quantity" class="font-medium mb-2 block">Quantity</label>
                            <InputNumber inputId="quantity" v-model="product.quantity" type="number" placeholder="Quantity"
                                class="w-full" />
                        </div>
                    </div>

                    <div class="w-full">
                        <Editor v-model="product.description" editorStyle="height: 320px" />
                    </div>


                </div>

                <div class="fileupload flex flex-col gap-4 lg:w-1/4 md:w-1/4 w-full">
                    <div class="w-full ">
                        <label class=" font-medium mb-2 block">Category</label>
                        <Select v-model="product.category_id" :options="categories" option-value="id" optionLabel="name"
                            placeholder="Select a Category" class="!w-full md:w-56" />
                    </div>
                    <div class="w-full">
                        <label class=" font-medium mb-2 block">Image</label>

                            <img :src="product?.image ? '/storage/' + product?.image : '/imgs/default.png'" alt="Product Image"
                                class="shadow-md rounded-xl w-full sm:w-64" style="filter: grayscale(100%)" />

                    </div>
                    <div class="w-full">
                        <label class=" font-medium mb-2 block">Update Image</label>
                        <FileUpload mode="basic" choose-label="Product Image" choose-icon="pi pi-upload"
                            @select="onFileSelect" customUpload
                            class="!w-full  !text-slate-600 !bg-none  !bg-transparent ring-gray-200 !border-gray-200 !py-2 !px-3 !m-0 ! !border-2 " />
                        <img v-if="src" :src="src" alt="Image" class="shadow-md rounded-xl w-full sm:w-64"
                            style="filter: grayscale(100%)" />
                    </div>

                </div>
            </div>
            <div class="flex">
                <Button type="submit" :label="updating ? 'Updating' : 'Update'" icon="pi pi-save" :disabled="updating" severity="contrast"
                    raised></Button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from 'primevue/usetoast';
import { useRoute } from 'vue-router'

const route = useRoute()
const toast = useToast();
const auth = useAuthStore()
const categories = ref([])
const updating = ref(false)
const src = ref(null);
const loadingProduct = ref(true)
const product = ref({
    title: null,
    description: null,
    price: null,
    quantity: null,
    category_id: null,
    image: null,
})
const newImage = ref(null)

const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Products', icon: 'pi pi-shopping-bag', route: { name: 'admin.products' } },
    { label: 'Edit Product', icon: 'pi pi-plus' },

])


async function getCategories() {
    await axios.get("/api/categories")
        .then(res => { categories.value = res.data.data })
}


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


async function updateProduct() {

    updating.value = true

    const formData = new FormData();

    if (newImage.value) {
        product.value.image = newImage.value
    }else{
      delete product.value.image
    }

    for (const key in product.value) {
        formData.append(key, product.value[key])
    }

    formData.append('_method', 'put')

    await axios.post(`/api/products/${route.params.id}`, formData).then(res => {
        toast.add({ severity: 'success', summary: 'Updated', detail: 'Product Updated Successfully', life: 4000 });
        getProduct()
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Update Record!', life: 4000 });
    }).finally(() => {
        updating.value = false
    })

}

function onFileSelect(event) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        src.value = e.target.result;
    };

    newImage.value = file
    reader.readAsDataURL(file);
}

onMounted(async () => {
    await getCategories()
    await getProduct()
})



</script>

<style scoped></style>
