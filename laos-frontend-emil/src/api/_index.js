import axios from 'axios'

function encode(val) {
  return encodeURIComponent(val)
    .replace(/%3A/gi, ':')
    .replace(/%24/g, '$')
    .replace(/%2C/gi, ',')
    .replace(/%20/g, '+')
    .replace(/%5B/gi, '[')
    .replace(/%5D/gi, ']')
}

const paramsSerializer = function(params) {
  const parts = []
  Object.keys(params).forEach((item) => {
    let val = params[item]
    if (val === null || typeof val === 'undefined') {
      return
    }

    if (Array.isArray(val)) {
      item = item + ''
    } else {
      val = [val]
    }

    val.forEach((elem) => {
      if (elem instanceof Date && !isNaN(elem.valueOf())) {
        elem = elem.toISOString()
      } else if (typeof elem === 'object') {
        elem = JSON.stringify(elem)
      }

      parts.push(encode(item) + '=' + elem)
    })
  })

  return parts.join('&')
  // return a query string
}

const {VUE_APP_BACK_SERVER} = process.env
const API_ROOT = VUE_APP_BACK_SERVER

const Api = axios.create({
  baseURL: API_ROOT,
  withCredentials: false,
  headers: {
    Accept: 'application/json',
    Authorization: `Bearer`
  }
})

const type_json = {'Content-Type': 'application/json'}

export default {
  setHeaderAuth(token) {
    Api.defaults.headers['Authorization'] = `Bearer ${token}`
  },
  delHeaderAuth() {
    delete Api.defaults.headers.common['Authorization']
  },

  /*---------  AUTH  ---------------------*/
  /** */
  /** Login
   * @param {string} username // user name
   * @param {string} password // password
   * @returns {string} - 200 access_toke
   * @throws Error
   */
  login(data) {
    const {login, password} = data
    return Api.post(`/auth/login`, {
      username: login,
      password
    })
  },
  logout() {
    return Api.post(`/auth/logout`)
  },

  /*---------  APP OPTIONS  ---------------------*/
  /** */
  /** App
   * @returns {Object} - 200
   * {
   *  <String>sidebar_text,
   *  <String>title_text,
   *  <String>logo
   * }
   * @throws Error
   */
  load_app_options() {
    return Api.get(`/app`, {
      headers: {
        ...type_json
      }
    })
  },
  /*---------  USERS  ---------------------*/
  /** User personal data
   * @returns {Array} dashboard-items
   * {
      "id": integer,
      "username": string,
      "first_name": string,
      "last_name": string,
      "role": string,
      "created_at": datetime,
      "updated_at": null|datetime,
      "deleted_at": null|datetime
    }
   */
  load_user_profile() {
    return Api.get(`/users/me`, {
      headers: {
        ...type_json
      }
    })
  },

  /*---------  KPI  ---------------------*/
  /** Dashboard tabs
   * @returns {Array} dashboard-tabs
   * [{
      "id": 1,
      "name": "translate.dashboard-1"
    },
    {
      "id": 2,
      "name": "translate.dashboard-2"
    },
    {
      "id": 3,
      "name": "translate.dashboard-3"
    }]
   */
  //-------------------amkha-----------contracts/contracts
  load_api_data_testing(){
    return Api.get(`/contracts/work_tasks`, {
      headers: {
        ...type_json
      }
    })
  },
  load_swagger_docs(){
    return Api.get(`/swagger.json`, {
      headers: {
        ...type_json
      }
    })
  },
  
  add_new_lot(id_contract,lot){
    // console.log("API-LOT:", lot)
    return Api.post(`/contracts/contracts/${id_contract}/lots`, lot)
    // return Api.post(`/contracts/contracts`, contract)
  },
  add_new_contract(contract) {
    // const {login, password} = data
    console.log("API-contract:", contract)
    // return
    return Api.post(`/contracts/contracts`, contract)
  },
  load_districts_list_all(){
    return Api.get(`/contracts/districts`, {
      headers: {
        ...type_json
      }
    })
  },
  load_roads_list(province_id){
    return Api.get(`/contracts/roads/${province_id}`, {
      headers: {
        ...type_json
      }
    })
  },
  load_province_list(){
    return Api.get(`/contracts/provinces`, {
      headers: {
        ...type_json
      }
    })
  },
  load_districts_list(province_id) {
    return Api.get(`/contracts/districts/${province_id}`, {
      headers: {
        ...type_json
      }
    })
  },
  load_contracts_reports_list() {
    // console.log("load_contracts_reports_list:API")
    // return
    return Api.get(`/contracts/contract_types`, {
      headers: {
        ...type_json
      }
    })
  },
  
  load_contract_list() {
    // return Api.get(`/swagger.json`, {
      return Api.get(`/contracts/contracts`, {
        headers: {
          ...type_json
        }
      })
    },
  //----------load lots list
  load_lots_list(contract_id) {
    // return Api.get(`/contracts/contracts/1/lots`, {
      return Api.get(`/contracts/contracts/${contract_id}/lots`, {
        headers: {
          ...type_json
        }
      })
    },
    // add_lot_list(contract_id) {
    //   // return Api.get(`/contracts/contracts/1/lots`, {
    //     return Api.post(`/contracts/contracts/${contract_id}/lots`, {
    //       headers: {
    //         ...type_json
    //       }
    //     })
    //   },
    //-----------------------------------------
  load_dashboard_tabs() {
    return Api.get(`/kpis/dashboard/tabs`, {
      headers: {
        ...type_json
      }
    })
  },

  /** Dashboard tab data
   * @returns {Array} dashboard data
   */

  async load_dashboard_tab_data(id) {
    return Api.get(`/kpis/dashboard/tabs/${id}`, {
      headers: {
        ...type_json
      }
    })
  },

  /*  ---------  TRANSLATING  ---------------------*/
  /** list of localisation
   * @return {Promise<*> {}} 
   * {
        "en": "English",
        "fi": "Suomi"
      } - 200	Default Response
   * @throws Error
   */
  load_locales_list() {
    return Api.get(`/localisation/list`, {
      headers: {
        ...type_json
      }
    })
  },

  /** list of all translating keys
   * @return {Promise<*> [item]} 
   * item: {
        "id": number,
        "category": string,
        "key": string,
        "en": string,
        "ru": string,
        "kg": string
        }
    ,} - 200	Default Response
   * @throws Error
   */
  load_translate_list() {
    return Api.get(`/localisation/all`, {
      headers: {
        ...type_json
      }
    })
  },
  /** User interface's translate
   * @return {Promise<*> {item}}
   * category: {
   *  key: string
   * } - 200	Default Response
   * @throws Error
   */
  load_ui_messages(lang) {
    return Api.get(`/localisation/${lang}`, {
      headers: {
        ...type_json
      }
    })
  },

  /** Login form interface's translate
   * @return {Promise<*> {item}}
   * category: {
   *  key: string
   * } - 200	Default Response
   * @throws Error
   */
  load_login_messages(lang) {
    return Api.get(`/localisation/login_strings/${lang}`, {
      headers: {
        ...type_json
      }
    })
  },

  /** add translate entry
   * @param {object} entry 
  * {
      "category": "string",
      "key": "string",
      "en": "string",
      "kg": "string",
      "ru": "string"
    }
   * @return {Promise<*> {}} - 201	Default Response
   * {
      "id": integer,
      "category": "string",
      "key": "string",
      "en": "string",
      "kg": "string",
      "ru": "string"
    }
   * @throws Error
   */
  add_translate_entry(item) {
    return Api.post(
      `/localisation`,
      {...item},
      {
        headers: {
          ...type_json
        }
      }
    )
  },
  /** upd translate entry
  * @param {integer} id 
  * @param {object} entry 
  * {
      "category": "string",
      "key": "string",
      "en": "string",
      "kg": "string",
      "ru": "string"
    }
   * @return {Promise<*> []} - 201	Default Response
   * @throws Error
   */
  upd_translate_entry(id, item) {
    return Api.put(
      `/localisation/${id}`,
      {...item},
      {
        headers: {
          ...type_json
        }
      }
    )
  },
  /** ------------ REPORTS ------------------- */

// ---------------
  /** list of report types
   * @return {Promise<*> [reports]} 
   * reports: [
   *  {
            "key": "first",
            "value": "reports.first"
        },
        {
            "key": "second",
            "value": "reports.second"
        }
    ] - 200	Default Response
   * @throws Error
   */
  //-----------------AMKHA------------------
  // load_funding_sources(){
  //   return Api.get(`/contracts/funding_sources`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },
  // load_funding_types(){
  //   return Api.get(`/contracts/funding_types`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },
  // load_worktypes(){
  //   return Api.get(`/contracts/worktypes`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },
  // load_contractors(){
  //   return Api.get(`/contracts/contractors`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },
  // load_asset_types(){
  //   return Api.get(`/contracts/asset_types`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },
  load_contracts_data_reports_list(){
    return Api.get(`/contracts/contract_types`, {
      headers: {
        ...type_json
      }
    })
  },
  load_contract_report_data(type){
      // return Api.get(`/reports/data/${type}`, {        this give a bad request
      // return Api.get(`/contracts/contracts_types/${type}`, {
        return Api.get(`/contracts/contracts`, {
        headers: {
          ...type_json
        }
      })
    },
    //-------------------------------------
  // load_reports_list() {
  //   return Api.get(`/reports/list`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },
  // /** load report data
  //  * @param {String} type
  //  * @return {Promise<*> [data]}
  //  *  "data": [
  //       {
  //           "Tien nimi": "Aallontie",
  //           "Pituus (m)": 254.0,
  //           "Hallinnollinen luokka": 2,
  //           "Toiminnallinen luokka": 5,
  //           "Leveys (m)": 5.0
  //       },
  //   ] - 200	Default Response
  //  * @throws Error
  //  */
  // load_report_data(type) {
  //   return Api.get(`/reports/data/${type}`, {
  //     headers: {
  //       ...type_json
  //     }
  //   })
  // },

  /** ------------ ROADS ------------------- */
  /** load webGis data
   * webgis/data?lon_max=-61.05&lat_max=-61.4&lon_min=13.95&lat_min=14&zoom=10&var={iri, webGis, traffic}&hash=brown
   * @param {integer} zoom
   * @param {float} lat_min
   * @param {float} lat_max
   * @param {float} lon_min
   * @param {float} lon_max
   * @param {float} type
   * 
   * @return {Promise<*> []} - 200	Default Response
   * {
    "hash": "brown",
    "data": [
        {
          "road": "A10",
          "values": [
              {
                "start": 0,
                "end": 20,
                "lat": 13.7297927736808,
                "lon": -60.9515961042504,
                "iri": 10.2
              }
          ]
        }
      ]
    }
   * @throws Error
   */
  async load_roads_data({
    zoom,
    lat_min,
    lat_max,
    lon_min,
    lon_max,
    hash,
    type,
    road,
    types,
    filter_by,
    filter_values
  }) {
    const params = {
      zoom,
      lat_min,
      lat_max,
      lon_min,
      lon_max,
      hash,
      var: type,
      all_vars: types.join(','),
      road
    }
    if (filter_by) {
      params.filter_by = filter_by
      params.filter_values = filter_values
    }
    const res = await Api.get(
      `/webgis/data`,
      {
        params,
        paramsSerializer
      },
      {
        headers: {
          ...type_json
        }
      }
    )
    return res
  },

  /** load webGis list by type
   * webgis/webGis/iri
   * @param {String} type
   * @return {Promise<*> []} - 200	Default Response
   * {
    "webGis": [
        {
            "roadcode": "A10",
            "road_name": "Vieux Fort to SoufriÃ¨re",
            "iri": 4.8
        }
      ]
    }
   * @throws Error
   */
  async load_roads_list_by_type({type}) {
    const res = await Api.get(`/webgis/roads/${type}`, {
      headers: {
        ...type_json
      }
    })

    return res
  },

  /** load map default params
   * webgis/default_parameters
   * 
   * @return {Promise<*> {}} - 200	Default Response
   * {
    "view_projection": "EPSG:3857",
    "data_projection": "EPSG:4326",
    "map_centre": [
        -60.98347663879394,
        13.91708027258394
    ],
    "zoom": 11,
    "max_zoom": 18,
    "additional_layers": true
}
   * @throws Error
   */
  async load_map_default_params() {
    const res = await Api.get(`/webgis/default_parameters`, {
      headers: {
        ...type_json
      }
    })

    return res
  },

  /** load vector types
   * webgis/layers
   * @return {Promise<*> []} - 200	Default Response
   * {
    "layers": [
        {
          "key": "iri",
          "value": "map_layers.iri"
        }
      ]
    }
   * @throws Error
   */
  async load_vector_types() {
    const res = await Api.get(`/webgis/layers`, {
      headers: {
        ...type_json
      }
    })

    return res
  },

  /** load addition vector types
   * /webgis/additional_layers
   * @return {Promise<*> []} - 200	Default Response
   * {
      "layers": [
        {
          "key": "bli_points",
          "value": "map_layers.bli_points"
        }
      ]
    }
   * @throws Error
   */
  async load_addition_vector_types() {
    const res = await Api.get(`/webgis/additional_layers`, {
      headers: {
        ...type_json
      }
    })

    return res
  },
  /** Load vector filters
   * @param {String} layer
   * @return {} - 200	Default Response
   */

  async load_vector_filters({layer}) {
    const params = {layer}
    return Api.get(
      `/webgis/filters`,
      {params},
      {
        headers: {
          ...type_json
        }
      }
    )
  },
  /** load basemaps
   * webgis/basemaps
   * @return {Promise<*> []} - 200	Default Response
   * {
    "basemap_tiles": [
        {
            "category": "osm",
            "flavors": [
                {
                    "name": "osm",
                    "props": {
                        "crossOrigin": "anonymous",
                        "wrapX": false
                    }
                }
            ]
        }
      ]
    }
   * @throws Error
   */
  async load_basemaps() {
    const res = await Api.get(`/webgis/basemaps`, {
      headers: {
        ...type_json
      }
    })

    return res
  },

  /*---------  PLANNING  ---------------------*/
  /** Generate plan budget
   * @param {Object} budget
   * @return {} - 200	Default Response
   */

  async plan_budget_generate(payload) {
    return Api.post(
      `/mp/plans`,
      {...payload},
      {
        headers: {
          ...type_json
        }
      }
    )
  },

  /** Genenrate plan data
   * @param {Integer} plan_id
   * @param {String} type
   * @return {} - 201	Default Response
   */

  async generate_plan_data(payload) {
    const {plan_id, type} = payload
    return Api.post(
      `/mp/plans/${plan_id}/works`,
      {type},
      {
        headers: {
          ...type_json
        }
      }
    )
  },

  /** Load plan list
   * @return [{plan}] - 200	Default Response
   */

  async load_plan_list() {
    return Api.get(`/mp/plans`, {
      headers: {
        ...type_json
      }
    })
  },

  /** Load plan parameters
   * @param {String} plan_id
   * @return {} - 200	Default Response
   */

  async load_plan_params(plan) {
    return Api.get(`/mp/plans/${plan}`, {
      headers: {
        ...type_json
      }
    })
  },

  /** Load plan filters
   * @param {String} plan_id
   * @param {String} type
   * @return {} - 200	Default Response
   */

  async load_plan_filters({plan_id, type}) {
    const params = {type}
    return Api.get(
      `/mp/plans/${plan_id}/filters`,
      {params},
      {
        headers: {
          ...type_json
        }
      }
    )
  },

  /** Set plan parameters
   * @param {String} plan_id
   * @param {Object} props {
   *  {Numeric} total_budget,
   *  {Numeric} periodic_budget
   *  {Numeric} routine_budget
   * }
   * @return {} - 201	Success
   */

  async set_plan_params({plan_id, params}) {
    return Api.put(
      `/mp/plans/${plan_id}`,
      {...params},
      {
        headers: {
          ...type_json
        }
      }
    )
  },
  /** Load plan data records
   * @param {String} plan_id
   * @param {Object} reqQuery
   *  {
   *    type,
        page,
        limit,
        filter,
        roadcode
      }
   * @return [{}] - 200	Default Response
   */

  async load_plan_data({plan_id, reqQuery}) {
    return Api.get(
      `/mp/plans/${plan_id}/works`,
      {params: {...reqQuery}, paramsSerializer},
      {
        headers: {
          ...type_json
        }
      }
    )
  },
  /** Save modified plan data
   * @param {String} plan_id
   * @param {Object} changes
   *  {
        "selected": ["string"],
        "deselected": ["string"],
        "type": "string"
      }
   * @return [{}] - 201	Default Response
   */

  async save_plan_data({plan_id, changes}) {
    return Api.put(
      `/mp/plans/${plan_id}/works`,
      {...changes},
      {
        headers: {
          ...type_json
        }
      }
    )
  }
}
