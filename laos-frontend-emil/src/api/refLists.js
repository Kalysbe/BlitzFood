/** ------------ REFERENCES LISTS ------------------- */

/**
 * @typedef {Object} ListItem
 * @property {number} id - ID
 * @property {string} name - Name
 */

/**
 * @typedef {Object} RefList
 * @property {string} id - ID
 * @property {string} name - Name
 * @property {string} description - Description
 */

const list = [
    {id: 'list_impact_evaluation_types', name: 'List impact evaluation types', description: ' This is a List impact evaluation types'},
    {id: 'list_payment_types', name: 'List payment types', description: ' This is a List payment types'},
    {id: 'list_work_tasks', name: 'List work tasks', description: ' This is a List work tasks'},
    {id: 'list_clients', name: 'List clients', description: ' This is a List clients'},
    {id: 'list_contract_types', name: 'List contract types', description: ' This is a List contract types'},
    {id: 'list_asset_types', name: 'List asset types', description: ' This is a List asset types'},
    {id: 'list_contractors', name: 'List contractors', description: ' This is a List contractors'},
    {id: 'list_funding_sources', name: 'List funding sources', description: ' This is a List funding sources'},
    {id: 'list_esm_types', name: 'List esm types', description: ' This is a List esm types'},
    {id: 'list_equipment_types', name: 'List equipment types', description: ' This is a List equipment types'},
    {id: 'list_contract_status', name: 'List contract status', description: ' This is a List contract status'},
    {id: 'list_funding_types', name: 'List funding types', description: ' This is a List funding types'},
    {id: 'list_worktypes', name: 'List worktypes', description: ' This is a List worktypes'},
    {id: 'list_material_types', name: 'List material types', description: ' This is a List material types'},
    {id: 'list_labour_types', name: 'List labour types', description: ' This is a List labour types'},
    {id: 'list_mac', name: 'List mac', description: ' This is a List mac'},
]

export default Api => ({
    /**
     * Permissions list
     * @returns {Promise<Array<RefList>} - list of references
     */
    load_list() {
        return new Promise(resolve => {
            resolve({status: 200, data: list})
        })
        // return Api.get(`/refs-list`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },
})