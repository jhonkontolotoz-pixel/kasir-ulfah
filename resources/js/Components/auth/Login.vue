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
        </div>
    </div>
</template>
<script setup>

import { ref } from 'vue';
import { useAuthStore } from '@/store/auth';
import { useToast } from "primevue/usetoast";
import { useRouter } from 'vue-router'

const creds = ref({
    email: '',
    password: '',
    remember: false
})

const toast = useToast();
const loading = ref(false)
const loginfailed = ref(false)
const authStore = useAuthStore()
const router = useRouter()

const login = async () => {

    loading.value = true
    await axios.get("sanctum/csrf-cookie")
    await axios.post("api/login", creds.value)
        .then(res => {
            authStore.login(res.data.data)
            router.push({ name: 'admin.dashboard' })
        })
        .catch(err => {
            loginfailed.value = true;
            console.log(err)
            toast.add({ severity: 'error', summary: 'Login Failed', detail: 'Invalid Email or Password', life: 5000 });
        })
        .finally(() => {
            loading.value = false
        })
}


</script>
