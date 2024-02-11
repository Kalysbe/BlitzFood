/*---------  ENVIRONMENTALS  ---------------------*/

const currDate = new Date()
const fDate = currDate.toISOString().split('T')[0]
const fTime = currDate.toISOString().split('T')[1].substring(0, 5)

const tempEnvironments = []
for (let i = 1; i < 10; i += 1) {
  tempEnvironments.push({
    environment_id: i + 1,
    province: 6,
    district: 603,
    road_name: '6.0000008',

    road_no: i,
    link_no: 'Link no ',
    type_of_monitoring: {
      name: 'Annual/semi-annual',
      id: 4
    },
    location: i + '_location_map_image.png',
    detail_description: '',
    tables: [
      {
        headers: ['Activities', 'Implementation', 'Comments', 'Action'],
        rows: [
          {
            activities: 'Activities 1',
            implementation: 'Satisfactory',
            comment: 'jnk'
          },
          {
            activities: 'Activities 2',
            implementation: 'Satisfactory',
            comment: 'jnk'
          },
          {
            activities: 'Activities 3',
            implementation: 'Satisfactory',
            comment: 'jnk'
          }
        ]
      }
    ],
    distributed: [
      {
        distributed: 'MPWT-ESD/PTI',
        active: true,
        value: new Date().toISOString().slice(0, 10)
      },
      {
        distributed: 'MPWT-TD/DOR',
        active: true,
        value: new Date().toISOString().slice(0, 10)
      },
      {
        distributed: 'DPWT–ESU',
        active: false,
        value: new Date().toISOString().slice(0, 10)
      },
      {
        distributed: 'MONRE/DONRE',
        active: false,
        value: new Date().toISOString().slice(0, 10)
      }
    ],
    groups: [
      {
        field: 'compiled',
        fields: {
          name: 'Alex',
          designation: 'Alex designation',
          date: '2023-05-20'
        }
      },
      {
        field: 'verified',
        fields: {
          name: 'Bob',
          designation: 'Bob designation',
          date: '2023-05-20'
        }
      }
    ],
    image_gallery: Array.from(Array(5)).map((item, i) => ({
      thumbnail: `/images/images/road${i + 1}.jpg`,
      meta: `Some image ${i + 1} meta very-very-very long data `,
      previewUrl: `/images/images/road${i + 1}.jpg`
    }))
  })
}

/**
 * @typedef {Object} Environment
 * @property {number} environment_id
 * @property {string} province
 * @property {string} district
 * @property {string} road_name
 * @property {string} road_no
 * @property {Object<TypeOfMonitoring>} type_of_monitoring
 * @property {Object<Location>} location
 * @property {Array<Table>} tables
 * @property {Array<Object>} distributed
 * @property {Array<Object>} groups
 */
/**
 * @typedef {Object} TypeOfMonitoring
 * @property {number} id
 * @property {string} name
 */
/**
 * @typedef {Object} Location
 * @property {number} id
 * @property {string} name
 */
/**
 * @typedef {Object} Table
 * @property {Array<string>} headers
 * @property {Array<Object>} rows
 * @property {Array<Object>} template
 */

/**
 * @typedef {Object} DtoEnvironment
 * @property {number} environment_id
 * @property {string} province
 * @property {string} district
 * @property {string} road_name
 * @property {string} road_no
 * @property {Object<TypeOfMonitoring>} type_of_monitoring
 * @property {Object<Location>} location
 * @property {Array<Table>} tables
 * @property {Array<Object>} distributed
 * @property {Array<Object>} groups
 */

export default (Api) => ({
  /** Returns environment list
   * @param filter - Filter value (location, district, road, etc...)
   * @return {Promise<Array<Environment>>}
   */
  loadList(filter) {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({data: tempEnvironments, status: 200})
      }, 300)
    })
    // return Api.get(`/monitoring/accidents?filter`, {
    //     headers: {
    //         ...type_json
    //     }
    // })
  },

  /** Returns environment list
   * @param {number} - Filter value (location, district, road, etc...)
   * @return {Promise<Array<Environment>>}
   */
  getEnvironmentById(environmentId) {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({
          data: tempEnvironments.filter(
            (env) => env.environment_id == environmentId
          )[0],
          status: 200
        })
      }, 300)
    })
    // return Api.get(`/monitoring/accidents?filter`, {
    //     headers: {
    //         ...type_json
    //     }
    // })
  },

  /** Adds accident to list
   * @param {DtoEnvironment} data - Environmental data
   * @return {Promise<{status}>}
   */
  add(data) {
    return new Promise((resolve) => {
      setTimeout(() => {
        tempEnvironments.push({
          ...data,
          environment_id: tempEnvironments.length + 2
        })
        resolve({status: 201})
      }, 300)
    })
    // return Api.post(`/monitoring/accidents`, data, {
    //     headers: {
    //         ...type_json
    //     }
    // })
  },

  /** Updates Environmental data
   * @param {number} id - Environmental id
   * @param {DtoEnvironment} data - Environmental data
   * @return {Promise<{status}>}
   */
  update(id, data) {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({status: 200})
      }, 300)
    })
    // return Api.put(`/monitoring/accident/${id}`, data, {
    //     headers: {
    //         ...type_json
    //     }
    // })
  },

  /** Deletes Environmental from list
   * @param {number} id - Environmental id
   * @return {Promise<{status}>}
   */
  delete(id) {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({status: 200})
      }, 300)
    })
    // return Api.delete(`/monitoring/accident/${id}`,  {
    //     headers: {
    //         ...type_json
    //     }
    // })
  }
})
