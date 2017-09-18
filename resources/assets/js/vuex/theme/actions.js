export default {
    switch_theme: ({commit}, param) => commit('SWITCHTHEME', {theme: param}),
    switch_font: ({commit}, param) => commit('SWITCHFONT', {font: param}),
    switch_record: ({commit}, param) => commit('SWITCHRECORD', {record: param}),
    change_siderBar: ({commit}, param) => {
        commit('CHANGESIDERBAR', {siderBar: param})
    }
}
