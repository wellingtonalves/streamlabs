export const login = async ({commit}, token) => {
    return await axios.get('/api/user', {headers: {'Authorization': `Bearer ${token}`}}).then(response => {
        localStorage.setItem('access_token', token);
        commit('SET_LOGIN', response.data)
    }).catch(error => {
        throw new Error(error)
    })
}

export const logout = async ({commit}, vue) => {
    const token = localStorage.getItem('access_token');
    return await axios.get('/api/user/revoke', {headers: {'Authorization': `Bearer ${token}`}}).then(response => {
        commit('SET_LOGOUT')
        localStorage.removeItem('access_token');
        vue.$router.push('/login')
    }).catch(error => {
        throw new Error(error)
    })
}