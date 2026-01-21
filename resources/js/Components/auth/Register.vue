<template>
  <Toast class="rounded" />

  <div
    class="p-6 text-slate-100 bg-indigo-400 backdrop-filter backdrop-blur-[5px] bg-opacity-10 rounded-md md:w-6/12 lg:w-4/12 mx-auto">
    
    <div class="text-center mb-8">
      <div class="text-3xl font-medium mb-4">Create Account</div>
    </div>

    <div>
      <!-- Name -->
      <label for="name" class="font-medium mb-2 block">Full Name</label>
      <InputText :invalid="registerFailed" inputId="name" v-model="creds.name" type="text" placeholder="Full Name"
        class="w-full mb-4" />

      <!-- Email -->
      <label for="email" class="font-medium mb-2 block">Email</label>
      <InputText :invalid="registerFailed" inputId="email" v-model="creds.email" type="text" placeholder="Email address"
        class="w-full mb-4" />

      <!-- Password -->
      <label for="password" class="font-medium mb-2 block">Password</label>
      <Password toggleMask :feedback="false" :invalid="registerFailed" inputId="password" v-model="creds.password"
        type="password" placeholder="Password" class="w-full mb-4"
        input-class="w-full bg-none bg-transparent placeholder-slate-100" />

      <!-- Confirm Password -->
      <label for="password2" class="font-medium mb-2 block">Confirm Password</label>
      <Password toggleMask :feedback="false" :invalid="registerFailed" inputId="password2"
        v-model="creds.password_confirmation" type="password" placeholder="Confirm Password"
        class="w-full mb-6" input-class="w-full bg-none bg-transparent placeholder-slate-100" />

      <!-- Terms Checkbox -->
      <div class="flex items-center mb-6">
        <Checkbox inputId="terms" v-model="creds.terms" :binary="true" class="mr-2 bg-transparent" />
        <label for="terms">I agree to the Terms and Conditions</label>
      </div>

      <!-- Register Button -->
      <div class="flex items-center justify-center">
        <Button label="Register" :disabled="loading" @click.prevent="register" icon="pi pi-user-plus"
          severity="success" class="!outline-none !border-none !bg-indigo-700" />
      </div>
    </div>

    <p class="text-center mt-6 text-slate-200">
      Already have an account? 
      <router-link to="/login" class="font-medium text-indigo-200 hover:text-indigo-100">Sign In</router-link>
    </p>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from 'primevue/usetoast';
import { useRouter } from 'vue-router';
import axios from 'axios';

const creds = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false
});

const toast = useToast();
const loading = ref(false);
const registerFailed = ref(false);
const authStore = useAuthStore();
const router = useRouter();

const register = async () => {
  if (!creds.value.terms) {
    toast.add({ severity: 'warn', summary: 'Terms Required', detail: 'You must accept the terms', life: 4000 });
    return;
  }

  loading.value = true;
  registerFailed.value = false;

try {
    await axios.get("/sanctum/csrf-cookie");
    const res = await axios.post("/api/register", creds.value);

    if (res.data.status) {
      // 1. JANGAN panggil authStore.login(res.data.user);
      
      // 2. Munculkan pesan sukses
      toast.add({ 
        severity: 'success', 
        summary: 'Success', 
        detail: 'Account created! Please sign in.', 
        life: 4000 
      });

      // 3. Arahkan ke halaman login
      setTimeout(() => {
        router.push({ name: 'login' }); 
      }, 1500);
    }
} catch (err) {
    registerFailed.value = true;
    
    // Ambil pesan error spesifik dari Laravel (misal: Email sudah ada)
    const errorMsg = err.response?.data?.message || 'Check your inputs';
    const validationErrors = err.response?.data?.errors;
    
    // Jika ada error validasi spesifik, tampilkan detailnya
    let detail = errorMsg;
    if (validationErrors) {
        detail = Object.values(validationErrors).flat().join(', ');
    }

    toast.add({ 
        severity: 'error', 
        summary: 'Registration Failed', 
        detail: detail, 
        life: 5000 
    });
    
    console.error("Register Error:", err.response);
  } finally {
    loading.value = false;
  }
};
</script>