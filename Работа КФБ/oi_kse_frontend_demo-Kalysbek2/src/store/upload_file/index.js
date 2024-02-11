// import axios from "axios";
import Api from '../api'

export default {
  namespaced: true,
  actions: {
    async uploadFileReport({ commit }, data) {
      try {
        let progress = function( progressEvent ) {
          let procent = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ))
          commit('setProgress', {procent, position: true})
        }
        const res = await Api.uploadFileReport(data, progress);
        commit('report/CLEAR_REPORT_LIST', null, { root: true }); // root:true - означает что мутация глобальная, а не локальная; null - резервация для дальнейших аргументов
        commit('clearReport')
        if(res.status == 200) {
          commit('setProgress', {procent: 0, position: false})
        }
        return res
      } catch (error) {

      }
    },
    async deleteFileReport({}, data) {
      try {
        const res = await Api.deleteFileReport(data)
        return res
      } catch (error) {
        
      }
    },
    async setReport({commit}, data) {
      commit('setReport', data)
    }
  },
  mutations: {
    setProgress(state, data) {
      state.percent = data.procent
      state.isUploaded = data.position
    },
    setReport(state, data) {
      if (data.type == 'anex_1')
        state.reportArray.anex_1 = data.doc
      else if (data.type == 'anex_2')
        state.reportArray.anex_2 = data.doc
      else if (data.type == 'listing_prospectus')
        state.reportArray.listing_prospectus = data.doc
      else if (data.type == 'anex_2_1')
        state.reportArray.anex_2_1 = data.doc
    },
    clearReport(state) {
      state.reportArray.anex_1 = null
      state.reportArray.anex_2 = null
      state.reportArray.listing_prospectus = null
    }
  },
  state: {
    percent: 0,
    isUploaded: false,
    reportArray: {
      anex_1: null,
      anex_2: null,
      listing_prospectus: null,
      anex_2_1: null,
    }
  },
  getters: {
    getFileHost(){
      return Api.getHost()
    },
    getPercent(state) {
      return state.percent
    },
    getPosition(state) {
      return state.isUploaded
    },
    getReportByType(state) {
      return state.reportArray
    }
  }
}
