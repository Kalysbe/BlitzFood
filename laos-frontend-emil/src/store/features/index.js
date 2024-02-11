import api from '@/api'

export default {
  state: {
  },
  actions: {
    // LOAD_FEATURES_STRUCTS loads array of features with their actions
    async LOAD_FEATURES_STRUCTS() {
      try {
        const {status, data} = await api.permissions.load_features_objects()
        if (status === 200) {
          return data
        } else {
          throw `Load features structs error, code:${data}`
        }
      } catch (err) {
        throw err
      }
    }
  },
  mutations: {},
  getters: {}
}
