import Api from '../api'

const state = {}
const mutations = {
  SET_SLIDER (state, data) {
    state.slide = data
  }
}
const actions = {

  async addNewSlide ({}, data) {
    try {
      const res = await Api.addNewSlide(data)
      return res
    } catch (error) {

    }
  },
  async GET_SLIDER_IMAGE ({ commit }) {
    try {
      const res = await Api.getSliderImages()
      commit('SET_SLIDER', res.data)
      return res
    } catch (err) {
      return err
    }
  },
  async DELETE_SLIDE_IMAGE ({}, id) {
    try {
      await Api.deleteSlide(id)
      return true
    } catch (err) {
      return err
    }
  }

}
const getters = {
  setSliderImages (state) {
    return state.slide
  }
}

const companyModule = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

export default companyModule
