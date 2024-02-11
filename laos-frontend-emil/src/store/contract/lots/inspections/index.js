import api from '@/api/index'

export default {
    state: {},
    actions: {
        async LOAD_CONTRACT_LOT_DAILY_INSPECTIONS(context, payload) {
            const {contractId, lotId} = payload
            try {

                const res = await api.contractLotInspections.loadDailyInspections(contractId, lotId)
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load contract lot inspections status: ${status}`
                }
            } catch (err) {
                throw `Load contract lot inspections: ${err}`
            }
        },

        async LOAD_DAILY_INSPECTION_WORKS_DATA(context, payload) {
            const {contractId, lotId, insId} = payload
            try {

                const res = await api.contractLotInspections.loadDailyInspectionWorksData({contractId, lotId, insId})
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load DI works data status: ${status}`
                }
            } catch (err) {
                throw `Load DI works: ${err}`
            }
        },
        async LOAD_DAILY_INSPECTION_MATERIALS_DATA(context, payload) {
            const {contractId, lotId, insId} = payload
            try {

                const res = await api.contractLotInspections.loadDailyInspectionMaterialsData({contractId, lotId, insId})
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load DI materials data status: ${status}`
                }
            } catch (err) {
                throw `Load DI materials: ${err}`
            }
        },
        async LOAD_DAILY_INSPECTION_EQUIPMENT_DATA(context, payload) {
            const {contractId, lotId, insId} = payload
            try {

                const res = await api.contractLotInspections.loadDailyInspectionEquipmentData({contractId, lotId, insId})
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load DI equipment data status: ${status}`
                }
            } catch (err) {
                throw `Load DI equipment: ${err}`
            }
        },
        async LOAD_DAILY_INSPECTION_LABOUR_DATA(context, payload) {
            const {contractId, lotId, insId} = payload
            try {

                const res = await api.contractLotInspections.loadDailyInspectionLabourData({contractId, lotId, insId})
                const {status, data} = res
                if (status === 200) {
                    return data
                } else {
                    throw `Load DI labour data status: ${status}`
                }
            } catch (err) {
                throw `Load DI labour: ${err}`
            }
        },
    }
}
