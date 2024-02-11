import Vue from 'vue'
import Vuex from 'vuex'
import i18nStore from './i18n'
import Login from './login'
import Kpi from './kpi'
import WebGis from './webGis'
import Reports from './reports'
import Contract from './contract/index'
import Lots from './contract/lots'
import ContractLotInspections from "./contract/lots/inspections";
import RefLists from "./refLists";
import Monitoring from "./monitoring";
//import OldContracts from "./oldContract/index";
import Roles from "./roles";
import Permissions from "./permissions";
import Features from "./features";
import Users from "./users";

// import * as Contract from "@/store/modules/contract.js";
Vue.use(Vuex)

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    i18nStore,
    Login,
    Kpi,
    WebGis,
    Reports,
    Contract,
    Lots,
    ContractLotInspections,
    Features,
    Roles,
    Permissions,
    Users,
    RefLists,
    Monitoring
  }
})
