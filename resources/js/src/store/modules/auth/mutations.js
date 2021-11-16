export const SET_LOGIN = (state, data) => {
    state.user = data?.user
    state.isAuthenticated = true
}

export const SET_LOGOUT = (state) => {
    state.user = {}
    state.isAuthenticated = false
}