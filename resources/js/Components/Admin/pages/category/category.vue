<template>
    <Toast />
    <ConfirmDialog />
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
            <Button v-tooltip.bottom="{ value: 'Create Category', pt: { text: '!text-[0.7rem]' } }" variant="text"
                type="text" class="self-center" as="router-link" severity="contrast" icon="pi pi-plus"
                to="/admin/categories/create" />
            <Button v-tooltip.bottom="{ value: 'Delete', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-trash" @click.prevent="deleteRecord(category.id)" />
        </div>

    </div>

    <div v-if="loading" class="w-full p-3">
        <div class="flex gap-3 flex-col">
            <div class="w-full mb-3 h-3">
                <Skeleton />
            </div>
            <div class="w-full mb-3 h-3">
                <Skeleton />
            </div>
        </div>
    </div>

    <div v-else class="card flex w-full flex-col gap-3 p-3">
        <div class="flex gap-3 flex-col">
            <div class="w-full mb-3">
                <label class=" font-medium mb-2 block">Name</label>
                <p>{{ category.name }}</p>
            </div>
            <div class="w-full mb-3">
                <label for="title" class=" font-medium mb-2 block">Description</label>
                <p v-html="category.description"></p>
            </div>
        </div>
        <label class=" font-medium mb-2 block">Products: {{ category?.products?.length }}</label>
        <div class="flex flex-wrap ">
                <div class="w-full lg:w-1/4 md:w-2/4 p-3 mb-2" v-for="product in category.products" :key="product.id" style="overflow: hidden">
                    <div class="shadow ">
                        <div class="w-full h-24 overflow-hidden rounded shadow border-b">
                            <template v-if="product.image">
                            <img :src="'/storage/' + product?.image" alt="Product Image" class="block" />
                        </template>
                        <template v-else>
                            <img :src="'/storage/default.png'" alt="Product Image" class="block align-middle object-cover"/>
                        </template>
                    </div>
                    <div class="p-3">
                        <h5 class="text-sm">{{ product.title }}</h5>
                        <div class="flex justify-center mt-1">
                            <Button icon="pi pi-shopping-cart" @click="cart.addToCart(product)" severity="secondary" class="w-full" variant="text"  />
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useRoute } from 'vue-router';
import { useConfirm } from "primevue/useconfirm";
import {useCartStore} from '@/store/cart'

const cart = useCartStore()
const confirm = useConfirm();
const toast = useToast();
const loading = ref(false);
const route = useRoute();
const category = ref({})

const getCategoryName = computed(() => category.value.name)

const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Categories', icon: 'pi pi-list', route: { name: 'admin.categories' } },
    { label: getCategoryName },

])


async function getCategory(id) {

    loading.value = true

    await axios.get(`/api/categories/${id}`).then(res => {
        category.value = res.data.data
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Fetch Record!', life: 4000 });
    }).finally(() => {
        loading.value = false
    })

}


async function deleteCategory(id) {
    await axios.delete(`/api/categories/${id}`).then(res => {
        toast.add({ severity: 'success', summary: 'Deleted', detail: 'Record deleted', life: 4000 });
        getCategories(_page.value, _rows.value)
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Delete Record!', life: 4000 });
    })

}


const deleteRecord = (id) => {
    confirm.require({
        message: 'Do you want to delete this record?',
        header: 'Danger Zone',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Cancel',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity: 'danger'
        },
        accept: () => {
            deleteCategory(id)
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};


onMounted(async () => {

    await getCategory(route.params.id)
})

</script>

<style scoped></style>
