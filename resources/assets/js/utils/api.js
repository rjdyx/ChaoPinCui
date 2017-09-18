// const host = require('projectRoot/env')
/**
 * 接口的前缀
 */
export const pre = (url, middle = 'api') => {
    let regx = /^\/{1,}/g
    url = url.replace(regx, '')
    return '/' + middle + '/' + url
}
