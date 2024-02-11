import api from '@/api/index'

export default {
  state: {panel_data: []},
  actions: {
    // //---------------amkha--------------------------------
    // async LOAD_API_DATA_TESTING({}){
    //   try {
    //     const res = await Api.load_api_data_testing()
    //     const code = res.status
    //     if (code === 200) {
    //       return res.data
    //     } else {
    //       throw 'Load swagger docs error'
    //     }
    //   } catch (err) {
    //     throw err
    //   }
    // },
    // async LOAD_CONTRACT_DATA_REPORT({}){
    //   try {
    //     const res = await Api.load_contract_data_report()
    //     const code = res.status
    //     if (code === 200) {
    //       return res.data
    //     } else {
    //       throw 'Load swagger docs error'
    //     }
    //   } catch (err) {
    //     throw err
    //   }
    // },
    // async LOAD_SWAGGER_DOCS({}) {
    //   try {
    //     const res = await Api.load_swagger_docs()
    //     const code = res.status
    //     if (code === 200) {
    //       return res.data
    //     } else {
    //       throw 'Load swagger docs error'
    //     }
    //   } catch (err) {
    //     throw err
    //   }
    // },
    // async LOAD_CONTRACT_LIST({}) {
    //   try {
    //     const res = await Api.load_contract_list()
    //     const code = res.status
    //     if (code === 200) {
    //       return res.data
    //     } else {
    //       throw 'Load contract data error'
    //     }
    //   } catch (err) {
    //     throw err
    //   }
    // },
    //------------------------------------------------------
    async LOAD_DASHBOARD_TABS({}) {
      try {
        const res = await api.dashboard.load_dashboard_tabs()
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Load dashboard tabs error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_DASHBOARD_TAB_DATA({commit}, payload) {
      const {tab_id: id} = payload
      try {
        const res = await api.dashboard.load_dashboard_tab_data(id)
        const {status, data} = res
        if (status === 200) {
          commit('SET_PANEL_DATA', data)
        } else {
          throw `Load dashboard tab data status ${status}`
        }
      } catch (err) {
        throw `Load dashboard: ${err}`
      }
    }
  },
  mutations: {
    SET_PANEL_DATA(state, data) {
      state.panel_data = {...data}
    }
  },
  getters: {}
}
