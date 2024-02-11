import Api from '../api'

const state = {
 category: []
}
const mutations = {
    SET_CATEGORY(state, data){
        state.category = data.data
    },
}
const actions = {
    async addCategory ({}, data) {
      console.log(data)
        try {
          const res = await Api.addNewCategory(data)
          return res
        } catch (error) {
    
        }
    },
    async GET_CATEGORY({commit}, data) {
        try {
          const res = await Api.getCategory(data)
          commit('SET_CATEGORY', res.data)
          return res.data
        } catch (error) {
          
        }
      },
      async DELETE_CATEGORY ({}, id) {
        console.log(id)
          try {
            const res = await Api.deleteCategory(id)
            return res
          } catch (error) {
      
          }
      },
}
const getters = {
    getCategory(state){
        return state.category
      }
}

const categoryModule = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

export default categoryModule
