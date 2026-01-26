import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref(null);
  const isAuthenticated = ref(false);
  const token = ref(null);

  // Getters
  const getUser = computed(() => user.value);

  // Actions
  const login = ({ user: newUser }) => {
    isAuthenticated.value = true;
    user.value = newUser;
   // token.value = newToken;
  };

  const logout = () => {
    isAuthenticated.value = false;
    user.value = null;
    //token.value = null;
  };

  return {
    user,
    isAuthenticated,
    token,
    getUser,
    login,
    logout,
  };
}, {
  persist: true
});