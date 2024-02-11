import Vue from 'vue'
import VueRouter from 'vue-router'

import store from './store/'
import DashboardPlugin from './material-dashboard'

// Plugins
import App from './App.vue'
import Chartist from 'chartist'

// translate
import i18n from './i18n'

// router setup
import routes from './routes'
import multiguard from '@/routes/middleware/multiguard'
// format number, persentage etc...
import Vue2Filters from 'vue2-filters'
import {MdField} from 'vue-material/dist/components'
//----------------------Nanthigna------------------
//Image Viewer
// import VueViewer from './components/ImageViewer'
// import 'bulma/bulma.sass'
import 'viewerjs/dist/viewer.css'

// plugin setup
Vue.use(VueRouter)
Vue.use(DashboardPlugin)

// configure router
const router = new VueRouter({
    mode: 'history',
    routes, // short for routes: routes
    scrollBehavior: (/*to*/) => {
        //if (to.hash) {
        //  return {selector: to.hash}
        //} else {
        return {x: 0, y: 0}
        //}
    },
    linkExactActiveClass: 'nav-item active',
    linkActiveClass: 'nav-item active'
})

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware
    const context = {
        to,
        from,
        next,
        store
    }

    return multiguard(middleware, context)
})

// global library setup
Object.defineProperty(Vue.prototype, '$Chartist', {
    get() {
        return this.$root.Chartist
    }
})


var numeral = require("numeral");
// var currency = require("currency");
Vue.use(Vue2Filters)
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
});
Vue.filter("formatPercent", function (value) {
    return numeral(value).format("0.00%"); // displaying other groupings/separators is possible, look at the docs
});
Vue.filter("formatUpperCase", function (value) {
    return value.String().toUpperCase(); // displaying upper case value
});

Vue.use(MdField)
Vue.component('MdSelect', Vue.options.components.MdSelect.extend({
    methods: {
        isInvalidValue: function isInvalidValue() {
            return this.$el.validity ? this.$el.validity.badInput : this.$el.querySelector('input').validity.badInput
        }
    }
}));

//-------------------------------------------------


/* eslint-disable no-new */
Vue.config.productionTip = false;

new Vue({
    el: '#app',
    i18n,
    router,
    store,
    data: {
        Chartist: Chartist
    },
    render: (h) => h(App)
})
