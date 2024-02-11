/** ----------- AUTH -----------------------*/
import {type_json} from '@/api/utils'

/**
 * @typedef {Object} TokenList
 * @property {string} access_token - The access token
 */

export default Api => ({
    getApiBaseUrl() {
        return Api.defaults.baseURL
    },
    /**
     * Returns an object with token list {access_token, etc...}
     * @param {Object} data - Auth properties
     * @param {string} data.login - Login
     * @param {string} data.password - Password
     * @return {Promise<TokenList>}
     */
    login(data) {
        const {login: username, password} = data
        return Api.post(`/auth/login`, {username, password}, {
            headers: {
                ...type_json
            }
        })
    },
    /**
     * Sends user logout message to the API
     * @return {Promise<null>}
     */
    logout() {
        //return Api.post(`/auth/logout`)
    }
})