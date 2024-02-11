import api from '@/api'

export default {
    state: {},
    actions: {
        // LOAD_ROLES loads roles list
        async LOAD_ROLES() {
            try {
                const {status, data} = await api.roles.load_roles()
                if (status === 200) {
                    return data
                } else {
                    throw `Load roles list error, status:${status}`
                }
            } catch (err) {
                throw err
            }
        },
        // LOAD_ROLES loads roles list
        async LOAD_ROLE_USERS(context, role_name) {
            try {
                const {status, data} = await api.roles.load_role_users(role_name)
                if (status === 200) {
                    return data
                } else {
                    throw `Load role users error, status:${status}`
                }
            } catch (err) {
                throw err
            }
        },

    },
    mutations: {},
    getters: {}
}