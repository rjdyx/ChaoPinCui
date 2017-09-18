import { tableStoreFactory } from './table-store'
export default {
    computed: {
        /**
         * 列表数据和分页
         */
        tableData () {
            return this.$store.state.basicModel.tableData
        },
        totalNum () {
            return this.$store.state.basicModel.totalNum
        },
        num () {
            return this.$store.state.basicModel.num
        },
        paginator () {
            return this.$store.state.basicModel.paginator
        },
        navbarName () {
            return this.$store.state.basicModel.navbarName
        },
        subNavBarName () {
            return this.$store.state.basicModel.subNavBarName
        },
        modelUrlParams () {
            return this.$route.params.model
        },
        model () {
            return tableStoreFactory(this.modelParam)
        },
        key () {
            return this.model.key
        },
        tab () {
            return this.model.tab
        },
        url () {
            return this.model.url
        },
        urlParams () {
            return this.model.urlParams
        },
        theads () {
            return this.model.theads
        },
        protos () {
            return this.model.protos
        },
        widths () {
            return this.model.widths
        },
        searchPlaceholder () {
            return this.model.searchPlaceholder
        },
        showSearchModel () {
            return this.model.showSearchModel
        },
        showNewBuild () {
            return this.model.showNewBuild
        },
        showOutputExcel () {
            return this.model.showOutputExcel
        },
        showCheckbox () {
            return this.model.showCheckbox
        },
        showNumber () {
            return this.model.showNumber
        },
        showOperateCol () {
            return this.model.showOperateCol
        },
        showEdit () {
            return this.model.showEdit
        },
        showDelete () {
            return this.model.showDelete
        },
        searchModelPosition () {
            return this.model.searchModelPosition
        },
        topOperateButtonPosition () {
            return this.model.topOperateButtonPosition
        },
        operateButtonPosition () {
            return this.model.operateButtonPosition
        },
        searchModelComponents () {
            return this.model.searchModelComponents
        },
        topOperateComponents () {
            return this.model.topOperateComponents
        },
        operateComponents () {
            return this.model.operateComponents
        },
        colComponents () {
            return this.model.colComponents
        }
    }
}
