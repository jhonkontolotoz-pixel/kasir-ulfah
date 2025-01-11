<template>
    <Toast />
    <ConfirmDialog></ConfirmDialog>
    
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
                <Button v-tooltip.bottom="{ value: 'Create Product', pt: { text: '!text-[0.7rem]' } }" type="text"
                    class="self-center  " severity="contrast" as="router-link" variant="text" icon="pi pi-plus" size="small"
                    to="/admin/products/create" />
                <Button v-tooltip.bottom="{ value: 'Export as PDF', pt: { text: '!text-[0.7rem]' } }" type="text"
                    class="self-center  " severity="contrast" variant="text" icon="pi pi-file-pdf" size="small" />
                <Button v-tooltip.bottom="{ value: 'Refresh Data', pt: { text: '!text-[0.7rem]' } }" type="text"
                    class="self-center " severity="contrast" variant="text" icon="pi pi-refresh" size="small"
                    @click.prevent="getProducts(_page,_rows)" />

            </div>


        </div>

        <template v-if="loading">
            <DataTable :value="dummyProducts" tableStyle="min-width: 50rem;" class="text-sm">
                <Column field="sku" header="Code" style="width: 10%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="image" header="Image" sortable style="width: 10%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="title" header="Title" sortable style="width: 25%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="price" header="Price" sortable style="width: 5%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="quantity" header="Quantity" style="width: 5%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="category_name" header="Category" sortable style="width: 10%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="created_at" header="Created At" style="width: 15%">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
            </DataTable>
        </template>
        <template v-else>
            <DataTable :value="products" tableStyle="min-width: 50rem;" class="text-sm">

                <Column  header="#" style="width: 5%">
                    <template #body="{index}">
                        {{ index + 1 }}
                    </template>
                    </Column>
                <Column field="image" header="Image" sortable style="width: 10%">
                    <template #body="slotProps">
                        <router-link :to="{name : 'admin.products.product' , params : {id : slotProps.data.id}}"><img class="block w-7 h-7 rounded-sm" alt="cover" :src="slotProps.data?.image ? '/storage/'+ slotProps.data?.image : '/storage/default.png'"></router-link>
                    </template>
                </Column>
                <Column field="sku" header="SKU" style="width: 15%"></Column>
                <Column field="title" header="Title" sortable style="width: 25%">
                </Column>
                <Column field="price" header="Price" sortable style="width: 5%">
                    <template #body="slotProps">
                        ${{slotProps.data.price}}
                    </template>
                </Column>
                <Column field="quantity" header="Quantity" style="width: 5%">
                </Column>
                <Column field="category_name" header="Category" sortable style="width: 10%">
                    <template #body="slotProps">
                        <router-link :to="{name : 'admin.categories.category' , params : {id : slotProps.data?.category_id}}">{{ slotProps.data?.category_name }}</router-link>
                        </template>
                </Column>
                <Column field="created_at" header="Created At" style="width: 15%">
                </Column>
                <Column style="width: 5%">
                    <template #body="slotProps">
                        <div class="flex gap-1 ">
                            <Button v-tooltip.bottom="{ value: 'Edit', pt: { text: '!text-[0.6rem]' } }" type="text"
                                class="self-center" as="router-link" icon="pi pi-pen-to-square"
                                :to="'/admin/products/' + slotProps.data.id + '/edit'" iconClass="!text-sm !text-gray-700"
                                variant="text" size="small" />
                            <Button @click="deleteRecord(slotProps.data.id)"
                                v-tooltip.bottom="{ value: 'Delete', pt: { text: '!text-[0.6rem]' } }" class="self-center "
                                variant="text" icon="pi pi-trash" iconClass="!text-sm !text-gray-700" size="small" />
                        </div>

                    </template>
                </Column>

            </DataTable>
        </template>

        <div class="card">
            <Paginator :rows="_rows" @page="(page) => { _page = page.page + 1 }" @update:rows="(rows) => { _rows = rows }"
                :totalRecords="_total" :rowsPerPageOptions="[5, 10, 20, 50]"></Paginator>
        </div>
</template>

<script setup>
import {  ref, watchEffect } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from 'primevue/usetoast';
import ConfirmDialog from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
const toast = useToast();
const auth = useAuthStore()
const products = ref([])
const search = ref('')
const loading = ref(false)
const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Products', icon: 'pi pi-shopping-bag' },
])
const _total = ref(0)
const _rows = ref(10)
const _page = ref(1)
const dummyProducts = ref(new Array(_rows.value))


async function getProducts(page = 1, rows = 10) {
    loading.value = true
    await axios.get(`/api/products?page=${page}&limit=${rows}`).then(res => {
        products.value = res.data.data;
        _total.value = res.data.pagination.total
        _rows.value = res.data.pagination.per_page
    }).catch(err => {
        console.log(err)
    }).finally(() => {
        loading.value = false
    })
}


async function deleteProduct(id) {

    await axios.delete(`/api/products/${id}`).then(res => {
        toast.add({ severity: 'info', summary: 'Deleted', detail: 'Record deleted', life: 4000 });
        getProducts(_page.value, _rows.value)
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
            deleteProduct(id)
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};


watchEffect(async () => {
    await getProducts(_page.value, _rows.value)
})

</script>

<style scoped></style>
