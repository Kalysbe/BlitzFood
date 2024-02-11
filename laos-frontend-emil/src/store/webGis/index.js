import api from '@/api/index'
//import {containsExtent} from 'ol/extent'

// const cartoDbConfig = {
//   layers: [
//     {
//       type: 'cartodb',
//       options: {
//         cartocss_version: '2.1.1',
//         cartocss: '#layer { polygon-fill: #F00; }',
//         sql: 'select * from european_countries_e where area > 0'
//       }
//     }
//   ]
// }

export default {
  state: {
    roadLastRequestHash: {},
    roadsGeoJSON: {},
    mapDefaultParams: {
      viewProjection: '',
      dataProjection: '',
      map_centre: [],
      zoom: null,
      max_zoom: null,
      additional_layers: false
    }
  },
  actions: {
    async LOAD_ROADS_VECTOR_DATA({state, commit}, payload) {
      //const {zoom, lat_min, lat_max, lon_min, lon_max, hash, type} = payload
      const {layer, roadsData} = payload
      try {
        commit('SET_ROADS_GEOJSON', {})
        const resp = await api.webGis.load_roads_data({
          ...roadsData
        })
        const code = resp.status
        if (code === 200) {
          const {hash, data} = resp.data
          if (hash !== state.roadLastRequestHash[layer]) {
            return false
          } else {
            commit('SET_ROADS_GEOJSON', data)
            return true
          }
        } else {
          throw `Load roads data code: ${code}`
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_MAP_DEFAULT_PARAMS({commit}) {
      try {
        const res = await api.webGis.load_map_default_params()
        const {status: code, data} = res
        if (code === 200) {
          commit('SET_MAP_DEFAULT_PARAMS', data)
        } else {
          throw `Load map default params: ${code}`
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_ROADS_LIST_BY_TYPE(context, payload) {
      const {type} = payload
      try {
        const resp = await api.webGis.load_roads_list_by_type({
          type
        })
        const {status, data} = resp
        if (status === 200) {
          return data
        } else {
          throw `Load roads list by type: ${status}`
        }
      } catch (err) {
        throw err
      }
    },

    async LOAD_VECTOR_TYPES({}) {
      try {
        const resp = await api.webGis.load_vector_types()
        const code = resp.status
        if (code === 200) {
          return resp.data
        } else {
          throw `Load vector types: ${code}`
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_ADDITION_VECTOR_TYPES({}) {
      try {
        const resp = await api.webGis.load_addition_vector_types()
        const code = resp.status
        if (code === 200) {
          return resp.data
        } else {
          throw `Load addition vector types: ${code}`
        }
      } catch (err) {
        throw err
      }
    },

    async LOAD_BASEMAP_TYPES({}) {
      try {
        const resp = await api.webGis.load_basemaps()
        const code = resp.status
        if (code === 200) {
          return resp.data
        } else {
          throw `Load basemaps: ${code}`
        }
      } catch (err) {
        throw err
      }
    },
    async LOAD_VECTOR_FILTER_LIST({}, {layer}) {
      try {
        const res = await api.webGis.load_vector_filters({layer})
        const {status, data} = res
        if (status === 200) {
          return data
        } else {
          throw `Load plan filters status: ${status}`
        }
      } catch (err) {
        if (err.response && err.response.status === 422) {
          return []
        }
        throw err
      }
    }
  },
  mutations: {
    SET_ROADS_LAST_REQUEST_HASH(state, hash) {
      for (const [key, value] of Object.entries(hash)) {
        state.roadLastRequestHash[key] = value
      }
    },
    SET_ROADS_GEOJSON(state, data) {
      state.roadsGeoJSON = {...data}
    },
    SET_MAP_DEFAULT_PARAMS(state, data) {
      state.mapDefaultParams = {...data}
    }
  },
  getters: {}
}
