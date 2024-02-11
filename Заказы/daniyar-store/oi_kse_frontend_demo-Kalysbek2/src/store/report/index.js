import Api from '../api'
const state = {
  reports: [],
  reports_count: 0,
  reports_view: true
}
const mutations = {
  SET_REPORT_LIST(state, data) {
    state.reports.length = 0
    state.reports = data
    state.reports_count = data.count
  },
  SET_STATUS_REPORT(state, data) {
    //state.reports[key].status = 2
    //console.log('state', state.reports[key].status)
    //console.log(data)
    state.reports.list[data.key].status = data.status
  },
  DELETE_REPORT_FROM_LIST(state, data) {
    state.reports.list.splice(data.key, 1)
  },
  SET_REF_VAL_TO_REPORT(state, data) {
    state.reports.list[data.key].ref = data.ref
  },
  DEL_REF_VAL_TO_REPORT(state, data) {
    delete state.reports.list[data.key].ref
  },
  CLEAR_REPORT_LIST: (state) => {state.reports = []}
}
const actions = {
  async INSERT_REPORT({commit}, report) {
    try {
      const res = await Api.insertReport(report)
      commit('CLEAR_REPORT_LIST')
      if (res.status == '200') {
        return res
      }
      // await Api.insertReport(report).then(() => {
      //   router.push({path: `/dashboard/reports`})
      // })
    } catch (err) {
      return err
    }
  },

  async UPDATE_REPORT({}, {id, doc, status, kvartal, typedoc}) {
    try {
      const res = await Api.updateReport(id, doc, status, kvartal, typedoc)

      return true
    } catch (err) {
      return err
    }
  },

  async DELETE_REPORT({commit}, {id, key}) {
    try {
      const res = await Api.deleteReport(id)
      commit('DELETE_REPORT_FROM_LIST', {data: res.data, key})
      return true
    } catch (err) {
      return err
    }
  },
  async GET_REPORT_LIST({commit}, params) {
    try {
      const res = await Api.getReportList(params)
      const {status, data} = res
      commit('SET_REPORT_LIST', res.data)
      if (status === 200) {
        return res
      }
    } catch (err) {
      return err
    }
  },
  async GET_REPORT_BY_ID({}, id) {
    try {
      const res = await Api.getReportById(id)
      return res.data
    } catch (err) {
      return err
    }
  },
  async SEND_REPORT_TO_ADMIN({commit}, {id, type, key}) {
    try {
      const res = await Api.sendReport(id, type)
      //console.log(res, ' ', key)
      if (res)
        commit('SET_STATUS_REPORT', {data: res.data, key, status: 2})
      return true
    } catch (err) {
      return err
    }
  },

  async GET_USER_PIN({}) {
    try {
      let res = await Api.getUserPin()
      return res
    } catch (error) {
      return error.response.data.message
    }
  },
  async SIGN_REPORT({}, {id, pin, order}) {

    try {
      const res = await Api.signReport(id, pin, order)

      return res
    } catch (err) {
      return err
    }
  },
  async CHECK_SIGN_REPORT({}, {id, order}) {
    try {
      const res = await Api.checkSignReport(id, order)
      return res
    } catch (err) {
      return err
    }
  },
  async GET_REPORT_RECEIPT({commit}, {id, sender, companyName, typedoc, kvartal, datesend, key}) {
    try {
      let date = new Date(datesend)
      let newDate = date.toLocaleDateString()
      const res = await Api.getDocByName('receipt')
      if (res.status === 200) {
        let data = res.data
        data.fields[1].value = companyName
        data.fields[2].value = typedoc
        data.fields[3].value = newDate
        data.fields[4].value = id
        const query = await Api.insertReport(
          {
            docslayoutid: 28,
            typedoc: 'Квитанция',
            xmldoc:JSON.stringify(data),
            sender: 'CONFIRMED',
            status: 3,
            kvartal
          })
        if (query.status === 200) {
          let ref = query.data.idReport
          const confirm = await Api.confirmReport(id, sender, ref)
          if (confirm.status === 200) {
            commit('SET_STATUS_REPORT', {data: confirm.data, key, status: 3})
            commit('SET_REF_VAL_TO_REPORT', {data: confirm.data, key, ref})
            return ref
          }
        }
      }
    } catch (err) {
      return err
    }
  },
  async CONFIRM_REPORT({}, {id, sender, ref}) {
    try {
     let res = await Api.confirmReport(id, sender, ref)
     return res
    } catch (err) {
      return err
    }
  },
  // удалить квитанцию при ошибке подписи эцп
  async DELETE_CONFIRM_REPORT({commit}, data){
    try {
      const res = await Api.deleteConfirmReport(data)
      commit('SET_STATUS_REPORT', {data: res.data, key: data.key, status: 2})
      commit('DEL_REF_VAL_TO_REPORT', {data: res.data, key: data.key})
      return res
    } catch (err) {
      return err
    }
  },

  //отправка сущ факта
  async SEND_NEWS_TO_KSE(
    {},
    {doAddEntry, BlogId, mEntryText, mEntryName, mEntryCompany, titles}
  ) {
    try {
      let res = await Api.addNewsToKSE(
        doAddEntry,
        BlogId,
        mEntryText,
        mEntryName,
        mEntryCompany,
        titles
      )
      
      return res
    } catch (err) {
      return err
    }
  },
  async SEND_REPORTS_TO_KSE({}, {doc, kvartal, company_name}) {
    try {
      let res = await Api.addReportToKSE(doc, kvartal, company_name)
      return res
    } catch (err) {
      return err
    }
  },
  async ADD_LINK_TO_KSE({}, {idfact, link}) {
    try {
      Api.addLinkToFact(idfact, link)
      return true
    } catch (err) {
      return err
    }
  },
  async REVOKE_REPORT({commit}, {id, key}) {
    try {
      const res = await Api.revokeReport(id)
      commit('SET_STATUS_REPORT', {data: res.data, key, status: 1})
      return true
    } catch (err) {
      return err
    }
  },
  async REJECT_REPORT({commit}, {id, key}) {
    try {
      const res = await Api.rejectReport(id)
      commit('DELETE_REPORT_FROM_LIST', {data: res.data, key})
      return true
    } catch (err) {
      return err
    }
  },
  async MOVE_TO_CART_REPORT({}, {id, key}) {
    try {
      const res = await Api.moveToCartReport(id)
      commit('DELETE_REPORT_FROM_LIST', {data: res.data, key})
      return true
    } catch (err) {
      return err
    }
  },
  async GET_CART_LIST({}) {
    try {
      const res = await Api.getCartList()
      const {status, data} = res
      if (status === 200) {
        return data
      }
    } catch (err) {
      return err
    }
  },
  async DELETE_REPORT_FROM_CART({}, id) {
    try {
      Api.deleteReportFromCart(id)
      return true
    } catch (err) {
      return err
    }
  },
  async RESTORE_REPORT_FROM_CART({}, id) {
    try {
      Api.restoreReportFromCart(id)
      return true
    } catch (err) {
      return err
    }
  },
  async ADD_LINK_FILE_TO_KSE({}, fileInfo, companyName, kvartal) {
    try {
      let data = Api.addLinkFileToKSE(fileInfo, companyName, kvartal)
      return data
    } catch (err) {
      return err
    }
  }, //addLinkFileToKSE

  async SEARCH_REPORT({commit}, search) { // поисковик документов
    try {
      let res = await Api.searchReport(search)
      //console.log(res)
      commit('SET_REPORT_LIST', res.data)
      return res
    } catch (err) {
      return err
    }
  }
}

const getters = {
  getReportList(state) {
    return state.reports
  },
  getReportsCount(state) {
    return +state.reports_count
  }
}
const reportModule = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
export default reportModule
