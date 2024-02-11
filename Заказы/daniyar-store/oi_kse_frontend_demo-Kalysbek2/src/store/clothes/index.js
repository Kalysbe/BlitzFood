import Api from '../api'

const state = {
  clothes: [],
  cloth_detail: null,
}
const mutations = {
  SET_CLOTHES(state, data){
    state.clothes = data.list
  },
  SET_CLOTH(state , data){
    state.cloth_detail = data
  },
}
const actions = {
    async addClothes ({}, data) {
      console.log(data)
        try {
          const res = await Api.addNewClothes(data)
          return res
        } catch (error) {
    
        }
    },
  async GET_CLOTHES({commit}, data) {
    try {
      const res = await Api.getClothes(data)
      console.log(res,'35')
      commit('SET_CLOTHES', res.data)
      return res
    } catch (error) {
      
    }
  },
  async GET_CLOTH_BY_ID({commit}, data) {
    try {
      const res = await Api.getClothById(data)
      commit('SET_CLOTH', res.data)
    } catch (error) {
      console.log(error)
    }
  },
 



}
const getters = {
  getClothes(state){
    return state.clothes
  },
  getClothById(state) {
    return state.cloth_detailt
  },
 
 


}



const clothesModule = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

export default clothesModule
