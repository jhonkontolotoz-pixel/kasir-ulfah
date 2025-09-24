<template>
    <Toast />
    <ConfirmDialog />


<div>

    <Dialog v-model:visible="visible" modal header="Edit Customer" :style="{ 'min-width': '20rem' }">
    <span class="text-surface-500 dark:text-surface-400 block mb-8">Update <strong>{{editedCustomer.originalData.name}}</strong> information.</span>

    <div class="mb-4">
        <label for="name" class="dark:text-surface-0 font-semibold mb-1 block">Name</label>
        <InputText id="name" v-model="editedCustomer.newData.name" class="w-full" size="small" autocomplete="off" />
    </div>
    <div class="mb-4">
        <label for="email" class="dark:text-surface-0 font-semibold mb-1 block">Email</label>
        <InputText id="email" v-model="editedCustomer.newData.email" class="w-full" size="small" autocomplete="off" />
    </div>

    <div class="mb-4">
        <label for="phone" class="dark:text-surface-0 font-semibold mb-1 block">Phone</label>
        <InputText id="phone" v-model="editedCustomer.newData.phone" class="w-full" size="small" autocomplete="off" />
    </div>
    <div class="mb-4">
        <label for="address" class="dark:text-surface-0 font-semibold mb-1 block">Address</label>
        <InputText id="address" v-model="editedCustomer.newData.address" class="w-full" size="small" autocomplete="off" />
    </div>

    <div class="flex justify-center gap-2">
        <Button type="button" label="Cancel" severity="secondary" @click="visible = false"></Button>
        <Button type="button" :disabled="updateLoading" :label="updateLoading ? 'Saving' : 'Save'" @click="updateCustomer()"></Button>
    </div>
</Dialog>
</div>

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
                class="self-center"  severity="contrast" icon="pi pi-filter-slash" @click="clearFilter()" />
            <Button v-tooltip.bottom="{ value: 'Create Customer', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" as="router-link" severity="contrast" icon="pi pi-plus" to="/admin/customers/create" />
            <Button v-tooltip.bottom="{ value: 'Export as PDF', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-file-pdf" @click="download()" />
            <Button v-tooltip.bottom="{ value: 'Refresh Data', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-refresh" @click.prevent="getCustomers(_page, _rows,filters,sortBy)" />


        </div>


    </div>

         <DataTable  v-model:filters="filters" filterDisplay="menu" dataKey="id"  :value="customers" tableStyle="min-width: 50rem;"  @sort="sortData($event)"  :loading="loading" tableClass="text-[0.8rem] font-semibold"
         >
 <template #loading>
      <TableLoader :cols="7" :rows="customers.length > 7 ? 10 : 1"/>

</template>
            <Column header="#" style="width: 4%">
                <template #body="{ index }">
                    {{ index + 1 }}
                </template>
            </Column>
            <Column field="name" header="Name" style="width: 15%" :showFilterMatchModes="false">
                <template #body="{data}">
                    <router-link :to="{ name: 'admin.customers.customer', params: { id: data.id } }">{{
                        data.name }}</router-link>
                </template>
                <template #filter="{ filterModel  }">
                    <InputText v-model="filterModel.value"  class="w-[1/2]" type="text"
                    size="small"
                        placeholder="Search by Name" />
                </template>
            </Column>
            <Column field="email" header="Email"  style="width: 15%" :showFilterMatchModes="false">
                <template #body="{ data }">
                    {{ data.email }}
                </template>
<template #filter="{ filterModel  }">
                    <InputText v-model="filterModel.value"  class="w-[1/2]" type="text"
                    size="small"
                        placeholder="Search by Email" />
                </template>
            </Column>
            <Column field="phone" header="Phone" style="width: 10%" :showFilterMatchModes="false">
                <template #body="{ data }">
                    {{ data.phone }}
                </template>
<template #filter="{ filterModel  }">
                    <InputText v-model="filterModel.value"  class="w-[1/2]" type="text"
                    size="small"
                        placeholder="Search by Phone" />
                </template>
            </Column>

            <Column field="address" header="Address" style="width: 15%;text-wrap: text !important;">
                <InputText v-model="filterModel.value"  class="w-[1/2]" type="text"
                    size="small"
                        placeholder="Search by Address" />
            </Column>
            <Column field="orders_count" header="Orders" sortField="orders_count" sortable   style="width: 10%"></Column>
            <Column field="created_at" header="Created At" sortField="created_at" sortable style="width: 25%"></Column>
            <Column style="width: 5%">
                <template #body="{data}">
                    <div class="flex gap-1 ">

                        <Button @click="showEditDialog(data)"
                            v-tooltip.bottom="{ value: 'Edit', pt: { text: '!text-[0.6rem]' } }" class="self-center "
                            variant="text" icon="pi pi-pencil" iconClass="!text-sm !text-gray-500" size="small" />
                        <Button @click="deleteRecord(data.id)"
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
import { ref, nextTick, watchEffect,watch ,reactive , onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";
import debounce from 'lodash.debounce'
import TableLoader from '@/Components/inc/TableLoader.vue'

const confirm = useConfirm();
const toast = useToast();
const customers = ref([])
const visible = ref(false)
const loading = ref(true)
const updateLoading = ref(false)
const pdf_url = ref('')
const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Customers', icon: 'pi pi-users' },
])
const _total = ref(0)
const _rows = ref(10)
const _page = ref(1)
const editedCustomer = ref({
    originalData : '',
    newData : ''
})
const filters = ref({
    name : '',
    phone : '',
    email: '',
    address : ''
});

const sortBy = reactive({
    key : '',
    order : 'desc'
})

async function getCustomers(page = 1, rows = 10 , filters, sortBy  ) {


    const params = new URLSearchParams({
        page : page,
        limit : rows,
        name : filters.value?.name.value || '',
        email : filters.value?.email.value || '',
        phone : filters.value?.phone.value || '' ,
        address : filters.value?.address.value || '' ,

        sortBy : sortBy.key,
        order  : sortBy.order
    }).toString();

    loading.value = true

    await axios.get(`/api/customers/?${params}`)
        .then(res => {

            customers.value = res.data.data;
            _total.value = res.data.pagination.total
            _rows.value = res.data.pagination.
            pdf_url.value = res.data.pdf_url
            
        }).catch(err => {
            console.log(err)
        }).finally(() => {
            loading.value = false
        })

}

async function updateCustomer()  {

let data = {}

for (const key in editedCustomer.value.newData)
{

    if(editedCustomer.value.newData[key] != editedCustomer.value.originalData[key])
    {
         data[key] = editedCustomer.value.newData[key]

    }
}


updateLoading.value = true
    await axios.post(`/api/customers/${editedCustomer.value.originalData.id}`,{...data, _method : 'put'})
    .then((res) => {
        toast.add({ severity: 'success', summary: 'Deleted', detail: 'Record Updated', life: 4000 });
         getCustomers(_page.value, _rows.value,filters,sortBy)
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Update Record!', life: 4000 });
    }).finally(()=>{
        data = {}
        updateLoading.value = false
        visible.value = false
    })
}


async function deleteCustomer(id) {
    await axios.delete(`/api/customers/${id}`).then(res => {
        toast.add({ severity: 'success', summary: 'Deleted', detail: 'Record deleted', life: 4000 });
        getCustomers(_page.value, _rows.value,filters,sortBy)
        visible.value = false
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Delete Record!', life: 4000 });
    })

}

const clearFilter =  () => {

filters.value.name = ''
filters.value.email = ''
filters.value.phone = ''
filters.value.address = ''

}

const showEditDialog = (data) => {

visible.value = true

let {name} = data

editedCustomer.value.originalData = {...data}

editedCustomer.value.newData = {...data}

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
            deleteCustomer(id)
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};

const sortData = (e) =>{
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
await getCustomers(_page.value, _rows.value , filters,sortBy)
})


</script>

<style>
.p-overlay-mask{
    background: rgba(246, 243, 244, 0.6);
    color: white;
    border-radius: 5px;
}
.p-datatable-thead{
padding: 0px !important;
}
th{
    padding: 0 0.9rem !important;
}
td{
    font-size: 0.7rem;
}
</style>
