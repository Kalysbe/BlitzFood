/*---------  DASHBOARD  ---------------------*/

import {type_json} from "@/api/utils";

/**
 * @typedef {Object} DashboardTab
 * @property {number} id - Id tab
 * @property {string} id - Name tab
 */

export default Api => ({

    /** Returns list of dashboard tab
     * @param {string} system - System Id
     * @return {Promise<DashboardTab[]>}
     */
    load_dashboard_tabs(system) {
        return Api.get(`/kpis/dashboard/tabs`, {
            headers: {
                ...type_json
            }
        })
    },

    /** Returns dashboard tab data
     * @param {string} system - System Id
     * @param {number} id - tab id
     * @returns {Promise<Array>} Dashboard data
     */

    load_dashboard_tab_data(id) {
        return Api.get(`/kpis/dashboard/tabs/${id}`, {
            headers: {
                ...type_json
            }
        })
    },
})