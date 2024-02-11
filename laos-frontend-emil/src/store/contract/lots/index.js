import api from '@/api/index'

export default {
    state: {},
    actions: {
        async LOAD_CONTRACT_LOTS(context, contractId) {
            try {
                const res = await api.lots.loadLots(contractId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load list of contract lots status: ${status}`
                }
            } catch (err) {
                throw `Load contract lots: ${err}`
            }
        },
        async LOAD_LOT_DETAILS(context, payload) {
            const {contractId, lotId} = payload
            try {
                const res = await api.lots.loadLotDetails(contractId, lotId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract lot details status: ${status}`
                }
            } catch (err) {
                throw `Load contract lot details: ${err}`
            }
        },

        async LOAD_LOT_PAYMENTS(context, payload) {
            const {contractId, lotId} = payload
            try {
                const res = await api.lots.loadLotPayments(contractId, lotId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract lot payments status: ${status}`
                }
            } catch (err) {
                throw `Load contract lot payments: ${err}`
            }
        },

        async LOAD_LOT_CONTENT(context, payload) {
            const {contractId, lotId} = payload
            try {
                const res = await api.lots.loadLotContent(contractId, lotId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract lot content status: ${status}`
                }
            } catch (err) {
                throw `Load contract lot content: ${err}`
            }
        },

        async ADD_LOT(context, payload) {
            const {contractId, data} = payload
            try {
                const res = await api.lots.add(contractId, data)
                const {status} = res
                if (status === 200) {
                    return 'added'
                } else {
                    throw `Add lot status: ${status}`
                }
            } catch (err) {
                throw `Add lot: ${err}`
            }
        },
        async UPD_LOT(context, payload) {
            const {contractId, lotId, data} = payload
            try {
                const res = await api.lots.update(contractId, lotId, data)
                const {status} = res
                if (status === 200) {
                    return 'updated'
                } else {
                    throw `Upd lot status: ${status}`
                }
            } catch (err) {
                throw `Upd lot: ${err}`
            }
        },
        async REMOVE_LOT_DAYWORK_ITEM(context, payload) {
            const {contractId, lotId, itemNo} = payload
            try {
                const res = await api.lots.daywork_delete(contractId, lotId, itemNo)
                const {status} = res
                if (status === 200) {
                    return 'deleted'
                } else {
                    throw `Del lot daywork item status: ${status}`
                }
            } catch (err) {
                throw `Del lot daywork item : ${err}`
            }
        },
        async REMOVE_LOT_BILL_ITEM(context, payload) {
            const {contractId, lotId, itemNo} = payload
            try {
                const res = await api.lots.bill_delete(contractId, lotId, itemNo)
                const {status} = res
                if (status === 200) {
                    return 'deleted'
                } else {
                    throw `Del lot bill item status: ${status}`
                }
            } catch (err) {
                throw `Del lot bill item : ${err}`
            }
        },
        async ADD_LOT_BILL_ITEM(context, payload) {
            const {contractId, lotId, billData} = payload
            try {
                const res = await api.lots.bill_add(contractId, lotId, billData)
                const {status} = res
                if (status === 200) {
                    return 'added'
                } else {
                    throw `Add lot bill item status: ${status}`
                }
            } catch (err) {
                throw `Add lot bill item : ${err}`
            }
        }
    },
    mutations: {},
    getters: {}
}