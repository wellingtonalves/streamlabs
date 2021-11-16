import state from './state'
import * as actions from './actions'
import mutations from './mutations'
import getters from './getters'

const Auth = {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}

export default Auth