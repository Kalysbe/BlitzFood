/*---------  CONTRACTS  ---------------------*/

import {type_json} from "@/api/utils";

/**
 * @typedef {any[]} rowData
 */

/**
 * @typedef {Object} ContractVariations
 * @property {string[]} headers - Headers array
 * @property {rowData[]} rows - Data array
 * @property {number[]} translate - Translate field num
 */

const _contractVariations = {
    headers: ['id_contract', 'variation_number', 'revised_cost', 'variation_date', 'work_type_id',  'revised_end', 'updated_at', 'updated_by', 'comments'],
    rows: [
        [1, 1, 3728965, "01.05.2023", 1, "01.05.2023", "01.05.2023", "user", "no comment"],
        [1, 2, 37465, "01.05.2023", 1, "01.05.2023", "01.05.2023", "user", "no comment"],
        [1, 3, 9465, "01.05.2023", 1, "01.05.2023", "01.05.2023", "user", "no comment"],
        [1, 4, 465, "01.05.2023", 1, "01.05.2023", "01.05.2023", "user", "no comment"],
        [1, 5, 375, "01.05.2023", 1, "01.05.2023", "01.05.2023", "user", "no comment"],
    ],
    translate: []
}

/**
 * @typedef {Object} Contract
 * @property {string} contract_number
 * @property {string} contract_e_archive_url
 * @property {string} contract_title
 * @property {string} project_name
 * @property {string} id_contract_type
 * @property {string} id_contractor
 * @property {string} id_employer
 * @property {number[]}
 * @property {number[]}
 */

/**
 * @typedef {Object} Contracts
 * @property {string[]} headers - Headers array
 * @property {rowData[]} rows - Data array
 */


/**
 * @typedef {Object} ContractVariation
 * @property {number} id - Contract variation ID
 * @property {number} id_contract - Contract ID
 * @property {number} variation_number - Contract variation number
 * @property {date} variation_date - Variation date
 * @property {number} work_type_id - Variation work type
 * @property {number} revised_cost - Revised cost
 * @property {date} revised_end - Revised end (Date)
 * @property {date} updated_at - Updated at
 * @property {number} updated_by - User ID
 * @property {number} comments - Comments
 */

/**
 * @typedef {Object} VariationItem
 * @property {number} id - Contract variation ID
 * @property {number} id_contract - Contract ID
 * @property {number} variation_number - Contract variation number
 * @property {VariationWork[]} works - Contract variation number
 */

/**
 * @typedef {Object} VariationItemDTO
 * @property {number} variation_number - Contract variation number
 * @property {number} comments - Comments
 */

/**
 * @typedef {Object} VariationWork
 * @property {string} type - type (boq, mac, dw)
 * @property {number} type_id - BoQ, MAC or DayWork ID
 * @property {string} unit - Unit
 * @property {number} quantity - Quantity
 * @property {number} unit_cost - Work unit cost
 * @property {string} description - Description
 */


/**
 * @typedef {Object} RefListVal
 * @property {number} id - Id
 * @property {string} name - Name
 */

/**
 * @typedef {Object} ProvinceRoads
 * @property {string} roadcode - Road code
 * @property {string} roadnumber - Road number
 * @property {number} length_m - Road length (m)
 */

/**
 * @typedef {Object} Boq
 * @property {number} id - record ID
 * @property {number} boq_top - BoQ top
 * @property {string} boq_id - BoQ ID
 * @property {string} boq_description - BoQ description
 * @property {string} unit - Unit
 * @property {string} updated_at - Updated at
 * @property {number} updated_by - User ID
 * @property {number} comments - Comments
 */

/**
 * @typedef {Object} Mac - Maintenance Activity Code
 * @property {number} id - row ID
 * @property {number} mac_top - MAC top num
 * @property {number} mac_group - MAC group
 * @property {number} mac_id - MAC ID
 * @property {string} work_task - Work task
 * @property {string} unit - Unit
 * @property {string} updated_at - Updated at
 * @property {number} updated_by - User ID
 * @property {number} comments - Comments
 */

/**
 * @typedef {Object} DayWork
 * @property {string} ds_id - DS ID
 * @property {number} ds_group - DS group (1-Labor, 2-Materials, 3-Equipment)
 * @property {string} description - Description
 * @property {string} unit - Unit
 */

/**
 * @typedef {Object} ContractWorkType
 * @property {number} id - Work type ID
 * @property {string} name - Work type name
 */

/**
 * @typedef {Object} ContractWorkTypeDto
 * @property {string} name - Work type name
 */


// TODO remove the temp tables

const _dayworks = [
    {id: 1, ds_id: 'DS1-1', ds_group: 1, description: 'Leading hand/ Surveyor', unit: 'hr'},
    {id: 2, ds_id: 'DS1-2', ds_group: 1, description: 'Skilled Operator (Tradesman)', unit: 'hr'},
    {id: 3, ds_id: 'DS1-3', ds_group: 1, description: 'Labourer', unit: 'hr'},
    {id: 4, ds_id: 'DS2-1', ds_group: 2, description: 'Washed natural gravel aggregate', unit: 'm3'},
    {id: 5, ds_id: 'DS2-2', ds_group: 2, description: 'Crushed gravel aggregate', unit: 'm3'},
    {id: 6, ds_id: 'DS2-3', ds_group: 2, description: 'Crushed rock aggregate', unit: 'm3'},
    {id: 7, ds_id: 'DS2-4', ds_group: 2, description: 'Washed sand', unit: 'm3'},
    {id: 8, ds_id: 'DS2-5', ds_group: 2, description: 'Cement', unit: 'tonne'},
    {id: 9, ds_id: 'DS2-6', ds_group: 2, description: 'Cut-back asphalt', unit: 'litre'},
    {id: 10, ds_id: 'DS2-7', ds_group: 2, description: 'Steel reinforcing', unit: 'tonne'},
    {id: 11, ds_id: 'DS2-8', ds_group: 2, description: 'Riprap', unit: 'm3'},
    {id: 12, ds_id: 'DS2-9', ds_group: 2, description: 'Timber planks', unit: 'm3'},
    {id: 13, ds_id: 'DS2-10', ds_group: 2, description: 'Timber props', unit: 'm3'},
    {id: 14, ds_id: 'DS3-1', ds_group: 3, description: 'Dump Truck, 8-10m3', unit: 'hr'},
    {id: 15, ds_id: 'DS3-2', ds_group: 3, description: 'Water Tanker with spray bar', unit: 'hr'},
    {id: 16, ds_id: 'DS3-3', ds_group: 3, description: 'Excavator, 80-100 hp', unit: 'hr'},
    {id: 17, ds_id: 'DS3-4', ds_group: 3, description: 'Bulldozer with ripping equipment, 200-300 hp', unit: 'hr'},
    {id: 18, ds_id: 'DS3-5', ds_group: 3, description: 'Wheel Tractor, 40-60 hp', unit: 'hr'},
    {id: 19, ds_id: 'DS3-6', ds_group: 3, description: 'Motor Grader, 100-120 hp', unit: 'hr'},
    {id: 20, ds_id: 'DS3-7', ds_group: 3, description: 'Track Loader, 180-220 hp', unit: 'hr'},
    {id: 21, ds_id: 'DS3-8', ds_group: 3, description: 'Wheel Loader, 100-150 hp', unit: 'hr'},
    {id: 22, ds_id: 'DS3-9', ds_group: 3, description: 'Steel-wheeled Roller, self-propelled, 10-12t', unit: 'hr'},
    {id: 23, ds_id: 'DS3-10', ds_group: 3, description: 'Rubber-wheeled Roller, self-propelled 10-12t', unit: 'hr'},
    {id: 24, ds_id: 'DS3-11', ds_group: 3, description: 'Vibrating Roller, self-propelled, 12-15t (base)', unit: 'hr'},
    {id: 25, ds_id: 'DS3-12', ds_group: 3, description: 'Padfoot Roller, 60”', unit: 'hr'},
    {id: 26, ds_id: 'DS3-13', ds_group: 3, description: 'Concrete Mixer, 3-6 m3/hr', unit: 'hr'},
    {id: 27, ds_id: 'DS3-14', ds_group: 3, description: 'Poker Vibrator, 4 hp', unit: 'hr'},
]

/**
 * @typedef {Object} DsGroup
 * @property {number} id - ID
 * @property {string} name - Name
 */

const _dsGroups = [
    {id: 1, name: "labour", top: 100},
    {id: 2, name: "materials", top: 100},
    {id: 3, name: "equipment", top: 100},
]


/**
 * @typedef {Object} BoqSubGroup
 * @property {number} id - ID
 * @property {string} name - Name
 * @property {number} top - Boq top number
 */

const _boqSubGroups = [
    {id: 1, name: "securities_and_insurances", top: 100},
    {id: 2, name: "miscellaneous_obligations", top: 100},
    {id: 3, name: "contractors_establishments", top: 100},
    {id: 4, name: "facilities_for_the_project_manager", top: 100},
    {id: 5, name: "laboratories_facilities", top: 100},
    {id: 6, name: "preparatory_works", top: 200},
    {id: 7, name: "removal_works", top: 200},
    {id: 8, name: "general_excavations", top: 200},
    {id: 9, name: "embankment_works", top: 200},
    {id: 10, name: "structural_excavation", top: 200},
    {id: 11, name: "sub_base", top: 300},
    {id: 12, name: "base_course", top: 300},
    {id: 13, name: "prime_coat ", top: 300},
    {id: 14, name: "surface_treatment", top: 300},
    {id: 15, name: "box_culverts", top: 400},
    {id: 16, name: "pipe_culverts", top: 400},
    {id: 17, name: "ditches_apron_protection_and_inlet_and_outlet_structures_for_pipe_culverts", top: 400},
    {id: 18, name: "steel_reinforcement", top: 500},
    {id: 19, name: "structural_concrete", top: 500},
    {id: 20, name: "protection_works", top: 600},
    {id: 21, name: "road_furniture", top: 600},
    {id: 22, name: "traffic_markings", top: 600},
    {id: 23, name: "traffic_signs", top: 600},
    {id: 24, name: "miscellaneous", top: 600},
    {id: 25, name: "general", top: 700},

]

/**
 * @typedef {Object} BoqTop
 * @property {number} id - ID
 * @property {string} name - Name
 */
const _boqTops = [
    {id: 100, name: "general_provisions"},
    {id: 200, name: "earthworks"},
    {id: 300, name: "pavement"},
    {id: 400, name: "drainage",},
    {id: 500, name: "structure",},
    {id: 600, name: "miscellaneous",},
    {id: 700, name: "contractors_environmental_and_social_management_plan",},
]

const _units = [
    {id: "meter", name: "unit.meter"},
    {id: "meter2", name: "unit.meter2"},
    {id: "meter3", name: "unit.meter3"},
    {id: "ml", name: "ml"},
    {id: "hour", name: "unit.hour"},
    {id: "tonne", name: "unit.tonne"},
    {id: "lump_sum", name: "unit.lump_sum"},
    {id: "month", name: "unit.month"}, {
        id: "set",
        name: "unit.set"
    },
    {id: "vehicle_month", name: "unit.vehicle_month"},
    {id: "number", name: "unit.number"},
    {id: "liter", name: "unit.liter"},
    {id: "provisional_sum", name: "unit.provisional_sum"}]

const _variationWorks = [
    {type: "mac", type_id: 222, description: "Reshaping the road ( including ditches )", unit: "meter2", unit_cost: 300, quantity: -9984},
    {type: "mac", type_id: 223, description: "Regravelling", unit: "meter3", unit_cost: 14300, quantity: -315},
    {type: "mac", type_id: 132, description: "Clearing of ditches by machine", unit: "ml", unit_cost: 325, quantity: 4000},
    {type: "mac", type_id: 162, description: "Bush cutting, incl. removal of cut material", unit: "meter2", unit_cost: 200, quantity: 30000},
]

export default Api => ({

    /** Returns list of contracts
     * @return {Promise<Contracts>}
     */
    loadContracts() {
        return Api.get(`/contracts`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contract details
     * @param {number} contractId - Contract ID
     * @return {Promise<Object>}
     */
    loadContractDetails(contractId) {
        return Api.get(`/contracts/${contractId}`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Creates a new contract
     * @param data {Contract} - contract params
     * @return {Promise<null>} - 200
     */
    add(data) {
        return Api.post(`/contracts`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Updates a contract
     * @param {number} id - contract Id
     * @param {Contract} data - contract params
     * @return {Promise<null>} - 200
     */
    update(id, data) {
        return Api.put(`/contracts/${id}`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contractor list
     * @return {Promise<Array<RefListVal>>}
     */
    loadContractors() {
        return Api.get(`/contracts/contractors`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contract type list
     * @return {Promise<Array<RefListVal>>}
     */
    loadContractTypes() {
        return Api.get(`/contracts/contract_types`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns employer list
     * @return {Promise<Array<RefListVal>>}
     */
    loadEmployers() {
        return Api.get(`/contracts/clients`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contract variations list by contract id
     * @return {Promise<Array<ContractVariation>>}
     */
    loadVariations(contractId) {
        // return Api.get(`/contracts/${contractId}/variations`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
        return new Promise(resolve => {
            resolve({status: 200, data: _contractVariations})
        })
    },

    /** Returns contract variations by contract id and variation id
     * @return {Promise<VariationItemDTO>}
     */
    loadVariationsById(contractId, variationId) {
        // return Api.get(`/contracts/${contractId}/variations/${variationId}`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
        return new Promise(resolve => {
            const data = {}
            _contractVariations.headers.forEach((name, index) => {
                data[name] = _contractVariations.rows[0][index]
            })
            resolve({status: 200, data: {...data}})
        })
    },

    /**
     * Creates a new contract variation order
     * @param contractId {number} - contract ID
     * @param data {VariationItemDTO} - variation item props
     * @return {Promise<null>} - 201
     */
    addVariation(contractId, data) {
        return Api.post(`/contracts/${contractId}/variations`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Updates a contract variation order
     * @param {number} contractId - contract ID
     * @param {number} variationId - variation ID
     * @param {VariationItemDTO} data - contract params
     * @return {Promise<null>} - 200
     */
    updateVariation(contractId, variationId, data) {
        return Api.put(`/contracts/${contractId}/variations/${variationId}`, data, {
            headers: {
                ...type_json
            }
        })
    },


    /** Returns contract variation works by contract id and variation id
     * @return {Promise<VariationWork[]>}
     */
    loadVariationWorksById(contractId, variationId) {
        // return Api.get(`/contracts/${contractId}/variations/${variationId}/works`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
        return new Promise(resolve => {
            resolve({status: 200, data: _variationWorks})
        })
    },

    /**
     * Creates a new contract variation work
     * @param {number} contractId  - contract ID
     * @param {number} variationId  - variation ID
     * @param {VariationWork} data  - variation work item
     * @return {Promise<null>} - 201
     */
    addVariationWork(contractId, variationId, data) {
        return new Promise(resolve => {
            resolve({status:200 })
        })
        // return Api.post(`/contracts/${contractId}/variations/${variationId}/works`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Deletes a contract variation work
     * @param {number} contractId - contract ID
     * @param {number} variationId - variation ID
     * @param {VariationWork} data - variation work item
     * @return {Promise<null>} - 200
     */
    deleteVariationWork(contractId, variationId, data) {
        return new Promise(resolve => {
            resolve({status:200 })
        })
        // const {type, type_id} = data
        // const workId = `${type}-${type_id}`
        // return Api.delete(`/contracts/${contractId}/variations/${variationId}/works/${workId}`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },


    /** Returns funding type list
     * @return {Promise<Array<RefListVal>>}
     */
    loadFundingTypes() {
        return Api.get(`/contracts/funding_types`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns employer list
     * @return {Promise<Array<RefListVal>>}
     */
    loadFundingSources() {
        return Api.get(`/contracts/funding_sources`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns contract status list
     * @return {Promise<Array<RefListVal>>}
     */
    loadStatusList() {
        return Api.get(`/contracts/contract_status`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns list of province roads
     * @param {number} provincesId - Province ID
     * @return {Promise<Array<ProvinceRoads>>}
     */
    loadProvinceRoads(provincesId) {
        return Api.get(`/contracts/roads/${provincesId}`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns list of provinces
     * @return {Promise<Array<RefListVal>>}
     */
    loadProvinces() {
        return Api.get(`/contracts/provinces`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns province districts
     * @param {number} provinceId - Province ID
     * @return {Promise<Array<RefListVal>>}
     */
    loadProvinceDistricts(provinceId) {
        return Api.get(`/contracts/districts/${provinceId}`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns boqs
     * @return {Promise<Array<Boq>>}
     */
    loadBoqs() {
        return Api.get(`/contracts/boq`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Creates a new BoQ item
     * @param data {Boq} - BoQ item params
     * @return {Promise<null>} - 200
     */
    addBoqItem(data) {
        return new Promise(resolve => {
            resolve({status: 201})
        })
        // return Api.post(`/contracts/boq`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Updates a BoQ item
     * @param {number} id - Item ID
     * @param {Boq} data -  Item params
     * @return {Promise<null>} - 200
     */
    updateBoqItem(id, data) {
        return Api.put(`/contracts/boq/${id}`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns macs
     * @return {Promise<Array<Mac>>}
     */
    loadMacs() {
        return Api.get(`/contracts/mac`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Creates a new Mac item
     * @param data {Mac} - MAC item params
     * @return {Promise<null>} - 200
     */
    addMacItem(data) {
        return new Promise(resolve => {
            resolve({status: 201})
        })
        // return Api.post(`/contracts/mac`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Updates a Mac item
     * @param {number} id - Item ID
     * @param {Mac} data -  Item params
     * @return {Promise<null>} - 200
     */
    updateMacItem(id, data) {
        // return new Promise(resolve => {
        //     resolve({status:200})
        // })
        return Api.put(`/contracts/mac/${id}`, data, {
            headers: {
                ...type_json
            }
        })
    },


    /** Returns contract work types
     * @return {Promise<Array<ContractWorkType>>}
     */
    loadContractWorkTypes() {
        return Api.get(`/contracts/worktypes`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Creates a new contract work type item
     * @param data {ContractWorkTypeDto} - Work type item params {name:"name"}
     * @return {Promise<null>} - 200
     */
    addContractWorkTypeItem(data) {
        return new Promise(resolve => {
            resolve({status: 201})
        })
        // return Api.post(`/contracts/worktypes`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Updates a contract work type item
     * @param {number} id - Item ID
     * @param {ContractWorkTypeDto} data -  Item params {name:"name"}
     * @return {Promise<null>} - 200
     */
    updateContractWorkTypeItem(id, data) {
        return Api.put(`/contracts/worktypes/${id}`, data, {
            headers: {
                ...type_json
            }
        })
    },


    /** Returns dayworks
     * @return {Promise<Array<DayWork>>}
     */
    loadDayworks() {
        return new Promise(resolve => {
            resolve({status: 200, data: _dayworks})
        })
        // return Api.get(`/contracts/districts/${provinceId}`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Creates a new DayWork item
     * @param data {DayWork} - DayWork item params
     * @return {Promise<null>} - 200
     */
    addDayWorkItem(data) {
        return new Promise(resolve => {
            resolve({status: 201})
        })
        // return Api.post(`/contracts/boq`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /**
     * Updates a DayWork item
     * @param {number} id - Item ID
     * @param {DayWork} data -  Item params
     * @return {Promise<null>} - 200
     */
    updateDayWorkItem(id, data) {
        return new Promise(resolve => {
            resolve({status: 200})
        })

        // return Api.put(`/contracts/daywork/${id}`, data, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Returns unit list
     * @return {Promise<Array<string>>}
     */
    loadUnits() {
        return new Promise(resolve => {
            resolve({status: 200, data: _units})
        })
    },

    /** Returns unit list
     * @return {Promise<Array<BoqTop>>}
     */
    loadBoqTops() {
        return new Promise(resolve => {
            resolve({status: 200, data: _boqTops})
        })
    },

    /** Returns boq sub groups
     * @return {Promise<Array<BoqSubGroup>>}
     */
    loadBoqSubGroup() {
        return new Promise(resolve => {
            resolve({status: 200, data: _boqSubGroups})
        })
    },

    /** Returns dayWork groups
     * @return {Promise<Array<DsGroup>>}
     */
    loadDsGroups() {
        return new Promise(resolve => {
            resolve({status: 200, data: _dsGroups})
        })
    },
})