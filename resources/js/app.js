
import './assets'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

import './bootstrap';

import { createApp , defineAsyncComponent} from 'vue/dist/vue.esm-bundler'

import { getActiveLanguage, i18nVue } from 'laravel-vue-i18n';
import moment from 'moment'
import App from './App.vue'
// Vuetify


import { createVuetify } from 'vuetify'
//import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({directives})

import router from './routes'

import store from './store/index.js'

const app = createApp({
    components :{
        App
    }
})


app.use(i18nVue, {
    lang: store.getters.getLang ,
    resolve: lang => import(`../../lang/${lang}.json`),
})

app.component('errors',defineAsyncComponent(()=> import('./Components/inc/ValidationErrors.vue')))

app.use(store).use(router).use(vuetify).mount("#app")

