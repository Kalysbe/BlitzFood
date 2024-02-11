import {mapState} from "vuex";

export const permMixin = {
    computed: {
        ...mapState({
            permissions: (state) => {
                return state.Login.me.permissions ? state.Login.me.permissions : []
            },
        })
    },
    methods: {
        hasAccess(feature, action) {
            return true //this.permissions.some(item => item.feature === feature && item.action === action)
        },
    }
}