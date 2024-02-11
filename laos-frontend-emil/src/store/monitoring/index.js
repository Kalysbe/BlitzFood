import api from '@/api'

export default {
  state: {},
  actions: {
    // LOAD_ACCIDENTS loads accidents list
    async LOAD_ACCIDENTS(context, filter) {
      try {
        const {status, data} = await api.monitoring.accidents.loadList(filter)
        if (status === 200) {
          return data
        } else {
          throw `Load accident list error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // ADD_ACCIDENTS adds accident
    async ADD_ACCIDENT(context, payload) {
      const {data} = payload
      try {
        const {status} = await api.monitoring.accidents.add(data)
        if (status === 201) {
          return true
        } else {
          throw `Add accident error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // UPDATE_ACCIDENT updates accident by id
    async UPDATE_ACCIDENT(context, payload) {
      const {id, data} = payload
      try {
        const {status} = await api.monitoring.accidents.update(id, data)
        if (status === 200) {
          return true
        } else {
          throw `Update accident error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // DELETE_ACCIDENT deletes accident by id
    async DELETE_ACCIDENT(context, id) {
      try {
        const {status} = await api.monitoring.accidents.delete(id)
        if (status === 200) {
          return true
        } else {
          throw `Delete accident error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // LOAD_ENVIRONMENTS loads environments list
    async LOAD_ENVIRONMENTS(context, filter) {
      try {
        const {status, data} = await api.monitoring.environments.loadList(
          filter
        )
        if (status === 200) {
          return data
        } else {
          throw `Load environment list error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },
    // GET_ENVIRONMENT_BY_ID load environment item
    async GET_ENVIRONMENT_BY_ID(context, id) {
      try {
        const {status, data} =
          await api.monitoring.environments.getEnvironmentById(id)
        if (status === 200) {
          return data
        } else {
          throw `Load environment list error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },
    // ADD_ENVIRONMENT adds environment
    async ADD_ENVIRONMENT(context, payload) {
      try {
        const {status} = await api.monitoring.environments.add(payload)
        if (status === 201) {
          return true
        } else {
          throw `Add environment error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // UPDATE_ENVIRONMENT updates environment by id
    async UPDATE_ENVIRONMENT(context, payload) {
      const {id, data} = payload
      try {
        const {status} = await api.monitoring.environment.update(id, data)
        if (status === 200) {
          return true
        } else {
          throw `Update environment error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    },

    // DELETE_ENVIRONMENT deletes environment by id
    async DELETE_ENVIRONMENT(context, id) {
      try {
        const {status} = await api.monitoring.environment.delete(id)
        if (status === 200) {
          return true
        } else {
          throw `Delete environment error, status:${status}`
        }
      } catch (err) {
        throw err
      }
    }
  }
}
