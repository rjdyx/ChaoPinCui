
/**
 *
 * 以数组下标的方式从对象中取数据
 *
 * @param object
 * @param index
 * @returns {*}
 */
exports.getItemFromObject = (object, index) => {
    let arr = Array.from(namesSet)
    return arr[index]
}

exports.objectToString = (array) => {
    let arrNames = []
    for (let item of array) {
        arrNames.push(item.name)
    }
    return arrNames.join('、')
}

exports.rulesToString = (array) => {
    return array.join('|')
}

exports.eventStatus = (status) => {
    switch (status) {
    case 2:
    case 5:
        return '进行中'
    case 3:
    case 6:
        return '已完成'
    }
}
