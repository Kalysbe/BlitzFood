<template>
    <div v-if="getCompanyById" class="md-layout">
      <div class="md-layout-item md-xsmall-size-100  md-large-size-100">
            <h3 class="name-company">
            {{ getCompanyById.name }} <span v-if="getCompanyById.symbol">({{getCompanyById.symbol}})</span>
            </h3>
          <div class="md-layout">
          <div class="md-layout-item md-size-35 md-small-size-100 box-info-company" :class="getReportsDiagram && getReportsDiagram.series.length != 0 || getReportsDiagramFinstate && getReportsDiagramFinstate.series.length != 0 ? 'md-size-35' : 'md-size-100'">
          <h3 class="name-company">Информация о компании</h3>
          <md-table>
            <md-table-row
              v-if="
                getCompanyById.sepervisor.dir ||
                getCompanyById.sepervisor.position">
              <md-table-cell class="md-title">
                {{$t('pageDetailCompany.firstLeader')}}
              </md-table-cell>
              <md-table-cell class="md-headline">
                {{ getCompanyById.sepervisor.dir }} -
                {{ getCompanyById.sepervisor.position }}
                </md-table-cell>
            </md-table-row>
            <md-table-row v-if="getCompanyById.activity">
              <md-table-cell class="md-title">
                {{$t('pageDetailCompany.primaryActivity')}}
              </md-table-cell>
              <md-table-cell class="md-headline">
                {{getCompanyById.activity}}
              </md-table-cell>
            </md-table-row>
            <md-table-row v-if="getCompanyById.email">
              <md-table-cell class="md-title">
                {{$t('pageDetailCompany.email')}}
              </md-table-cell>
              <md-table-cell class="md-headline">
                <a :href="`mailto:${getCompanyById.email}`">{{getCompanyById.email}}</a> 
              </md-table-cell>
            </md-table-row>
            <md-table-row v-if="getCompanyById.phone">
              <md-table-cell class="md-title">{{$t('pageDetailCompany.contacts')}}</md-table-cell>
              <md-table-cell class="md-headline">
                Телефоны: <a title="Позвонить" :href="`tel:${getCompanyById.phone}`">{{ getCompanyById.phone }}</a>  <br />
                {{ getCompanyById.address }}
              </md-table-cell
              >
            </md-table-row>
          </md-table>
          </div>
          <div class="md-layout-item md-size-5"></div>
        <div class="md-layout-item md-large-size-48 md-medium-size-50 md-small-size-100 md-title"
             v-if="getReportsDiagram && getReportsDiagram.series.length != 0 || getReportsDiagramFinstate && getReportsDiagramFinstate.series.length != 0">
                         <ul class="select-finance">
                             <li @click="selectFinance" :class="showFinance ?  'active-finance' : '' ">Финанс 1</li>
                             <li @click="selectFinance" :class="!showFinance ?  'active-finance' : '' ">Финанс 2</li>
                          </ul>
                            <hr>
                          <!-- Финансовое состояния -->
                          <apexchart
                            width="100%"
                            type="area"
                            v-if="getReportsDiagram && getReportsDiagram.series.length != 0 && showFinance"
                            :options="DiagramOptions"
                            :series="getReportsDiagram.series">
                          </apexchart>
                       
                          <!-- Финансовое состояния -->
                          <apexchart
                            width="100%"
                            type="bar"
                            v-if="getReportsDiagramFinstate && getReportsDiagramFinstate.series.length != 0 && !showFinance"
                            :options="FinstateOptions"
                            :series="getReportsDiagramFinstate.series">
                          </apexchart>
                        </div>
              </div>
          <!-- Документы -->
          <detail-company-report type="1"></detail-company-report>
          <!--Новости -->
          <detail-company-report type="2"></detail-company-report>
      </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import ReportsVue from '../../../Pages/Reports.vue'
import {CollapseTransition} from 'vue2-transitions'
import DetailCompanyReport from './DetailCompanyReport.vue'

export default {
  data: () => ({
    expandSingle: false,
    showFinance:true,
    isClosedNews: true,
    isClosedFinance: true
  }),
  methods: {
    ...mapActions('company', [
      'GET_COMPANY_BYID',
      'GET_COMPANY_REPORTS',
      'GET_REPORTS_DIAGRAM',
      'GET_REPORTS_DIAGRAM_FINSTATE'
    ]),
    getReports(type) {
      this.GET_COMPANY_REPORTS({kod: this.$route.params.kod, type})
    },
    ReportView(id) {
      let OpenReport = this.$router.resolve({
        path: '/openinformation/company/report/' + id
      })
      window.open(OpenReport.href, '_blank')
    },
    clicked: function (e) {
      e.preventDefault()
    },
    toggleDocument: function () {
      this.isClosedDocument = !this.isClosedDocument
    },
    toggleNews: function () {
      this.isClosedNews = !this.isClosedNews
    },
    toggleFinance: function () {
      this.isClosedFinance = !this.isClosedFinance
    },
    selectFinance: function() {
        this.showFinance = !this.showFinance
    },
    getDate(date) {
      // Форматирование даты в формат d.m.Y
      if (date != undefined) {
        var options = {
          day: 'numeric',
          month: 'numeric',
          year: 'numeric'
        }
        let newDate = new Date(date)
        return newDate.toLocaleString('ru', options)
      }
    }
  },
  computed: {
    ...mapGetters('company', [
      'getCompanyById',
      'getCompanyReports',
      'getReportsDiagram',
      'getReportsDiagramFinstate'
    ]),
     DiagramOptions() {
      return {
        xaxis: this.getReportsDiagram && this.getReportsDiagram.xaxis
      }
    },
    FinstateOptions() {
      return {
        xaxis:
          this.getReportsDiagramFinstate && this.getReportsDiagramFinstate.xaxis
      }
    }
  },
  mounted() {
    this.GET_COMPANY_BYID(this.$route.params.kod)
    this.GET_REPORTS_DIAGRAM(this.$route.params.kod)
    this.GET_REPORTS_DIAGRAM_FINSTATE(this.$route.params.kod)
    this.getReports(1)
  },
  components: {
    CollapseTransition,
    DetailCompanyReport
  }
}
</script>

<style lang="scss" scoped>
.collapsed {
  transition: opacity 10s;
}
.name-company-box {
  margin-bottom: 16px;
}
.box-info-company {
padding-left: 0px;

}
.name-company {
  color: #42a5af;
}
.information-company {
  text-align: center;
  color: #42a5af;
}
.select-params {
  display: flex;
}
.text-document {
  color: #42a5af;
}
#selectDocument {
  padding: 2px;
}
.md-list-expand {
  transition: 10s;
}

.toggle-section {
  width: 100%;
  padding-bottom: 20px;
}
.select-finance {
  display: flex;
  transition: 1s;
  padding-left: 0px;
}
.select-finance li {
  list-style: none;
  margin:0 10px;
  cursor: pointer;
}
.active-finance {
  border-bottom: 3px solid #42a5af;
}
</style>