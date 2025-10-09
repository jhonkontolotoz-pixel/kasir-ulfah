```vue
<template>
  <div class="flex flex-col h-screen bg-gray-100">
    <!-- Header: Search + Category Carousel -->
    <div class="p-4 bg-white shadow-sm">
      <!-- Search Bar -->
      <div class="flex items-center gap-2 mb-3">
        <InputText
          v-model="searchQuery"
          placeholder="Search products..."
          class="w-full"
        />
        <Button icon="pi pi-search" style="color: #999;border-color: #999 !important; " outlined />
      </div>

      <!-- Category Carousel -->
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        <button
          v-if="categories.length"
          @click="filters.category_name = ''"
          :class="[
            'whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium border transition',
            filters.category_name === ''
              ? 'bg-black text-white '
              : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
          ]"
        >
          All
        </button>
        <button
          v-for="category in categories"
          :key="category"
          @click="filters.category_name = category.name"
          :class="[
            'whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium border transition',
            filters.category_name === category.name
              ? 'bg-black text-white '
              : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
          ]"
        >
          {{ category.name }}
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-1 overflow-hidden">
      <!-- Products Grid -->
      <div class="flex-1 p-4 overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Products</h2>
        <div v-if="loading" class="text-center py-10 italic">
          Loading products...
        </div>
        <div
          v-else-if="products.length"
          class="grid grid-cols-2 md:grid-cols-4 gap-4"
        >
          <div
            v-for="product in products"
            :key="product.id"
            class="bg-white p-4 rounded-lg shadow hover:shadow-md cursor-pointer transition"
            @click="cartStore.addToCart(product)"
          >
            <div class="w-full h-32 ">
                <img
                :src="product?.image ? '/storage/' + product?.image : '/imgs/box.png'"
                alt="product image"
                class="w-full h-32 object-fit rounded-md mb-2"
                />
            </div>
            <div class="text-gray-800 font-medium">{{ product.title }}</div>
            <div class="black font-bold">${{ product.price }}</div>
          </div>
        </div>

        <div v-else class="text-gray-500 text-center py-10 italic">
          No products found.
        </div>
      </div>

      <!-- Cart Sidebar -->
      <div class="w-80 bg-white p-4 shadow-lg flex flex-col">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Cart</h2>

        <!-- Customer Selection -->
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2 text-gray-700">Select Customer</label>
          <Select
            v-model="selectedCustomer"
            :options="customers"
            optionLabel="name"
            placeholder="Choose a customer"
            class="w-full"
            filter
            @filter="(e) => {
                searchCustomers(e)
            }"
          />
        </div>

        <div v-if="cart.length" class="flex-1 overflow-y-auto">
          <div
            v-for="item in cart"
            :key="item.id"
            class="flex justify-between items-center mb-3 border-b pb-2"
          >
            <div>
              <div class="font-medium">{{ item.title }}</div>
              <div class="text-gray-500 text-sm">
                ${{ item.price }} x {{ item.qty }}
              </div>
            </div>
            <div class="flex items-center">
              <button @click="cartStore.decreaseQty(item)" class="px-2 text-gray-600">-</button>
              <span class="px-2">{{ item.qty }}</span>
              <button
                :disabled="item.qty >= item.quantity"
                @click="cartStore.increaseQty(item)"
                class="px-2 text-gray-600"
              >+</button>
            </div>
          </div>
        </div>

        <div v-else class="text-gray-400 flex-1 flex items-center justify-center">
          No items in cart
        </div>

        <div class="border-t pt-3 mt-3">
          <div class="flex justify-between font-semibold text-lg mb-3">
            <span>Total:</span>
            <span>${{ total.toFixed(2) }}</span>
          </div>
          <Button
            label="Checkout"
            class="w-full"
            severity="primary"
            @click="checkout"
            :disabled="!selectedCustomer || cart.length === 0"
          />
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { debounce, get } from 'lodash';
import { ref, computed , watch, onMounted } from 'vue'
import { useRoute,useRouter } from 'vue-router';
import { useCartStore } from '@/store/cart'
import { storeToRefs } from 'pinia'
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const route = useRoute();
const router = useRouter();
const loading = ref(false)
const filters = ref({
    title:'',
    category_name: '',
    sku: '',
});

const categories = ref([])

const products = ref([])

const customers = ref([])

const cartStore = useCartStore()

const {cart , total , selectedCustomer} = storeToRefs(cartStore)

const searchQuery = computed({
  get: () => filters.value.title,
  set: debounce((val) => {
    filters.value.title = val;
  }, 600)
});

const checkout = () => {
  cartStore.createOrder().then(() => {
      cartStore.clearCart();
      selectedCustomer.value = null;
      toast.add({ severity: 'success', summary: 'Success', detail: 'Order created successfully', life: 3000 });
      router.push({ name: 'admin.orders' });
  }).catch(() => {
      toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to create order', life: 3000 });
  });
}

async function getProducts() {

    const params = new URLSearchParams({
        ...route.query, limit : 1000,
    }).toString();
    loading.value = true
    await axios.get(`/api/products?${params}`).then(res => {

        products.value = res.data.data;

    }).catch(err => {
        console.log(err)
    }).finally(() => {
        loading.value = false
    })
}

async function getCategories(page = 1, rows = 10,) {

    const params = new URLSearchParams({
        limit: 1000,
    }).toString();

    loading.value = true
    await axios.get(`/api/categories/?${params}`)
        .then(res => {
            categories.value = res.data.data;
        }).catch(err => {
            console.log(err)
        }).finally(() => {
            loading.value = false
        })
}



async function searchCustomers(e = null) {

    const params = new URLSearchParams({
        query: e ? e.value : null,
        limit: 1000,
    }).toString();

    await axios.get(`/api/customers/search/pos?${params}`)
        .then(res => {
            customers.value = res.data.data;
        }).catch(err => {
            console.log(err)
        })
}


watch(filters.value, () => {
    router.replace({
        name: 'admin.pos',
        query: {
            title: filters.value?.title || '',
            category: filters.value?.category_name || '',
            sku: filters.value?.sku || '',
        }
    })
})


watch(() => route.query, async () => {
    await getProducts()
}, { immediate: true })

onMounted(async () => {
    await getCategories()
    await searchCustomers()
})
</script>

<style>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
```
