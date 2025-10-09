import { defineStore } from "pinia";
import { ref, computed } from "vue";

export const useCartStore = defineStore(
    "cart",
    () => {
        // State
        const cart = ref([]);

        const selectedCustomer = ref(null);

        // Getters
        const getCartItems = computed(() =>
            cart.value.reduce((sum, item) => sum + item.qty, 0)
        );

        const total = computed(() =>
            cart.value.reduce((sum, item) => sum + item.price * item.qty, 0)
        );

        // Actions
        const addToCart = (product) => {
            const item = cart.value.find((i) => i.id === product.id);
            if (item) item.qty++;
            else cart.value.push({ ...product, qty: 1 });
        };

        const deleteFromCart = (productId) => {
            cart.value = cart.value.filter(product => product.id !== productId);
        };

        const increaseQty = (product) => {
            product.qty++
            cart.value = [...cart.value];
            };
        const decreaseQty = (product) => {
            if (product.qty > 1) product.qty--;
            else cart.value = cart.value.filter((i) => i.id !== product.id);
            cart.value = [...cart.value];
        };

        const updateQty = (productId, qty) => {
            const item = cart.value.find((i) => i.id === productId);
            if (item) item.qty = qty;
        };
        const clearCart = () => {
            cart.value.length = 0;
        };

        const createOrder = async () => {
          return await axios.post('/api/orders', {
                products: cart.value,
                customer_id: selectedCustomer.value ? selectedCustomer.value.id : null,
            })
        };

        return {
            cart,
            addToCart,
            deleteFromCart,
            increaseQty,
            decreaseQty,
            clearCart,
            total,
            getCartItems,
            updateQty,
            createOrder,
            selectedCustomer
        };
    },
    {
        persist: true,
    }
);
