// export const editCallBack = (id, obj, res) => {
//     return new Promise((resolve, reject) => {
//         obj.img = res.data.img
//         console.log(obj)
//         return resolve(obj)
//     })
// }
export const editCallBack = (id, obj, res) => {
    console.log(obj)
    console.log(res.data)
    obj.img = 'res.data.img'
    console.log(obj)
}
