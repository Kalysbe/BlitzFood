import api from '@/api/index'
import {Actions, Features} from '@/routes/consts.js'

export default {
  state: {
    token: localStorage.getItem('rms-token') || '',
    authStatus: '',
    me: {},
    pathAfterLogin: '',
    appOptions: {}
  },
  actions: {
    async LOGIN({commit}, formData) {
      commit('AUTH_REQUEST')
      const {login, password} = formData

      try {
        const resp = await api.auth.login({login, password})
        const {status, data} = resp
        const {access_token} = data
        if (status === 200 && access_token) {
          localStorage.setItem('rms-token', access_token)
          commit('AUTH_SUCCESS', access_token)
          commit('SET_HEADER_AUTH')
        } else {
          throw 'Authorization error'
        }
      } catch (err) {
        commit('AUTH_ERROR')
        localStorage.removeItem('rms-token')
      }
    },
    async LOGOUT({commit}) {
      try {
        await api.auth.logout()
      } finally {
        localStorage.removeItem('rms-token')
        await api.delHeaderAuth()
        commit('AUTH_LOGOUT')
      }
    },

    async LOAD_APP_OPTIONS({commit}) {
      try {
        const res = await api.app.load_app_options()
        commit('SET_APP_OPTIONS', res.data)
      } catch (e) {
        throw `Load app options: ${e}`
      }
    },
    async GET_MY_PROFILE({commit, dispatch}) {
      try {
        const result = await api.users.load_user_profile()
        const permissions = []
        Object.keys(Features).forEach((feature) => {
          Object.keys(Actions).forEach((action) => {
            permissions.push({feature, action})
          })
        })

        const data = {...result.data, permissions}

        // data.menu_items[1].children.push({icon: 'currency_exchange', name: "menu.currency_rates", path: "/contracts/currency-rates"})
        // data.menu_items[1].children.push({icon: 'receipt', name: "menu.boqs", path: "/contracts/boqs"})
        // data.menu_items[1].children.push({icon: 'subject', name: "menu.macs", path: "/contracts/macs"})
        // data.menu_items[1].children.push({icon: 'receipt_long', name: "menu.dayworks", path: "/contracts/dayworks"})
        data.menu_items.push({
          icon: 'fact_check',
          name: 'menu.monitoring',
          children: [
            {
              icon: 'car_crash',
              name: 'menu.accidents',
              path: '/monitoring/accidents'
            },
            {
              icon: 'inventory',
              name: 'menu.grievances',
              path: '/monitoring/grievances'
            },
            {
              icon: 'repeat',
              name: 'menu.environmental_monitoring',
              path: '/monitoring/environmental-monitoring'
            },
            {
              icon: 'group_work',
              name: 'menu.social_monitoring',
              path: '/monitoring/social-monitoring'
            },
            {
              icon: 'yard',
              name: 'menu.impact_evaluation',
              path: '/monitoring/impact-evaluation'
            }
          ]
        })
        data.menu_items.push({
          icon: 'download',
          name: 'menu.import',
          path: '/rams/import'
        })
        //data.menu_items.push({icon: 'settings', name: "old", path: "/old/contracts"})
        commit('SET_USER', data)
      } catch (e) {
        dispatch('LOGOUT')
        throw `Getting profile error: ${e}`
      }
    }
  },
  mutations: {
    AUTH_REQUEST: (state) => {
      state.authStatus = 'loading'
    },
    AUTH_SUCCESS: (state, token) => {
      state.token = token
      state.authStatus = 'success'
    },
    AUTH_ERROR: (state) => {
      state.authStatus = 'error'
    },
    AUTH_LOGOUT: (state) => {
      state.authStatus = ''
      state.token = ''
    },
    SET_HEADER_AUTH: (state) => {
      api.setHeaderAuth(state.token)
    },
    SET_REDIRECT_AFTER_LOGIN: (state, path) => {
      state.pathAfterLogin = path
    },
    SET_USER: (state, profile) => {
      state.me = {...profile}
    },
    SET_APP_OPTIONS: (state, opt) => (state.appOptions = {...opt})
  },
  getters: {
    hasToken: (state) => Boolean(state.token),
    profileLoaded: (state) => Object.keys(state.me).length > 0,
    appOptionsLoaded: (state) => Object.keys(state.appOptions).length > 0
  }
}
