/*---------  CURRENCY  ---------------------*/

const tempCurrencyRates = [{
    currency_id: 1,
    currency_name: "Laotian Kip",
    currency_code: "Kip",
    currency_rate: 1,
    rate_date: "2022-01-01"
}, {
    currency_id: 2, currency_name: "US Dollar", currency_code: "USD", currency_rate: 0.000059, rate_date: "2023-02-01"
}]

/**
 * @typedef {Object} Currency
 * @property {Number} currency_id - Currency ID
 * @property {String} currency_name - Currency Name
 * @property {String} currency_code - Currency Code (USD, Kip)
 */

/**
 * @typedef {Object} CurrencyRate
 * @property {Number} currency_id - Currency ID
 * @property {String} currency_name - Currency Name
 * @property {String} currency_code - Currency Code (USD, Kip)
 * @property {Number} currency_rate - Currency Rate (USD, Kip)
 * @property {String} rate_date - Last Inserted Currency rate
 */

export default Api => ({
    /** Returns currency rates
     * @return {Promise<Array<CurrencyRate>>}
     */
    loadCurrencyRates() {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({data: tempCurrencyRates, status: 200});
            }, 300);

        })
        // return Api.get(`/contracts/currency-rates/`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    },

    /** Returns currency list
     * @return {Promise<Array<Currency>>}
     */
    loadCurrencyList() {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({
                    data: tempCurrencyRates.map(rate => {
                        return {
                            currency_id: rate.currency_id,
                            currency_code: rate.currency_code,
                            currency_name: rate.currency_name
                        }
                    }), status: 200
                });
            }, 300);
        })
        // return Api.get(`/contracts/currency-rates/`, {
        //     headers: {
        //         ...type_json
        //     }
        // })
    }
})
