let TableStore = {
    // 此table模块的唯一标识
    key: '',
    // 此table模块的tab名称
    tab: '',
    // 此table模块使用到的通用url
    url: '',
    // url的参数
    urlParams: {},
    // 数据库表名
    database: '',
    // 此table模块的列名称，如['名称', '性别']，不包括checkbox列和序号列
    theads: [''],
    // 此table模块的列属性，与从后端获取到的数据字段名相同
    protos: [''],
    // 过滤不想在列表中显示的数据
    protosFilter: [''],
    // 此table模块的列宽度，不包括checkbox列和序号列的宽度，不填则默认都为50
    widths: [50],
    // 新增/编辑表单数据
    formRows: {},
    // 是否显示每行数据的详情下拉框
    showDetail: false,
    // 搜索框的placeholder
    searchPlaceholder: '请搜索',
    // 是否显示tab栏
    showTabs: true,
    // 是否显示搜索框模块，默认显示
    showSearchModel: true,
    // 是否显示新建按钮，默认显示
    showNewBuild: true,
    // 是否显示导出表格按钮，默认显示
    showOutputExcel: true,
    // 是否显示checkbox列，默认显示
    showCheckbox: true,
    // 是否显示序号列，默认显示
    showNumber: true,
    // 是否显示操作列，默认显示
    showOperateCol: true,
    // 是否显示编辑按钮，默认显示
    showEdit: true,
    // 是否显示删除按钮，默认显示
    showDelete: true,
    // 是否显示分页
    showFooter: true,
    // 决定上边（和搜索模块同行）自定义搜索模块在左边显示还是右边（以搜索模块为中心），
    // 默认"left"
    // 可选"left"或"right"
    searchModelPosition: 'left',
    // 决定上边（和新建按钮同行）自定义按钮在左边显示还是右边（以"新建"和"导出表格"为中心），
    // 默认"left"
    // 可选"left"或"right"
    topOperateButtonPosition: 'left',
    // 决定列表中自定义按钮在左边显示还是右边（以"编辑|删除"为中心），
    // 默认"left"
    // 可选"left"或"right"
    operateButtonPosition: 'left',
    // 自定义搜索模块
    // 此属性为一维数组时，可通过searchModelPosition属性决定模块的位置
    // 此属性为二维数组时，自动将第一个数组在左边显示，第二个在右边显示
    searchModelComponents: [{component: null, params: {}}],
    // 自定义按钮（和新建按钮同行）
    // 此属性为一维数组时，可通过topOperateButtonPosition属性决定按钮的位置
    // 此属性为二维数组时，自动将第一个数组在左边显示，第二个在右边显示
    topOperateComponents: [{component: null, params: {}}],
    // 列表中自定义按钮
    // 此属性为一维数组时，可通过operateButtonPosition属性决定按钮的位置
    // 此属性为二维数组时，自动将第一个数组在左边显示，第二个在右边显示
    operateComponents: [{component: null, params: {}}],
    // 列替换对象
    // 比如需要自定义性别这一列，可写为{sex: sexComponent}
    // 属性名与protos属性数组里的值一致
    // 没被替换的列则简单地根据protos数组显示字符串数据
    colComponents: {},
    // 表单新增时，数据录入前的回调函数
    addActive: null,
    // 表单编辑时，数据录入前的回调函数
    editActive: null,
    // 表单新增成功后的回调函数
    addedActive: null,
    // 表单编辑成功后的回调函数
    editedActive: null,
    // 表单删除时，数据删除前的回调函数
    deleteActive: null
}

/**
 * 对有固定选项的属性进行过滤
 * @param  {String} pro          属性名
 * @param  {String} value        属性值
 * @param  {Array}  filterArr    属性可选的值数组
 * @param  {String} defaultValue 属性默认值
 */
const proFilter = (pro, value, filterArr = ['left', 'right'], defaultValue = 'left') => {
    if (!filterArr.includes(value)) {
        console.error(`${pro}属性必须为left或right，已将其改为默认值left`)
        return defaultValue
    }
    return value
}

/**
 * 将传递过来的对象里面不为undefined的属性赋予新建的实例
 * 为undefined的属性则使用TableStore对象的默认属性赋予新建实例
 * 其中对checkPros数组里面含有属性进行过滤，保证赋值合法
 * @param  {Object} tableStoreParam [description]
 * @return {[type]}                 [description]
 */
const paramsMapInstance = (tableStoreParam = {}) => {
    let tableStoreInstance = {}
    const checkPros = ['searchModelPosition', 'topOperateButtonPosition', 'operateButtonPosition']
    for (let pro in TableStore) {
        if (typeof tableStoreParam[pro] !== 'undefined') {
            if (checkPros.includes(pro)) {
                tableStoreInstance[pro] = proFilter(pro, tableStoreParam[pro])
            } else {
                tableStoreInstance[pro] = tableStoreParam[pro]
            }
        } else {
            tableStoreInstance[pro] = TableStore[pro]
        }
    }
    return tableStoreInstance
}

/**
 * 工厂函数
 */
const tableStoreFactory = (tableStoreParams = {}) => {
    let tableStoreInstance = null
    if (tableStoreParams instanceof Array) {
        tableStoreInstance = []
        for (let tableStoreParam of tableStoreParams) {
            let tableStoreItemInstance = paramsMapInstance(tableStoreParam)
            tableStoreInstance.push(tableStoreItemInstance)
        }
    } else {
        tableStoreInstance = paramsMapInstance(tableStoreParams)
    }
    return tableStoreInstance
}

export { tableStoreFactory }
