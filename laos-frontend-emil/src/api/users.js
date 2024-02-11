/**---------  USERS  ---------------------*/
import {type_json} from "@/api/utils";

/**
 * @typedef {Object} MenuItem
 * @property {string} name - Name
 * @property {string} icon - Icon
 * @property {string} path - Path
 * @example
 * {
 *  "name": "menu.dashboard",
 *  "icon": "dashboard",
 *  "path": "/dashboard"
 * },
 */

/**
 * @typedef setPassPayload
 * @property {string} login - User login
 * @property {string} password - Password
 */

/**
 * @typedef {Object} User
 * @property {string} login - User login
 * @property {string} first_name - First name
 * @property {string} last_name - Last name
 * @property {string} role - User role
 * @property {null|string} avatar - User avatar
 * @property {datetime} created_at - Created at
 * @property {datetime} updated_at - Updated at
 * @property {null|datetime} deleted_at - Deleted at
 */

/**
 * @typedef {Object} UserProps
 * @property {number} id - User Id
 * @property {string} username - User login
 * @property {string} first_name - First name
 * @property {string} last_name - Last name
 * @property {string} role - User role
 * @property {null|string} avatar - User avatar
 * @property {datetime} created_at - Created at
 * @property {datetime} updated_at - Updated at
 * @property {null|datetime} deleted_at - Deleted at
 * @property {MenuItem[]} menu_items - User menu items
 */

export default Api => ({
    /** Returns user personal data
     * @return {Promise<UserProps>} props
     */
    load_user_profile() {
        return Api.get(`/users/me`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Returns Users list
     * @return {Promise<Array<User>>} user list
     */
    load_users() {
        return Api.get(`/users/all`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Creates a new user
     * @param data {User} - user params
     * @return {Promise<null>} - 201
     */
    add(data) {
        return Api.post(`/users`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Updates user data
     * @param login {string} - login
     * @param data {User} - user params
     * @returns {Promise<null>} - 204
     * @type {(login: string, data:{}) => void}
     */
    update(login, data) {
        return Api.put(`/users/${login}`, data, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Loads User props
     * @returns {Promise<User>} user props
     */
    load_user_by_login(login) {
        return Api.get(`/users/${login}`, {
            headers: {
                ...type_json
            }
        })
    },

    /**
     * Sets User password
     * @param payload {setPassPayload} - payload
     * @returns {Promise<null>}
     */
    set_password(payload) {
        const {login, password} = payload
        return Api.put(`/users/${login}/set-password`, {password}, {
            headers: {
                ...type_json
            }
        })
    }
})