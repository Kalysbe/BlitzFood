/*---------  ACCIDENTS  ---------------------*/

const currDate = new Date()
const fDate = currDate.toISOString().split('T')[0]
const fTime = currDate.toISOString().split('T')[1].substring(0, 5)

const tempAccidents = []
for (let i = 1; i < 10; i += 1) {
    tempAccidents.push({
        accident_id: i,
        accident_date: fDate,
        accident_time: fTime,
        province_id: Math.round(Math.random() * 10 + 5),
        district_id: Math.round(Math.random() * 10 + 5),
        road_id: Math.round(Math.random() * 10 + 5),
        start_m: Math.round(Math.random() * 100 + 5),
        type: "Accident type",
        detail_description: "Accident Description",
        responses: "Responses",
        possible_causes: "Posible Causes",
        preventive_measures: "Preventive measures",
        submitted_by: 1,
        submitted_at: fDate,
        reviewed_by: 2,
        reviewed_at: fDate,
    })
}

/**
 * @typedef {Object} Accident
 * @property {number} accident_id - Accident ID
 * @property {string} accident_date - Accident Date
 * @property {string} accident_time - Accident Time
 * @property {number} province_id - Province ID
 * @property {number} district_id - District ID
 * @property {number} road_id - Road ID
 * @property {number} start_m - Start m
 * @property {string} type - Accident Type
 * @property {string} detail_description - Accident detail description
 * @property {string} responses - Responses | Corrective Actions Taken
 * @property {string} possible_causes - Possible causes
 * @property {string} preventive_measures - Suggested preventive measures
 * @property {number} submitted_by - Submit user ID
 * @property {datetime} submitted_at - Submit date
 * @property {number} reviewed_by - Review user ID
 * @property {datetime} reviewed_at - Review date
 */

/**
 * @typedef {Object} DtoAccident
 * @property {string} accident_date - Accident Date
 * @property {string} accident_time - Accident Time
 * @property {number} province_id - Province ID
 * @property {number} district_id - District ID
 * @property {number} road_id - Road ID
 * @property {number} start_m - Start m
 * @property {string} type - Accident Type
 * @property {string} detail_description - Accident detail description
 * @property {string} responses - Responses | Corrective Actions Taken
 * @property {string} possible_causes - Possible causes
 * @property {string} preventive_measures - Suggested preventive measures
 * @property {number} submitted_by - Submit user ID
 * @property {datetime} submitted_at - Submit date
 * @property {number} reviewed_by - Review user ID
 * @property {datetime} reviewed_at - Review date
 */

export default Api => ({
    /** Returns accidents list
     * @param filter - Filter value (location, district, road, etc...)
     * @return {Promise<Array<Accident>>}
     */
    loadList(filter) {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({data: tempAccidents, status: 200});
            }, 300);

        })
        // return Api.get(`/monitoring/accidents?filter`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Adds accident to list
     * @param {DtoAccident} data - Accident data
     * @return {Promise<{status}>}
     */
    add(data) {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({status: 201});
            }, 300);

        })
        // return Api.post(`/monitoring/accidents`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Updates accident data
     * @param {number} id - Accident id
     * @param {DtoAccident} data - Accident data
     * @return {Promise<{status}>}
     */
    update(id, data) {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({status: 200});
            }, 300);

        })
        // return Api.put(`/monitoring/accident/${id}`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Deletes accident from list
     * @param {number} id - Accident id
     * @return {Promise<{status}>}
     */
    delete(id) {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({status: 200});
            }, 300);

        })
        // return Api.delete(`/monitoring/accident/${id}`,  {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },
})