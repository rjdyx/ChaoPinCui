// 接口统一管理
const env = require('projectRoot/env.js')
const { pre } = require('../utils/api')

export function fetchToken () {
    return axios.get(env.host + '/token')
}

export function fetchKit (cookies) {
    return typeof window === 'undefined'
        ? axios.get(env.host + '/kit', { headers: { Cookie: cookies } })
        : axios.get(env.host + '/kit')
}

export function fetchTokenAndKit (cookies) {
    return axios.all([fetchToken(), fetchKit(cookies)])
}
