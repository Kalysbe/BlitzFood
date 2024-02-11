/** ------------ PERMISSIONS ------------------- */

import {type_json} from '@/api/utils'

/**
 * @typedef {Object} Permission
 * @property {string} sub - Subject (role name)
 * @property {string} feature - Feature name
 * @property {string} action - Action name
 */

export default Api => ({
    /**
     * Permissions list
     * @returns {Promise<Array<Permission>>} - users permissions
     */
    load_list() {
        return Api.get(`/permissions`, {
            headers: {
                ...type_json
            }
        })
    },
    /**
     * Grant permission
     * @param {Permission} data
     * @returns {Promise<null>} 200
     */
    grant(data) {
        return Api.post(`/permissions/grant`, data, {
            headers: {
                ...type_json
            }
        })
    },
    /**
     * Revoke permission
     * @param {Permission} data
     * @returns {Promise<null>} 200
     */
    revoke(data) {
        return Api.post(`/permissions/revoke`, data, {
            headers: {
                ...type_json
            }
        })
    },
    /**
     * Features structs list
     * @returns {Promise<AxiosResponse<any>>} features
     * @returns {Array}
     * [
     *    @returns {string} features name
     *    @returns {Array} features actions
     *    @returns {string} action name
     * ]
     *
     */
    load_features_objects() {
        return Api.get(`/features/objects`, {
            headers: {
                ...type_json
            }
        })
    }
})