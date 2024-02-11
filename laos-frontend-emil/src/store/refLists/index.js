import api from '@/api'

export default {
    state: {},
    actions: {

        // LOAD_REFERENCES_LIST loads references list
        async LOAD_REFERENCES_LIST() {
            try {
                const {status, data} = await api.refLists.load_list()
                if (status === 200) {
                    return data
                } else {
                    throw `Load references list error, status:${status}`
                }
            } catch (err) {
                throw err
            }
        },
    },
    mutations: {},
    getters: {}
}