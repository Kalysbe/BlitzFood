/**---------  APP OPTIONS  ---------------------*/
import {type_json} from "@/api/utils";

/**
 * @typedef {Object} AppProps
 * @property {string} sidebar_text - Sidebar text (RAMS)
 * @property {string} title_text - Title text
 * @property {string} logo - Logo image path
 * @property {string} logo_link - Url for logo images
 */

export default Api => ({
    /** Returns app properties
     * @return {Promise<AppProps>}
     * @throws Error
     */
    load_app_options() {
        return Api.get(`/app`, {
            headers: {
                ...type_json
            }
        })
    }
})