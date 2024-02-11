/** ----------- LOCALISATION -----------------------*/
import {type_json} from '@/api/utils'

/**
 * @typedef {Object} LangList
 * @property {string} key - The lang code and name
 */

/**
 * @typedef {Object} LocalisationItemValue
 * @property {string} key - The key and value
 */

/**
 * @typedef {Object} LocalisationItem
 * @property {number} id - Item id
 * @property {string} category - Item category
 * @property {string} key - Item key
 * @property {string} en - Value for lang
 * @property {string} la - Value for lang
 */



export default Api => ({

    /** Returns list of localisation languages
     * <br>
     * ex: {en:"English", fi:"Suomi"}
     * @return {Promise<LangList[]>}
     * @throws Error
     */
    load_locales() {
        return Api.get(`/localisation/list`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns all localisation items
     * @return {Promise<LocalisationItem[]>}
     * @throws Error
     */
    load_translate() {
        return Api.get(`/localisation/all`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns localisation items for the selected lang
     * @param {string} lang - Language code (en, fi, etc...)
     * @return {Promise<LocalisationItemValue[]>}
     * @throws Error
     */
    load_ui_messages(lang) {
        return Api.get(`/localisation/${lang}`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns localisation items for the selected lang only for login form
     * @param {string} lang - Language code (en, fi, etc...)
     * @return {Promise<LocalisationItemValue[]>}
     * @throws Error
     */
    load_login_messages(lang) {
        return Api.get(`/localisation/login_strings/${lang}`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Adds translate entry
     * @param {LocalisationItem} item
     * @return {Promise<null>} default response code: 200
     * @throws Error
     */
    add_translate_entry(item) {
        return Api.post(
            `/localisation`,
            {...item},
            {
                headers: {
                    ...type_json
                }
            }
        )
    },

    /** Updates translate entry
     * @param {number} id
     * @param {LocalisationItem} item
     * @return {Promise<null>} default response code: 201
     * @throws Error
     */
    upd_translate_entry(id, item) {
        return Api.put(
            `/localisation/${id}`,
            {...item},
            {
                headers: {
                    ...type_json
                }
            }
        )
    }
})