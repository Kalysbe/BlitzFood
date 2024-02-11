/** ------------ REPORTS ------------------- */

import {type_json} from "@/api/utils";

/**
 * @typedef {Object} reports
 * @property {string} key - Key
 * @property {string} value - Value
 */

export default Api => ({

    /** Loads list of report types
     * @return {Promise<reports[]>} - reports - 200 Default Response
     * @example
     *reports: [
     *  {
     *    "id": "first",
     *    "name": "reports.first"
     *  },
     *  {
     *    "id": "second",
     *    "name": "reports.second"
     *  }
     *]
     * @throws Error
     */
    load_reports_list() {
        return Api.get(`/reports/list`, {
            headers: {
                ...type_json
            }
        })
    },
    /** Loads report data
     * @param {string} type - Report name
     * @return {Promise<Array<>>} - data - 200 Default Response
     * @throws Error
     */
    load_report_data(type) {
        return Api.get(`/reports/data/${type}`, {
            headers: {
                ...type_json
            }
        })
    },
})