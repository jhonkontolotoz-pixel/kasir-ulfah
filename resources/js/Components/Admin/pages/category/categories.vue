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
            <Button v-tooltip.bottom="{ value: 'Export as PDF', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-file-pdf" />
            <Button v-tooltip.bottom="{ value: 'Refresh Data', pt: { text: '!text-[0.7rem]' } }" variant="text" type="text"
                class="self-center" severity="contrast" icon="pi pi-refresh" @click.prevent="getCategories(_page, _rows)" />

        </div>


    </div>


    <template v-if="loading">
        <DataTable :value="dummyCategories" tableStyle="min-width: 50rem;" class="text-sm">
            <Column field="id" header="Code" style="width: 5%">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
            <Column field="name" header="Name" sortable style="width: 25%">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
            <Column field="products_count" header="Products Count" sortable style="width: 5%">
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
        <DataTable :value="categories" tableStyle="min-width: 50rem;" class="text-sm">
            <Column  header="#" style="width: 4%">
                    <template #body="{index}">
                        {{ index + 1 }}
                    </template>
                    </Column>
            <Column field="name" header="Name" sortable style="width: 25%">
            <template #body="slotProps">
                <router-link :to="{name : 'admin.categories.category' , params : {id : slotProps.data.id}}">{{ slotProps.data.name }}</router-link>
            </template>
            </Column>
            <Column field="products_count" header="Products Count" sortable style="width: 25%"></Column>
            <Column field="created_at" header="Created At" style="width: 25%"></Column>
            <Column style="width: 5%">
                <template #body="slotProps">
                    <div class="flex gap-1 ">
                        <Button v-tooltip.bottom="{ value: 'Edit', pt: { text: '!text-[0.6rem]' } }" type="text"
                            class="self-center" as="router-link" icon="pi pi-pen-to-square"
                            :to="'/admin/categories/' + slotProps.data.id + '/edit'" iconClass="!text-sm !text-gray-700"
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
import { ref, watchEffect } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
const toast = useToast();
const categories = ref([])
const search = ref('')
const loading = ref(false)
const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Categories', icon: 'pi pi-list' },
])
const _total = ref(0)
const _rows = ref(10)
const _page = ref(1)
const dummyCategories = ref(new Array(5))

async function getCategories(page = 1, rows = 10) {
    loading.value = true
    await axios.get(`/api/categories/?page=${page}&limit=${rows}`)
        .then(res => {
            categories.value = res.data.data;
            _total.value = res.data.pagination.total
            _rows.value = res.data.pagination.per_page
        }).catch(err => {
            console.log(err)
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



watchEffect(async () => {
    await getCategories(_page.value, _rows.value)
})


</script>

<style scoped></style>
