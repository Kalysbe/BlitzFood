import Api from '@/api/index'

export default {
  namespaced: true,
  state: {
    report_data: {
      headers: [], rows: []
    },
    lots_list: [],
    LOT_DATA: {}
  },
  actions: {
    //----------------amkha----------------------------
    async ADD_NEW_LOT({ commit },lot) {
      try {
      // console.log("ADD-CONTRACT:",contract_id)
      // // return
      const res = await Api.add_new_lot(lot.id_contract, lot)
      const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Provinces data error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_DISTRICTS_LIST_ALL({}) {
      // console.log("m at: CONTRACT/LOAD_DISTRICTS_LIST_ALL ")
      try {
        const res = await Api.load_districts_list_all()
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Provinces data error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_DISTRICTS_LIST({}, province_id) {
      try {
        const res = await Api.load_districts_list(province_id)
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Provinces data error'
        }
      } catch (err) {
        throw err
      }
    },

    async LOAD_ROADS_LIST({}, procince_id ) {
      console.log("m at: CONTRACT/LOAD_DISTRICT_LIST ")
      try {
        const res = await Api.load_roads_list(procince_id)
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Provinces data error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_ROADS_LIST_VK({}, province_id) {
      try {
        const res = await Api.load_roads_list(province_id)
        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        const code = res.status
        if (code === 200) {
          return arr_obj
        } else {
          throw 'Road data error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_PROVINCE_LIST_KV({}) {
      try {
        const res = await Api.load_province_list()
        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        const code = res.status
        if (code === 200) {
          return arr_obj
        } else {
          throw 'Provinces data error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_DISTRICT_LIST_KV({}, province_id) {
      try {
        // const res = await Api.load_district_list()
        const res = await Api.load_districts_list(province_id)
        const arr_obj = res.data.rows.map((x) => {
          return { 'key': x[0], 'value': x[1] }
        })
        const code = res.status
        if (code === 200) {
          return arr_obj
        } else {
          throw 'District data error'
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_PROVINCE_LIST({}) {
      console.log("m at: CONTRACT/LOAD_province_LIST ")
      try {
        const res = await Api.load_province_list()
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Provinces data error'
        }
      } catch (err) {
        throw err
      }
    },
    async setLotData( { commit }, lot){
      commit('SET_LOT_DATA', lot)
    },
    async LOAD_LOTS_LIST({ commit }, contract_id) {
      console.log("Contract_ID:", contract_id)
      try {
        const res = await Api.load_lots_list(contract_id)
        const code = res.status
        if (code === 200) {
          return res.data
        } else {
          throw 'Load lots data error'
        }
      } catch (err) {
        throw err
      }
      // try {
      //   const res = await Api.load_lots_list(contract_id)
      //   // console.log("Load Asset type:", res.data.rows)
      //   commit('SET_LOTS_LIST', res.data.rows)
      //   const arr_obj = res.data.rows.map((x) => {
      //     return { 'key': x[0], 'value': x[1] }
      //   })
      //   // console.log("arr_obj:",arr_obj);

      //   const { status, data } = res
      //   if (status === 200) {
      //     // return data.reports
      //     return arr_obj
      //   } else {
      //     throw `Load asset types status: ${status}`
      //   }
      // } catch (err) {
      //   throw `Load asset types: ${err}`
      // }
    },
    
  },
  mutations: {
    SET_LOT_DATA: (state,payload) => (state.LOT_DATA = payload),
    SET_LOTS_LIST: (state, payload) => (state.lots_list = payload),
    SET_REPORT_DATA(state, report_data) {
      //console.log({report_data: report_data.data})
      state.report_data = { ...report_data.data }
    }
  },
  getters: {}
}
