import Api from '../api'

const state = {
  companies: [],
  company_count: null,
  company_profile: null,
  company_reports: {
    kvar: null,
    news: null
  },
  reports_diagram:null,
  reports_diagram_finstate:null,
  report_view:null,
  page: 1
}
const mutations = {

  SET_SLIDER(state, data) {
    state.slide = data
  },
  SET_COMPANIES(state, data){
    state.companies = data.list
    state.company_count = data.count
    state.page = data.page
  },
  SET_COMPANY(state , data){
    state.company_profile = data
  },
  SET_COMPANY_REPORTS(state , data) {
    if(data.type == 1){
      state.company_reports.kvar = data.data
    }else {
      state.company_reports.news = data.data
    }
    
  },
  SET_REPORTS_DIAGRAM(state, data){
    state.reports_diagram = data
  },
  SET_REPORTS_DIAGRAM_FINSTATE(state, data){
    state.reports_diagram_finstate = data
  },
  SET_REPORT_VIEW(state, data){
    state.report_view = data
  },
  SET_SEARCH_COMPANY(state, data) {
    state.search_company_res = data.list
  }
}
const actions = {
  async GET_COMPANY_DATA({}) {
    try {
      const res = await Api.getProfileInfo()
      return res.data
    } catch {
      return 'Произошла ошибка'
    }
  },
  async EDIT_COMPANY_DATA(
    {},
    {
      name,
      opforma,
      activity,
      address,
      phone,
      fax,
      email,
      supervisor,
      id,
      first_signers
    }
  ) {
    try {
      Api.editProfileInfo(
        name,
        opforma,
        activity,
        address,
        phone,
        fax,
        email,
        supervisor,
        id,
        first_signers
      )
      return true
    } catch {
      return 'Произошла ошибка'
    }
  },
  async GET_COMPANY_LIST({commit}, data) {
    try {
      const res = await Api.getCompanyList(data)
      commit('SET_COMPANIES', res.data)
      return res
    } catch (error) {
      
    }
  },
  async GET_COMPANY_BYID({commit}, data) {
    try {
      const res = await Api.getCompanyById(data)
      commit('SET_COMPANY', res.data)
    } catch (error) {
      console.log(error)
    }
  },
  async GET_COMPANY_REPORTS({commit}, data) {
    try {
      const { type } = data
      const res = await Api.getCompanyReports(data)
      commit('SET_COMPANY_REPORTS', {data: res.data, type})
    } catch (error) {
      console.log('нету')
    }
  },

async GET_REPORTS_DIAGRAM({commit}, data) {
  try {
    const res = await Api.getReportsDiagram(data)
    commit('SET_REPORTS_DIAGRAM', res.data)
  } catch (error) {
    console.log(error)
  }
},
async GET_REPORTS_DIAGRAM_FINSTATE({commit}, data) {
  try {
    const res = await Api.getReportsDiagramFinState(data)
    commit('SET_REPORTS_DIAGRAM_FINSTATE', res.data)
  } catch (error) {
    console.log(error)
  }
},
async GET_COMPANY_REPORT_BY_ID({commit}, data) {
  try {
    const res = await Api.getCompanyReportById(data)
    commit('SET_REPORT_VIEW', res.data)
  } catch (error) {
    console.log(error)
  }
},
async SEARCH_COMPANY({commit}, search) {
  try {
    const res = await Api.searchCompany(search)
    commit('SET_COMPANIES', res.data)
    return res
  } catch (err) {
    return err
  }
},
  async addNewSlide({}, data) {
    try {
      const res = await Api.addNewSlide(data)
      return res
    } catch (error) {

    }
},
  async GET_SLIDER_IMAGE({commit}) {
    try {
      const res = await Api.getSliderImages()
      commit('SET_SLIDER', res.data)
       return res
    } catch (err) {
      return err
    }
  },
async DELETE_SLIDE_IMAGE({}, id) {
  try {
    await Api.deleteSlide(id)
    return true
  } catch (err) {
    return err
  }
},
async GET_ANALYTICS_LIST() {
  try {
    const res = await Api.getAnalyticsList()
     return res
  } catch (err) {
    return err
  }
},
async GET_ANALYTICS_BY_ID({}, blog_id) {
  try {
    const res = await Api.getAnalyticsById(blog_id)
     return res
  } catch (err) {
    return err
  }
}
}
const getters = {
  getCompanyList(state){
    return state.companies
  },
  getCompanyCount(state){
    return state.company_count
  },
  getCompanyById(state) {
    return state.company_profile
  },
  getCompanyReports(state) {
    return state.company_reports
  },
  getReportsDiagram(state) {
    return state.reports_diagram
  },
  getReportsDiagramFinstate(state) {
    return state.reports_diagram_finstate
  },
  getCompanyReportById(state) {
    return state.report_view
  },
  getSearchResult(state) {
    return state.search_company_res
  },
  getTotalCompany(state) {
    return Math.ceil(state.company_count / state.companies.length)
  },

  setSliderImages(state) {
    return state.slide
  },
  getPage(state) {
    return state.page
  }
}



const companyModule = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

export default companyModule
