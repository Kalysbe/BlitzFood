import api from '@/api'

export default {
  state: {},
  actions: {
// LOAD_PERMISSIONS loads permissions list
    async LOAD_PERMISSIONS() {
      try {
        const {status, data} = await api.permissions.load_list()
        if (status === 200) {
          return data
        } else {
          throw `Load permissions list error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },
    // GRANT_PERMISSION grants user role permission
    async GRANT_PERMISSION(context, payload) {
      try {
        const {status, data} = await api.permissions.grant(payload)
        if (status === 200) {
          return data
        } else {
          throw `Grant user role permission error, code:${status}`
        }
      } catch (err) {
        throw err
      }
    },
    // REVOKE_PERMISSION revokes user role permission
    async REVOKE_PERMISSION(context, payload) {
      try {
        const {status, data} = await api.permissions.revoke(payload)
        if (status === 200) {
          return data
        } else {
          throw `Revoke user role permission error, code:${status}`
        }
      } catch (err) {
        throw err
      }
    },
  },
  mutations: {},
  getters: {}
}