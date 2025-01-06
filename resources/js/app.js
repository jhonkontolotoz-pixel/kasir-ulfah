import '@/bootstrap';
import 'primeicons/primeicons.css'
import { createApp , defineAsyncComponent} from 'vue/dist/vue.esm-bundler'
//import { getActiveLanguage, i18nVue } from 'laravel-vue-i18n';
import router from '@/routes'
import App from './App.vue'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import ConfirmationService from 'primevue/confirmationservice';

const app = createApp({
    components :{
        App
    }
})

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

/* app.use(i18nVue, {
    lang: 'en' ,
    resolve: lang => import(`../../lang/${lang}.json`),
}) */

app
.use(pinia)
.use(router)
.use(PrimeVue, {
    theme: {
        preset: Aura
    }
})
.use(ToastService)
.use(ConfirmationService)
.directive('tooltip', Tooltip)
.mount("#app")