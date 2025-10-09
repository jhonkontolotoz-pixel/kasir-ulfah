<template>
    <Toast />
    <ConfirmDialog />
<div class="p-4">
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
            <Button v-if="cart.length" v-tooltip.bottom="{ value: 'Clear All Products From Cart', pt: { text: '!text-[0.7rem]' } }"
                variant="text" type="text" class="self-center" severity="contrast" icon="pi pi-trash"
                @click.prevent="_clearCart()" />

        </div>


    </div>


    <template v-if="Array.from(cart)?.length > 0">
        <DataTable :value="Array.from(cart)" tableStyle="min-width: 50rem;" class="text-sm">
            <Column header="#" style="width: 4%">
                <template #body="{ index }">
                    {{ index + 1 }}
                </template>
            </Column>
            <Column field="title" header="Name" sortable style="width: 25%">

                <template #body="slotProps">
                    <router-link :to="{ name: 'admin.products.product', params: { id: slotProps.data.id } }">{{
                        slotProps.data.title }}</router-link>
                </template>
            </Column>
            <Column field="qty" header="Quantity" sortable style="width: 45%"></Column>
            <Column field="quantity" header="In Stock" sortable style="width: 50%"></Column>

            <Column style="width:5%">
                <template #body="slotProps">
                    <div class="flex gap-1">
                        <InputNumber inputClass="!w-[3rem]" :defaultValue="slotProps.data.qty" @value-change="updateQty(slotProps.data.id , $event)" showButtons buttonLayout="horizontal"  size="small" class="" :min="1" :max="slotProps.data.quantity">
                        <template #incrementbuttonicon><span class="pi pi-plus"></span></template>
                        <template #decrementbuttonicon><span class="pi pi-minus"></span></template>
                        </InputNumber>
                        <Button @click="deleteRecord(slotProps.data.id)"
                            v-tooltip.bottom="{ value: 'Delete', pt: { text: '!text-[0.6rem]' } }" class="self-center "
                            variant="text" icon="pi pi-trash" iconClass="!text-sm !text-gray-700" size="small" />
                    </div>

                </template>
            </Column>

        </DataTable>
        <div class="flex justify-items-start my-4">
            <Button label="Checkout" icon="pi pi" variant="text" severity="contrast" raised @click="createOrder" />
        </div>
    </template>
    <template v-else>

        <p class="text-center m-5">Cart is empty <router-link :to="{ name: 'admin.pos' }" class="underline font-bold">Create
                Order</router-link></p>
    </template>
</div>
</template>

<script setup>
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";
import { useCartStore } from '@/store/cart'
import { storeToRefs } from 'pinia'

const confirm = useConfirm();
const toast = useToast();
const cartStore = useCartStore()

const {cart,updateQty} = storeToRefs(cartStore)
const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Cart', icon: 'pi pi-shopping-cart' },
])

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
            cartStore.deleteFromCart(id)
            toast.add({ severity: 'success', summary: 'Cleared', detail: 'Porduct Deleted!', life: 4000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};

const _clearCart = (id) => {
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
            cartStore.clearCart()
            toast.add({ severity: 'success', summary: 'Cleared', detail: 'Cart Cleared!', life: 4000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};


const createOrder = async () => {

};


</script>

<style scoped></style>
