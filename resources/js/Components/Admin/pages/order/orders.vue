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
            <Button v-tooltip.bottom="{ value: 'Clear Filters', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-filter-slash" @click="clearFilter()" />
            <Button v-tooltip.bottom="{ value: 'Create Order', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" as="router-link" severity="contrast" icon="pi pi-plus" to="/admin/pos" />
            <Button v-tooltip.bottom="{ value: 'Export as PDF', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-file-pdf" @click="download()" />
            <Button v-tooltip.bottom="{ value: 'Refresh Data', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-refresh"
                @click.prevent="getOrders(_page, _rows, filters, sortBy)" />

        </div>


    </div>

    <DataTable v-model:filters="filters" filterDisplay="menu" dataKey="id" :value="orders" tableStyle="min-width: 50rem;"
        @sort="sortData($event)" :loading="loading" tableClass="text-[0.8rem] font-semibold">

        <template #loading>
            <TableLoader :cols="9" :rows="orders.length > 7 ? 10 : 1" />

        </template>

        <Column header="#" style="width: 4%">
            <template #body="{ index }">
                {{ index + 1 }}
            </template>
        </Column>
        <Column field="code" header="Code" style="width: 15%" :showFilterMatchModes="false">
            <template #body="slotProps">
                <router-link :to="{ name: 'admin.orders.order', params: { id: slotProps.data.id } }">{{
                    slotProps.data.code }}</router-link>
            </template>

            <template #filter="{ filterModel }">
                <InputText v-model="filterModel.value" class="w-[1/2]" type="text" size="small"
                    placeholder="Search by code" />
            </template>
        </Column>
        <Column field="customer_name" header="Customer" style="width: 20%" :showFilterMatchModes="false">
            <template #body="{ data }">
                {{ data.customer_name }}
            </template>
            <template #filter="{ filterModel }">
                <InputText v-model="filterModel.value" class="w-[1/2]" type="text" size="small"
                    placeholder="Search by name" />
            </template>
        </Column>
        <Column field="payment_method" header="Payment" style="width: 10%" :showFilterMatchModes="false">
            <template #body="{ data }">
                <Tag :value="data.payment_method" :severity="getSeverity(data.payment_method)" />
            </template>
            <template #filter="{ filterModel }">
                <Select v-model="filterModel.value" size="small" :options="payment_methods" placeholder="Select One"
                    style="min-width: 5rem" :showClear="true">
                    <template #option="slotProps">
                        <Tag :value="slotProps.option" style="font-weight: 500;"
                            :severity="getSeverity(slotProps.option)" />
                    </template>
                </Select>
            </template>
        </Column>
        <Column field="status" header="Status" style="width: 10%" :showFilterMatchModes="false">
            <template #body="{ data }">
                <Tag :value="data.status" :severity="getSeverity(data.status)" />
            </template>
            <template #filter="{ filterModel }">
                <Select v-model="filterModel.value" size="small" :options="statuses" placeholder="Select One"
                    style="min-width: 5rem;" :showClear="true">
                    <template #option="slotProps">
                        <Tag :value="slotProps.option" style="font-weight: 500;"
                            :severity="getSeverity(slotProps.option)" />
                    </template>
                </Select>
            </template>
        </Column>
        <Column field="products_count" header="Items" style="width: 10%"></Column>
        <Column field="total" header="Total" sortField="total_price" sortable style="width: 10%"></Column>

        <Column field="created_at" header="Created At" sortField="created_at" sortable style="width: 25%"></Column>
        <Column style="width: 5%">
            <template #body="slotProps">
                <div class="flex gap-1 ">
                    <Button v-tooltip.bottom="{ value: 'Edit', pt: { text: '!text-[0.6rem]' } }" type="text"
                        class="self-center" as="router-link" icon="pi pi-pencil"
                        :to="'/admin/orders/' + slotProps.data.id + '/edit'" iconClass="!text-sm !text-gray-500"
                        variant="text" size="small" />
                    <Button @click="deleteRecord(slotProps.data.id)"
                        v-tooltip.bottom="{ value: 'Delete', pt: { text: '!text-[0.6rem]' } }" class="self-center "
                        variant="text" icon="pi pi-trash" iconClass="!text-sm !text-gray-500" size="small" />
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
import { ref, watchEffect, reactive } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";
import TableLoader from '@/Components/inc/TableLoader.vue'


const confirm = useConfirm();
const toast = useToast();
const orders = ref([])
const pdf_url = ref('')
const loading = ref(true)
const statuses = ref(['canceled', 'pending', 'shipped', 'delivered']);
const payment_methods = ref(['cash', 'card']);
const _total = ref(0)
const _rows = ref(10)
const _page = ref(1)

const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Orders', icon: 'pi pi-list' },
])

const filters = ref({
    code: '',
    status: '',
    customer_name: '',
    payment_method: ''
});

const sortBy = reactive({
    key: '',
    order: 'desc'
})


async function getOrders(page = 1, rows = 10, filters, sortBy) {


    const params = new URLSearchParams({
        page: page,
        limit: rows,
        code: filters.value?.code.value || '',
        status: filters.value?.status.value || '',
        customer_name: filters.value?.customer_name.value || '',
        payment_method: filters.value?.payment_method.value || '',
        sortBy: sortBy.key,
        order: sortBy.order
    }).toString();

    loading.value = true

    await axios.get(`/api/orders/?${params}`)
        .then(res => {

                orders.value = res.data.data
                pdf_url.value = res.data.pdf_url
                _total.value = res.data.pagination.total
                _rows.value = res.data.pagination.per_page
        }).catch(err => {
            console.log(err)
        }).finally(() => {
            loading.value = false
        })

}

async function deleteOrder(id) {
    await axios.delete(`/api/orders/${id}`).then(res => {
        toast.add({ severity: 'success', summary: 'Deleted', detail: 'Record deleted', life: 4000 });
        getOrders(_page.value, _rows.value)
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Delete Record!', life: 4000 });
    })

}

const clearFilter = async () => {

    filters.value.code = ''
    filters.value.status = ''
    filters.value.payment_method = ''
    filters.value.customer_name = ''

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
            deleteOrder(id)
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};

const getSeverity = (status) => {
    switch (status) {
        case 'canceled':
            return 'danger';

        case 'delivered':
            return 'success';

        case 'shipped':
            return 'info';

        case 'pending':
            return 'warn';

        case 'cash':
            return 'secondary';

        case 'card':
            return 'success';


    }
};

const sortData = (e) => {
    sortBy.key = e.sortField
    sortBy.order = e.sortOrder == 1 ? 'asc' : 'desc'
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
    await getOrders(_page.value, _rows.value, filters, sortBy)
})


</script>

<style>
.p-overlay-mask {
    background: rgba(246, 243, 244, 0.6);
    color: white;
    border-radius: 5px;
}

.p-datatable-thead {
    padding: 0px !important;
}

th {
    padding: 0 0.9rem !important;
}

td {
    font-size: 0.7rem;
}</style>
