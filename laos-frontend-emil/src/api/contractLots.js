/*---------  CONTRACTS  ---------------------*/

import {type_json} from "@/api/utils";

/**
 * @typedef {any[]} rowData
 */

/**
 * @typedef {Object} Lot
 * @property {number} id - Lot Id
 * @property {number} id_contract - Contract ID
 * @property {number} lot_no - Lot No
 * @property {String} lot_name - Lot name
 * @property {number} lot_value - Lot value
 * @property {number} local_financing - Lot local financing
 * @property {number} id_province - Province ID
 * @property {number} id_district - District ID
 * @property {number} id_road - Road ID
 * @property {number} start_m - Start meters
 * @property {number} end_m - End meters
 * @property {number} manager_id
 */

/**
 * @typedef {Object} Lots
 * @property {string[]} headers - Headers array
 * @property {rowData[]} rows - Data array
 */

/**
 * @typedef {Object} LotContent
 * @property {<Object>[]} boqs - BOQs
 * @property {Object[]} dayworks - Dayworks
 */

/**
 * @typedef {Object} RefListVal
 * @property {number} id - Id
 * @property {String} name - Name
 */

/**
 * @typedef {Object} LotPayment
 * @property {number} id - Payment ID
 * @property {number} currency_id - Payment currency_id
 * @property {string} currency_name - Payment currency_name
 * @property {number} sum - Payment sum
 * @property {string} paid_at - Payment paid date (value will be null if it is not paid)
 * @property {string} dl - need to clear this prop (value will be null if it is not paid)
 */

/**
 * @typedef {Object} LotBillAdd
 * @property {string} item_no - Item No
 * @property {number} quantity - Item quantity
 * @property {number} price - Item price
 */

const _tableDataPlain = [
    {description: "Performance Security", unit: "lump sum", quantity: 1, unit_price: 34720.00},
    {

        description: "Bank Guarantee for Advance Payment",
        unit: "lump sum",
        quantity: 1,
        unit_price: 50000.00,
    },
    {description: "Insurance of the Works", unit: "lump sum", quantity: 1, unit_price: 20000.00},
    {

        description: "Insurance of Contractor’s Equipment",
        unit: "lump sum",
        quantity: 1,
        unit_price: 30000.00,
    },
    {description: "Third Party Insurance", unit: "lump sum", quantity: 1, unit_price: 20000.00},
]
const _tableContractPayments = [
    {id: 23, currency_id: 2, currency_name: "USD", sum: 38746.78, paid_at: '2023-01-25', dl: '25.02.2023'},
    {id: 34, currency_id: 2, currency_name: "USD", sum: 23456.00, paid_at: null, dl: '25.02.2023'},
    {id: 345, currency_id: 2, currency_name: "USD", sum: 65433.00, paid_at: null, dl: '25.02.2023'},
    {id: 458, currency_id: 2, currency_name: "USD", sum: 46345.34, paid_at: null, dl: '25.02.2023'},
    {id: 176, currency_id: 2, currency_name: "USD", sum: 3245.7, paid_at: '2023-01-25', dl: '25.02.2023'},
    {id: 344, currency_id: 2, currency_name: "USD", sum: 674523.8, paid_at: '2023-01-25', dl: '27.02.2023'},
    {id: 25, currency_id: 2, currency_name: "USD", sum: 123465.07, paid_at: '2023-01-25', dl: '28.02.2023'},
    {id: 39, currency_id: 2, currency_name: "USD", sum: 38345345.13, paid_at: '2023-01-25', dl: '20.02.2023'},
]

function genLotWorks() {
    let bogLst = []
    let dayworkList = []
    let data = []

    for (let i = 1; i < 5; i += 1) {
        data = _tableDataPlain.map((item, index) => {
            const num = i * 100 + 1
            return {...item, item_no: `${num}-${index + 1}`, quantity: Math.floor(Math.random() * 4 + 1)}
        })
        bogLst.push(
            {billGroup: i * 100, data: [...data]}
        )
    }
    for (let i = 1; i < 3; i += 1) {
        data = _tableDataPlain.map((item, index) => {
            return {...item, item_no: `DS${i}-${index + 1}`, quantity: Math.floor(Math.random() * 4 + 1)}
        })
        dayworkList = [...data]
    }

    return {boqs: bogLst, dayworks: dayworkList}

}

export default Api => ({

    /** Returns list of contract lots
     * @return {Promise<Lots>}
     */
    loadLots(contractId) {
        return Api.get(`/contracts/${contractId}/lots`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contract lot details
     * @param {number} contractId - Contract ID
     * @param {number} lotId - Lot ID
     * @return {Promise<Lot>}
     */
    loadLotDetails(contractId, lotId) {
        return Api.get(`/contracts/${contractId}/lots/${lotId}`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contract lot payments
     * @param {number} contractId - Contract ID
     * @param {number} lotId - Lot ID
     * @return {Promise<[LotPayment]>}
     */
    loadLotPayments(contractId, lotId) {
        return new Promise(resolve => {
            return resolve({status:200, data:_tableContractPayments})
        })
        // return Api.get(`/contracts/${contractId}/lots/${lotId}`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Returns contract lot content
     * @param {number} contractId - Contract ID
     * @param {number} lotId - Lot ID
     * @return {Promise<LotContent>}
     */
    loadLotContent(contractId, lotId) {
        // return Api.get(`/contracts/contracts/${contractId}/lots/${lotId}/content`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
        return new Promise(resolve => {
            resolve({status: 200, data: genLotWorks()})
        })
    },

    /** Deletes contract lot daywork item
     * @param {number} contractId - Contract ID
     * @param {number} lotId - Lot ID
     * @param {string} itemNo - Item no
     * @return {Promise<boolean>}
     */
    daywork_delete(contractId, lotId, itemNo) {
        return new Promise((resolve, reject) => {
            resolve({status: 200})
        })
    },

    /** Deletes contract lot bill item
     * @param {number} contractId - Contract ID
     * @param {number} lotId - Lot ID
     * @param {string} itemNo - Item no
     * @return {Promise<boolean>}
     */
    bill_delete(contractId, lotId, itemNo) {
        return new Promise((resolve, reject) => {
            resolve({status: 200})
        })
    },

    /** Adds contract lot bill item
     * @param {number} contractId - Contract ID
     * @param {number} lotId - Lot ID
     * @param {string} billData - Bill Data
     * @return {Promise<boolean>}
     */
    bill_add(contractId, lotId, itemData) {
        return new Promise((resolve, reject) => {
            resolve({status: 200})
        })
    },

    /**
     * Creates a new lot
     * @param {number} contractId - Contract ID
     * @param {Lot} data - Lot params
     * @return {Promise<Lot>} - 200
     */
    add(contractId, data) {
        return Api.post(`/contracts/${contractId}/lots`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Updates a lot
     * @param {Number} contractId - Contract Id
     * @param {Number} lotId - Lot Id
     * @param {Lot} data - Lot params
     * @return {Promise<Lot>} - 200
     */
    update(contractId, lotId, data) {
        return Api.put(`/contracts/${contractId}/lots/${lotId}`, data, {
            headers: {
                ...type_json
            }
        })
    },
})