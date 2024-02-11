import {checkAccess, checkAuth} from "@/routes/checkers";
import {Actions, Features} from "@/routes/consts";

const Lot = () => import('@/pages/Dashboard/Contracts/Lots/List.vue')
const LotProfileForm = () => import('@/pages/Dashboard/Contracts/Lots/LotProfileForm.vue')
const LotContent = () => import('@/pages/Dashboard/Contracts/Lots/LotContent.vue')
const LotDailyInspections = () => import('@/pages/Dashboard/Contracts/Lots/DailyInspections/List.vue')
const DailyInspectionProfileForm = () => import('@/pages/Dashboard/Contracts/Lots/DailyInspections/InspectionProfileForm.vue')

const routes = [
    {
        path: '/contracts/:contractId/lots',
        name: 'contract-lot-list',
        component: Lot,
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
        path: '/contracts/:contractId/lots/add',
        name: 'contract-lot-add',
        component: LotProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.contract,
            action: Actions.create
        },
        props: (route) => {
            return {
                ...route.params, ...{contractId: Number.parseInt(route.params.contractId, 10)}, act: 'add'
            }
        }
    },
    {
        path: '/contracts/:contractId/lots/upd/:lotId',
        name: 'contract-lot-upd',
        component: LotProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.contract,
            action: Actions.update
        },
        props: (route) => {
            return {
                ...route.params,
                ...{contractId: Number.parseInt(route.params.contractId, 10)},
                ...{lotId: Number.parseInt(route.params.lotId, 10)},
                act: 'upd'
            }
        }
    },
    {
        path: '/contracts/:contractId/lots/:lotId/content',
        name: 'contract-lot-content',
        component: LotContent,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params,
                ...{contractId: Number.parseInt(route.params.contractId, 10)},
                ...{lotId: Number.parseInt(route.params.lotId, 10)},
                act: 'upd'
            }
        }
    },

    {
        path: '/contracts/:contractId/lots/:lotId/daily-inspections',
        name: 'contract-daily-inspections',
        component: LotDailyInspections,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params,
                ...{contractId: Number.parseInt(route.params.contractId, 10)},
                ...{lotId: Number.parseInt(route.params.lotId, 10)},
            }
        }
    },

    {
        path: '/contracts/:contractId/lots/:lotId/daily-inspection/add',
        name: 'daily-inspection-add',
        component: DailyInspectionProfileForm,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params,
                ...{contractId: Number.parseInt(route.params.contractId, 10)},
                ...{lotId: Number.parseInt(route.params.lotId, 10)},
                act: 'add'
            }
        }
    },

    {
        path: '/contracts/:contractId/lots/:lotId/daily-inspection/upd/:insId',
        name: 'daily-inspection-upd',
        component: DailyInspectionProfileForm,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: (route) => {
            return {
                ...route.params,
                ...{contractId: Number.parseInt(route.params.contractId, 10)},
                ...{lotId: Number.parseInt(route.params.lotId, 10)},
                ...{insId: Number.parseInt(route.params.insId, 10)},
                act: 'upd'
            }
        }
    },

]

export default routes