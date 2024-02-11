import Api from '../api'

const state = {
  doc_list: [],
  doc_title: ''
}
const mutations = {
  SET_DOC_LIST(state, data) {
    state.doc_list = data
  },
  SET_DOC_TITLE(state, title) {
    state.doc_title = title
  }
}
const actions = {
  async GET_DOC_LIST({commit}) {
    try {
      const res = await Api.getDocsList()
      const {status, data} = res
      commit('SET_DOC_LIST', data)
      if (status === 200) {
        return data
      }
    } catch (err) {
      return err
    }
  },

  async GET_DOC_PROPS({commit}, name) {
    try {
      const res = await Api.getDocByName(name)
      const {status, data} = res
      commit('SET_DOC_TITLE', data.title)
      if (status === 200) {
        return data
      }
    } catch (err) {
      return err
    }
  }
}
const getters = {
  getDocList(state) {
    return state.doc_list
  },
  getFactList(state) {
    return state.doc_list.filter(f => {
      return f.name.includes('fact') && f.isview == 1
    })
  },
  getReportList(state) {
    return state.doc_list.filter(f => {
      if (!f.name.includes('fact') && f.isview == 1) 
        return true
    })
  },
  getTitle(state) {
    return state.doc_title
  }
}

const documentsModule = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

export default documentsModule

// GET_DOC_PROPS({ }, name) {

//     return Promise.resolve(docList.find(doc => doc.name === name))
// }
