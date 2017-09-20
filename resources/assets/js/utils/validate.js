
/**
 * 手机或固定电话验证
 */
exports.phones = (rule, value, callback) => {
    if (!value) {
        callback()
        return
    }
    let length = value.length
    if ((length === 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value)) || (length === 12 && /^(([0]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/.test(value))) {
        callback()
    } else {
        callback(new Error('格式错误!'))
    }
}

/**
 * 固定电话验证
 */
exports.phone = (rule, value, callback) => {
    if (!value) {
        callback()
        return
    }
    let length = value.length
    if (length === 12 && /^(([0]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/.test(value)) {
        callback()
    } else {
        callback(new Error('格式错误!'))
    }
}

/**
 * 手机验证
 */
exports.cellphone = (rule, value, callback) => {
    if (!value) {
        callback()
        return
    }
    let length = value.length
    if (length === 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value)) {
        callback()
    } else {
        callback(new Error('格式错误!'))
    }
}

/**
 * 专家人数验证
 */
exports.count = (rule, value, callback) => {
    if (value === 'error') {
        callback(new Error('人数超出现有专家总人数!'))
    } else {
        callback()
    }
}
