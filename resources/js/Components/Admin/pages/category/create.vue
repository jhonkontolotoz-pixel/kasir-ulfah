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
        <form @submit.prevent="createCategory"  class="w-full">
            <div class="flex gap-3 flex-col">
                        <div class="w-full mb-3">
                            <label for="title" class=" font-medium mb-2 block">Name</label>
                            <InputText inputId="title" v-model="category.name" type="text" placeholder="Name"
                                class="w-full " />
                        </div>
                    <div class="w-full mb-3">
                        <label for="title" class=" font-medium mb-2 block">Description</label>

                        <Editor v-model="category.description" editorStyle="height: 320px" />
                    </div>

            </div>
            <div class="w-full">
                <Button type="submit" :label="loading ? 'Saving..' : 'Save'" icon="pi pi-save" :disabled="loading" severity="contrast"
                    raised></Button>
            </div>
        </form>
    </div>

</template>

<script setup>
import { ref} from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const auth = useAuthStore()
const loading = ref(false)

const category = ref({
    name: null,
    description: null,
})

const home = ref({
    icon: 'pi pi-home',
    route: '/dashboard'
});
const items = ref([
    { label: 'Categories', icon: 'pi pi-list', route: { name: 'admin.categories' } },
    { label: 'Create Category', icon: 'pi pi-plus' },

])


async function createCategory() {

    loading.value = true

    await axios.post(`/api/categories`, category.value).then(res => {
        toast.add({ severity: 'success', summary: 'Saved', detail: 'Category Saved Successfully', life: 4000 });
    }).catch(err => {
        toast.add({ severity: 'error', summary: 'failed', detail: 'Failed to Save Record!', life: 4000 });
    }).finally(() => {
        loading.value = false
    })

}

</script>

<style scoped></style>
