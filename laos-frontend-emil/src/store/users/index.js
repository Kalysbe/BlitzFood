import api from '@/api'

export default {
  state: {},
  actions: {
    // LOAD_USERS loads user list
    async LOAD_USERS() {
      try {
        const {status, data} = await api.users.load_users()
        if (status === 200) {
          return data
        } else {
          throw `Load user list error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },
    // LOAD_USER_BY_LOGIN loads user props
    async LOAD_USER_BY_LOGIN(context, login) {
      try {
        const {status, data} = await api.users.load_user_by_login(login)
        if (status === 200) {
          return data
        } else {
          throw `Load roles list error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // ADD_USER creates a new user
    async ADD_USER(context, payload) {
      try {
        const {status = 0, response} = await api.users.add(payload)
        if (status === 201) {
          return 'added'
        } else {
          throw `Add user error, status: ${response.status}, ${response.data}`
        }
      } catch (err) {
        throw err
      }
    },

    // UPD_USER  updates a user
    async UPD_USER(context, payload) {
      const {login, data} = payload
      const {status = 0, response} = await api.users.update(login, data)
      try {
        if (status === 204) {
          return 'updated'
        } else {
          throw `Upd user error, status: ${response.status}, ${response.data}`
        }
      } catch (err) {
        throw err
      }
    },
    async SET_USER_PASSWORD(context, payload) {
      try {
        const {status, data, response} = await api.users.set_password(payload)
        if (status === 204) {
          return data
        } else {
          throw `Set user password error, status:${response.status}, ${response.data}`
        }
      } catch (err) {
        throw err
      }
    }
  },
  mutations: {},
  getters: {}
}