import {checkAccess, checkAuth} from "@/routes/checkers";
import {Actions, Features} from "@/routes/consts";

const Reports = () => import('@/pages/Dashboard/Contracts/Report.vue')
const Contract = () => import('@/pages/Dashboard/Contracts/List.vue')
const ContractDetails = () => import('@/pages/Dashboard/Contracts/ContractDetails.vue')
const ContractPayments = () => import ("@/pages/Dashboard/Contracts/ContractPayments.vue");
const ContractVariations = () => import( "@/pages/Dashboard/Contracts/ContractVariations.vue");
const ContractVariationsProfileForm = () => import( "@/pages/Dashboard/Contracts/ContractVariationsProfileForm.vue");
const ContractEnvironmentData = () => import('@/pages/Dashboard/Contracts/ContractEnvironment.vue')
const ContractProfileForm = () => import('@/pages/Dashboard/Contracts/ContractProfileForm.vue')
const Boqs = () => import('@/pages/Dashboard/Contracts/References/BillOfQuantities.vue')
const Macs = () => import('@/pages/Dashboard/Contracts/References/MaintenanceActivityCodes.vue')
const Dayworks = () => import('@/pages/Dashboard/Contracts/References/Dayworks.vue')

const routes = [
    {path: '/contracts', redirect: '/contracts/list'},
    {
        path: '/contracts/list',
        name: 'contract-list',
        component: Contract,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },
    {
        path: '/contracts/add',
        name: 'contract-add',
        component: ContractProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.contract,
            action: Actions.create
        },
        props: {act: 'add'}
    },
    {
        path: '/contracts/upd/:contractId',
        name: 'contract-upd',
        component: ContractProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.contract,
            action: Actions.update
        },
        props: {act: 'upd'}
    },
    {
        path: '/contracts/:contractId/details',
        name: 'contract-details',
        component: ContractDetails,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params, ...{contractId: Number.parseInt(route.params.contractId, 10)}
            }
        }
    },
    {
        path: '/contracts/:contractId/payments',
        name: 'contract-payments',
        component: ContractPayments,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params, ...{contractId: Number.parseInt(route.params.contractId, 10)}
            }
        }
    },

    {
        path: '/contracts/:contractId/variations',
        name: 'contract-variations',
        component: ContractVariations,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params, ...{contractId: Number.parseInt(route.params.contractId, 10)}
            }
        }
    },
    {
        path: '/contracts/:contractId/variations/add',
        name: 'contract-variations-add',
        component: ContractVariationsProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.contractVariations,
            action: Actions.create
        },
        props: (route) => {
            return {
                ...route.params, ...{act: 'add', contractId: Number.parseInt(route.params.contractId, 10)}
            }
        }
    },
    {
        path: '/contracts/:contractId/variations/upd/:variationId',
        name: 'contract-variations-upd',
        component: ContractVariationsProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.contractVariations,
            action: Actions.update
        },
        props: (route) => {
            return {
                ...route.params, ...{
                    act: 'upd',
                    contractId: Number.parseInt(route.params.contractId, 10),
                    variationId: Number.parseInt(route.params.variationId, 10)}
            }
        }
    },

    {
        path: '/contracts/:contractId/environment',
        name: 'contract-environment',
        component: ContractEnvironmentData,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },
    {path: '/contracts/reports/', redirect: '/contracts/reports/list'},
    {
        path: '/contracts/reports/:reportType',
        name: 'contracts-reports',
        component: Reports,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },

    {
        path: '/contracts/boqs',
        name: 'contract-boqs',
        component: Boqs,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },
    {
        path: '/contracts/macs',
        name: 'contract-macs',
        component: Macs,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },
    {
        path: '/contracts/dayworks',
        name: 'contract-dayworks',
        component: Dayworks,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },


]

export default routes