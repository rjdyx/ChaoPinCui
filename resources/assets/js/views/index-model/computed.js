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
        protosFilter () {
            return this.model.protosFilter
        },
        theadsShort () {
            let realTarget = this.$deepClone(this.model.theads)
            let targetArr = this.model.protos
            let seletedArr = this.protosFilter
            let targetArrLength = targetArr.length - 1
            let seletedArrLength = seletedArr.length - 1
            for (; seletedArrLength >= 0; seletedArrLength--) {
                for (; targetArrLength >= 0; targetArrLength--) {
                    if (seletedArr[seletedArrLength] === targetArr[targetArrLength]) {
                        realTarget.splice(targetArrLength, 1)
                        targetArrLength--
                        break
                    }
                }
            }
            return realTarget
        },
        protosShort () {
            let targetArr = this.$deepClone(this.model.protos)
            let seletedArr = this.protosFilter
            let targetArrLength = targetArr.length - 1
            let seletedArrLength = seletedArr.length - 1
            for (; seletedArrLength >= 0; seletedArrLength--) {
                for (; targetArrLength >= 0; targetArrLength--) {
                    if (seletedArr[seletedArrLength] === targetArr[targetArrLength]) {
                        targetArr.splice(targetArrLength, 1)
                        targetArrLength--
                        break
                    }
                }
            }
            return targetArr
        },
        widths () {
            return this.model.widths
        },
        formRows () {
            return this.model.formRows
        },
        showDetail () {
            return this.model.showDetail
        },
        searchPlaceholder () {
            return this.model.searchPlaceholder
        },
        showTabs () {
            return this.model.showTabs
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
        showFooter () {
            return this.model.showFooter
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
