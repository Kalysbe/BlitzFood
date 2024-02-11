import axios from 'axios'
import store from '../store'

import VueRouter from 'vue-router'
import routes from '../routes/_index'

import Auth from '@/api/auth'
import Localisation from '@/api/localisation'
import Dashboard from '@/api/dashboard'
import App from '@/api/app'
import Users from '@/api/users'
import WebGis from '@/api/webGis'
import Reports from '@/api/reports'
import Contracts from '@/api/contracts'
import ContractLots from '@/api/contractLots'
import ContractLotInspections from '@/api/contractLotInspections'
import Roles from '@/api/roles'
import Permissions from '@/api/permissions'
import Currencies from '@/api/currencies'
import RefLists from '@/api/refLists'
import Accidents from '@/api/monitoring/accidents'
import Environments from '@/api/monitoring/environments'

const {VUE_APP_BACK_SERVER = ''} = process.env
const API_ROOT = VUE_APP_BACK_SERVER

const Api = axios.create({
  baseURL: API_ROOT,
  withCredentials: false,
  headers: {
    Accept: 'application/json',
    Authorization: `Bearer`
  }
})

const router = new VueRouter({
  mode: 'history',
  routes // short for index: index
})
Api.interceptors.response.use(
  (res) => {
    return res
  },
  async (err) => {
    if (err.response.status === 401) {
      console.log('interceptors 401')
      await store.dispatch('LOGOUT')
      router.push('/login')
    } else {
      return err
    }
  }
)

export default {
  setHeaderAuth(token) {
    Api.defaults.headers.Authorization = `Bearer ${token}`
  },
  delHeaderAuth() {
    delete Api.defaults.headers.common.Authorization
  },
  isSetHeaderAuth() {
    return (
      Api.defaults.headers.hasOwnProperty('Authorization') &&
      Api.defaults.headers.common['Authorization'] !== ''
    )
  },

  // Api modules
  auth: Auth(Api),
  localisation: Localisation(Api),
  dashboard: Dashboard(Api),
  app: App(Api),
  users: Users(Api),
  webGis: WebGis(Api),
  reports: Reports(Api),
  contracts: Contracts(Api),
  lots: ContractLots(Api),
  contractLotInspections: ContractLotInspections(Api),
  //oldContracts: old_contracts(Api),
  roles: Roles(Api),
  permissions: Permissions(Api),
  currencies: Currencies(Api),
  refLists: RefLists(Api),
  monitoring: {
    accidents: Accidents(Api),
    environments: Environments(Api)
  }
}
