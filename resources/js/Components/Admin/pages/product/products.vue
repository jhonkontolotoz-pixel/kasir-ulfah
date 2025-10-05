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
            <Button v-tooltip.bottom="{ value: 'Clear Filters', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-filter-slash" @click="clearFilter()" />
            <Button v-tooltip.bottom="{ value: 'Create Product', pt: { text: '!text-[0.7rem]' } }" type="text"
                class="self-center  " severity="contrast" as="router-link" variant="text" icon="pi pi-plus" size="small"
                to="/admin/products/create" />
            <Button v-tooltip.bottom="{ value: 'Export as PDF', pt: { text: '!text-[0.7rem]' } }" type="text"
                class="self-center  " severity="contrast" variant="text" icon="pi pi-file-pdf" size="small" @click="download()" />
            <Button v-tooltip.bottom="{ value: 'Refresh Data', pt: { text: '!text-[0.7rem]' } }" type="text"
                class="self-center " severity="contrast" variant="text" icon="pi pi-refresh" size="small"
                @click.prevent="getProducts(_page, _rows, filters, sortBy)" />

        </div>


    </div>

    <DataTable :filter="false" v-model:filters="filters" filterDisplay="menu" dataKey="id" :loading="loading"
        @sort="sortData($event)" :value="computedData" tableStyle="min-width: 50rem;" class="text-sm">

        <template #loading>
            <TableLoader :cols="7" :rows="products.length > 7 ? 10 : 1" />
        </template>
        <Column header="#" style="width: 5%">
            <template #body="{ index }">
                {{ index + 1 }}
            </template>
        </Column>
        <Column field="image" header="Image" sortable style="width: 10%">
            <template #body="slotProps">
                <router-link :to="{ name: 'admin.products.product', params: { id: slotProps.data.id } }"><img
                        class="block w-7 h-7 rounded-sm" alt="cover"
                        :src="slotProps.data?.image ? '/storage/' + slotProps.data?.image : '/imgs/default.png'"></router-link>
            </template>
        </Column>
        <Column field="sku" header="SKU" style="width: 15%" filterMatchMode="contains" :showFilterMatchModes="false">
            <template #filter="{ filterModel }">
                <InputText v-model="filterModel.value" class="w-[1/2]" type="text" size="small"
                    placeholder="Search by SKU" />
            </template>
        </Column>
        <Column field="title" header="Title" sortable style="width: 25%" :showFilterMatchModes="false">
            <template #filter="{ filterModel }">
                <InputText v-model="filterModel.value" class="w-[1/2]" type="text" size="small"
                    placeholder="Search by Title" />
            </template>
        </Column>
        <Column field="price" header="Price" sortable style="width: 5%">
            <template #body="slotProps">
                ${{ slotProps.data.price }}
            </template>
        </Column>
        <Column field="quantity" header="Quantity" style="width: 5%">
        </Column>
        <Column field="category_name" header="Category" sortable style="width: 10%" :showFilterMatchModes="false">
            <template #body="slotProps">
                <router-link :to="{ name: 'admin.categories.category', params: { id: slotProps.data?.category_id } }">{{
                    slotProps.data?.category_name }}</router-link>
            </template>
            <template #filter="{ filterModel }">
                <InputText v-model="filterModel.value" class="w-[1/2]" type="text" size="small"
                    placeholder="Search by Category" />
            </template>
        </Column>
        <Column field="created_at" header="Created At" style="width: 15%">
        </Column>
        <Column style="width: 5%">
            <template #body="{ data }">
                <div class="flex gap-1 ">
                    <Button v-tooltip.bottom="{ value: 'Edit', pt: { text: '!text-[0.6rem]' } }" type="text"
                        class="self-center" as="router-link" icon="pi pi-pencil"
                        :to="'/admin/products/' + data.id + '/edit'" iconClass="!text-sm !text-gray-700" variant="text"
                        size="small" />
                    <Button @click="deleteRecord(data.id)"
                        v-tooltip.bottom="{ value: 'Delete', pt: { text: '!text-[0.6rem]' } }" class="self-center "
                        variant="text" icon="pi pi-trash" iconClass="!text-sm !text-gray-700" size="small" />
                </div>

            </template>
        </Column>

    </DataTable>

    <div class="card">
        <Paginator :rows="_rows" @page="(page) => { _page = page.page + 1 }" @update:rows="(rows) => { _rows = rows }"
            :totalRecords="_total" :rowsPerPageOptions="[5, 10, 20, 50]"></Paginator>
    </div>
</template>

<script setup>
import { ref, watchEffect, reactive, computed } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from 'primevue/confirmdialog';
import TableLoader from '@/Components/inc/TableLoader.vue'

const confirm = useConfirm();
const toast = useToast();
const products = ref([])
const pdf_url = ref('')
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
const filters = ref({
    global: { value: null, matchMode: 'contains' },
    sku: { value: null, matchMode: 'contains' },
    title: { value: null, matchMode: 'contains' },
    category_name: { value: null, matchMode: 'contains' },
});

const sortBy = reactive({
    key: '',
    order: 'desc'
})


const computedData = computed(() => products.value)
async function getProducts(page = 1, rows = 10, filters, sortBy) {

    const params = new URLSearchParams({
        page: page,
        limit: rows,
        title: filters.value?.title.value || '',
        category: filters.value?.category_name.value || '',
        sku: filters.value?.sku.value || '',
        sortBy: sortBy.key,
        order: sortBy.order
    }).toString();

    loading.value = true
    await axios.get(`/api/products?${params}`).then(res => {

        products.value = res.data.data;
        _total.value = res.data.pagination.total
        _rows.value = res.data.pagination.per_page
        pdf_url.value = res.data.pdf_url

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


const sortData = (e) => {
    sortBy.key = e.sortField
    sortBy.order = e.sortOrder == 1 ? 'asc' : 'desc'
}

const clearFilter = () => {
    filters.value.sku = ''
    filters.value.title = ''
    filters.value.category_name = ''
}


const download = () => {

try {
    const link = document.createElement('a')
    link.href = pdf_url.value
    link.setAttribute('download', 'Report.pdf')
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

} catch (error) {
    console.log("failed to download", error)
}
}


watchEffect(async () => {
    await getProducts(_page.value, _rows.value, filters, sortBy)
})

</script>

<style scoped></style>
