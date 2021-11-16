import Vue from 'vue'
import Vuex from 'vuex'

import Auth from "./modules/auth";
import Stream from "./modules/stream";

Vue.use(Vuex)

const Store = new Vuex.Store({
    modules: {
        auth: Auth,
        stream: Stream
    }
})

export default Store