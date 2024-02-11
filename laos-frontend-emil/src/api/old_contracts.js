/*---------  CONTRACTS  ---------------------*/

import {type_json} from "@/api/utils";

/**
 * @typedef {any[]} rowData
 */

/**
 * @typedef {Object} Contracts
 * @property {string[]} headers - Headers array
 * @property {rowData[]} rows - Data array
 */

export default Api => ({

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

//-----------------AMKHA------------------
    load_funding_sources(){
        return Api.get(`/contracts/funding_sources`, {
            headers: {
                ...type_json
            }
        })
    },
    load_funding_types(){
        return Api.get(`/contracts/funding_types`, {
            headers: {
                ...type_json
            }
        })
    },
    load_worktypes(){
        return Api.get(`/contracts/worktypes`, {
            headers: {
                ...type_json
            }
        })
    },
    load_contractors(){
        return Api.get(`/contracts/contractors`, {
            headers: {
                ...type_json
            }
        })
    },
    load_asset_types(){
        return Api.get(`/contracts/asset_types`, {
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
})