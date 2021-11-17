export const getAmount = async ({}, {type = 'database', page = 1, sort = 'desc'}) => {
    return await api(`/api/streams-amount-per-game?type=${type}&page=${page}&sort=${sort}`)
}

export const getHighest = async ({}, {type = 'database', page = 1, sort = 'desc'}) => {
    return await api(`/api/streams-highest-per-game?type=${type}&page=${page}&sort=${sort}`)
}

export const getMedian = async ({}, type = 'database') => {
    return await api(`/api/streams-median?type=${type}`)
}

export const getOdd = async ({}, {type = 'database', page = 1, sort = 'desc'}) => {
    return await api(`/api/streams-odd?type=${type}&page=${page}&sort=${sort}`)
}

export const getEven = async ({}, {type = 'database', page = 1, sort = 'desc'}) => {
    return await api(`/api/streams-even?type=${type}&page=${page}&sort=${sort}`)
}

export const getTop = async ({}, {type = 'database', page = 1, sort = 'desc'}) => {
    return await api(`/api/streams-top?type=${type}&page=${page}&sort=${sort}`)
}

export const getSame = async ({}, {type = 'database', page = 1, sort = 'desc'}) => {
    return await api(`/api/streams-same-amount?type=${type}&page=${page}&sort=${sort}`)
}


function api(url) {
    const token = localStorage.getItem('access_token')
    return axios.get(url + '', {headers: {'Authorization': `Bearer ${token}`}})
}