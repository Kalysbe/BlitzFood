// import axios from "axios";
import Api from '../api'

export default {
  namespaced: true,
  actions: {
    async getUserList({commit}) {
      try {
        const {data} = await Api.UserList()
        commit('setUsersList', data)
      } catch (error) {}
    },

    async resetUser({commit}, id) {
      try {
        const res = await Api.resetUserPassword({user_id: id})
        if (res.status == 200) {
            commit('toggleShowSnackbar', true)
        }
        setTimeout(() => {
            commit('toggleShowSnackbar', false)

        }, 5000)
      } catch (error) {
        commit('toggleShowSnackbar', false)
      }
    },
    closeShowSnackbar({commit}){
        commit('toggleShowSnackbar', false)
    },

    async addNewCompany({commit, dispatch}, data) {
      try {
        let res = await Api.newCompany(data.company)
        if (res.status === 200) {
          let user = {
            login: data.login,
            idcompany: res.data.id
          }
          const query = await Api.newCompanyUser(user)
          if(query.status === 204){
            dispatch('getUserList')
          }
          return res
        }
      } catch (error) {
        return error
      }
  },
    
  },
  mutations: {
    setUsersList(state, users) {
      state.users = users
    },
    toggleShowSnackbar(state, data) {
      state.showSnackbar = data
      
    }
  },
  state: {
    users: [],
    showSnackbar: false,
    msgpass:''
  },
  getters: {
    getAllUsersList(state) {
      return state.users
    },
    getShowSnackbar(state) {
      return state.showSnackbar
    }
  }
}
