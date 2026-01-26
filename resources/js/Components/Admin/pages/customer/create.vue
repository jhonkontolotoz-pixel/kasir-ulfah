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
    <div class="card flex w-full p-3">
        <form @submit.prevent="createCustomer" class="w-full">

    <div class="mb-4">
        <label for="name" class="dark:text-surface-0 font-semibold mb-1 block">Name</label>
        <InputText id="name" v-model="customer.name" class="w-full" size="small" autocomplete="off" />
    </div>
    <div class="mb-4">
        <label for="email" class="dark:text-surface-0 font-semibold mb-1 block">Email</label>
        <InputText id="email" v-model="customer.email" class="w-full" size="small" autocomplete="off" />
    </div>

    <div class="mb-4">
        <label for="phone" class="dark:text-surface-0 font-semibold mb-1 block">Phone</label>
        <InputText id="phone" v-model="customer.phone" class="w-full" size="small" autocomplete="off" />
    </div>
    <div class="mb-4">
        <label for="address" class="dark:text-surface-0 font-semibold mb-1 block">Address</label>
        <InputText id="address" v-model="customer.address" class="w-full" size="small" autocomplete="off" />
    </div>
            <div class="flex">
                <Button type="submit" label="Save" icon="pi pi-download" :disabled="loading" severity="contrast"
                    raised></Button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';

const toast = useToast()
const loading = ref(false)
const customer = ref({})

const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Customers', icon: 'pi pi-users', route: { name: 'admin.customers' } },
    { label: 'Create Customer', icon: 'pi pi-plus' },

])


async function createCustomer() {
    loading.value = true

    const userId = localStorage.getItem('user_id') // atau dari store / inertia props

    await axios.post(`/api/customers`, customer.value, {
        headers: {
            id: userId
        }
    }).then(res => {
        toast.add({ severity: 'success', summary: 'Saved', detail: 'Customer Saved Successfully', life: 4000 });
        customer.value = {}
    }).catch(err => {
        console.log(err.response)
        toast.add({ severity: 'error', summary: 'Failed', detail: 'Failed to Save Record!', life: 4000 });
    }).finally(() => {
        loading.value = false
    })
}

</script>

<style scoped></style>
