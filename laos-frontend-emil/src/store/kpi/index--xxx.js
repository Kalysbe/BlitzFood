import Api from '@/api/index'

export default {
  state: {panel_data: [], contract_data: [], contract_headers: []},
  actions: {
    //---------------amkha--------------------------------
    async LOAD_SWAGGER_DOCS({}) {
      try {
        const res = await Api.load_swagger_docs()
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Load swagger docs error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_CONTRACT_LIST({commit}) {
      try {
        const res = await Api.load_contract_list()
        const code = res.status
        const {status, data} = res
        if (status === 200) {
          commit('SET_CONTRACT_DATA', data)
          // return res.data
        } else {
          throw 'Load contract data error'
        }
      } catch (err) {
        throw err
      }
    },
    //------------------------------------------------------
    async LOAD_DASHBOARD_TABS({}) {
      try {
        const res = await Api.load_dashboard_tabs()
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
        const res = await Api.load_dashboard_tab_data(id)
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
    },
    SET_CONTRACT_DATA(state, payload) {
      console.log("paload:", payload)
      state.contract_data = (payload.rows)
      console.log("state.contract_data:", state.contract_data)
      let y = state.contract_data

      state.contract_headers = (payload.headers)
      let x = state.contract_headers

      console.log("state.contract_headers:", state.contract_headers)
      var my_array = y.map(item=>({
                       item
                      }));
                    console.log("my_array:", my_array)
    }
  },
  getters: {}
}
