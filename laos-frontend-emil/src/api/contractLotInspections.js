/*---------  DAILY INSPECTIONS  ---------------------*/

/**
 * @typedef {any[]} rowData
 */

/**
 * @typedef {Object} DailyInspection
 * @property {number} id - Inspection ID
 * @property {number} id_contract - Contract ID
 * @property {number} id_lot - Lot ID
 * @property {string} date - Inspection Date
 * @property {string} work_start_at - Inspection work start
 * @property {Number} duration - Works duration
 * @property {Number} work_cost_amount - works cost amount
 * @property {Number} manager_id
 */

/**
 * @typedef {Object} DailyInspections
 * @property {string[]} headers - Headers array
 * @property {rowData[]} rows - Data array
 */

/**
 * @typedef {Object} RefListVal
 * @property {number} id - Id
 * @property {String} name - Name
 */

/**
 * @typedef {Object} InspectionDataParams
 * @property {number} contractId - Contract ID
 * @property {number} lotId - Lot ID
 * @property {number} insId - Inspection ID
 */

/**
 * @typedef {Object} InspectionSubData
 * @property {number} id - Id
 * @property {String} name - Name
 */


const _inspections = {
    headers: ["id", "date", "work_start_at", "duration", "work_cost_amount", "status"],
    rows: [
        [1, "27.01.2023", "08:00", 480, 19237864, "confirmed"],
        [2, "28.01.2023", "08:00", 430, 346785, "confirmed"],
        [3, "29.01.2023", "08:00", 410, 39278465, "confirmed"],
        [4, "30.01.2023", "08:00", 340, 389475, "confirmed"],
        [5, "31.01.2023", "08:00", 180, 9384734, "not_confirmed"],
    ],
    localisation: []
}
const _inspectionWorks = [
    {work_no: 1, category_of_work: "BoQ", type_of_work: " 303-1 / Prime Coat", details: "km30+300 - km31+623", quantity: "6.615 m2"},
    {work_no: 2, category_of_work: "BoQ", type_of_work: " 303-1 / Prime Coat", details: "km30+300 - km31+623", quantity: "6.615 m2"},
    {work_no: 3, category_of_work: "BoQ", type_of_work: " 303-1 / Prime Coat", details: "km30+300 - km31+623", quantity: "6.615 m2"},
    {work_no: 4, category_of_work: "BoQ", type_of_work: " 303-1 / Prime Coat", details: "km30+300 - km31+623", quantity: "6.615 m2"},
    {work_no: 5, category_of_work: "BoQ", type_of_work: " 303-1 / Prime Coat", details: "km30+300 - km31+623", quantity: "6.615 m2"},
    {work_no: 6, category_of_work: "BoQ", type_of_work: " 303-1 / Prime Coat", details: "km30+300 - km31+623", quantity: "6.615 m2"}]
const _inspectionEquipment = [
    {id: 1, description: 'Road sweeper machine', qty: 1, unit: "hour"},
    {id: 2, description: 'Asphalt mixing plant', qty: 1, unit: "hour"},
    {id: 3, description: 'Wheel loader', qty: 1, unit: "hour"},
    {id: 4, description: 'Backhoe', qty: 1, unit: "hour"},
    {id: 5, description: 'Dragline excavator', qty: 1, unit: "hour"},
    {id: 6, description: 'Bulldozer', qty: 1, unit: "hour"},
    {id: 7, description: 'Wheel tractor scraper', qty: 1, unit: "hour"}]
const _inspectionMaterials = [
    {id: 1, description: 'Cement', qty: 1, unit: "tonne"},
    {id: 2, description: 'Concrete', qty: 1, unit: "tonne"},
    {id: 3, description: 'Bitumen', qty: 1, unit: "tonne"}
]
const _inspectionLabour = [
    {id: 1, description: 'Engineer', qty: 1, unit: "hour"},
    {id: 2, description: 'Skill worker', qty: 1, unit: "hour"},
    {id: 3, description: 'Driver', qty: 1, unit: "hour"},]

export default Api => ({

    /** Returns list of lot daily inspection
     * @return {Promise<DailyInspections>}
     */
    loadDailyInspections(contractId, lotId) {

        return new Promise(resolve => {
            resolve({status: 200, data: _inspections})
        })
        // return Api.get(`/contracts/${contractId}/lots`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Creates a new lot
     * @param {number} contractId - Contract ID
     * @param {Lot} data - Lot params
     * @return {Promise<Lot>} - 200
     */
    // add(contractId, data) {
    //     return Api.post(`/contracts/${contractId}/lots`, data, {
    //         headers: {
    //             ...type_json
    //         }
    //     })
    // },

    /**
     * Updates a lot
     * @param {Number} contractId - Contract Id
     * @param {Number} lotId - Lot Id
     * @param {Lot} data - Lot params
     * @return {Promise<Lot>} - 200
     */
    // update(contractId, lotId, data) {
    //     return Api.put(`/contracts/${contractId}/lots/${lotId}`, data, {
    //         headers: {
    //             ...type_json
    //         }
    //     })
    // },

    /** Returns list of daily inspection works
     * @param {Object<InspectionDataParams>}payload
     * @return {Promise<InspectionSubData>}
     */
    loadDailyInspectionWorksData(payload) {
        const {contractId, lotId, insId} = payload

        return new Promise(resolve => {
            resolve({status: 200, data: _inspectionWorks})
        })
        // return Api.get(`/contracts/${contractId}/lots`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Returns list of daily inspection equipment
     * @param {Object<InspectionDataParams>} payload
     * @return {Promise<InspectionSubData>}
     */
    loadDailyInspectionEquipmentData(payload) {
        const {contractId, lotId, insId} = payload

        return new Promise(resolve => {
            resolve({status: 200, data: _inspectionEquipment})
        })
        // return Api.get(`/contracts/${contractId}/lots`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Returns list of daily inspection materials
     * @param {Object<InspectionDataParams>} payload
     * @return {Promise<InspectionSubData>}
     */
    loadDailyInspectionMaterialsData(payload) {
        const {contractId, lotId, insId} = payload

        return new Promise(resolve => {
            resolve({status: 200, data: _inspectionMaterials})
        })
        // return Api.get(`/contracts/${contractId}/lots`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Returns list of daily inspection labour
     * @param {Object<InspectionDataParams>} payload
     * @return {Promise<InspectionSubData>}
     */
    loadDailyInspectionLabourData(payload) {
        const {contractId, lotId, insId} = payload

        return new Promise(resolve => {
            resolve({status: 200, data: _inspectionLabour})
        })
        // return Api.get(`/contracts/${contractId}/lots`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },
})