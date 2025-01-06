import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCartStore = defineStore('cart', () => {
  // State
  const cart = ref([]);
  
  // Getters
  const getCart = computed(() => cart.value);

  // Actions
  const addToCart = (product) => {
    product = {...product , requested : 1}
   cart.value.push(product)
  };

  const deleteFromCart = (productId) => {
    cart.value = cart.value.filter(product => product.id !== productId);
  };

  
  const updateQuantity = (productId,quantity) => {
    let product = cart.value.find(product => product.id == productId)

    product.requested = quantity

  };

const clearCart = () => {
    cart.value = [];
  };
  
  return {
    cart,
    getCart,
    addToCart,
    deleteFromCart,
    updateQuantity,
    clearCart
  };
}, {
  persist: true
});
