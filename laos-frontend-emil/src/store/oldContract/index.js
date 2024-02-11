import api from '@/api/index'

export default {
  state: {
    contractors_list: [],
    CONTRACT_DATA: {},
    show_new_contract_form: false,
    show_new_lot_form: false,
    show_new_dailywork_form: false,
    show_new_lotpayment_form: false,
    show_new_roadphoto_form: false,
    show_roadenvironment_form: false
  },
  actions: {
    //----------------amkha----------------------------
    
    async LOAD_CONTRACT_LIST({}) {
      console.log("m at: CONTRACT/LOAD_CONTRACT_LIST ")
      try {
        const res = await api.oldContracts.load_contract_list()
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Load contract data error'
        }
      } catch (err) {
        throw err
      }
    },
    async AddNewContract({ commit }, contract) {
      console.log("ADD-CONTRACT:",contract)
      // return
      const res = await api.oldContracts.add_new_contract(contract)
      console.log("RESP-POST-CONTRACT:",res)
      commit('SET_CONTRACT_DATA', contract)
    },
    async setContractData({ commit }, contract) {
      commit('SET_CONTRACT_DATA', contract)
    },
    async showContracForm({ commit }, status) {
      commit('SET_SHOW_FORM', status)
    },
    async showLotForm({ commit }, status) {
      commit('SET_LOT_FORM', status)
    },
    // ---------- Nanthigna -----------
    async showDailyWorkForm({ commit }, status) {
      commit('SET_DAILYWORK_FORM', status)
    },
    async showLotPaymentForm({ commit }, status) {
      commit('SET_LOTPAYMENT_FORM', status)
    },
    async showRoadPhotoForm({ commit }, status) {
      commit('SET_ROADPHOTO_FORM', status)
    },
    async showRoadEnvironmentForm({ commit }, status) {
      commit('SET_ROADENVIRONMENT_FORM', status)
    },
    // ---------------------------------
    // asset_types
    async LOAD_ASSET_TYPES({ }) {
      try {
        const res = await api.oldContracts.load_asset_types()
        // console.log("Load Asset type:", res.data.rows)

        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        // console.log("arr_obj:",arr_obj);

        const { status, data } = res
        if (status === 200) {
          // return data.reports
          return arr_obj
        } else {
          throw `Load asset types status: ${status}`
        }
      } catch (err) {
        throw `Load asset types: ${err}`
      }
    },
    // loand funding sources 
    async _LOAD_FUNDING_SOURCES({ }) {
      try {
        const res = await api.oldContracts.load_funding_sources()
        // console.log("Load Asset type:", res.data.rows)

        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        // console.log("arr_obj:",arr_obj);

        const { status, data } = res
        if (status === 200) {
          // return data.reports
          return arr_obj
        } else {
          throw `Load finding sources status: ${status}`
        }
      } catch (err) {
        throw `Load finding sources: ${err}`
      }
    },
    // loand funding types 
    async _LOAD_FUNDING_TYPES({ }) {
      try {
        const res = await api.oldContracts.load_funding_types()
        // console.log("Load Asset type:", res.data.rows)

        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        // console.log("arr_obj:",arr_obj);

        const { status, data } = res
        if (status === 200) {
          // return data.reports
          return arr_obj
        } else {
          throw `Load finding type status: ${status}`
        }
      } catch (err) {
        throw `Load finding type: ${err}`
      }
    },
    // LOAD_WORK_TYPES
    async LOAD_WORK_TYPES({ }) {
      try {
        const res = await api.oldContracts.load_worktypes()
        // console.log("Load Asset type:", res.data.rows)

        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        // console.log("arr_obj:",arr_obj);

        const { status, data } = res
        if (status === 200) {
          // return data.reports
          return arr_obj
        } else {
          throw `Load contractors status: ${status}`
        }
      } catch (err) {
        throw `Load contractors: ${err}`
      }
    },
    // contrators 
    async LOAD_CONTRACTORS({ }) {
      try {
        const res = await api.oldContracts.load_contractors()
        // console.log("ROW:", res.data.rows)

        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        // console.log("arr_obj:",arr_obj);
        
        const { status, data } = res
        if (status === 200) {
          return arr_obj
        } else {
          throw `Load contractors status: ${status}`
        }
      } catch (err) {
        throw `Load contractors: ${err}`
      }
    },
    // contract_types
    async LOAD_CONTRACT_REPORTS_LIST({ }) {
      // console.log("LOAD_CONTRACT_REPORTS_LIST-STORE")
      // return
      try {
        const res = await api.oldContracts.load_contracts_reports_list()
        const { status, data } = res
        if (status === 200) {
          const arr_obj = res.data.rows.map((x) => {
            return { 'key': x[0], 'value': x[1] }
          })
          return arr_obj
        } else {
          throw `Load list of contract reports status: ${status}`
        }
      } catch (err) {
        throw `Load contract: ${err}`
      }
    },

    async LOAD_REPORT_DATA({ commit }, type) {
      // console.log('LOAD_REPORT_DATA:', type)
      try {
        const res = await api.oldContracts.load_report_data(type)
        const { status, data } = res
        if (status === 200) {
          commit('SET_REPORT_DATA', data)
        } else {
          throw `Load report data status: ${status}`
        }
      } catch (err) {
        throw `Load dashboard: ${err}`
      }
    }
  },
  mutations: {
    SET_CONTRACTORS_LIST: (state,payload) => (state.contractors_list = payload),
    SET_CONTRACT_DATA: (state, payload) => (state.CONTRACT_DATA = payload),
    SET_SHOW_FORM: (state, paypoad) => (state.show_new_contract_form = paypoad),
    SET_LOT_FORM: (state, paypoad) => (state.show_new_lot_form = paypoad),
    SET_DAILYWORK_FORM: (state, paypoad) => (state.show_new_dailywork_form = paypoad),
    SET_LOTPAYMENT_FORM: (state, paypoad) => (state.show_new_lotpayment_form = paypoad),
    SET_ROADPHOTO_FORM: (state, paypoad) => (state.show_new_roadphoto_form = paypoad),
    SET_ROADENVIRONMENT_FORM: (state, paypoad) => (state.show_roadenvironment_form = paypoad),
    SET_REPORT_DATA(state, report_data) {
      //console.log({report_data: report_data.data})
      state.report_data = { ...report_data.data }
    }
  },
  getters: {}
}
