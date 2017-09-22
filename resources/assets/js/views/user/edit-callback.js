export const editCallBack = (id, obj, res) => {
    console.log(res.data.img)
    obj.img = res.data.img
    resolve(obj)
}
