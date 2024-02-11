import api from '@/api/index'

export default {
    state: {},
    actions: {
        async LOAD_CONTRACTS() {
            try {
                const res = await api.contracts.loadContracts()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load list of contracts status: ${status}`
                }
            } catch (err) {
                throw `Load contracts: ${err}`
            }
        },
        async LOAD_CONTRACT_DETAILS(context, contractId) {
            try {
                const res = await api.contracts.loadContractDetails(contractId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract details status: ${status}`
                }
            } catch (err) {
                throw `Load contract details: ${err}`
            }
        },
        async ADD_CONTRACT(context, payload) {
            const {data} = payload
            try {
                const res = await api.contracts.add(data)
                const {status} = res
                if (status === 200) {
                    return 'added'
                } else {
                    throw `Add contract status: ${status}`
                }
            } catch (err) {
                throw `Add contract: ${err}`
            }
        },
        async UPD_CONTRACT(context, payload) {
            const {id, data} = payload
            try {
                const res = await api.contracts.update(id, data)
                const {status} = res
                if (status === 200) {
                    return 'added'
                } else {
                    throw `Upd contract status: ${status}`
                }
            } catch (err) {
                throw `Upd contract: ${err}`
            }
        },
        async LOAD_CONTRACTOR_LIST() {
            try {
                const res = await api.contracts.loadContractors()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contractors status: ${status}`
                }
            } catch (err) {
                throw `Load contractors: ${err}`
            }
        },
        async LOAD_CONTRACT_TYPES() {
            try {
                const res = await api.contracts.loadContractTypes()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract types status: ${status}`
                }
            } catch (err) {
                throw `Load contract types: ${err}`
            }
        },

        async LOAD_CONTRACT_VARIATIONS(context, contractId) {
            try {
                const res = await api.contracts.loadVariations(contractId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract variations list status: ${status}`
                }
            } catch (err) {
                throw `Load contract variations list: ${err}`
            }
        },
        async LOAD_CONTRACT_VARIATION_BY_ID(context, payload) {
            try {
                const {contractId, variationId} = payload
                const res = await api.contracts.loadVariationsById(contractId, variationId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract variation by id status: ${status}`
                }
            } catch (err) {
                throw `Load contract variation by id: ${err}`
            }
        },
        async LOAD_CONTRACT_VARIATION_WORKS_BY_ID(context, payload) {
            try {
                const {contractId, variationId} = payload
                const res = await api.contracts.loadVariationWorksById(contractId, variationId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract variation works by id status: ${status}`
                }
            } catch (err) {
                throw `Load contract variation works by id: ${err}`
            }
        },

        async ADD_CONTRACT_VARIATION(context, payload) {
            const {contractId, data} = payload
            try {
                const res = await api.contracts.addVariation(contractId, data)
                const {status} = res
                if (status === 200) {
                    return 'added'
                } else {
                    throw `Add contract variation order status: ${status}`
                }
            } catch (err) {
                throw `Add contract variation order: ${err}`
            }
        },
        async UPD_CONTRACT_VARIATION(context, payload) {
            const {contractId, variationId, data} = payload
            try {
                const res = await api.contracts.updateVariation(contractId, variationId, data)
                const {status} = res
                if (status === 200) {
                    return 'updated'
                } else {
                    throw `Upd contract variation order status: ${status}`
                }
            } catch (err) {
                throw `Upd contract variation order: ${err}`
            }
        },

        /**
         * Adds work to variation work list
         * @param context
         * @param {Object} payload - payload
         * @param {VariationWork} payload.data
         */
        async ADD_CONTRACT_VARIATION_WORK(context, payload) {
            const {contractId, variationId, data} = payload
            try {
                const res = await api.contracts.addVariationWork(contractId, variationId, data)
                const {status} = res
                if (status === 200) {
                    return 'added'
                } else {
                    throw `Add contract variation work status: ${status}`
                }
            } catch (err) {
                throw `Add contract variation work: ${err}`
            }
        },
        async DEL_CONTRACT_VARIATION_WORK(context, payload) {
            const {contractId, variationId, data} = payload
            try {
                const res = await api.contracts.deleteVariationWork(contractId, variationId, data)
                const {status} = res
                if (status === 200) {
                    return 'deleted'
                } else {
                    throw `Del contract variation work status: ${status}`
                }
            } catch (err) {
                console.log(`Del contract variation work: ${err}`)
                throw err
            }
        },

        async LOAD_EMPLOYERS() {
            try {
                const res = await api.contracts.loadEmployers()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load employer list status: ${status}`
                }
            } catch (err) {
                throw `Load employer list: ${err}`
            }
        },
        async LOAD_FUNDING_TYPES() {
            try {
                const res = await api.contracts.loadFundingTypes()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load funding type list status: ${status}`
                }
            } catch (err) {
                throw `Load funding type list: ${err}`
            }
        },
        async LOAD_FUNDING_SOURCES() {
            try {
                const res = await api.contracts.loadFundingSources()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load employer list status: ${status}`
                }
            } catch (err) {
                throw `Load employer list: ${err}`
            }
        },

        async LOAD_PROVINCES() {
            try {
                const res = await api.contracts.loadProvinces()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load province list status: ${status}`
                }
            } catch (err) {
                throw `Load province list: ${err}`
            }
        },
        async LOAD_PROVINCE_DISTRICTS(context, provinceId) {
            try {
                const res = await api.contracts.loadProvinceDistricts(provinceId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load district list status: ${status}`
                }
            } catch (err) {
                throw `Load district list: ${err}`
            }
        },
        async LOAD_PROVINCE_ROADS(context, provinceId) {
            try {
                const res = await api.contracts.loadProvinceRoads(provinceId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load province roads list status: ${status}`
                }
            } catch (err) {
                throw `Load district list: ${err}`
            }
        },


        async LOAD_CONTRACT_STATUS_LIST() {
            try {
                const res = await api.contracts.loadStatusList()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load employer list status: ${status}`
                }
            } catch (err) {
                throw `Load employer list: ${err}`
            }
        },
        async LOAD_CURRENCY_LIST() {
            try {
                const res = await api.currencies.loadCurrencyList()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load currency list status: ${status}`
                }
            } catch (err) {
                throw `Load currency list: ${err}`
            }
        },
        async LOAD_CURRENCY_RATES() {
            try {
                const res = await api.currencies.loadCurrencyRates()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load currency rates status: ${status}`
                }
            } catch (err) {
                throw `Load currency rates: ${err}`
            }
        },

        async LOAD_BILLS_OF_QUANTITIES() {
            try {
                const res = await api.contracts.loadBoqs()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load boqs status: ${status}`
                }
            } catch (err) {
                throw `Load boqs rates: ${err}`
            }
        },
        async ADD_BOQ_ITEM(context, payload) {
            const {data} = payload
            try {
                const res = await api.contracts.addBoqItem(data)
                const {status} = res
                if (status === 201) {
                    return 'added'
                } else {
                    throw `Add Boq item status: ${status}`
                }
            } catch (err) {
                throw `Add Boq item: ${err}`
            }
        },
        async UPD_BOQ_ITEM(context, payload) {
            const {id, data} = payload
            try {
                const res = await api.contracts.updateBoqItem(id, data)
                const {status, message} = res
                if (status === 200) {
                    return 'updated'
                } else {
                    throw `Upd Boq item status: ${message}`
                }
            } catch (err) {
                throw `Upd Boq item: ${err}`
            }
        },

        async LOAD_CONTRACT_WORK_TYPES() {
            try {
                const res = await api.contracts.loadContractWorkTypes()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract work types status: ${status}`
                }
            } catch (err) {
                throw `Load boqs rates: ${err}`
            }
        },
        async ADD_CONTRACT_WORK_TYPE_ITEM(context, payload) {
            const {data} = payload
            try {
                const res = await api.contracts.addContractWorkTypeItem(data)
                const {status} = res
                if (status === 201) {
                    return 'added'
                } else {
                    throw `Add contract work type item status: ${status}`
                }
            } catch (err) {
                throw `Add contract work type item: ${err}`
            }
        },
        async UPD_CONTRACT_WORK_TYPE_ITEM(context, payload) {
            const {id, data} = payload
            try {
                const res = await api.contracts.updateContractWorkTypeItem(id, data)
                const {status, message} = res
                if (status === 200) {
                    return 'updated'
                } else {
                    throw `Upd contract work type item status: ${message}`
                }
            } catch (err) {
                throw `Upd Boq item: ${err}`
            }
        },

        async LOAD_BOQ_TOPS() {
            try {
                const res = await api.contracts.loadBoqTops()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load boqTops status: ${status}`

                }
            } catch (err) {
                throw `Load boqTops: ${err}`
            }
        },
        async LOAD_BOQ_SUBGROUPS() {
            try {
                const res = await api.contracts.loadBoqSubGroup()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load boqSubGroups status: ${status}`

                }
            } catch (err) {
                throw `Load boqSubGroups: ${err}`
            }
        },

        async LOAD_MAINTENANCE_ACTIVITY_CODES() {
            try {
                const res = await api.contracts.loadMacs()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load macs status: ${status}`
                }
            } catch (err) {
                throw `Load macs rates: ${err}`
            }
        },
        async ADD_MAC_ITEM(context, payload) {
            const {data} = payload
            try {
                const res = await api.contracts.addMacItem(data)
                const {status} = res
                if (status === 201) {
                    return 'added'
                } else {
                    throw `Add MAC item status: ${status}`
                }
            } catch (err) {
                throw `Add MAC item: ${err}`
            }
        },
        async UPD_MAC_ITEM(context, payload) {
            const {id, data} = payload
            try {
                const res = await api.contracts.updateMacItem(id, data)
                const {status, message} = res
                if (status === 200) {
                    return 'updated'
                } else {
                    throw `Upd MAC item status: ${message}`
                }
            } catch (err) {
                throw `Upd MAC item: ${err}`
            }
        },


        async LOAD_DAY_WORKS() {
            try {
                const res = await api.contracts.loadDayworks()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load dayworks status: ${status}`
                }
            } catch (err) {
                throw `Load dayworks rates: ${err}`
            }
        },
        async ADD_DAYWORK_ITEM(context, payload) {
            const {data} = payload
            try {
                const res = await api.contracts.addDayWorkItem(data)
                const {status} = res
                if (status === 201) {
                    return 'added'
                } else {
                    throw `Add DayWork item status: ${status}`
                }
            } catch (err) {
                throw `Add DayWork item: ${err}`
            }
        },
        async UPD_DAYWORK_ITEM(context, payload) {
            const {id, data} = payload
            try {
                const res = await api.contracts.updateDayWorkItem(id, data)
                const {status, message} = res
                if (status === 200) {
                    return 'updated'
                } else {
                    throw `Upd DayWork item status: ${message}`
                }
            } catch (err) {
                throw `Upd DayWork item: ${err}`
            }
        },

        async LOAD_DAY_WORKS_GROUPS() {
            try {
                const res = await api.contracts.loadDsGroups()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load dsGroups status: ${status}`

                }
            } catch (err) {
                throw `Load dsGroups: ${err}`
            }
        },

        async LOAD_UNITS() {
            try {
                const res = await api.contracts.loadUnits()
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load units status: ${status}`

                }
            } catch (err) {
                throw `Load units: ${err}`
            }
        },


    },
    mutations: {},
    getters: {}
}