import {checkAuth} from "@/routes/checkers";

const Contracts = () => import('@/pages/Dashboard/_legacy_Contracts/Contract')
const ContractProfile = () => import('@/pages/Dashboard/_legacy_Contracts/ContractProfile')
const LotDetails = () => import('@/pages/Dashboard/_legacy_Contracts/lots/LotDetails')


const routes = [
    {
        path: 'old/Contracts',
        name: 'contracts',
        components: {default: Contracts},
        meta: {hideFooter: true}

    },
    {
        path: 'old/ContractProfile',
        name: 'contractprofile',
        components: {default: ContractProfile},
        meta: {hideFooter: true}

    },
    {
        path: 'old/LotDetails',
        name: 'lotdetails',
        components: {default: LotDetails},
        meta: {hideFooter: true}

    }]

export default routes