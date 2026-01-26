<template>
    <Toast class=" rounded" />
    <div
        class="p-6 text-slate-100 bg-indigo-400 backdrop-filter backdrop-blur-[5px] bg-opacity-10 rounded-md md:w-6/12 lg:w-4/12 mx-auto">
        <div class="text-center mb-8">
            <div class="text-slate-100 dark:text-surface-0 text-3xl font-medium mb-4">Welcome Back</div>
        </div>

        <div>
            <label for="email1" class=" font-medium mb-2 block">Email</label>
            <InputText :invalid="loginfailed" inputId="email" v-model="creds.email" type="text" placeholder="Email address"
                class="w-full mb-4" />


            <label for="password1" class=" dark:text-surface-0 font-medium mb-2 block ">Password</label>
            <Password toggleMask :feedback="false" :invalid="loginfailed" inputId="password1" v-model="creds.password"
                type="password" placeholder="Password" class="w-full mb-4 "
                input-class="w-full bg-none bg-transparent placeholder-slate-100" />

            <div class="flex items-center justify-between mb-12">
                <div class="flex items-center">
                    <Checkbox inputId="rememberme1" name="rememberme" v-model="creds.remember" :binary="true"
                        class="mr-2 bg-transparent" />
                    <label for="rememberme1">Remember me</label>
                </div>
                <a class="font-medium no-underline ml-2  text-right cursor-pointer">Forgot password?</a>
            </div>
            <div class="flex items-center justify-center ">
                <Button label="Sign In" :disabled="loading" @click.prevent="login" icon="pi pi-user" severity="success"
                    class="!outline-none !border-none !bg-indigo-700" />
            </div>
            <p>
    Don't have an account? 
    <router-link to="/register" class="font-bold hover:underline">
      Register
    </router-link>
  </p>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from "primevue/usetoast";
import { useRouter } from 'vue-router';
import axios from 'axios'; // <-- WAJIB DITAMBAH

const creds = ref({
    email: '',
    password: '',
    remember: false
})

const toast = useToast();
const loading = ref(false);
const loginfailed = ref(false);
const authStore = useAuthStore();
const router = useRouter();

const login = async () => {
    loading.value = true;
    loginfailed.value = false; // Reset status error tiap kali klik

    try {
    // ... (setelah axios.post)
const res = await axios.post("/api/login", creds.value);

// 1. Ambil user dan token dari response backend
const userData = res.data.user || res.data.data;
const userToken = res.data.token || res.data.access_token; // Sesuaikan key dari backend kamu

// 2. Kirim object lengkap ke store sesuai struktur: { user, token }
authStore.login({ 
    user: userData, 
    token: userToken 
});

toast.add({ severity: 'success', summary: 'Success', detail: 'Welcome back!', life: 3000 });
router.push({ name: 'admin.dashboard' });
    } catch (err) {
        loginfailed.value = true;
        // Ambil pesan error dari Laravel jika ada (misal: "These credentials do not match our records")
        const msg = err.response?.data?.message || 'Invalid Email or Password';
        toast.add({ severity: 'error', summary: 'Login Failed', detail: msg, life: 5000 });
    } finally {
        loading.value = false;
    }
}
</script>