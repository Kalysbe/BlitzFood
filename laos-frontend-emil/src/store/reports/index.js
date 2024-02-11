import api from '@/api/index'

export default {
  state: {report_data: {headers: [], rows: []}, contract_report_data: {headers: [], rows: []}},
  actions: {
    // //----------------amkha----------------------------
    // async LOAD_CONTRACT_REPORTS_LIST({}) {
    // // console.log("LOAD_CONTRACT_REPORTS_LIST-Reports")
    //   try {
    //     const res = await Api.load_contracts_data_reports_list()
    //     // console.log("DATA-LIST-Reports", res.data.rows)
    //
    //     // const obj = Object.fromEntries(res.data.rows)
    //     // console.log("Object:",obj);
    //
    //     const arr_obj = res.data.rows.map((x)=>{
    //       return {'key': x[0], 'value': x[1]}
    //     })
    //     // console.log("arr_obj:",arr_obj);
    //
    //     const {status, data} = res
    //     if (status === 200) {
    //       // return data.reports
    //       return arr_obj
    //     } else {
    //       throw `Load list of contract reports status: ${status}`
    //     }
    //   } catch (err) {
    //     throw `Load contract: ${err}`
    //   }
    // },
    // async LOAD_CONTRACT_REPORT_DATA({commit}, type) {
    //   // console.log('LOAD_REPORT_DATA-store:', type)
    //   try {
    //     const res = await api.reports.load_contract_report_data(type)
    //     const {status, data} = res
    //     if (status === 200) {
    //       commit('SET_REPORT_DATA', data)
    //     } else {
    //       throw `Load contract report data status: ${status}`
    //     }
    //   } catch (err) {
    //     throw `Load contract report data: ${err}`
    //   }
    // },
    //--------------------------------------------------------------------
    async LOAD_REPORTS_LIST(context, section='general') {
      try {
        const res = await api.reports.load_reports_list(section)
        const {status, data} = res
        if (status === 200) {
          return data.reports
        } else {
          throw `Load list of reports status: ${status}`
        }
      } catch (err) {
        throw `Load dashboard: ${err}`
      }
    },
    async LOAD_REPORT_DATA({commit}, payload) {
      try {
        commit('SET_REPORT_DATA', {data:{headers:[], rows:[]}})
        const {sector='general', type} = payload
        const res = await api.reports.load_report_data(type)
        const {status, data} = res
        if (status === 200) {
          commit('SET_REPORT_DATA', data)
        } else {
          throw `Load report data status: ${status}`
        }
      } catch (err) {
        throw `Load report data: ${err}`
      }
    }
  },
  mutations: {
    SET_REPORT_DATA(state, report_data) {
      state.report_data = {...report_data.data}
    },
    SET_CONTRACT_REPORT_DATA(state, report_data) {
      state.contract_report_data = {...report_data.data}
    }, 
  },
  getters: {}
}
