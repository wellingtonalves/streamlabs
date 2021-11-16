import Vue from 'vue'
import App from './src/App'

import router from './src/router'
import store from './src/store'
import './bootstrap'

import './src/plugins'
import vuetify from './src/plugins/vuetify'

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    render: h => h(App),
});