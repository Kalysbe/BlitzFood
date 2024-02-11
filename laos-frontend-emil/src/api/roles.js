/**---------  ROLES  ---------------------*/
import {type_json} from "@/api/utils";

/**
 * @typedef {Object} Roles
 * @property {number} id - ID
 * @property {string} role_name - Name of the role
 * @property {string} role_type - Type of the role
 * @property {string} description - Role description
 * @example
 * {
 *      "id": 1,
 *      "role_name": "admin",
 *      "role_type": "administrator",
 *      "description": "Administrator: Full read and edit access to everything in the system",
 *      "created_at": "2022-10-21T12:06:30.860406Z",
 *      "updated_at": "2022-10-21T12:06:30.860406Z",
 *      "deleted_at": null
 *     },
 */

export default Api => ({
    /**
     * Roles list
     * @return {Promise<Roles>} props
     */
    load_roles() {
        return Api.get(`/roles`, {
            headers: {
                ...type_json
            }
        })
    },
    /**
     * Role users
     * @returns {Promise<AxiosResponse<any>>} user role properties
     * [
     * @returns {Object}
     *  {
     *    @returns {string}  login,
     *    @returns {string} email
     *    @returns {string} first_name
     *    @returns {string} last_name
     * }
     * ]
     */
    load_role_users(name) {
        return Api.get(`/roles/${name}/users`, {
            headers: {
                ...type_json
            }
        })
    },
})